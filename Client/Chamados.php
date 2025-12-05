<?php
    require_once(__DIR__ . '/../Config/auth.php');
    require_once(__DIR__ . '/../Config/redirectadmin.php');

    $id = '';
    $tipo = '';
    $periferico = '';
    $msg = '';
    
    $status = false;
    $tipo = false;
    $data = false;

    $ordenar = $_GET['ordenar'] ?? "";

    $mensagens = $_SESSION['mensagens'] ?? [];
    unset($_SESSION['mensagens']);
    
    if(!empty($ordenar)) {
        //Status
        if ($ordenar === 'status_asc') {
            $sql = "
            SELECT * FROM chamados
            WHERE ID_Solicitante = $id_user
            ORDER BY FIELD(status, 'Aberto', 'Não resolvido', 'Incompleto', 'Cancelado', 'Concluído');
            ";

            $status = true;
        }
        if ($ordenar === 'status_desc') {
            $sql = "
            SELECT * FROM chamados
            WHERE ID_Solicitante = $id_user
            ORDER BY FIELD(status, 'Concluído', 'Cancelado', 'Incompleto', 'Não resolvido', 'Aberto');
            ";
            $status = true;
        }

        //Tipo
        if ($ordenar === 'tipo_asc') {
            $sql = "
            SELECT * FROM chamados
            WHERE ID_Solicitante = $id_user
            ORDER BY FIELD(tipo, 'Computador', 'Perifericos', 'Outros');
            ";
            $tipo = true;
        }
        if ($ordenar === 'tipo_desc') {
            $sql = "
            SELECT * FROM chamados
            WHERE ID_Solicitante = $id_user
            ORDER BY FIELD(tipo, 'Outros', 'Perifericos', 'Computador');
            ";
            $tipo = true;
        }
        
        //Data
        if ($ordenar === 'data_asc') {
            $sql = "SELECT * FROM chamados WHERE ID_Solicitante = ". $id_user . " ORDER BY data_abertura DESC";
            $data = true;
        }
        if ($ordenar === 'data_desc') {
            $sql = "SELECT * FROM chamados WHERE ID_Solicitante = ". $id_user . " ORDER BY data_abertura ASC";
            $data = true;
        }

    }else {
        $sql = "SELECT * FROM chamados WHERE ID_Solicitante = ". $id_user . " ORDER BY ID DESC";
    }

    //Se veio com metodo POST -> quer excluir o chamado
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id_pedido = $_POST['id_chamado'] ?? "";
        $tipo_chamado = $_POST['tipo_chamado'] ?? "";

        if ($tipo_chamado === 'computador') {
            $sql_rmv = "DELETE FROM chamado_computador WHERE id_chamado = $id_pedido";
            $remover = $con->query($sql_rmv);
        }
        if ($tipo_chamado === 'outros') {
            $sql_rmv = "DELETE FROM chamado_outros WHERE id_chamado = $id_pedido";
            $remover = $con->query($sql_rmv);
        }
        if ($tipo_chamado === 'perifericos') {
            $sql_rmv = "DELETE FROM chamado_perifericos WHERE id_chamado = $id_pedido";
            $remover = $con->query($sql_rmv);
        }

        $sql_rmv = "DELETE FROM chamados WHERE id = $id_pedido";
        $remover = $con->query($sql_rmv);

    }

    

    $resultado = $con->query($sql);

?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>Reparar</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon">
        <link rel="stylesheet" href="css/header.css">
        <link rel="stylesheet" href="css/config.css">
        <link rel="stylesheet" href="css/Chamados.css">

        <script src="https://kit.fontawesome.com/de310c1571.js" crossorigin="anonymous"></script>
    </head>
    <body>
        <div id="pagina">
            <header>
                <div>
                    <img src="img/LogoCliente.png" alt="Logo_Crafty" id="logo">
                </div>
                <nav>
                    <a href="Inicio.php">
                        Inicio
                        <div class="linha"></div>
                    </a>

                    <a href="Reparar.php">
                            Reparar
                            <div class="linha"></div>
                    </a>

                    <a href="Funcionarios.php">
                        Funcionarios
                        <div class="linha"></div>
                    </a>

                    <a href="Chamados.php" id="selecionado">
                        Chamados
                        <div id="selecionadolinha"></div>
                    </a>

                    <a href="Conta.php">
                        Conta
                        <div class="linha"></div>
                    </a>
                </nav>
            </header>
        
            <div id="chamados">
                <main>
                    <h1>CHAMADOS</h1>
                    <h2>Veja os seus chamados ativos</h2>
                    
                    <div id="chamados_ativos">
                        <div id="order">
                            <p>Ordenar por</p>
                            <div id="ordenar">
                                <div id="status" <?php if ($status) {echo 'class="menu_selecionado"';}?>>
                                    <div class="ordenar_btn" data-menu="menu-status">
                                        <i class="fa-solid fa-rotate"></i>
                                        Status
                                    </div>
                                    <div class="ordenar-menu" id="menu-status">
                                        <a href="Chamados.php?ordenar=status_asc">Aberto → Concluido</a>
                                        <a href="Chamados.php?ordenar=status_desc">Concluido → Aberto</a>
                                    </div>
                                </div>
                                <div id="tipo" <?php if ($tipo) {echo 'class="menu_selecionado"';}?>>
                                    <div class="ordenar_btn" data-menu="menu-tipo">
                                        <i class="fa-solid fa-laptop"></i>  
                                        Tipo
                                    </div>
                                    <div class="ordenar-menu" id="menu-tipo">
                                        <a href="Chamados.php?ordenar=tipo_asc">Computador → Outros</a>
                                        <a href="Chamados.php?ordenar=tipo_desc">Outros → Computador</a>
                                    </div>
                                </div>

                                <div id="data" <?php if ($data) {echo 'class="menu_selecionado"';}?>>
                                    <div class="ordenar_btn" data-menu="menu-data">
                                        <i class="fa-regular fa-clock"></i>
                                        Data
                                    </div>
                                    <div class="ordenar-menu" id="menu-data">
                                        <a href="Chamados.php?ordenar=data_asc">Mais recentes</a>
                                        <a href="Chamados.php?ordenar=data_desc">Mais antigos</a>
                                    </div>  
                                </div>
                            </div>
                        </div>

                        <?php if ($resultado->num_rows > 0): ?>
                            <?php foreach ($resultado as $res): ?>
                                <div class="chamado" tabindex="0">
                                    <div class="info">
                                        <div class="esquerda">
                                            <h1>
                                                <?php
                                                    echo ucfirst($res['tipo']) . ' #' . $res['ID'];
                                                ?>
                                            </h1>
                                            <h2>
                                                <?php
                                                    if ($res['status'] === 'Aberto') {
                                                        $msg = 'Não resolvido';
                                                    }
                                        
                                                    echo $res['status'] . ' - ' .$msg;
                                                ?>
                                            </h2>
                                            <p>Clique para ver mais detalhes</p>
                                        </div>
                                        <div class="divisoria"></div>
                                        <div class="direita">
                                            <h3>Informações extras</h3>
                                            <p>
                                                <?php
                                                    echo 'Urgência: ' . ucfirst($res['urgencia']);
                                                ?>
                                            </p>
                                            <p>
                                                <?php echo 'Data do ocorrido: ' . $res['data_ocorrido']?>
                                            </p>
                                            <p>
                                                <?php echo 'ID do pedido: #' . $res['ID']?>
                                            </p>
                                        </div>
                                    </div>

                                    <div class="detalhes">
                                        <div class="divisoria_esq_dir"></div>
                                        <div class="detalhes_info">
                                            <div class="gerais_especificas">
                                                <div class="gerais">
                                                    <h1>Gerais</h1>
                                                    <p>ID: <?php echo $res['ID']?></p>
                                                    <p>Tipo: <?php echo ucfirst($res['tipo'])?></p>
                                                    <?php 
                                                        $tipo = $res['tipo'];
                                                        if ($tipo === 'perifericos') {
                                                            $id = intval($res['ID']);
                                                            $sql = "SELECT * FROM chamado_perifericos WHERE id_chamado = $id";
                                                            $query = $con->query($sql);

                                                            if ($query && $query->num_rows > 0) {
                                                                $periferico = $query->fetch_assoc();

                                                                if ($periferico['tipo_periferico'] === 'Outro') {
                                                                    echo '<p>Tipo de periferico: ' . $periferico['tipo_personalizado'] . "</p>";
                                                                }else {
                                                                echo '<p>Tipo de periferico: ' . $periferico['tipo_periferico'] . "</p>";
                                                                }
                                                            }
                                                        }

                                                        if ($tipo === 'outros') {
                                                            $id = intval($res['ID']);
                                                            $sql = "SELECT * FROM chamado_outros WHERE id_chamado = $id";
                                                            $query = $con->query($sql);

                                                            if ($query && $query->num_rows > 0) {
                                                                $outro = $query->fetch_assoc();

                                                                if ($outro['tipo_problema'] === 'Outro') {
                                                                    echo '<p>Tipo de problema: ' . $outro['tipo_personalizado'] . "</p>";
                                                                }else {
                                                                echo '<p>Tipo de periferico: ' . $outro['tipo_problema'] . "</p>";
                                                                }
                                                            }
                                                        }
                                                    ?>
                                                    <p>Solicitante: <?php echo ucfirst($res['solicitante'])?></p>
                                                    <p>Urgência: <?php echo ucfirst($res['urgencia'])?></p>
                                                    <p>Status: <?php echo $res['status']?></p>
                                                    <p>Setor ou laboratorio: <?php echo $res['setor_lab']?></p>
                                                </div>
                                                <div class="especificas">
                                                    <h1>Especificas</h1>
                                                    <p>Data do ocorrido: <?php echo $res['data_ocorrido']?></p>
                                                    <p>Data de abertura: <?php echo $res['data_abertura']?></p>
                                                    <p>Data de conclusão: <?php echo $res['data_conclusao']?></p>
                                                </div>
                                            </div>

                                            <div class="descricao">
                                                <h2>Descricao </h2>
                                                <p><?php echo $res['descricao']?></p>
                                            </div>

                                            <div class="anexo">
                                                <h2>Anexo </h2>
                                                <p>
                                                    <?php
                                                    if (!empty($res['anexo'])) {
                                                        $src = $res['anexo'];
                                                        echo '<img src="../uploads/foto_chamados/' . $src . '" alt="Imagem Anexo">';
                                                    }else {
                                                        echo 'Nenhuma imagem encontrada.';
                                                    }
                                                    ?>
                                                </p>
                                            </div>

                                            <div class="excluir">
                                                <h2>EXCLUIR</h2>
                                                <button class="excluir_confirm">Clique aqui para excluir o pedido</button>
                                                <form action="Chamados.php" method="post">
                                                    <div class="botaooculto">
                                                        <h2>Tem certeza?</h2>
                                                        <div class="btns">
                                                            <input type="hidden" name="id_chamado" id="id_chamado" value="<?php echo $res['ID']?>">
                                                            <input type="hidden" name="tipo_chamado" id="tipo_chamado" value="<?php echo $res['tipo']?>">
                                                            <button class="sim" type="submit">Sim</button>
                                                            <button class="nao" type="button">Não</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>                                
                                </div>
                            <?php endforeach?>
                        <?php else:?>
                            <p>Nenhum chamado.</p>
                        <?php endif ?>
                    </div>
                </main>
            </div>
        </div>

        <script src="js/Chamados.js"></script>
    </body>
</html>
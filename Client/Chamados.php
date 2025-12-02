<?php
    session_start();

    /*
    if (!isset($_SESSION['usuario_id'])) {
        // se não tiver uma sessão ativa, voltar para o login
        header("Location: ../login_registro.php?painel=login");
    }
    */

    $id = '';
    $tipo = '';
    $periferico = '';
    $msg = '';
    $id_user = intval($_SESSION['usuario_id']);
    
    $status = false;
    $tipo = false;
    $data = false;

    include_once "config.php";
    $ordenar = $_GET['ordenar'] ?? "";
    
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
            $sql = "SELECT * FROM chamados WHERE ID_Solicitante = ". $id_user . " ORDER BY data_ocorrido DESC";
            $data = true;
        }
        if ($ordenar === 'data_desc') {
            $sql = "SELECT * FROM chamados WHERE ID_Solicitante = ". $id_user . " ORDER BY data_ocorrido ASC";
            $data = true;
        }

    }else {
        $sql = "SELECT * FROM chamados WHERE ID_Solicitante = ". $id_user . " ORDER BY data_ocorrido DESC";
    }



    $resultado = $con->query($sql);

?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>Reparar</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/header.css">
        <link rel="stylesheet" href="css/config.css">
        <link rel="stylesheet" href="css/Chamados.css">
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
                                        <img src="" alt="">
                                        Status
                                    </div>
                                    <div class="ordenar-menu" id="menu-status">
                                        <a href="Chamados.php?ordenar=status_asc">Aberto → Concluido</a>
                                        <a href="Chamados.php?ordenar=status_desc">Concluido → Aberto</a>
                                    </div>
                                </div>
                                <div id="tipo" <?php if ($tipo) {echo 'class="menu_selecionado"';}?>>
                                    <div class="ordenar_btn" data-menu="menu-tipo">
                                        <img src="" alt="">    
                                        Tipo
                                    </div>
                                    <div class="ordenar-menu" id="menu-tipo">
                                        <a href="Chamados.php?ordenar=tipo_asc">Computador → Outros</a>
                                        <a href="Chamados.php?ordenar=tipo_desc">Outros → Computador</a>
                                    </div>
                                </div>

                                <div id="data" <?php if ($data) {echo 'class="menu_selecionado"';}?>>
                                    <div class="ordenar_btn" data-menu="menu-data">
                                        <img src="" alt="">
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
                                <button class="chamado">
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
                                                <h2>Descricao: </h2>
                                                <p><?php echo $res['descricao']?></p>
                                            </div>

                                            <div class="anexo">
                                                <h2>Anexo: </h2>
                                                <p>
                                                    <?php
                                                    if (!empty($res['anexo'])) {
                                                        $src = $res['anexo'];
                                                        echo '<img src="uploads/' . $src . '" alt="Imagem Anexo">';
                                                    }else {
                                                        echo 'Nenhuma imagem encontrada.';
                                                    }
                                                    ?>
                                                </p>
                                            </div>
                                            
                                        </div>
                                    </div>                                
                                </button>
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
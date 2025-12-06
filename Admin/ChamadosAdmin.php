<?php
    require_once(__DIR__ . '/../Config/auth.php');
    $mensagens = $_SESSION['mensagens'] ?? [];


//Pegando a tabela chamados
    $ordenar = $_GET['ordenar'] ?? "";

    if (empty($ordenar) || $ordenar === 'todos') {
        $sql = "SELECT * FROM chamados
        WHERE status IN ('Não resolvido', 'Incompleto', 'Aberto', 'Em andamento')
        ORDER BY FIELD(status, 'Em andamento', 'Aberto', 'Incompleto', 'Não resolvido');";
    }else if ($ordenar === 'andamento') {
        $sql = "SELECT * FROM chamados
WHERE status IN ('Em andamento')
ORDER BY FIELD(urgencia, 'alta', 'media', 'baixa');";
    }else if ($ordenar === 'espera') {
        $sql = "SELECT * FROM chamados
WHERE status IN ('Não resolvido', 'Incompleto')
ORDER BY FIELD(urgencia, 'alta', 'media', 'baixa');";
    }

    $resultado = $con->query($sql);
    $chamados = $resultado->fetch_all(MYSQLI_ASSOC);
//Se veio aqui por um formulario
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id_pedido = intval($_POST['id_pedido']);
        $acao = $_POST['acao'] ?? "";
        $motivo = $_POST['motivo'] ?? "";
        $tecnico = $_SESSION['usuario_nome'];

        if ($acao === 'assumir') {
            $sql = "UPDATE chamados SET status = 'Em andamento', tecnico_responsavel = '$tecnico', ID_tecnico = '$id_user' WHERE ID = '$id_pedido';";
            $result = $con->query($sql);
            $mensagens[] = [
                'tipo' => 'sucesso',
                'mensagem' => 'Chamado assumido com sucesso!',
                'assumir' => 'true',
            ];
            $chamados['status'] = 'Em andamento';
            $chamados['tecnico_responsavel'] = "$tecnico";
        }
        if ($acao === 'negar') {
            if (empty($motivo)) {
                $mensagens[] = [
                    'tipo' => 'erro',
                    'mensagem' => 'Informe um motivo para negar o pedido!',
                ];
                return;
            }
            $sql = "UPDATE chamados SET status ='Negado' WHERE ID = '$id_pedido'";
            $result = $con->query($sql);
            $mensagens[] = [
                'tipo' => 'sucesso',
                'mensagem' => 'Chamado negado com sucesso!',
            ];
            $chamados['status'] = 'Em andamento';
        }

        $_SESSION['mensagens'] = $mensagens;
        header ("Location: ChamadosAdmin.php");
        exit;
    }

?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>Chamados - Admin</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon">
        <link rel="stylesheet" href="css/header.css">
        <link rel="stylesheet" href="css/config.css">
        <link rel="stylesheet" href="css/chamados.css">

        <script src="https://kit.fontawesome.com/de310c1571.js" crossorigin="anonymous"></script>
    </head>
    <body>
        <div id="pagina">
            <header>
                <div>
                    <img src="img/crafty_barra_lateral.png" alt="Logo_Crafty" id="logo">
                </div>
                <nav>
                    <a href="Inicio.php">
                        <i class="fa-solid fa-house-chimney"></i>
                        Inicio
                    </a>

                    <a href="ChamadosAdmin.php" id="selecionado">
                        <i class="fa-solid fa-wrench" ></i>
                        Chamados
                        <i class="fa-solid fa-angle-right" id="chamado_expandir"></i>

                        <div id="historico">
                            <a href="Funcionarios.php">
                                <i class="fa-solid fa-calendar"></i>
                                Historico
                            </a>
                        </div>
                    </a>

                    <a href="Equipe.php">
                        <i class="fa-solid fa-user-group"></i>
                        Equipe
                    </a>

                    <div class="inferior">
                        <a href="../Client/Conta.php">
                            <i class="fa-solid fa-user"></i>
                            Perfil
                        </a>
                        <a href="../Client/logout.php">
                            <i class="fa-solid fa-arrow-right-from-bracket" ></i>
                            Sair
                        </a>
                    </div>
                </nav>
            </header>

            <div id="overlay" class="<?= !empty($mensagens) ? 'ativo': "" ?>"></div>
            <div id="caixa_mensagem" class="<?= !empty($mensagens) ? 'ativo': "" ?>">
                <h2>
                    <?php 
                        $tipos = array_column($mensagens, 'tipo'); // pegando apenas o tipo da array

                        if (!in_array('erro', $tipos)) { // verificando se tem algum erro
                            $h2 = "Sucesso!";
                        }else {
                            $h2 = "Erro!";
                        }
                        echo $h2;
                    ?>
                </h2>

                <p>
                    <?php
                        foreach($mensagens as $mensagem) {
                            echo $mensagem['mensagem'];

                            if (!empty($mensagem['assumir'])) {
                                $temAssumir = true;
                            }
                        }
                    ?>
                </p>

                <div id="caixa_btn">
                    <button id="fechar">Fechar</button>
                    <?php if ($temAssumir) {
                            echo '<a href="MeusChamados.php" id="meuschamados">Meus Chamados</a>';
                        }
                    ?>
                </div>
            </div>

            <div id="ChamadosAdmin">
                <main>
                    <div id="topo">
                        <div id="texto_chamado">
                            <h1>Chamados</h1>
                            <p>15 chamados encontrados</p>
                        </div>

                        <div id="not_foto">
                            <div id="notificacoes">
                                <i class="fa-solid fa-bell"></i>
                            </div>
                            <div id="foto_perfil">
                                <img src="" alt="">
                            </div>
                        </div>
                    </div>

                    <div id="conteudotabela">
                        <div id="filtro">
                            <a href="ChamadosAdmin.php?ordenar=todos" class="<?= $ordenar === "todos" || empty($ordenar) ? "selecionado" : ""?>">Todos os chamados</a>
                            <a href="ChamadosAdmin.php?ordenar=andamento" class="<?= $ordenar === "andamento" ? "selecionado" : ""?>">Chamados em andamento</a>
                            <a href="ChamadosAdmin.php?ordenar=espera" class="<?= $ordenar === "espera" ? "selecionado" : ""?>">Chamados em espera</a>
                        </div>

                        <div class="tabela">
                            <div class="linha header">
                                <div>ID do pedido</div>
                                <div>Tipo</div>
                                <div>Solicitante</div>
                                <div>Data de Abertura</div>
                                <div>Técnico Responsavel</div>
                                <div>Laboratório</div>
                                <div>Urgência</div>
                                <div>Status</div>
                            </div>


                            <?php if (!empty($chamados)) { foreach($chamados as $chamado) { ?>
                                <button class="chamado">
                                    <div class="mascara-imagem"></div>

                                    <div>#<?php echo $chamado['ID']; ?></div>

                                    <div><?php echo ucfirst($chamado['tipo']); ?></div>

                                    <div><?php echo $chamado['solicitante']; ?></div>

                                    <div><?php echo $chamado['data_abertura']; ?></div>

                                    <div><?= empty($chamado['tecnico_responsavel']) ? "---" : $chamado['tecnico_responsavel']; ?></div>

                                    <div><?php echo $chamado['setor_lab']; ?></div>

                                    <div class="<?php echo $chamado['urgencia']?>">
                                        <?php echo ucfirst($chamado['urgencia']); ?>
                                    </div>

                                    <div class="<?php echo $chamado['status'];?>">
                                        <?php echo $chamado['status'];?>
                                    </div>
                                </button>

                                <div class="chamado-dropdown">
                                    <div class="conteudo">
                                        <h2>Informações do chamado</h2>
                                        <div class="infos">
                                            <div class="info">
                                                <p>ID:</p>
                                                <p>Tipo:</p>
                                                <p>Urgência:</p>
                                                <p>Status: <?php echo $chamado['status']?></p>
                                                <p>Data de abertura: <?php echo $chamado['data_abertura']?></p>
                                            </div>
                                            <div class="info">
                                                <p>ID do Solicitante: </p>
                                                <p>Solicitante:</p>
                                                <p>ID do técnico: <?php echo $chamado['ID_tecnico']?></p>
                                                <p>Nome do técnico: <?php echo $chamado['tecnico_responsavel']?></p>
                                                <p>Setor ou laboratorio: <?php echo $chamado['setor_lab']?></p>
                                                <!--se computador, perifericos, outros, mostrar informações extras aqui-->
                                                <p>Data do ocorrido: <?php echo $chamado['data_ocorrido']?></p>
                                            </div>
                                        </div>

                                        <div class="descricao">
                                            <h2>Descricao </h2>
                                            <p><?php echo $chamado['descricao']?></p>
                                        </div>

                                        <div class="anexo">
                                            <h2>Anexo </h2>
                                            <p>
                                                <?php
                                                if (!empty($chamado['anexo'])) {
                                                    $src = $chamado['anexo'];
                                                    echo '<img src="../uploads/foto_chamados/' . $src . '" alt="Imagem Anexo">';
                                                }else {
                                                    echo 'Nenhuma imagem encontrada.';
                                                }
                                                ?>
                                            </p>
                                        </div>

                                        <div class="acoes">
                                            <form action="" method="POST" id="form">
                                                <input type="hidden" name="id_pedido" value="<?php echo $chamado['ID']?>">
                                                <?php if ($chamado['ID_tecnico'] !== "$id_user") {?>
                                                    <button class="assumir" value="assumir" type="submit" name="acao">Assumir</button>
                                                <?php }?>
                                                <button class="negar" type="button">Negar</button>

                                                <div class="menu_negar">
                                                    <h2>Informe o motivo de negar o pedido:</h2>
                                                    <textarea name="motivo" id="motivo"></textarea>
                                                    <div class="menu_btns">
                                                        <button type="submit" name="acao" value="negar" class="negar_menu">Negar pedido</button>
                                                        <button type="button" class="cancelar_menu">Cancelar</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>

                                    </div>
                                </div>
                            <?php }} else { echo "<p>Nenhum chamado encontrado!</p>";}?>
                        </div>
                    </div>
                </main>

            </div>
        </div>

        <script src="js/Chamados.js"></script>
    </body>
</html>
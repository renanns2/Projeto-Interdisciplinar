<?php
    require_once(__DIR__ . '/../Config/auth.php');
    require_once(__DIR__ . '/../Config/redirectadmin.php');
    $mensagens = $_SESSION['mensagens'] ?? [];
    unset($_SESSION['mensagens']);

    $_SESSION['mensagens'] = $mensagens;

//Pegando a tabela chamados
    $sql = "SELECT * FROM chamados";
    $resultado = $con->query($sql);
    $chamados = $resultado->fetch_all(MYSQLI_ASSOC);

//Se veio aqui por um formulario
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id_pedido = intval($_POST['id_pedido']);
        $acao = $_POST['acao'] ?? "";
        $tecnico = $_SESSION['usuario_nome'];

        if ($acao === 'assumir') {
            $sql = "UPDATE chamados SET status = 'Em andamento', tecnico_responsavel = '$tecnico' WHERE ID = '$id_pedido';";
            $result = $con->query($sql);
            $mensagens[] = [
                'tipo' => 'sucesso',
                'mensagem' => 'Chamado assumido com sucesso!',
            ];
        }
        if ($acao === 'negar') {
            $sql = "UPDATE chamados SET status ='Negado' WHERE ID = '$id_pedido'";
            $result = $con->query($sql);
            $mensagens[] = [
                'tipo' => 'sucesso',
                'mensagem' => 'Chamado negado com sucesso!',
            ];
        }
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

                    <a href="Reparar.php">
                        <i class="fa-solid fa-wrench"></i>
                        Chamados
                        <i class="fa-solid fa-angle-right" id="chamado_expandir"></i>

                        <div id="historico">
                            <a href="Funcionarios.php">
                                <i class="fa-solid fa-calendar"></i>
                                Historico
                            </a>
                        </div>
                    </a>

                    <a href="Chamados.php">
                        <i class="fa-solid fa-user-group"></i>
                        Equipe
                    </a>

                    <div class="inferior">
                        <a href="Conta.php" id="selecionado">
                            <i class="fa-solid fa-user"></i>
                            Perfil
                        </a>
                        <a href="Conta.php">
                            <i class="fa-solid fa-arrow-right-from-bracket" ></i>
                            Sair
                        </a>
                    </div>
                </nav>
            </header>
        
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
                            <button id="todos" class="selecionado">Todos os chamados</button>
                            <button id="andamento">Chamados em andamento</button>
                            <button id="espera">Chamados em espera</button>
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


                            <?php foreach($chamados as $chamado) { ?>
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
                                                <button class="assumir" value="assumir" type="submit" name="acao">Assumir</button>
                                                <button class="negar" value="negar" type="submit" name="acao">Negar</button>
                                            </form>
                                        </div>

                                    </div>
                                </div>
                            <?php }?>
                        </div>


                    </div>
                </main>

            </div>
        </div>

        <script src="js/Chamados.js"></script>
    </body>
</html>
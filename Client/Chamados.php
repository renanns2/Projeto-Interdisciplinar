<?php
    session_start();

    /*
    if (!isset($_SESSION['usuario_id'])) {
        // se não tiver uma sessão ativa, voltar para o login
        header("Location: ../login_registro.php?painel=login");
    }
    */

    include_once "config.php";

    $id_user = intval($_SESSION['usuario_id']);
    $sql = "SELECT * FROM chamados WHERE ID_Solicitante = ". $id_user;
    $resultado = $con->query($sql);

    $msg = '';
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
                                <div id="status">
                                    <img src="" alt="Logo_Status">
                                    <p>Status</p>
                                </div>
                                <div id="tipo">
                                    <img src="" alt="Logo_Tipo">
                                    <p>Tipo</p>
                                </div>
                                <div id="data">
                                    <img src="" alt="Logo_Data">
                                    <p>Data</p>
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
                                        <div class="detalhes_info">
                                            <div class="gerais_especificas">
                                                <div class="gerais">
                                                    <h1>Gerais</h1>
                                                    <p>ID: <?php echo $res['ID']?></p>
                                                    <p>Tipo: <?php echo ucfirst($res['tipo'])?></p>
                                                    <p>Solicitante: <?php echo ucfirst($res['solicitante'])?></p>
                                                    <p>Urgência do chamado: <?php echo ucfirst($res['urgencia'])?></p>
                                                    <p>Status do chamado: <?php echo $res['status']?></p>
                                                    <p>Setor ou laboratorio: <?php echo $res['setor_lab']?></p>
                                                </div>
                                                <div class="especificas">
                                                    <h1>Especificas</h1>
                                                    <p>Data do ocorrido do chamado: <?php echo $res['data_ocorrido']?></p>
                                                    <p>Data de abertura do chamado: <?php echo $res['data_abertura']?></p>
                                                    <p>Data de conclusão: <?php echo $res['data_conclusao']?></p>
                                                </div>
                                            </div>

                                            <div class="descricao">
                                                <h2>Descricao: </h2>
                                            </div>

                                            <div class="anexo">
                                                <h2>Anexo: </h2>
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
<?php

    session_start();

    /*
    if (!isset($_SESSION['usuario_id'])) {
        // se não tiver uma sessão ativa, voltar para o login
        header("Location: login_registro.php?painel=login");
    }
    */
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Funcionarios</title>

    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/config.css">
    <link rel="stylesheet" href="css/Funcionarios.css">
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

                    <a href="Funcionarios.php" id="selecionado">
                        Funcionarios
                        <div id="selecionadolinha"></div>
                    </a>

                    <a href="Chamados.php">
                        Chamados
                        <div class="linha"></div>
                    </a>

                    <a href="Conta.php">
                        Conta
                        <div class="linha"></div>
                    </a>
                </nav>
            </header>

        
            <div id="funcionarios">
                <main>
                    <h1>FUNCIONARIOS</h1>
                    <h2>Que tipo de reparo você está procurando?</h2>
                    
                    <div id="caixafuncionarios">
                        <div class="perfil">
                            <div class="esquerda"> 
                                <img src="" alt="Foto_Perfil">
                                <h1>Nome</h1>
                                <h2>Status</h2>
                            </div>

                            <div class="direita">
                                <h3>Informações extras</h3>
                                <p>Horario de trabalho: </p>
                                <p>Contato:</p>
                                <p>Cargo:</p>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>

   
    </body>
</html>
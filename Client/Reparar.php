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
        <title>Reparar</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/header.css">
        <link rel="stylesheet" href="css/config.css">
        <link rel="stylesheet" href="css/Reparar.css">
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

                    <a href="#" id="selecionado">
                            Reparar
                            <div id="selecionadolinha"></div>
                    </a>

                    <a href="Funcionarios.php">
                        Funcionarios
                        <div class="linha"></div>
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

        
            <div id="reparar">
                <main>
                    <h1>REPARAR</h1>
                    <h2>Que tipo de reparo você está procurando?</h2>
                    
                    <div id="imagens">
                        <a href="reparar_computador.php" id="computador">
                            <img src="img/notebook_reparar.png" alt="Img_Notebook">
                            <p>Computador</p>
                        </a>

                        <a href="reparar_perifericos.php" id="perifericos">
                            <img src="img/perifericos_reparar.png" alt="Img_Perifericos">
                            <p>Perifericos</p>
                        </a>

                        <a href="reparar_outros.php" id="outros">
                            <img src="img/outros_reparar.png" alt="Img_Outros">
                            <p>Outros</p>
                        </a>
                    </div>
                </main>
            </div>
        </div>

   
    </body>
</html>
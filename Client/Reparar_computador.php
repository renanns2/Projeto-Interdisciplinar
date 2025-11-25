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
                    <h1>COMPUTADOR</h1>
                    <h2>Insira os detalhes do defeito</h2>
                    
                    <form method="GET" action="">
                        <div class="grupo-input">
                            <label for="numeropc">Numero do PC</label>
                            <input type="number" name="numeropc" id="numeropc" required>

                            <label for="numeropc">Laboratorio do PC</label>
                            <input type="number" name="numeropc" id="numeropc" required>
                        </div>
                    </form>
                </main>
            </div>
        </div>

   
    </body>
</html>
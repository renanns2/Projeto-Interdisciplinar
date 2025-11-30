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
        <link rel="stylesheet" href="css/Reparar_form.css">
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

            <div id="overlay"></div>
            <div id="caixa_mensagem"></div>
        
            <div id="chamados">
                <main>

                    <h1>CHAMADOS</h1>
                    <h2>Veja os seus chamados ativos</h2>
                    
                    <div id="chamados_ativos">

                    </div>
                </main>
            </div>
        </div>

        <script src="js/Chamados.js"></script>
    </body>
</html>
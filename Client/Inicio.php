<?php
    session_start();

    if (!isset($_SESSION['usuario_id'])) {
        // se não tiver uma sessão ativa, voltar para o login
        header("Location: login_registro.php?painel=login");
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/Inicio.css">
    </head>
    <body>
        <main>
        <header>
            <div>
                <img src="img/LogoCliente.png" alt="Logo_Crafty" id="logo">
            </div>
            <nav>
                <div id="selecionado">
                    Inicio
                    <div id="selecionadolinha"></div>
                </div>
                <div>
                    Reparar
                    <div class="linha"></div>
                </div>
                <div>
                    Funcionarios
                    <div class="linha"></div>
                </div>
                <div>
                    Chamados
                    <div class="linha"></div>
                </div>
                <div>
                    Conta
                    <div class="linha"></div>
                </div>
            </nav>
        </header>

        
            <div id="esquerda">
                <h1>Bem Vindo</h1>
                <h2>Comece a reparar o seu PC com a gente! <br> A melhor opção na sua INTRANET.</h2>
                <button id="Relatar">Relatar problema</button>
                <button id="Funcionarios">Funcionarios</button>
            </div>
            
            <div id="direita">
                <img src="img/notebook.png" alt="notebook">
            </div>
        </main>

   
    </body>
</html>
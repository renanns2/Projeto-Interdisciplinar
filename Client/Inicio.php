<?php
    require_once(__DIR__ . '/../Config/auth.php');
    require_once(__DIR__ . '/../Config/redirectadmin.php');
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>Inicio</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/header.css">
        <link rel="stylesheet" href="css/config.css">
        <link rel="stylesheet" href="css/Inicio.css">
    </head>
    <body>
        <div id="pagina">
            <header>
                <div>
                    <img src="img/LogoCliente.png" alt="Logo_Crafty" id="logo">
                </div>
                <nav>
                    <a href="#" id="selecionado">
                        Inicio
                        <div id="selecionadolinha"></div>
                    </a>

                    <a href="Reparar.php">
                            Reparar
                            <div class="linha"></div>
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

        
            <main>
                <div id="esquerda">
                    <h1>Bem Vindo</h1>
                    <h2>Comece a reparar o seu PC com a gente! <br> A melhor opção na sua INTRANET.</h2>
                    <p>
                        Lorem ipsum lozaddwa moasdlamsldmasdkdfgdfmglkmdfmlgk
                        dfmkglmdflgmldkfmkgsmdfkldmslkfmsklmflksdmfklsmdfkmk
                        Lorem ipsum lozaddwa moasdlamsldmasdkdfgdfmglkmdfmlgk
                        dfmkglmdflgmldkfmkgsmdfkldmslkfmsklmflksdmfklsmdfkmk
                        Lorem ipsum lozaddwa moasdlamsldmasdkdfgdfmglkmdfmlgk
                        dfmkglmdflgmldkfmkgsmdfkldmslkfmsklmflksdmfklsmdfkmk
                    </p>
                    
                        <div id="botoes">   
                        <a href="Reparar.php" id="Relatar">Relatar problema</a>
                        <a href="Funcionarios.php" id="Funcionarios">Funcionarios</a>
                    </div>
                </div>
                
                <div id="direita">
                    <img src="img/notebook.png" alt="notebook">
                </div>
                
                
            </main>
        </div>

   
    </body>
</html>
<?php
    require_once(__DIR__ . '/../Config/auth.php');
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>Inicio</title>
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
                    <a href="Inicio.php" id="selecionado">
                        <i class="fa-solid fa-house-chimney"></i>
                        Inicio
                    </a>

                    <a href="ChamadosAdmin.php">
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

            <div id="ChamadosAdmin">
                <main>
                    <h1>Professor nao deu tempo!!</h1>
                    <p>Na parte de técnico só tem os Chamados</p>
                    <p>Você nao consegue acessar as outras paginas sem ser um cliente, pois aqui era pra ser uma parte só de tecnico.</p>
                    <p>Mas sendo cliente você consegue acessar todas.</p>
                </main>

            </div>
        </div>
    </body>
</html>
<?php
    session_start();

    /*
    if (!isset($_SESSION['usuario_id'])) {
        // se não tiver uma sessão ativa, voltar para o login
        header("Location: ../login_registro.php?painel=login");
    }
    */

    $id_user = $_SESSION['usuario_id'];
    include_once "config.php";

    $sql = "SELECT * FROM usuarios WHERE ID = $id_user";
    $resultado = $con->query($sql);

    if ($resultado->num_rows > 0) {
        $usuario = $resultado->fetch_assoc();
    }else {
        echo 'Ocorreu um erro.';
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>Equipe</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/config.css">
        <link rel="stylesheet" href="css/Conta.css">

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
                        <i class="fa-solid fa-hammer"></i>
                        Reparar
                    </a>

                    <a href="Funcionarios.php">
                        <i class="fa-solid fa-user-group"></i>
                        Funcionarios
                    </a>

                    <a href="Chamados.php">
                        <i class="fa-solid fa-phone"></i>
                        Chamados
                    </a>

                    <div class="inferior">
                        <a href="Conta.php" id="selecionado">
                            <i class="fa-solid fa-user"></i>
                            Conta
                        </a>
                        <a href="Conta.php">
                            <i class="fa-solid fa-arrow-right-from-bracket" ></i>
                            Sair
                        </a>
                    </div>
                </nav>
            </header>
        
            <div id="conta">
                <main>
                    <h1>Equipe</h1>
                    <div id="info_basicas">
                        <h2>Conheça a nossa equipe de colaboradores á sua disposição</h2>
                        <div id="foto_perfil">
                            <h2>Foto de perfil</h2>
                            <div id="imagem">
                                <div id="img">
                                    <img src="uploads/anexo_692f02ad25e2d.jpg" alt="">
                                </div>
                                <div id="img_text">
                                    <p>Enviar nova foto</p>
                                    <p><strong>Redefinir</strong></p>
                                </div>
                            </div> 
                        </div>
                        <!--Nome-->
                        <div class="linha"></div>
                        <div class="info">
                            <h2>Nome</h2>
                            <p><?php echo $_SESSION['usuario_nome']?></p>
                            <i class="fa-solid fa-angle-right"></i>
                        </div>
                        <!--Contato-->
                        <div class="linha"></div>
                        <div class="info">
                            <h2>Contato</h2>
                            <p><?php echo $usuario['contato']?></p>
                            <i class="fa-solid fa-angle-right"></i>
                        </div>
                        <div class="linha"></div>
                    </div>

                    <div id="info_conta">
                        <h2>Informações de conta</h2>
                        

                        <!--E-mail-->

                        <div class="info">
                            <h2>Email</h2>
                            <p><?php echo $usuario['email']?></p>
                            <i class="fa-solid fa-angle-right"></i>
                        </div>
                        <div class="linha"></div>
                        <!--Contato-->
                        <div class="info">
                            <h2>Senha</h2>
                            <p><?php echo $usuario['senha_hash']?></p>
                            <i class="fa-solid fa-angle-right"></i>
                        </div>
                        <div class="linha"></div>
                    </div>
                    </div>
                </main>
            </div>
        </div>

        <script src="js/Chamados.js"></script>
    </body>
</html>
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

    if ($_SERVER['REQUEST_METHOD'] === "POST") {
        $nome = $_POST['nomeusuario'] ?? "";
        $contato = $_POST['contato'] ?? "";
        $email = $_POST['email'] ?? "";
        $senha = $_POST['senha'] ?? "";

        include_once("config.php");

        if (!empty($nome))  {
            $sql = "UPDATE usuarios SET nome_completo = '$nome' WHERE ID = '$id_user';";
            $resultado = $con->query($sql);

            $_SESSION['usuario_nome'] = $nome;
        }

        if (!empty($contato)) {
            $sql = "UPDATE usuarios SET contato = '$contato' WHERE ID = '$id_user';";
            $resultado = $con->query($sql);
        }
        
        if (!empty($email)) {
            $sql = "UPDATE usuarios SET email = '$email' WHERE ID = '$id_user';";
            $resultado = $con->query($sql);
        }

        if (!empty($senha)) {
            $sql = "UPDATE usuarios SET email = '$email' WHERE ID = '$id_user';";
            $resultado = $con->query($sql);
        }

    }
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>Conta</title>
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
                    <h1>Configurações da Conta</h1>
                    <form action="Conta.php" method="POST" id="formConta">
                        <div id="info_basicas">
                            <h2>Informações basicas</h2>
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
                            <button type="button" class="info">
                                <h2>Nome</h2>
                                <p><?php echo $_SESSION['usuario_nome']?></p>
                                <i class="fa-solid fa-angle-right"></i>
                            </button>
                            <div class="botaooculto">
                                <h2>Digite um novo nome: </h2>
                                <input type="text" name="nomeusuario" id="nomeusuario">
                            </div>
                            <!--Contato-->
                            <div class="linha"></div>
                            <button type="button" class="info">
                                <h2>Contato</h2>
                                <p><?php echo $usuario['contato']?></p>
                                <i class="fa-solid fa-angle-right"></i>
                            </button>
                            <div class="botaooculto">
                                <h2>Informe um email ou número de contato:</h2>
                                <input type="text" name="contato" id="contato">
                            </div>
                            <div class="linha"></div>
                        </div>
                        <div id="info_conta">
                            <h2>Informações de conta</h2>
                        
                            <!--E-mail-->
                            <button type="button" class="info">
                                <h2>Email</h2>
                                <p><?php echo $usuario['email']?></p>
                                <i class="fa-solid fa-angle-right"></i>
                            </button>
                            <div class="botaooculto">
                                <h2>Informe um email novo:</h2>
                                <input type="text" name="email" id="email">
                            </div>
                            <div class="linha"></div>
                            <!--Contato-->
                            <button type="button" class="info">
                                <h2>Senha</h2>
                                <p><?php echo $usuario['senha_hash']?></p>
                                <i class="fa-solid fa-angle-right"></i>
                            </button>
                            <div class="botaooculto">
                                <h2>Informe uma senha nova:</h2>
                                <input type="text" name="senha" id="senha">
                            </div>
                            <div class="linha"></div>
                        </div>
                    </form>
                </main>

                <div id="barra-confirmacao">
                        <p id="textoAlteracao">Cuidado - Você tem alterações não salvas!</p>

                        <button type="button" id="cancelarAlteracao">Cancelar</button>
                        <button type="submit" form="formConta" id="Salvar">Salvar alterações</button>
                </div>
            </div>
        </div>

        <script src="js/Conta.js"></script>
    </body>
</html>
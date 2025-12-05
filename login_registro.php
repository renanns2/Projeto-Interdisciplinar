<?php

    session_start();

    $painel = $_GET['painel'] ?? '';

    //se ele já esta logado, ir para pagina de inicio
    if (isset($_SESSION['usuario_id'])) {
        header ("Location: Client/Inicio.php");
    }

    // se ele chegou a essa pagina por meio de um formulario com metodo post, prosseguir
    if($_SERVER["REQUEST_METHOD"] === "POST") { 

        $acao = $_POST['acao'] ?? "";
        $mensagens = [];

        if ($acao === 'registro') {
            include_once "Config/config.php"; 
            $email = $_POST['email'] ?? "";
            $senha = $_POST['senha'] ?? "";
            $nome = $_POST['nome'] ?? "";
            $cargo = $_POST['cargo'] ?? "";

            //Validação de dados
            if (empty($email)) {
                $mensagens[] = [
                    'tipo' => 'registro',
                    'status' => 'erro',
                    'texto' => 'Nenhum email informado.',
                ];
            }
            if (empty($senha)) {
                $mensagens[] = [
                    'tipo' => 'registro',
                    'status' => 'erro',
                    'texto' => 'Nenhuma senha informada.',
                ];
            }
            if (empty($nome)) {
                $mensagens[] = [
                    'tipo' => 'registro',
                    'status' => 'erro',
                    'texto' => 'Nenhum nome informado.',
                ];
            }
            if (empty($cargo)) {
                $mensagens[] = [
                    'tipo' => 'registro',
                    'status' => 'erro',
                    'texto' => 'Nenhum cargo selecionado',
                ];
            }

            if (empty($mensagens)) {
                // comando para selecionar usuarios da tabela onde o email informado é o mesmo
                $selecao = "SELECT ID FROM usuarios WHERE email = '$email'"; 
                // comando pra fazer esse comando no banco de dados
                $resultado = $con->query($selecao); 

                // se o número de linhas que veio for maior que 0, um email já existe.
                if ($resultado->num_rows > 0) { 
                    $mensagens[] = [
                        'tipo' => 'registro',
                        'status' => 'erro',
                        'texto' => 'Esse e-mail já está cadastrado.',
                    ];
                }else { // se nao tiver, inserir no banco de dados
                    // hash da senha pra mais segurança
                    $senha = password_hash(($senha), PASSWORD_DEFAULT); 

                    // comando para inserir o usuario
                    $sql = "INSERT INTO usuarios (nome_completo,email,senha_hash,tipo_usuario) 
                    VALUES ('$nome', '$email', '$senha', '$cargo');"; 

                    // se nao conseguiu se  cadastrar no banco de dados, informar um erro
                    if (!$con->query($sql)) { 
                        $mensagens[] = [
                            'tipo' => 'registro',
                            'status' => 'erro',
                            'texto' => 'Erro ao cadastrar: ' .$con->error,
                        ];
                    }else {
                        $mensagens[] = [
                            'tipo' => 'registro',
                            'status' => 'sucesso',
                            'texto' => 'Usuario cadastrado com sucesso!',
                        ];
                    }
                }
            }
            
        }else  if ($acao === 'login') {
            include_once "Config/config.php";

            $email = $_POST['email'] ?? ''; 
            $senha = $_POST['senha'] ?? '';

            if (empty($email)) {
                $mensagens[] = [
                    'tipo' => 'login',
                    'status' => 'erro',
                    'texto' => 'Nenhum email informado.',
                ];
            }
            if (empty($senha)) {
                $mensagens[] = [
                    'tipo' => 'login',
                    'status' => 'erro',
                    'texto' => 'Nenhuma senha informada.',
                ];
            }

            if (empty($mensagens)) {
                $selecao = "SELECT * FROM usuarios where email = '$email';";
                $resultado = $con->query($selecao);

                if ($resultado->num_rows > 0) {
                    $usuarios = $resultado->fetch_assoc();
                    $hash = $usuarios['senha_hash'];

                    if (password_verify($senha, $hash)) {
                        $_SESSION['usuario_id'] = $usuarios['ID'];
                        $_SESSION['usuario_nome'] = $usuarios['nome_completo'];
                        $_SESSION['usuario_tipo'] = $usuarios['tipo_usuario'];

                        $mensagens[] = [
                            'tipo' => 'login',
                            'status' => 'sucesso',
                            'texto' => 'Informações corretas! Login executado com sucesso.',
                        ];
                    }else {
                        $mensagens[] = [
                            'tipo' => 'login',
                            'status' => 'erro',
                            'texto' => 'Senha incorreta! Digite novamente!',
                        ];
                    }

                }else {
                    $mensagens[] = [
                        'tipo' => 'login',
                        'status' => 'erro',
                        'texto' => 'Esse e-mail ainda não foi cadastrado.',
                    ];
                }
            }
        }

    }
    
    
    
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="css/Login.css">
</head> 
<body>

    <main id="container" <?= $painel === 'registro' ? 'class="painel-direito-ativo"' : ''?>>
    
        <?php if (!empty($mensagens)) : ?>
            <div id="overlay"></div>
            <div id="caixa_mensagem">
                
                <?php 
                $tipo = $mensagens[0]['tipo'];
                $status = $mensagens[0]['status'];
                ?>
                <!--H1-->
                <h1>
                    <?php 
                        if ($tipo === 'registro' && $status === 'erro') {
                            echo 'Erro no sistema!';
                        }
                        if ($tipo === 'registro' && $status === 'sucesso') {
                            echo 'Registro concluído!';
                        }


                        if ($tipo === 'login' && $status === 'erro') {
                            echo 'Erro no login!';
                        }
                        if ($tipo === 'login' && $status === 'sucesso') {
                            echo 'Login bem-sucedido!';
                        }
                    ?>
                </h1>

                <!--H2-->
                <h2>
                    <?php
                        if ($tipo === 'registro' && $status === 'erro') {
                            echo 'Algo deu errado';
                        }

                        if ($tipo === 'registro' && $status === 'sucesso') {
                            echo 'Seja bem vindo(a) ao sistema!';
                        }

                        if ($tipo === 'login' && $status === 'erro') {
                            echo 'Não foi possivel acessar sua conta';
                        }

                        if ($tipo === 'login' && $status === 'sucesso') {
                            echo 'Acesso liberado';
                        }
                    ?>
                </h2>

                <!-- Mensagem !-->

                <?php 
                    foreach ($mensagens as $mensagem) { 
                        echo '<p>' . $mensagem['texto'] . '</p>';
                    }
                ?>


                <!-- Botão !-->
                <!--Erro Login -->
                <?php if ($status === 'erro' and $tipo === 'login'): ?>
                    <button onclick="ocultar();">Tentar novamente</button>
                <!--Sucesso Login -->
                <?php elseif ($status === 'sucesso' and $tipo === 'login') : ?>
                    <button onclick="location.href='Client/Inicio.php'">Continuar</button>

                <!--Erro Registro -->
                <?php elseif ($status === 'erro' and $tipo === 'registro') : ?>
                    <button onclick="ocultar();">Tentar novamente</button>
                <!--Sucesso Registro -->
                <?php elseif ($status === 'sucesso' and $tipo === 'registro') : ?>
                    <button onclick="
                        container.classList.remove('painel-direito-ativo');

                        setTimeout(() => {
                            logarForm.style.zIndex = '5';   
                            registroForm.style.zIndex = '1';
                        }, 300); 

                        ocultar();
                    ">Voltar para o Login</button>
                <?php endif; ?>
            </div>

            <script>
                const caixamsg = document.getElementById("caixa_mensagem");
                const overlay = document.getElementById("overlay"); 

                setTimeout(() => {
                caixamsg.classList.add('ativo');
                overlay.classList.add('ativo');
                }, 50);

                function ocultar() {
                    caixamsg.classList.remove('ativo');
                    overlay.classList.remove('ativo');

                    setTimeout(() => {
                        caixamsg.remove();
                        overlay.remove();
                    }, 300);
                }

            </script>
        <?php endif; ?>


            <!--Login-->
        <section class="formulario login"  <?= $painel === 'registro' ? 'style="z-index:1"' : ''?>>
            <h1>Faça Login</h1>
            <p>Use sua conta existente</p>
        
            <form method="POST" action="login_registro.php?painel=login">
                <input type="hidden" name="acao" value="login"> <!--identificar no php qual é formulario e registro-->

                <div class="grupo-input">
                    <label for="email-login">E-mail</label>
                    <input type="email" name="email" id="email-login" required>
                </div>
                <div class="grupo-input">
                    <label for="senha-login">Senha</label>
                    <input type="password" name="senha" id="senha-login" required>
                </div>

                <button type="submit">Enviar</button>
            </form>
        </section>
        <!--Registro-->
        <section class="formulario registro" <?= $painel === 'registro' ? 'style="z-index:5"' : '' ?>>
            <h1>Faça Registro</h1>
            <p>Crie uma conta</p>
        
            <form method="POST" action="login_registro.php?painel=registro">
                <input type="hidden" name="acao" value="registro"> <!--identificar no php qual é formulario e registro-->

                <div class="grupo-input">
                    <label for="email-registro">E-mail</label>
                    <input type="email" name="email" id="email-registro" required>
                </div>
                <div class="grupo-input">
                    <label for="senha-registro">Senha</label>
                    <input type="password" name="senha" id="senha-registro" required>
                </div>
                <div class="grupo-input">
                    <label for="nome">Nome Completo</label>
                    <input type="text" name="nome" id="nome" required>
                </div>

                <div class="grupo-input"> 
                    <label for="cargo">Selecione um cargo</label>
                    <select name="cargo" id="cargo">
                        <option value="requisitante">Requisitante</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <button type="submit">Enviar</button>
            </form>
        </section>


        <div class="container-barralateral">
            <div class="barra-lateral">
                <section class="painel-lateral barra-esquerda">
                    <h1>Logue-se</h1>
                    <p>Volte a apreciar nossos serviços e repare seu PC novamente!</p>

                    <button class="ghost" id="logar">Logar</button>
                </section>

                <section class="painel-lateral barra-direita">

                    <h1>Registre-se</h1>

                    <p>Crie uma conta para futuros reparos e aproveite nossos serviços!</p>

                    <button class="ghost" id="registrar">Registrar</button>
                </section>
            </div>
        </div>

    </main>

    <script src="js/Login.js"></script>
</body>
</html>
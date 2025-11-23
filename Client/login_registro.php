<?php
    // se ele chegou a essa pagina por meio de um formulario com metodo post, prosseguir
    if($_SERVER["REQUEST_METHOD"] === "POST") { 

        $acao = $_POST['acao'] ?? "";
        $mensagens = [];

        if ($acao === 'registro') {
            include_once "config.php"; 
            $email = $_POST['email'] ?? "";
            $senha = $_POST['senha'] ?? "";
            $nome = $_POST['nome'] ?? "";
            $cargo = $_POST['cargo'] ?? "";

            //Validação de dados
            if (empty($email)) {
                $mensagens[] = 'Nenhum e-mail informado';
            }
            if (empty($senha)) {
                $mensagens[] = 'Nenhuma senha informada';
            }
            if (empty($nome)) {
                $mensagens[] = 'Nenhum nome informado';
            }
            if (empty($cargo)) {
                $mensagens[] = 'Nenhum cargo informado';
            }

            if (empty($mensagens)) {
                // comando para selecionar usuarios da tabela onde o email informado é o mesmo
                $selecao = "SELECT ID FROM usuarios WHERE email = '$email'"; 
                // comando pra fazer esse comando no banco de dados
                $resultado = $con->query($selecao); 

                // se o número de linhas que veio for maior que 0, um email já existe.
                if ($resultado->num_rows > 0) { 
                    $mensagens[] = 'Esse email já está cadastrado!';
                }else { // se nao tiver, inserir no banco de dados
                    // hash da senha pra mais segurança
                    $senha = password_hash(($senha), PASSWORD_DEFAULT); 

                    // comando para inserir o usuario
                    $sql = "INSERT INTO usuarios (nome_completo,email,senha_hash,tipo_usuario) 
                    VALUES ('$nome', '$email', '$senha', '$cargo');"; 

                    // se nao conseguiu se  cadastrar no banco de dados, informar um erro
                    if (!$con->query($sql)) { 
                        $mensagens[] = 'Erro ao cadastrar: ' .$con->error;
                    }else {
                        $mensagens[] = 'Usuario cadastrado com sucesso!';
                    }
                }
            }
            
        }else  if ($acao === 'login') {
            include_once "config.php";

            $email = $_POST['email'] ?? '';
            $senha = $_POST['senha'] ?? '';

            if (empty($email)) {
                $mensagens[] = "Nenhum email informado.";
            }
            if (empty($senha)) {
                $mensagens[] = "Nenhuma senha informada.";
            }

            if (empty($mensagens)) {
                $selecao = "SELECT * FROM usuarios where email = '$email';";
                $resultado = $con->query($selecao);

                if ($resultado->num_rows > 0) {
                    $usuarios = $resultado->fetch_assoc();
                    $hash = $usuarios['senha_hash'];

                    if (password_verify($senha, $hash)) {
                        $mensagens[] = "Informações corretas! Login executado com sucesso.";
                    }else {
                        $mensagens[] = "Senha incorreta! Digite novamente!";
                    }

                }else {
                    $mensagens[] = "Esse e-mail ainda não foi cadastrado.";
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

    <link rel="stylesheet" href="css/Login.css">
</head>
<body>

    <main id="container">
    
    <?php if (!empty($mensagens)) : ?>
        <div id="caixa_mensagem">
            <h1>Informações do registro</h1>
            <?php 
                foreach ($mensagens as $mensagem) { 
                    echo "<p> $mensagem </p>";
                }
            ?>
        </div>
    <?php endif; ?>

            <!--Login-->
        <section class="formulario login">
            <h1>Faça Login</h1>
            <p>Use sua conta existente</p>
        
            <form method="POST" action="login_registro.php#login">
                <input type="hidden" name="acao" value="login"> <!--identificar no php qual é formulario e registro-->

                <div class="grupo-input">
                    <label for="email-login">E-mail</label>
                    <input type="email" name="email" id="email-login">
                </div>
                <div class="grupo-input">
                    <label for="senha-login">Senha</label>
                    <input type="password" name="senha" id="senha-login">
                </div>

                <button type="submit">Enviar</button>
            </form>
        </section>
        <!--Registro-->
        <section class="formulario registro">
            <h1>Faça Registro</h1>
            <p>Crie uma conta</p>
        
            <form method="POST" action="login_registro.php#registro">
                <input type="hidden" name="acao" value="registro"> <!--identificar no php qual é formulario e registro-->

                <div class="grupo-input">
                    <label for="email-registro">E-mail</label>
                    <input type="email" name="email" id="email-registro">
                </div>
                <div class="grupo-input">
                    <label for="senha-registro">Senha</label>
                    <input type="password" name="senha" id="senha-registro">
                </div>
                <div class="grupo-input">
                    <label for="nome">Nome Completo</label>
                    <input type="text" name="nome" id="nome">
                </div>

                <div class="grupo-input"> 
                    <label for="cargo">Selecione um cargo</label>
                    <select name="cargo" id="cargo">
                        <option value="cliente">Cliente</option>
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
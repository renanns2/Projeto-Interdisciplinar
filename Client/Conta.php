<?php
    require_once(__DIR__ . '/../Config/auth.php');

    $mensagens = $_SESSION['mensagens'] ?? [];
    unset($_SESSION['mensagens']);

    $tamanho_maximo = 2 * 1024 * 1024;
    $tipos_permitidos = ['image/jpeg', 'image/png'];

    if ($_SERVER['REQUEST_METHOD'] === "POST") {
        $foto_perfil = $_FILES['inputImagem'] ?? null;
        $nome = $_POST['nomeusuario'] ?? "";
        $contato = $_POST['contato'] ?? "";
        $email = $_POST['email'] ?? "";
        $senha_antiga = $_POST['senha_antiga'] ?? "";
        $senha_nova = $_POST['senha_nova'] ?? "";
        $redefinir_hidden = $_POST['redefinir_hidden'] ?? "";
        $tipo_conta = $_POST['tipo'] ?? "";

        //Anexo
        if (isset($foto_perfil) && $foto_perfil['error'] !== UPLOAD_ERR_NO_FILE) {
            //se o upload deu certo tudinho
            if ($foto_perfil['error'] === UPLOAD_ERR_OK) {
                
                //Passou o tamanho maximo
                if($foto_perfil['size'] > $tamanho_maximo) {   
                    $mensagens[] = [
                        'tipo' => 'erro',
                        'mensagem' => 'O arquivo é muito grande!',
                    ];

                    $foto_perfil = null;
                //Não esta entre os tipos permitidos
                }else if (!in_array($foto_perfil['type'], $tipos_permitidos)){
                    $mensagens[] = [
                        'tipo' => 'erro',
                        'mensagem' => 'Tipo não permitido: '. $foto_perfil['type'],
                    ];
                    
                    $foto_perfil = null;
                //Deu tudo certo
                }else {
                    $ext = pathinfo($foto_perfil['name'], PATHINFO_EXTENSION); // pegar a extensão da imagem(jpg ou png, etc.)
                    $arquivo_final = uniqid("anexo_") . "." . $ext; // criar um id unico depois de anexo_(id unico) e concatenar com a variavel de ponto final do arquivo.
                    move_uploaded_file($foto_perfil['tmp_name'], "../uploads/foto_perfil/". $arquivo_final); // o PHP cria um arquivo de nome temporario ate o arquivo ser movido, e esse é mracado pelo "tmp_name". Nós estamos movendo esse arquivo para "uploads/", e colocando o nome dele final.

                    //excluindo imagem antiga
                    $imagem_antiga = "../uploads/foto_perfil/" . $usuario['foto_perfil'];
                    if ($imagem_antiga !== "../uploads/foto_perfil/SemFoto.jpg") {
                        if (file_exists($imagem_antiga)) {
                            unlink($imagem_antiga);
                        }
                    }
                    $sql = "UPDATE usuarios SET foto_perfil = '$arquivo_final' WHERE ID = '$id_user';";
                    $resultado = $con->query($sql);
                    $usuario['foto_perfil'] = $arquivo_final;
                    $mensagens[] = [
                        'tipo' => 'sucesso',
                        'mensagem'=> 'Foto enviada corretamente!',
                    ];
                }
            // se o upload deu errado
            }else {
                $foto_perfil = null;

                $mensagens[] = [    
                    'tipo' => 'erro',
                    'mensagem' => 'Ocorreu um erro no upload da imagem.',
                ];
            }
        }

        if (!empty($nome))  {
            $nome_banco = $usuario['nome_completo'];

            if ($nome !== $nome_banco) {
                $sql = "UPDATE usuarios SET nome_completo = '$nome' WHERE ID = '$id_user';";
                $resultado = $con->query($sql);

                $_SESSION['usuario_nome'] = $nome;
                
                $mensagens[] = [
                    'tipo' => 'sucesso',
                    'mensagem' => 'Nome trocado com sucesso!',
                ];   
            }else {
                $mensagens[] = [
                    'tipo' => 'erro',
                    'mensagem' => 'O nome é igual ao que está registrado!',
                ]; 
            }         
        }

        if (!empty($contato)) {
            $contato_banco = $usuario['contato'];

            if ($contato !== $contato_banco) {
                $sql = "UPDATE usuarios SET contato = '$contato' WHERE ID = '$id_user';";
                $resultado = $con->query($sql);

                $mensagens[] = [
                    'tipo' => 'sucesso',
                    'mensagem' => 'Contato trocado com sucesso!',
                ];   
            }else {
                $mensagens[] = [
                    'tipo' => 'erro',
                    'mensagem' => 'O contato é igual ao que está registrado!',
                ]; 
            }      
        }
        
        if (!empty($email)) {
            $email_banco = $usuario['email'];

            //Verificar se o email existe em outra conta.
            $sql_existe = "SELECT ID FROM usuarios where email = '$email' AND ID <> '$id_user'";
            $res_existe = $con->query($sql_existe);

            if($res_existe->num_rows > 0) {
                $mensagens[] = [
                    'tipo' => 'erro',
                    'mensagem' => 'Esse email está sendo utilizado por outra conta!',
                ]; 
            }else {
                if ($email !== $email_banco) {
                    $sql = "UPDATE usuarios SET email = '$email' WHERE ID = '$id_user';";
                    $resultado = $con->query($sql);
    
                    $mensagens[] = [
                        'tipo' => 'sucesso',
                        'mensagem' => 'E-mail trocado com sucesso!',
                    ];   
                }else {
                    $mensagens[] = [
                        'tipo' => 'erro',
                        'mensagem' => 'O email é igual ao que está registrado!',
                    ]; 
                }       
                
            }

        }

        if (!empty($senha_antiga) && !empty($senha_nova)) {
            $senha_banco = $usuario['senha_hash'];

            if (password_verify($senha_antiga, $senha_banco)) {
                $hash = password_hash($senha_nova, PASSWORD_DEFAULT);
                $sql = "UPDATE usuarios SET senha_hash = '$hash' WHERE ID = '$id_user';";           
                $resultado = $con->query($sql);

                $mensagens[] = [
                    'tipo' => 'sucesso',
                    'mensagem' => 'Senha trocada com sucesso!',
                ];   
            }else {
                $mensagens[] = [
                    'tipo' => 'erro',
                    'mensagem' => 'A sua senha está incorreta!',
                ];   
            }
        }else if (!empty($senha_antiga) && empty($senha_nova)) {
            $mensagens[] = [
                'tipo' => 'erro',
                'mensagem' => 'Informe a senha nova também!',
            ];   
        }else if (!empty($senha_nova) && empty($senha_antiga)) {
            $mensagens[] = [
                'tipo' => 'erro',
                'mensagem' => 'Informe a senha antiga!',
            ];  
        }

        if ($redefinir_hidden == 1) {
            $imagem_antiga = "../uploads/foto_perfil/" . $usuario['foto_perfil'];
            if ($imagem_antiga !== "../uploads/foto_perfil/SemFoto.jpg") {
                if (file_exists($imagem_antiga)) {
                    unlink($imagem_antiga);

                    $sql = "UPDATE usuarios SET foto_perfil = 'SemFoto.jpg' WHERE ID = '$id_user';";
                    $resultado = $con->query($sql);
                }
            }
        }

        if (!empty($tipo_conta)) {
            $sql_tipo = "SELECT tipo_usuario FROM usuarios WHERE ID = $id_user;";
            $consulta = $con->query($sql_tipo);
            $row = $consulta->fetch_assoc();
            $tipo_atual = $row['tipo_usuario'];
            if ($tipo_atual === $tipo_conta) {
                $mensagens[] = [
                    'tipo' => 'erro',
                    'mensagem' => 'Esse tipo já é o tipo atual da conta',
                ];
            }else {
                $sql = "UPDATE usuarios SET tipo_usuario = '$tipo_conta' WHERE ID = '$id_user';";

                $resultado = $con->query($sql);

                if ($resultado) { 
                    $usuario['tipo_usuario'] = $tipo_conta; 
                    $mensagens[] = [
                        'tipo' => 'sucesso',
                        'mensagem' => 'Tipo de conta atualizado com sucesso!',
                    ];
                }else {
                    $mensagens[] = [
                        'tipo' => 'erro',
                        'mensagem' => 'Erro ao atualizar tipo de conta.',
                    ];
                }
            }
        }

        $_SESSION['mensagens'] = $mensagens;
        header ("Location: Conta.php");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>Conta</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon">
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
                        <a href="logout.php">
                            <i class="fa-solid fa-arrow-right-from-bracket" ></i>
                            Sair
                        </a>
                    </div>
                </nav>
            </header>
        
            <?php if (!empty($mensagens)) {
                    $tipos = array_column($mensagens, 'tipo'); // pegando apenas o tipo da array

                    if (!in_array('erro', $tipos)) { // verificando se tem algum erro
                        $h1 = "Sucesso!";
                    }else {
                        $h1 = "Erro!";
                    }?>
                <div id="overlay"></div>
                <div id="caixa_mensagem">
                    <?php
                        echo "<h1> $h1 </h1>";
                        foreach($mensagens as $mensagem) {
                            echo "<p>" . $mensagem['mensagem'] ."</p>";
                        }
                    ?>
                    
                    <?php if ($h1 === 'Erro!') { ?>
                        <a href="Conta.php">Tentar novamente</a>
                    <?php }else if ($h1 === 'Sucesso!') { ?>
                        <a href="Conta.php">Fechar</a>
                    <?php } ?>
                </div>
            <?php } ?>
            <div id="conta">
                <main>
                    <h1>Configurações da Conta</h1>
                    <form action="Conta.php" method="POST" id="formConta" enctype="multipart/form-data">
                        <div id="info_basicas">
                            <h2>Informações basicas</h2>
                            <div id="foto_perfil">
                                <h2>Foto de perfil</h2>
                                <div id="imagem">
                                    <div id="img">
                                        <img src="../uploads/foto_perfil/<?php echo $usuario['foto_perfil']?>" alt="Imagem_Perfil" id="img_perfil">
                                    </div>
                                    <div id="img_text">
                                        <p id="abrirUpload">Enviar nova foto</p>
                                        <input type="file" id="inputImagem" accept="image/*" style="display:none" name="inputImagem">
                                        <button type="button" id="redefinir">
                                            <strong>Redefinir</strong>
                                        </button>
                                        <input type="hidden" name="redefinir_hidden" id="redefinir_hidden" value=0>

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
                                <h2><label for="nomeusuario">Digite um novo nome: </label></h2>
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
                                <h2><label for="contato">Informe um email ou número de contato:</label></h2>
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
                                <h2><label for="email">Informe um email novo:</label></h2>
                                <input type="email" name="email" id="email">
                            </div>
                            <div class="linha"></div>
                            <!--Senha-->
                            <button type="button" class="info">
                                <h2>Senha</h2>
                                <p>*************</p>
                                <i class="fa-solid fa-angle-right"></i>
                            </button>
                            <div class="botaooculto">

                                <div id="senhas">
                                    <div id="senha_antiga_container">
                                        <h2><label for="senha_antiga">Informe sua senha atual:</label></h2>
                                        <input type="password" name="senha_antiga" id="senha_antiga">
                                    </div>
                                    <div id="senha_nova_container">
                                        <h2><label for="senha_nova">Informe a nova senha:</label></h2>
                                        <input type="password" name="senha_nova" id="senha_nova">
                                    </div>
                                </div>
                            </div>
                            <div class="linha"></div>

                            <!--Tipo de Conta-->
                            <button type="button" class="info">
                                <h2>Tipo de conta</h2>
                                <p><?php echo ucfirst($usuario['tipo_usuario'])?></p>
                                <i class="fa-solid fa-angle-right"></i>
                            </button>
                            <div class="botaooculto">
                                <h2><label for="tipo">Selecione uma opção:</label></h2>
                                <select name="tipo" id="tipo" data-original="<?php echo $usuario['tipo_usuario']?>">
                                    <option value="requisitante">Requisitante</option>
                                    <option value="admin">Admin</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </main>

                <div id="barra-confirmacao">
                        <p id="textoAlteracao">Cuidado - Você tem alterações não salvas!</p>

                        <div id="btns">
                            <button type="button" id="cancelarAlteracao">Cancelar</button>
                            <button type="submit" form="formConta" id="Salvar">Salvar alterações</button>
                        </div>
                </div>
            </div>
        </div>

        <script src="js/Conta.js"></script>
    </body>
</html>
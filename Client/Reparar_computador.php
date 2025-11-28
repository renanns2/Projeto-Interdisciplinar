<?php
    session_start();

    /*
    if (!isset($_SESSION['usuario_id'])) {
        // se não tiver uma sessão ativa, voltar para o login
        header("Location: login_registro.php?painel=login");
    }
    */

    $mensagens = [];

    $tamanho_maximo = 2 * 1024 * 1024;
    $tipos_permitidos = ['image/jpeg', 'image/png'];

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $numeropc = $_POST["numeropc"] ?? "";
        $numerolab = $_POST["numerolab"] ?? "";
        $descricao = $_POST["descricao"] ?? "";
        $data = $_POST["data_ocorrido"] ?? "";
        $urgencia = $_POST["urgencia"] ?? "";

        $anexo = $_FILES["anexo"];

        if (isset($anexo) && $anexo['error'] === UPLOAD_ERR_OK) {
            
            if($anexo['file'] > $tamanho_maximo) {   
                $mensagens = [
                    'status' => 'erro',
                    'mensagem' => 'O arquivo é muito grande!',
                ];

                $anexo = null;
            }else if ($anexo != null && !in_array($anexo['type'], $tipos_permitidos)){
                $mensagens = [
                    'status' => 'erro',
                    'mensagem' => 'Ocorreu um erro no upload do arquivo. Codigo: ' . $anexo['error'],
                ];
                
                $anexo = null;
            }else {
                $anexo = null;
            }

        }else {
            $anexo = null;
        }
        
    }

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

                    <a href="Reparar.php" id="selecionado">
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
                    
                    <form method="POST" action="" enctype="multipart/form-data">
                        <div class="duplaselecao">
                            <div class="grupo-input">
                                <label for="numeropc">Numero do PC</label>
                                <input type="number" name="numeropc" id="numeropc" min="0" value="0">
                            </div>

                            <div class="grupo-input">
                                <label for="numerolab">Laboratorio do PC</label>
                                <input type="number" name="numerolab" id="numerolab" min="0" value="0">
                            </div>
                        </div>

                        <div class="grupo-input">
                                <label for="descricao">Descrição do problema</label>
                                <textarea name="descricao" id="descricao" required></textarea>
                        </div>

                        <div class="duplaselecao">
                            <div class="grupo-input">
                                <label for="data_ocorrido">Data do ocorrido</label>
                                <input type="date" name="data_ocorrido" id="data_ocorrido">
                            </div>

                            <div class="grupo-input">
                                <label for="urgencia">Urgência</label>
                                <select name="urgencia" id="urgencia">
                                    <option value="baixa">Baixa</option>
                                    <option value="media">Média</option>
                                    <option value="alta">Alta</option>
                                </select>
                            </div>
                        </div>

                        <div class="grupo-input">
                                <label for="anexo">Anexo</label>
                                <input type="file" name="anexo" id="anexo" accept="image/*">
                        </div>

                        <div id="botao">
                            <button type="submit">Enviar</button>
                        </div>

                    </form>
                </main>
            </div>
        </div>

   
    </body>
</html>
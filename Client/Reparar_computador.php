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
    $tipos_permitidos = ['image/jpeg', 'image/png', 'image/jpg'];

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $numeropc = $_POST["numeropc"] ?? "";
        $numerolab = $_POST["numerolab"] ?? "";
        $descricao = $_POST["descricao"] ?? "";
        $data = $_POST["data_ocorrido"] ?? "";
        $urgencia = $_POST["urgencia"] ?? "";

        $anexo = $_FILES["anexo"];
        
        $arquivo_final = null;

        if (isset($anexo) && $anexo['error'] !== UPLOAD_ERR_NO_FILE) {
            if ($anexo['error'] === UPLOAD_ERR_OK) {
                
                if($anexo['size'] > $tamanho_maximo) {   
                    $mensagens[] = [
                        'status' => 'erro',
                        'mensagem' => 'O arquivo é muito grande!',
                    ];

                    $anexo = null;
                }else if (!in_array($anexo['type'], $tipos_permitidos)){
                    $mensagens[] = [
                        'status' => 'erro',
                        'mensagem' => 'Ocorreu um erro no upload do arquivo. Codigo: ' . $anexo['error'],
                    ];
                    
                    $anexo = null;
                }else {
                    $ext = pathinfo($anexo['name'], PATHINFO_EXTENSION); // pegar a extensão da imagem(jpg ou png, etc.)
                    $arquivo_final = uniqid("anexo_") . "." . $ext; // criar um id unico depois de anexo_(id unico) e concatenar com a variavel de ponto final do arquivo.
                    move_uploaded_file($anexo['tmp_name'], "uploads/". $arquivo_final); // o PHP cria um arquivo de nome temporario ate o arquivo ser movido, e esse é mracado pelo "tmp_name". Nós estamos movendo esse arquivo para "uploads/", e colocando o nome dele final.
                }
            }else {
                $anexo = null;

                $mensagens[] = [
                    'status' => 'erro',
                    'mensagem' => 'Ocorreu um erro no upload da imagem.',
                ];
            }
        }

        if(empty($numeropc)) {
            $mensagens[] = [
                'status' => 'erro',
                'mensagem' => 'O número do PC não foi informado.',
            ];
        }
        if(empty($numerolab)) {
            $mensagens[] = [
                'status' => 'erro',
                'mensagem' => 'O número do laboratório não foi informado.',
            ];
        }
        if(empty($descricao)) {
            $mensagens[] = [
                'status' => 'erro',
                'mensagem' => 'Nenhuma descriçao foi informada.',
            ];
        }

        $erros = false;
        //Verificando se tem erros
        if (!empty($mensagens)) {

            foreach ($mensagens as $m) {
                if ($m['status'] === 'erro') {
                    $erros = true;
                    break;
                }
           }   
        }
        

        //Inserir no banco
        if (!$erros) {
            include_once "config.php";
            $solicitante = $_SESSION['usuario_nome'];
            $id_solicitante = $_SESSION['usuario_id'];

            $sql = "INSERT INTO chamados(tipo, solicitante, data_ocorrido, urgencia, status, anexo, descricao, ID_Solicitante) VALUES('computador', '$solicitante', '$data', '$urgencia', 'Aberto', '$arquivo_final', '$descricao', '$id_solicitante');";

            $chamado = $con->query($sql);
            
            if ($chamado) {
                $idChamado = $con->insert_id;
                
                //Dados computador
                $sql = "INSERT INTO chamado_computador(id_chamado, numero_lab, numero_pc) VALUES ('$idChamado', '$numerolab', '$numeropc');";
                $computador = $con->query($sql);

                if ($computador) {
                    $mensagens[] = [
                        'status' => 'sucesso',
                        'mensagem' => 'Chamado executado com sucesso! ID do chamado: ' . $idChamado . '.',
                    ];
                }
            }
        }

        if (!empty($mensagens)) {
            foreach ($mensagens as $m) {
                echo "<p>{$m['mensagem']}</p>";
            }
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
                                <input type="number" name="numeropc" id="numeropc" min="1" required>
                            </div>

                            <div class="grupo-input">
                                <label for="numerolab">Laboratorio do PC</label>
                                <input type="number" name="numerolab" id="numerolab" min="1" required>
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
                                <select name="urgencia" id="urgencia" value="baixa">
                                    <option value="baixa">Baixa</option>
                                    <option value="media">Média</option>
                                    <option value="alta">Alta</option>
                                </select>
                            </div>
                        </div>

                        <div class="grupo-input">
                                <label for="anexo">Anexo</label>
                                <div id="img">
                                    <input type="file" name="anexo" id="anexo" accept="image/*">
                                    <img alt="Preview_Anexo" id="preview">
                                </div>
                        </div>

                        <div id="botao">
                            <button type="submit">Enviar</button>
                        </div>

                    </form>
                </main>
            </div>
        </div>

        <script src="js/reparar_form.js"></script>
    </body>
</html>
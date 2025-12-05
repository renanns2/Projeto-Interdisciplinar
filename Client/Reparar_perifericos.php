<?php
    require_once(__DIR__ . '/../Config/auth.php');
    require_once(__DIR__ . '/../Config/redirectadmin.php');

    $mensagens = [];

    $tamanho_maximo = 2 * 1024 * 1024;
    $tipos_permitidos = ['image/jpeg', 'image/png', 'image/jpg'];

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $tipo_periferico = $_POST["tipo_periferico"] ?? "";
        $numero = $_POST["numero"] ?? "";
        $setor_lab = $_POST["setor_lab"] ?? "";
        $descricao = $_POST["descricao"] ?? "";
        $data = $_POST["data_ocorrido"] ?? "";
        $urgencia = $_POST["urgencia"] ?? "";
        $tipo_personalizado = $_POST["tipo_personalizado"] ?? "";

        $anexo = $_FILES["anexo"];
        
        $arquivo_final = null;

        //Verificando se tem ERRO no Anexo
        //Se tem um anexo e ele não está com erro de nenhum arquivo entao continuar
        if (isset($anexo) && $anexo['error'] !== UPLOAD_ERR_NO_FILE) {
            //se o upload deu certo tudinho
            if ($anexo['error'] === UPLOAD_ERR_OK) {
                
                //Passou o tamanho maximo
                if($anexo['size'] > $tamanho_maximo) {   
                    $mensagens[] = [
                        'status' => 'erro',
                        'mensagem' => 'O arquivo é muito grande!',
                    ];

                    $anexo = null;
                //Não esta entre os tipos permitidos
                }else if (!in_array($anexo['type'], $tipos_permitidos)){
                    $mensagens[] = [
                        'status' => 'erro',
                        'mensagem' => 'Ocorreu um erro no upload do arquivo. Codigo: ' . $anexo['error'],
                    ];
                    
                    $anexo = null;
                //Deu tudo certo
                }else {
                    $ext = pathinfo($anexo['name'], PATHINFO_EXTENSION); // pegar a extensão da imagem(jpg ou png, etc.)
                    $arquivo_final = uniqid("anexo_") . "." . $ext; // criar um id unico depois de anexo_(id unico) e concatenar com a variavel de ponto final do arquivo.
                    move_uploaded_file($anexo['tmp_name'],  "../uploads/foto_chamados/". $arquivo_final); // o PHP cria um arquivo de nome temporario ate o arquivo ser movido, e esse é mracado pelo "tmp_name". Nós estamos movendo esse arquivo para "uploads/", e colocando o nome dele final.
                }
            //Se tem 
            // se o upload deu errado
            }else {
                $anexo = null;

                $mensagens[] = [    
                    'status' => 'erro',
                    'mensagem' => 'Ocorreu um erro no upload da imagem.',
                ];
            }
        }

        //Validação de dados
        if(empty($tipo_periferico)) {
            $mensagens[] = [
                'status' => 'erro',
                'mensagem' => 'Informe um tipo de periferico!',
            ];
        }
        if(empty($setor_lab)) {
            $mensagens[] = [
                'status' => 'erro',
                'mensagem' => 'O laboratorio ou setor não foi informado.',
            ];
        }
        if(empty($descricao)) {
            $mensagens[] = [
                'status' => 'erro',
                'mensagem' => 'Nenhuma descriçao foi informada.',
            ];
        }
        if(empty($tipo_personalizado)) {
            $tipo_personalizado = null;
        }
        if(empty($data)) {
            $mensagens[] = [
                'status' => 'erro',
                'mensagem' => 'Por favor, forneça uma data do ocorrido!',
            ];
        }

        //Verificando se na array mensagens tem algum erro.
        //No codigo atual é impossivel se a variavel $mensagens existir não for um erro, mas pode ser algo pra pensar no futuro
        $erros = false;
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
            $solicitante = $_SESSION['usuario_nome'];
            $id_solicitante = $_SESSION['usuario_id'];

            $sql = "INSERT INTO chamados(tipo, solicitante, data_ocorrido, urgencia, status, anexo, descricao, ID_Solicitante, setor_lab) VALUES('perifericos', '$solicitante', '$data', '$urgencia', 'Aberto', '$arquivo_final', '$descricao', '$id_solicitante', '$setor_lab');";

            $chamado = $con->query($sql);
            
            if ($chamado) {
                $idChamado = $con->insert_id;
                
                //Dados perifericos
                $sql = "INSERT INTO chamado_perifericos(id_chamado, numero, tipo_periferico, tipo_personalizado) VALUES ('$idChamado', '$numero', '$tipo_periferico', '$tipo_personalizado');";
                $perifericos = $con->query($sql);

                if ($perifericos) {
                    $mensagens[] = [
                        'status' => 'sucesso',
                        'mensagem' => 'Chamado executado com sucesso! ID do chamado: ' . $idChamado . '.',
                    ];
                }else { // Inseriu em chamado mas nao em chamado_perifericos -> Excluir o registro anterior
                    $sql = "DELETE FROM `chamados` WHERE `chamados`.`ID` = $idChamado;";
                    $perifericos = $con->query($sql);

                    $mensagens[] = [
                        'status' => 'erro',
                        'mensagem' => 'Erro ao inserir na tabela chamados_perifericos! Verifique o banco de dados ou fale com um administrador do site.',
                    ];
                }
            }
        }

        // Define que as respostas que irei enviar a partir de agora vai ser em JSON.
        header("Content-Type: application/json");
        // Agora a gnt ta voltando a resposta pro servidor JS, uma resposta JSON.
        echo json_encode($mensagens);
        exit;
    }

?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>Reparar</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon">
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


            <div id="overlay"></div>
            <div id="caixa_mensagem"></div>

        
            <div id="reparar">
                <main>

                    <h1>PERIFERICOS</h1>
                    <h2>Insira os detalhes do defeito</h2>
                    
                    <form method="POST" action="" enctype="multipart/form-data" id="form" data-action="Reparar_perifericos.php">
                        <div class="duplaselecao">
                            <div class="grupo-input">
                                <label for="tipo_perso">Tipo de periferico</label>
                                <select name="tipo_periferico" id="tipo_perso" value="">
                                    <option value="" selected disabled>Selecione uma opção</option>
                                    <option value="mouse">Mouse</option>
                                    <option value="teclado">Teclado</option>
                                    <option value="som/headset">Som/Headset</option>
                                    <option value="outro">Outro</option>
                                </select>
                            </div>

                            <div class="grupo-input">
                                <label for="numero">Numero(se houver)</label>
                                <input type="number" name="numero" id="numero" placeholder="Ex: 2">
                            </div>
                        </div>

                        <div class="grupo-input" id="outro_input">
                            <label for="tipo_personalizado" id="outroTexto">Especifique:</label>
                            <input type="text" id="tipo_personalizado" name="tipo_personalizado" placeholder="Digite um tipo especifico aqui." maxlength="100">
                        </div>

                        <div class="grupo-input">
                                <label for="setor_lab">Laboratório ou Setor</label>
                                <input type="text" name="setor_lab" id="setor_lab" required placeholder="Ex: SalaMaker">
                        </div>

                        <div class="grupo-input">
                                <label for="descricao">Descrição do problema</label>
                                <textarea name="descricao" id="descricao" required placeholder="Ex: O monitor não está funcionando"></textarea>
                        </div>

                        <div class="duplaselecao">
                            <div class="grupo-input">
                                <label for="data_ocorrido">Data do ocorrido</label>
                                <input type="date" name="data_ocorrido" id="data_ocorrido" min="2025-01-01" required>
                            </div>

                            <div class="grupo-input">
                                <label for="urgencia">Urgência</label>
                                <select name="urgencia" id="urgencia">
                                    <option value="" selected disabled>Selecione uma opção</option>
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
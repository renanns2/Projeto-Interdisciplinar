<?php
    session_start();

    /*
    if (!isset($_SESSION['usuario_id'])) {
        // se não tiver uma sessão ativa, voltar para o login
        header("Location: login_registro.php?painel=login");
    }
    */

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
                    <h1>OUTROS</h1>
                    <h2>Insira os detalhes do defeito</h2>
                    
                    <form method="GET" action="">
                        <div class="duplaselecao">
                            <div class="grupo-input">
                                <label for="numeropc">Tipo de periférico</label>
                                <input type="number" name="numeropc" id="numeropc">
                            </div>

                            <div class="grupo-input">
                                <label for="numerolab">Número (se houver)</label>
                                <input type="number" name="numerolab" id="numerolab">
                            </div>
                        </div>

                        <div class="grupo-input">
                                <label for="anexo">Laboratório ou setor</label>
                                <input type="text" name="anexo" id="anexo" required>
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
                            <button type="submit" id="clicar">Enviar</button>
                        </div>

                    </form>
                </main>
            </div>
        </div>

   
    </body>
</html>
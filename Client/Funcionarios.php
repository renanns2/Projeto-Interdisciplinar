<?php

    session_start();

    /*
    if (!isset($_SESSION['usuario_id'])) {
        // se não tiver uma sessão ativa, voltar para o login
        header("Location: ../login_registro.php?painel=login"");
    }
    */
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Funcionarios</title>

    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/config.css">
    <link rel="stylesheet" href="css/Funcionarios.css">
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

                    <a href="Reparar.php">
                            Reparar
                            <div class="linha"></div>
                    </a>

                    <a href="Funcionarios.php" id="selecionado">
                        Funcionarios
                        <div id="selecionadolinha"></div>
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

        
            <div id="funcionarios">
                <main>
                    <h1>FUNCIONARIOS</h1>
                    <h2>Veja os funcionários disponíveis</h2>
                    
                   <div id="caixafuncionarios">

    <!-- FUNCIONÁRIO 1 -->
    <div class="Caixa_Perfis">

        <div class="imagem">
            <img src="img/Goku.jpg" alt="Foto_Perfil">
        </div>

        <div class="esquerda">
            <h3>Brian</h3>
            <h4>Online - Em atendimento </h4>
        </div>

        <div class="direita">
            <h5>Informações extras</h5>
            <p>Horario de trabalho:</p>
            <p>Contato:</p>
            <p>Cargo:</p>
        </div>

    </div>


    <!-- FUNCIONÁRIO 2 -->
    <div class="Caixa_Perfis">

        <div class="imagem">
            <img src="img/Sasuke.jpg" alt="Foto_Perfil">
        </div>

        <div class="esquerda">
            <h3>Renann</h3>
            <h4>Online - Formando aura</h4>
        </div>

        <div class="direita">
            <h5>Informações extras</h5>
            <p>Horario de trabalho:</p>
            <p>Contato:</p>
            <p>Cargo:</p>
        </div>

    </div>

    <!--Funcionario 3-->
     <div class="Caixa_Perfis">

        <div class="imagem">
            <img src="img/coiso2.jpg" alt="Foto_Perfil">
        </div>

        <div class="esquerda">
            <h3>Gabriel Assis</h3>
            <h4>Online - Explicando RPG</h4>
        </div>

        <div class="direita">
            <h5>Informações extras</h5>
            <p>Horario de trabalho:</p>
            <p>Contato:</p>
            <p>Cargo:</p>
        </div>

    </div>

     <!-- FUNCIONÁRIO 4 -->
    <div class="Caixa_Perfis">

        <div class="imagem">
            <img src="img/batmanpobre" alt="Foto_Perfil">
        </div>

        <div class="esquerda">
            <h3>Pietro</h3>
            <h4>Offline - Combatendo o Mau </h4>
        </div>

        <div class="direita">
            <h5>Informações extras</h5>
            <p>Horario de trabalho:</p>
            <p>Contato:</p>
            <p>Cargo:</p>
        </div>

    </div>

</div>

   
    </body>
</html>
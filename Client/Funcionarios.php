<?php
    require_once(__DIR__ . '/../Config/auth.php');
    require_once(__DIR__ . '/../Config/redirectadmin.php');
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Funcionarios</title>

    <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon">
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
            <p>Horario de trabalho: 19h</p>
            <p>Contato: (11) 76287-2983</p>
            <p>Cargo: Programador</p>
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
            <p>Horario de trabalho: 24h </p>
            <p>Contato: (22) 73842-6373</p>
            <p>Cargo: Patrão</p>
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
            <p>Horario de trabalho: 08h</p>
            <p>Contato: (99) 64537-7654</p>
            <p>Cargo: Analista de redes</p>
        </div>

    </div>

     <!-- FUNCIONÁRIO 4 -->
    <div class="Caixa_Perfis">

        <div class="imagem">
            <img src="img/pietro.png" alt="Foto_Perfil">
        </div>

        <div class="esquerda">
            <h3>Pietro</h3>
            <h4>Offline - Combatendo o Mau </h4>
        </div>

        <div class="direita">
            <h5>Informações extras</h5>
            <p>Horario de trabalho: 15h</p>
            <p>Contato: (11) 98274-4353</p>
            <p>Cargo: Analista de redes</p>
        </div>

    </div>

</div>

   
    </body>
</html>
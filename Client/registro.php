<?php
    include_once "config.php";

    $email = $_POST['email'] ?? "";
    $senha = $_POST['senha'] ?? "";
    $nome = $_POST['nome'] ?? "";
    $cargo = $_POST['cargo'] ?? "";


    //Validação de dados
    $erros = [];
    if (empty($email)) {
        $erros[] = 'Nenhum e-mail informado';
    }
    if (empty($senha)) {
        $erros[] = 'Nenhuma senha informada';
    }
    if (empty($nome)) {
        $erros[] = 'Nenhuma nome informada';
    }
    if (empty($cargo)) {
        $erros[] = 'Nenhum cargo informado';
    }
    if (!empty($erros)) {
        foreach($erros as $erro) {
            echo "<p>$erro </p>";
        }
        exit;
    }
    
    
    
?>
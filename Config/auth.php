<?php

//SESSÃO
    session_start();
    //Verificando se a sessão existe
    if (!isset($_SESSION['usuario_id'])) {
        header("Location: ../login_registro.php?painel=login");
        exit;
    }

    include_once "config.php";

    //Sessão existe mas usuario não esta logado
    $id_user = intval($_SESSION['usuario_id']);
    $sql = "SELECT * FROM usuarios WHERE ID = '$id_user'";
    $resultado = $con->query($sql);

    if ($resultado->num_rows === 0) {
        // Usuário da sessão não existe mais
        session_destroy();
        header("Location: ../login_registro.php?painel=login");
        exit;
    }
//Se existe então pegar o banco de dados
    if ($resultado->num_rows > 0) {
        $usuario = $resultado->fetch_assoc();
    }
//Se foto é igual a nulo entao adicionar a foto padrão de nada
    if ($usuario['foto_perfil'] === NULL) {
        $foto_null = "SemFoto.jpg";
        $sql = "UPDATE usuarios SET foto_perfil = '$foto_null' WHERE ID = '$id_user';";
        $resultado = $con->query($sql);
    }
//Se o usuario for do tipo ADMIN então redirecionar para a pagina de ADMIN.
?>
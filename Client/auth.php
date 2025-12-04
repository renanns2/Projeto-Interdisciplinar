<?php
    session_start();

    if (!isset($_SESSION['usuario_id'])) {
        // se não tiver uma sessão ativa, voltar para o login
        header("Location: ../login_registro.php?painel=login");
        exit;
    }

    $id_user = $_SESSION['usuario_id'];
    include_once "config.php";
    $sql = "SELECT * FROM usuarios WHERE ID = $id_user";
    $resultado = $con->query($sql);

    if ($resultado->num_rows > 0) {
        $usuario = $resultado->fetch_assoc();
    }else {
        $mensagens[] = [
            'tipo' => 'erro',
            'mensagem' => 'Ocorreu um erro.',
        ];
        exit;
    }

    if (empty($usuario['foto_perfil'])) {
        $foto_null = "SemFoto.jpg";
        $sql = "UPDATE usuarios SET foto_perfil = '$foto_null' WHERE ID = '$id_user';";
        $resultado = $con->query($sql);
    }
?>
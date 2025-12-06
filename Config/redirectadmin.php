<?php
    if($usuario['tipo_usuario'] === "admin") {
        header("Location: ../Admin/Inicio.php");
        exit;
    }
?>
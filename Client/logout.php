<?php
session_start();

// Remove todas as variáveis da sessão
$_SESSION = [];

// remove cookie de sessão do navegador
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(), 
        '', 
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// Destrói a sessão do servidor
session_unset();
session_destroy();

// redireciona para a página de login
header("Location: ../login_registro.php?painel=login");
exit;

<?php
// Inicia a sessão
session_start();

// Remove todas as variáveis da sessão
$_SESSION = [];

// Destroi a sessão
session_destroy();

// Impede o cache de páginas para evitar que o usuário volte
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Redireciona para a página de login
header("Location: ../login/login.php");
exit;

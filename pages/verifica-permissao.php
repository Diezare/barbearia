<?php
session_start(); // Inicia a sessão, se ainda não estiver ativa

if (!isset($_SESSION['id_usuario'])) {
    header("Location: " . PAGE_URL . "/login/login.php");
    exit();
}

// Carrega configuração e conexão
require_once __DIR__ . '/../paths.php'; 
require_once ROOT_PATH . '/db/config.php';

// Habilita o modo de erro do PDO para ajudar na depuração
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$pagina = filter_var($_GET['pagina'], FILTER_SANITIZE_STRING);

// Certifique-se de que a variável $pagina não está vazia
if (empty($pagina)) {
    header("Location: erro-permissao.php");
    exit();
}

try {
    $id_usuario = $_SESSION['usuario']['id'];

    // Consulta para verificar permissões de acesso
    $query = "
        SELECT COUNT(*) 
        FROM usuario_paginas up
        JOIN paginas p ON up.id_pagina = p.id
        WHERE up.id_usuario = :id_usuario 
        AND p.caminho = :pagina
    ";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
    $stmt->bindParam(':pagina', $pagina, PDO::PARAM_STR);
    $stmt->execute();

    // Verifica se o usuário tem permissão para acessar a página
    if ($stmt->fetchColumn() == 0) {
        // Registra no log de tentativas de acesso negadas
        $query_log = "
            INSERT INTO log_acessos (id_usuario, ip_usuario, data_tentativa, status) 
            VALUES (:id_usuario, :ip_usuario, NOW(), 'negado')
        ";
        $stmt_log = $pdo->prepare($query_log);
        $log_result = $stmt_log->execute([
            ':id_usuario' => $id_usuario,
            ':ip_usuario' => $_SERVER['REMOTE_ADDR'],
        ]);

        if ($log_result) {
            // Log registrado com sucesso
            // Redireciona para a página de erro de permissão
            header("Location: erro-permissao.php");
            exit();
        } else {
            // Se falhou ao gravar o log
            error_log("Falha ao registrar log de acesso negado");
            echo "Falha ao registrar log de acesso negado"; // Debug
        }
    }
} catch (PDOException $e) {
    // Loga o erro e redireciona para a página de erro
    error_log($e->getMessage());
    header("Location: erro-permissao.php");
    exit();
}
?>

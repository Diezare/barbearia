<?php
// db/config.php

$host = 'localhost'; // Nome de host
$dbname = 'barbearia'; //Nome do Banco
$user = 'root'; // Usuário do banco de dados
$password = ''; // Senha em branco

try {
    // Conectar ao banco de dados
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
?>

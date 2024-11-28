<?php
// cadastrar_pagina.php

require_once '../db/config.php'; // Conexão com o banco de dados

// Se o formulário for enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitização das entradas
    $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
    $caminho = filter_input(INPUT_POST, 'caminho', FILTER_SANITIZE_URL);

    try {
        // Valida se é uma URL válida
        if (!filter_var($caminho, FILTER_VALIDATE_URL)) {
            throw new Exception('O caminho especificado não é uma URL válida.');
        }

        // Verifica se a URL está acessível
        $headers = @get_headers($caminho);
        if (!$headers || strpos($headers[0], '200') === false) {
            throw new Exception('A URL fornecida não está acessível.');
        }

        // Verifica se o nome ou caminho já existem no banco
        $query = $pdo->prepare('SELECT id FROM paginas WHERE nome = :nome OR caminho = :caminho');
        $query->execute(['nome' => $nome, 'caminho' => $caminho]);
        $pagina = $query->fetch(PDO::FETCH_ASSOC);

        if ($pagina) {
            // Se o nome ou caminho já existe
            $erro = 'Já existe uma página com este nome ou caminho.';
        } else {
            // Insere a nova página no banco
            $insertQuery = $pdo->prepare('
                INSERT INTO paginas (nome, caminho)
                VALUES (:nome, :caminho)
            ');
            $insertQuery->execute([
                'nome' => $nome,
                'caminho' => $caminho
            ]);

            // Mensagem de sucesso
            $sucesso = 'Página cadastrada com sucesso!';
        }
    } catch (PDOException $e) {
        // Erro ao tentar cadastrar a página
        error_log('Erro ao cadastrar página: ' . $e->getMessage());
        $erro = 'Erro ao processar sua solicitação. Tente novamente mais tarde.';
    } catch (Exception $e) {
        // Caso ocorra erro de validação
        error_log('Erro de validação: ' . $e->getMessage());
        $erro = $e->getMessage();
    }
}
?>

<!-- Formulário de Cadastro de Página -->
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Nova Página</title>
</head>
<body>
    <h1>Cadastrar Nova Página</h1>

    <?php if (isset($erro)) { echo "<p style='color:red;'>$erro</p>"; } ?>
    <?php if (isset($sucesso)) { echo "<p style='color:green;'>$sucesso</p>"; } ?>

    <form method="POST">
        <label for="nome">Nome da Página</label>
        <input type="text" name="nome" id="nome" required><br><br>

        <label for="caminho">URL</label>
        <input type="text" name="caminho" id="caminho" required placeholder="http://localhost/gil/pages/index.php"><br><br>

        <button type="submit">Cadastrar Página</button>
    </form>
</body>
</html>

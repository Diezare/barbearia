<?php
// cadastrar_usuario.php

require_once '../db/config.php'; // Conexão com o banco de dados

// Se o formulário for enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitização das entradas
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING);
    $id_funcionario = filter_input(INPUT_POST, 'id_funcionario', FILTER_VALIDATE_INT);
    $id_usuario_cadastro = filter_input(INPUT_POST, 'id_usuario_cadastro', FILTER_VALIDATE_INT); // Usuário que está cadastrando

    try {
        // Verifica se o nome de usuário já existe
        $query = $pdo->prepare('SELECT id FROM usuarios WHERE username = :username');
        $query->execute(['username' => $username]);
        $user = $query->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Se o usuário já existe
            $erro = 'Nome de usuário já cadastrado. Escolha outro nome.';
        } else {
            // Gera o hash da senha
            $senha_hash = password_hash($senha, PASSWORD_BCRYPT);

            // Verifica se o hash foi gerado com sucesso
            if ($senha_hash === false) {
                throw new Exception('Erro ao gerar o hash da senha.');
            }

            // Insere o novo usuário no banco
            $insertQuery = $pdo->prepare('
                INSERT INTO usuarios (username, password, id_funcionario, id_usuario_cadastro)
                VALUES (:username, :senha_hash, :id_funcionario, :id_usuario_cadastro)
            ');
            $insertQuery->execute([
                'username' => $username,
                'senha_hash' => $senha_hash,
                'id_funcionario' => $id_funcionario,
                'id_usuario_cadastro' => $id_usuario_cadastro
            ]);

            // Mensagem de sucesso
            $sucesso = 'Usuário cadastrado com sucesso!';
        }
    } catch (PDOException $e) {
        // Erro ao tentar cadastrar o usuário
        error_log('Erro ao cadastrar usuário: ' . $e->getMessage());
        $erro = 'Erro ao processar sua solicitação. Tente novamente mais tarde.';
    } catch (Exception $e) {
        // Caso ocorra erro ao gerar o hash
        error_log('Erro ao gerar hash: ' . $e->getMessage());
        $erro = 'Erro ao gerar o hash da senha. Tente novamente.';
    }
}
?>

<!-- Formulário de Cadastro de Novo Usuário -->
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Novo Usuário</title>
</head>
<body>
    <h1>Cadastrar Novo Usuário</h1>

    <?php if (isset($erro)) { echo "<p style='color:red;'>$erro</p>"; } ?>
    <?php if (isset($sucesso)) { echo "<p style='color:green;'>$sucesso</p>"; } ?>

    <form method="POST">
        <label for="username">Nome de Usuário</label>
        <input type="text" name="username" id="username" required><br><br>

        <label for="senha">Senha</label>
        <input type="password" name="senha" id="senha" required><br><br>

        <label for="id_funcionario">ID do Funcionário</label>
        <input type="number" name="id_funcionario" id="id_funcionario" required><br><br>

        <label for="id_usuario_cadastro">ID do Usuário que está Cadastrando</label>
        <input type="number" name="id_usuario_cadastro" id="id_usuario_cadastro" required><br><br>

        <button type="submit">Cadastrar</button>
    </form>
</body>
</html>

<?php
session_start(); // Inicia a sessão

// Se o usuário já está logado, redireciona para a página inicial
if (isset($_SESSION['id_usuario'])) {
    header('Location: ../pages/index.php');
    exit();
}

require_once '../db/config.php'; // Conexão ao banco

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitização das entradas
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

    try {
        // Verifica o usuário no banco de dados
        $query = $pdo->prepare('SELECT u.id, u.username, u.password, f.nivel_usuario 
                                FROM usuarios u 
                                INNER JOIN funcionarios f ON u.id_funcionario = f.id 
                                WHERE u.username = :username');
        $query->execute(['username' => $username]);
        $user = $query->fetch(PDO::FETCH_ASSOC);

        // Registro de IP para logs
        $ip = $_SERVER['REMOTE_ADDR'];

        if ($user && password_verify($password, $user['password'])) {
            // Login bem-sucedido
            $_SESSION['id_usuario'] = $user['id'];
            $_SESSION['usuario'] = [
                'id' => $user['id'],
                'nome' => $user['username'],
                'nivel' => $user['nivel_usuario'],
            ];

            // Log de sucesso
            $logQuery = $pdo->prepare("INSERT INTO log_login (username, ip_address, status) VALUES (:username, :ip, 'sucesso')");
            $logQuery->execute(['username' => $username, 'ip' => $ip]);

            // Redirecionamento
            $destino = $_SESSION['pagina_destino'] ?? '../pages/index.php';
            unset($_SESSION['pagina_destino']);
            header('Location: ' . $destino);
            exit();
        } else {
            // Login falhou
            $logQuery = $pdo->prepare("INSERT INTO log_login (username, ip_address, status) VALUES (:username, :ip, 'falha')");
            $logQuery->execute(['username' => $username, 'ip' => $ip]);

            $error = 'Credenciais inválidas.';
        }
    } catch (PDOException $e) {
        error_log('Erro no login: ' . $e->getMessage());
        $error = 'Erro ao processar sua solicitação.';
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>Login - Barbearia</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="../app/imgs/favicon.ico"/>
    <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
    <link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
    <link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
    <link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
</head>
<body>
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <div class="login100-pic js-tilt" data-tilt>
                    <img src="images/img-01.png" alt="IMG">
                </div>
                <form class="login100-form validate-form" method="POST">
                    <span class="login100-form-title">Login</span>

                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger text-center"><?= htmlspecialchars($error) ?></div>
                    <?php endif; ?>

                    <div class="wrap-input100 validate-input" data-validate="Digite um nome de usuário válido.">
                        <input class="input100" type="text" name="username" placeholder="Nome de usuário" required>
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-user" aria-hidden="true"></i>
                        </span>
                    </div>

                    <div class="wrap-input100 validate-input" data-validate="Digite sua senha.">
                        <input class="input100" type="password" name="password" placeholder="Senha" required>
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-lock" aria-hidden="true"></i>
                        </span>
                    </div>
                    
                    <div class="container-login100-form-btn">
                        <button class="login100-form-btn" type="submit">Login</button>
                    </div>

                    <div class="text-center p-t-136">
                        <p>Feito com <span class="icon-heart-3">❤️</span> por Diézare Conde</p>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <script src="vendor/jquery/jquery-3.2.1.min.js"></script>
    <script src="vendor/bootstrap/js/popper.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="vendor/select2/select2.min.js"></script>
    <script src="vendor/tilt/tilt.jquery.min.js"></script>
    <script>
        $('.js-tilt').tilt({
            scale: 1.1
        });
    </script>
    <script src="js/main.js"></script>
</body>
</html>

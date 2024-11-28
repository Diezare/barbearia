<?php
// login.php

session_start();
require_once '../db/config.php'; // Conexão ao banco

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        // Verifica o usuário e a senha
        $query = $pdo->prepare('SELECT u.id, u.username, u.password, f.nivel_usuario 
                                FROM usuarios u 
                                INNER JOIN funcionarios f ON u.id_funcionario = f.id 
                                WHERE u.username = :username');
        $query->execute(['username' => $username]);
        $user = $query->fetch(PDO::FETCH_ASSOC);

        if ($user && $user['password'] === $password) { // Substituir por hash em produção
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['nivel_usuario'] = $user['nivel_usuario'];

            // Redireciona com base no nível do usuário
            header('Location: ../app/index.php');
            exit;
        } else {
            $error = 'Usuário ou senha inválidos.';
        }
    } catch (PDOException $e) {
        $error = 'Erro ao verificar login: ' . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login - Barbearia</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="../geral/img/favicon.ico"/>
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

                    <div class="text-center p-t-12">
						<!--<span class="txt1">
							Forgot
						</span>
						<a class="txt2" href="#">
							Username / Password?
						</a>-->
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
	<script >
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>
	<script src="js/main.js"></script>

</body>
</html>
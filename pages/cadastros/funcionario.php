<?php
// Inicia a sessão
session_start();
/*

// Define os níveis permitidos para esta página
$permissoesPermitidas = ['administrador'];

// Verifica se o usuário está logado e se é administrador
if (
    !isset($_SESSION['usuario_logado']) || 
    !isset($_SESSION['nivel_usuario']) || 
    !in_array($_SESSION['nivel_usuario'], $permissoesPermitidas)
) {
    header('Location: ../login/index.php'); // Redireciona para a página de login
    exit;
}
*/

// Caminho relativo apenas uma vez
require_once __DIR__ . '/../../paths.php'; 

// Inclui o arquivo de verificação de permissões
require_once ROOT_PATH . '/pages/verifica-permissao.php'; 

// Inclui o cabeçalho
include_once ROOT_PATH . '/pages/cabecalho.php';

// Inclui a conexão com o banco de dados
require_once ROOT_PATH . '/db/config.php'; 

// Mensagem de sucesso ou erro
$message = '';

// Variável para controle de exibição do modal
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['firstname'] ?? '';
    $celular = $_POST['number'] ?? '';
    $sexo = $_POST['gender'] ?? '';
    $nivel = $_POST['nivel'] ?? '';
    $porcentagem = $_POST['percentage'] ?? '';

    // Validações básicas
    if (!empty($nome) && !empty($celular) && !empty($sexo) && !empty($nivel) && !empty($porcentagem)) {
        try {
            // Prepara a query de inserção
            $stmt = $pdo->prepare('INSERT INTO funcionarios (nome, celular, sexo, nivel_usuario, porcentagem) VALUES (:nome, :celular, :sexo, :nivel, :porcentagem)');
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':celular', $celular);
            $stmt->bindParam(':sexo', $sexo);
            $stmt->bindParam(':nivel', $nivel);
            $stmt->bindParam(':porcentagem', $porcentagem);

            if ($stmt->execute()) {
                //$success = true; // Indica que o cadastro foi bem-sucedido
                //$message = 'Funcionário(a) cadastrado(a) com sucesso!';
                header("Location: funcionario.php?success=true");
                exit;
            } else {
                $message = 'Erro ao cadastrar funcionário(a). Tente novamente.';
            }
        } catch (PDOException $e) {
            $message = 'Erro: ' . $e->getMessage();
        }
    } else {
        $message = 'Por favor, preencha todos os campos obrigatórios.';
    }
}

$success = isset($_GET['success']) && $_GET['success'] === 'true';

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="content-language" content="pt-br" />
    <link rel="stylesheet" href="<?php echo CSS_PATH; ?>/style.css">
    <link rel="icon" type="image/x-icon" href="<?php echo IMG_PATH; ?>/favicon.ico">
    <title>Cadastro de Funcionário</title>
</head>

<body>
    <div class="container">
        <div class="form-image">
            <img src="<?php echo IMG_PATH; ?>/undraw_shopping_re_3wst.svg" alt="">
        </div>
        <div class="form">
            <!--<form method="POST" action="funcionario.php">-->
            <form method="POST" action="funcionario.php" id="form-funcionario">
                <div class="form-header">
                    <div class="title">
                        <h1>Cadastro de Funcionário</h1>
                    </div>
                    <div class="search-button">
                        <button><a href="../pesquisar/funcionarios.php">Pesquisar</a></button>
                    </div>
                </div>

                <!-- Mensagem de feedback -->
                <?php if (!empty($message)) : ?>
                    <p style="color: green;"><?= htmlspecialchars($message) ?></p>
                <?php endif; ?>

                <div class="input-group">
                    <div class="input-box">
                        <label for="firstname">Nome Completo</label>
                        <input id="firstname" type="text" name="firstname" placeholder="Digite o nome completo" required>
                    </div>

                    <div class="input-box">
                        <label for="number">Celular</label>
                        <input id="number" type="tel" name="number" placeholder="(xx) xxxxx-xxxx" required oninput="formatPhone(this)">
                    </div>

                    <div class="input-box">
                        <label for="percentage">Porcentagem</label>
                        <input id="percentage" type="text" name="percentage" placeholder="Digite a % a dividir" required oninput="formatPercentage(this)">
                    </div>

                    <div class="input-box select-box">
                        <label for="nivel">Nível de Usuário</label>
                        <select name="nivel" id="nivel" required>
                            <option value="" disabled selected>Selecione o nível</option>
                            <option value="administrador">Administrador</option>
                            <option value="funcionario">Funcionário</option>
                        </select>
                    </div>

                </div>

                <div class="gender-inputs">
                    <div class="gender-title">
                        <h6>Sexo</h6>
                    </div>

                    <div class="gender-group">
                        <div class="gender-input">
                            <input id="female" type="radio" name="gender" value="Feminino" required>
                            <label for="female">Feminino</label>
                        </div>

                        <div class="gender-input">
                            <input id="male" type="radio" name="gender" value="Masculino" required>
                            <label for="male">Masculino</label>
                        </div>

                        <div class="gender-input">
                            <input id="others" type="radio" name="gender" value="Outros" required>
                            <label for="others">Outros</label>
                        </div>

                    </div>
                </div>

                <div class="save-button">
                    <button type="submit">Salvar</button>
                </div>
            </form>
        </div>
    </div>

   <!-- Popup -->
   <div class="modal" id="success-modal">
        <div class="modal-content">
            <p>Funcionário cadastrado com sucesso!</p>
            <button onclick="closeModal()">OK</button>
        </div>
    </div>

    <script>
        
        // Exibe o modal se o cadastro foi bem-sucedido
        <?php if ($success) : ?>
            document.getElementById('success-modal').style.display = 'flex';
            window.history.replaceState(null, null, 'funcionario.php'); // Remove o parâmetro da URL
        <?php endif; ?>

        // Fecha o modal e limpa o formulário
        function closeModal() {
            document.getElementById('success-modal').style.display = 'none';
            document.getElementById('form-funcionario').reset();
        }
        
    </script>

<script src="<?php echo JS_PATH; ?>/funcionario.js"></script>
<script src="<?php echo JS_PATH; ?>/menu.js"></script>

<?php include_once ROOT_PATH . '/pages/rodape.php'; ?>

</body>
</html>
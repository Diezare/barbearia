<?php
// Inicia a sessão
session_start();

// Caminho relativo para recursos globais
require_once __DIR__ . '/../paths.php'; 

// Inclui o cabeçalho
include_once ROOT_PATH . '/pages/cabecalho.php';

//include_once ROOT_PATH . '/pages/verifica-permissao.php';

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="content-language" content="pt-br" />
    <link rel="stylesheet" href="<?php echo CSS_PATH; ?>/style.css">
    <link rel="icon" type="image/png" href="../app/imgs/favicon.ico"/>
    <title>Página Simples</title>
</head>

<body>
    <!-- Cabeçalho já incluído -->
</body>

</html>

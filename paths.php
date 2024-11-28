<?php
// Define o diretório raiz do projeto (absoluto no sistema de arquivos)
define('ROOT_PATH', __DIR__);

// Ambiente (desenvolvimento ou produção)
$isDev = true; // Altere para false em produção

// Define o caminho base acessível via HTTP
define('BASE_URL', $isDev ? 'http://localhost/gil' : 'https://meusite.com');

// Caminhos para os arquivos públicos (dentro de "app")
define('APP_PATH', BASE_URL . '/app');
define('CSS_PATH', APP_PATH . '/css');
define('JS_PATH', APP_PATH . '/js');
define('IMG_PATH', APP_PATH . '/imgs'); // Caminho para acesso via HTTP

// Caminho interno para o servidor (manipulação de arquivos locais, se necessário)
define('APP_SERVER_PATH', ROOT_PATH . '/app');

// Caminho para o arquivo de configuração do banco de dados
define('DB_CONFIG_PATH', dirname(ROOT_PATH) . '/db/config.php');

// Caminho base para a página pública (opcional se você usar uma estrutura de pastas específica)
define('PAGE_URL', BASE_URL . '/pages');

?>

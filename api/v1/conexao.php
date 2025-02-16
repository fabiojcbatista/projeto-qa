<?php 
header("Content-type: text/html; charset=utf-8");
require_once 'config.php'; // Certifique-se de carregar o .env primeiro

// Verifica o ambiente e define as configurações do banco
$appEnv = getenv('APP_ENV') ?: 'development'; // Default: desenvolvimento

if ($appEnv === 'localhost') {
    $dbHost = getenv('DB_HOST');
    $dbUser = getenv('DB_USER');
    $dbPass = getenv('DB_PASSWORD');
    $dbName = getenv('DB_NAME');
} else if ($appEnv === 'development') {
    $dbHost = getenv('DB_HOST_DEV');
    $dbUser = getenv('DB_USER_DEV');
    $dbPass = getenv('DB_PASSWORD_DEV');
    $dbName = getenv('DB_NAME_DEV');
} else {
    $dbHost = getenv('DB_HOST_PROD');
    $dbUser = getenv('DB_USER_PROD');
    $dbPass = getenv('DB_PASSWORD_PROD');
    $dbName = getenv('DB_NAME_PROD');
}

define('DB_SERVER', $dbHost);
define('DB_USERNAME', $dbUser);
define('DB_PASSWORD', $dbPass);
define('DB_NAME', $dbName);

//define('DB_SERVER', 'fdb27.runhosting.com');
//define('DB_USERNAME', '3534042_dbempresax');
//define('DB_PASSWORD', '2010fabiojcb');
//define('DB_NAME', '3534042_dbempresax');

$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
mysqli_set_charset($link, 'utf8');

session_start();

function sessao() {
    session_start();
    $id = $_SESSION['id']; 
}

function UsuarioLogado($id) {
    global $link;
    $sql = "SELECT nomeusuario FROM usuario WHERE idusuario = $id";                                
    $result = mysqli_query($link, $sql) or die("Erro no banco de dados!"); 

    $total = mysqli_num_rows($result); 
    $dados = mysqli_fetch_array($result);  

    $nome = $dados[0];
    echo $nome;
}
?>
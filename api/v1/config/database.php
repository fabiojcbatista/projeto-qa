<?php
require_once 'config.php'; 

$appEnv = getenv('APP_ENV') ?: 'development';

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

class Database {
    public $sql;

    public function connect() {
        $this->sql = null;

        try {
            $this->sql = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
        } catch (Exception $e) {
            echo json_encode(['error' => 'Connection error: ' . $e->getMessage()]);
            die();
        }
        return $this->sql;
    }
}

<?php
require_once __DIR__ . '/../controllers/AuthController.php';
require_once __DIR__ . '/../controllers/UserController.php';
require_once __DIR__ . '/../controllers/ProductController.php';
require_once __DIR__ . '/../controllers/AccountController.php';
require_once __DIR__ . '/../controllers/AccountTransactionController.php';
require_once __DIR__ . '/../controllers/PlayerController.php';
require_once __DIR__ . '/../controllers/TeamController.php';
require_once __DIR__ . '/../controllers/RoundScoreController.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Suporte para requisições OPTIONS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

function handleRequest($db) {
    $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $requestMethod = $_SERVER['REQUEST_METHOD'];
        
    $input = [];
    $contentType = $_SERVER['CONTENT_TYPE'] ?? '';
    if ($requestMethod === 'POST' || $requestMethod === 'GET') {
        $input = $_POST + $_GET;
    }

    if (strpos($contentType, 'application/json') !== false) {
        $inputJSON = file_get_contents('php://input');
        $input = json_decode($inputJSON, true);
    }

    if (strpos($contentType, 'application/xml') !== false) {
        $inputJSON = file_get_contents('php://input');
        $input = xml_decode($inputJSON, true);
    }

    if (strpos($contentType, 'text/html') !== false) {
        $inputJSON = file_get_contents('php://input');
        $input = htmlspecialchars($inputJSON, ENT_QUOTES, 'UTF-8');
    }

    $authController = new AuthController($db);
    $userController = new UserController($db);
    $productController = new ProductController($db);
    $accountController = new AccountController($db);
    $accountTransactionController = new AccountTransactionController($db);
    $playerController = new PlayerController($db);
    $teamController = new TeamController($db);
    $roundScoreController = new RoundScoreController($db);
    $routes = [
        'POST' => [
            '/projeto-qa/api/v1/login' => function() use ($authController, $input) {
                return $authController->login($input);
            },
            '/projeto-qa/api/v1/users' => function() use ($userController, $input) {
                return $userController->createUser($input);
            },
            '/projeto-qa/api/v1/products' => function() use ($productController, $input) {
                return $productController->createProduct($input);
            },
            '/projeto-qa/api/v1/accounts' => function() use ($accountController, $input) {
                return $accountController->createAccount($input);
            },
            '/projeto-qa/api/v1/accountTransactions' => function() use ($accountTransactionController, $input) {
                return $accountTransactionController->createAccountTransaction($input);
            },
            '/projeto-qa/api/v1/players' => function() use ($playerController, $input) {
                return $playerController->createPlayer($input);
            },
            '/projeto-qa/api/v1/teams' => function() use ($teamController, $input) {
                return $teamController->createTeam($input);
            },
            '/projeto-qa/api/v1/roundScores' => function() use ($roundScoreController, $input) {
                return $roundScoreController->createRoundScore($input);
            },
        ],
        'GET' => [
            '/projeto-qa/api/v1/users' => function() use ($userController, $input) {
                return $userController->getUsers();
            },
            '/projeto-qa/api/v1/users/:userId' => function($userId) use ($userController, $input) {
                return $userController->getUserById($userId);
            },
            '/projeto-qa/api/v1/products' => function() use ($productController, $input) {
                return $productController->getProducts();
            },
            '/projeto-qa/api/v1/products/:productId' => function($productId) use ($productController, $input) {
                return $productController->getProductById($productId);
            },
            '/projeto-qa/api/v1/accounts' => function() use ($accountController, $input) {
                return $accountController->getAccounts();
            },
            '/projeto-qa/api/v1/accounts/:accountId' => function($accountId) use ($accountController, $input) {
                return $accountController->getAccountById($accountId);
            },
            '/projeto-qa/api/v1/accountTransactions' => function() use ($accountTransactionController, $input) {
                return $accountTransactionController->getAccountTransactions();
            },
            '/projeto-qa/api/v1/accountTransactions/:accountTransactionId' => function($accountTransactionId) use ($accountTransactionController, $input) {
                return $accountTransactionController->getAccountTransactionById($accountTransactionId);
            },
            '/projeto-qa/api/v1/players' => function() use ($playerController, $input) {
                return $playerController->getPlayers();
            },
            '/projeto-qa/api/v1/players/:playerId' => function($playerId) use ($playerController, $input) {
                return $playerController->getPlayerById($playerId);
            },
            '/projeto-qa/api/v1/teams' => function() use ($teamController, $input) {
                return $teamController->getTeams();
            },
            '/projeto-qa/api/v1/teams/:teamId' => function($teamId) use ($teamController, $input) {
                return $teamController->getTeamById($teamId);
            },
            '/projeto-qa/api/v1/roundScores' => function() use ($roundScoreController, $input) {
                return $roundScoreController->getRoundScores();
            },
            '/projeto-qa/api/v1/roundScores/:roundScoreId' => function($roundScoreId) use ($roundScoreController, $input) {
                return $roundScoreController->getRoundScoreById($roundScoreId);
            },
        ],
        'PUT' => [
            '/projeto-qa/api/v1/users/:userId' => function($userId) use ($userController, $input) {
                return $userController->UpdateUserById($userId,$input);
            },
            '/projeto-qa/api/v1/products/:productId' => function($productId) use ($productController, $input) {
                return $productController->UpdateProductById($productId,$input);
            },
            '/projeto-qa/api/v1/accounts/:accountId' => function($accountId) use ($accountController, $input) {
                return $accountController->UpdateAccountById($accountId,$input);
            },
            '/projeto-qa/api/v1/accountTransactions/:accountTransactionId' => function($accountTransactionId) use ($accountTransactionController, $input) {
                return $accountTransactionController->UpdateAccountTransactionById($accountTransactionId,$input);
            },
            '/projeto-qa/api/v1/players/:playerId' => function($playerId) use ($playerController, $input) {
                return $playerController->UpdatePlayerById($playerId,$input);
            },
            '/projeto-qa/api/v1/teams/:teamId' => function($teamId) use ($teamController, $input) {
                return $teamController->UpdateTeamById($teamId,$input);
            },
            '/projeto-qa/api/v1/roundScores/:roundScoreId' => function($roundScoreId) use ($roundScoreController, $input) {
                return $roundScoreController->updateRoundScoreById($roundScoreId,$input);
            },
        ],
        'DELETE' => [
           '/projeto-qa/api/v1/users/:userId' => function($userId) use ($userController, $input) {
                return $userController->deleteUserById($userId);
            },
            '/projeto-qa/api/v1/products/:productId' => function($productId) use ($productController, $input) {
                return $productController->deleteProductById($productId);
            },
            '/projeto-qa/api/v1/accounts/:accountId' => function($accountId) use ($accountController, $input) {
                return $accountController->deleteAccountById($accountId);
            },
            '/projeto-qa/api/v1/accountTransactions/:accountTransactionId' => function($accountTransactionId) use ($accountTransactionController, $input) {
                return $accountTransactionController->deleteAccountTransactionById($accountTransactionId);
            },
            '/projeto-qa/api/v1/players/:playerId' => function($playerId) use ($playerController, $input) {
                return $playerController->deletePlayerById($playerId);
            },
            '/projeto-qa/api/v1/teams/:teamId' => function($teamId) use ($teamController, $input) {
                return $teamController->deleteTeamById($teamId);
            },
            '/projeto-qa/api/v1/roundScores/:roundScoreId' => function($roundScoreId) use ($roundScoreController, $input) {
                return $roundScoreController->deleteRoundScoreById($roundScoreId);
            },
        ]
    ];

    foreach ($routes[$requestMethod] as $route => $handler) {
        $routePattern = preg_replace('/:\w+/', '([^/]+)', $route);
        if (preg_match("#^$routePattern$#", $requestUri, $matches)) {
            array_shift($matches);
            $response = call_user_func_array($handler, $matches);
            header('Content-Type: application/json');
            echo json_encode($response);
            exit;
        }
    }

    http_response_code(404);
    echo json_encode(['error' => 'Route not found']);
}
?>
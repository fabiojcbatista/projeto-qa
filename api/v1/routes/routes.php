<?php
require_once __DIR__ . '/../controllers/AuthController.php';
require_once __DIR__ . '/../controllers/UserController.php';
require_once __DIR__ . '/../controllers/ProductController.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

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
    $routes = [
        'POST' => [
            '/projeto-qa/api/v1/login' => function() use ($authController, $input) {
                return $authController->login($input);
            },
            '/projeto-qa/api/v1/users' => function() use ($userController, $input) {
                return $userController->createUser($input);
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
        ],
        'PUT' => [
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
        ],
        'DELETE' => [
           '/projeto-qa/api/v1/users/:userId' => function($userId) use ($userController, $input) {
                return $userController->deleteUserById($userId);
            },
            '/projeto-qa/api/v1/products/:productId' => function($productId) use ($productController, $input) {
                return $productController->deleteProductById($productId);
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
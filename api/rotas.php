<?php
header("Content-type: text/html; charset=utf-8");
require_once ("conexao.php");//conectar ao banco
require_once ("usuario.php");
require_once ("produto.php");

// Definindo a rota com base no URL
$rota = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$rota = str_replace('/api/rotas.php', '', $rota);

// Controlador de rotas
switch ($rota) {
    case '/usuarios':
        rotaUsuario();
        break;
    case '/produtos':
        rotaProduto();
        break;
    default:
        http_response_code(404);
        echo json_encode([
            'status' => 'error',
            'message' => 'Rota não encontrada.'
        ]);
        break;
}

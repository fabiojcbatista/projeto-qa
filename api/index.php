<?php
header("Content-type: text/html; charset=utf-8");
require_once ("conexao.php");//conectar ao banco


$method = $_SERVER['REQUEST_METHOD'];
$nome = "";
$email = "";

// Inicializa o array que armazenará os dados do formulário
$formData = [];
$contentType = $_SERVER['CONTENT_TYPE'] ?? '';
if ($method === 'POST' || $method === 'GET') {
    $formData = $_POST + $_GET;
}

if (strpos($contentType, 'application/json') !== false) {
    $inputJSON = file_get_contents('php://input');
    $formData = json_decode($inputJSON, true);
}

if (strpos($contentType, 'application/xml') !== false) {
    $inputJSON = file_get_contents('php://input');
    $formData = xml_decode($inputJSON, true);
}
//echo "Form Data: ". $formData;
// Exemplo de campos do formulário que podem ser recebidos
$nome = $formData['nome'] ?? 'Nome não informado';
$email = $formData['email'] ?? 'Email não informado';
$mensagem = $formData['mensagem'] ?? 'Mensagem não informada';

// Prepara a resposta
$response = [
    'status' => 'success',
    'nome' => htmlspecialchars($nome),
    'email' => htmlspecialchars($email),
    'mensagem' => htmlspecialchars($mensagem)
];

// Configurar o cabeçalho para JSON
header('Content-Type: application/json');

// Função para lidar com solicitações GET
function handleGetRequest()
{
    $conn = conexao(); // Conexão interna

    if (!$conn) {
        $response = ['status' => 'error', 'message' => 'Falha na conexão com o banco de dados.'];
        echo json_encode($response);
        http_response_code(500);
        exit;
    }

    global $nome, $email;
    $sql = "SELECT * FROM `usuario` WHERE NOMEUSUARIO = '" . $nome . "' AND LOGINUSUARIO = '" . $email . "'";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        $response = ['status' => 'error', 'message' => 'Erro na consulta: '];
        http_response_code(500);
        echo json_encode($response);
        exit;
    }

    if (mysqli_num_rows($result) > 0) {
        $dados = mysqli_fetch_array($result);
        $data = [
            'id' => $dados['IDUSUARIO'],
            'nome' => $dados['NOMEUSUARIO'],
            'email' => $dados['LOGINUSUARIO'],
            'senha' => $dados['SENHAUSUARIO'],
            'nivel' => $dados['NIVELUSUARIO']
        ];
        http_response_code(200);
    } else {
        http_response_code(404);
        $data = ['status' => 'info', 'message' => 'Nenhum usuário encontrado.'];
    }

    echo json_encode($data);
    mysqli_close($conn);
}

function handlePostRequest()
{
    $conn = conexao();
    if (!$conn) {
        http_response_code(500);
        $response = ['status' => 'error', 'message' => 'Falha na conexão com o banco de dados.'];
        echo json_encode($response);
        exit;
    }
    global $nome, $email;
    $sql = "INSERT INTO USUARIO(NOMEUSUARIO,LOGINUSUARIO,SENHAUSUARIO,NIVELUSUARIO) VALUES('" . $nome . "','" . $email . "','" . $email . "',3)";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        $response = ['status' => 'error', 'message' => 'Erro na cadastro: '];
        http_response_code(500);
        exit;
    }

    http_response_code(201);
    echo json_encode([
        'status' => 'success',
        'message' => 'Usuário criado com sucesso.',
        'data' => $result
    ]);
    mysqli_close($conn);
}


function handleDeleteRequest()
{
    $conn = conexao();
    if (!$conn) {
        http_response_code(500);
        $response = ['status' => 'error', 'message' => 'Falha na conexão com o banco de dados.'];
        echo json_encode($response);
        exit;
    }
    global $nome, $email;
    $sql = "DELETE FROM USUARIO WHERE NOMEUSUARIO = '" . $nome . "' AND LOGINUSUARIO= '" . $email . "'";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        $response = ['status' => 'error', 'message' => 'Erro na exclusão: '];
        http_response_code(500);
        echo json_encode($response);
        exit;
    }

    http_response_code(204);
    echo json_encode([
        'status' => 'success',
        'message' => 'Recurso deletado com sucesso.'
    ]);
    mysqli_close($conn);
}

function handleUpdateRequest()
{
    $conn = conexao();
    if (!$conn) {
        http_response_code(500);
        $response = ['status' => 'error', 'message' => 'Falha na conexão com o banco de dados.'];
        echo json_encode($response);
        exit;
    }
    global $nome, $email;
    $sql = "UPDATE USUARIO SET NOMEUSUARIO = '" . $nome . "UPDATES',LOGINUSUARIO= '" . $email . "UPDATES' WHERE NOMEUSUARIO = '" . $nome . "' AND LOGINUSUARIO= '" . $email . "'";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        $response = ['status' => 'error', 'message' => 'Erro na exclusão: '];
        http_response_code(500);
        echo json_encode($response);
        exit;
    }

    http_response_code(200);
    echo json_encode([
        'status' => 'success',
        'message' => 'Recurso atualizado com sucesso.',
        'data' => $result
    ]);
    mysqli_close($conn);
}

function rotaUsuario()
{
    $method = $_SERVER['REQUEST_METHOD'];
    switch ($method) {
        case 'GET':
            handleGetRequest();
            break;
        case 'POST':
            handlePostRequest();
            break;
        case 'DELETE':
            handleDeleteRequest();
            break;
        case 'PUT':
            handleUpdateRequest();
            break;
        default:
            echo json_encode(['message' => 'Method not supported']);
    }
}

rotaUsuario();

<?php
// Permite o acesso de qualquer origem
header("Access-Control-Allow-Origin: *");

// Especifica os métodos HTTP permitidos
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

// Especifica os cabeçalhos permitidos
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-type: text/html; charset=utf-8");
require_once ("conexao.php");//conectar ao banco


$method = $_SERVER['REQUEST_METHOD'];
$nome = "";
$email = "";
$id = "";
$conn = conexao();

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
$id = $formData['id'] ?? 'Id não informado';
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

//verifica conexão estável com servidor
function verificaConexao(){
global $conn;
        if (!$conn) {
        $response = ['status' => 'error', 'message' => 'Falha na conexão com o banco de dados.'];
        echo json_encode($response);
        http_response_code(500);
        exit;
    }
}

function handleGetRequest()
{
    $statusCode = 404;
    global $email, $conn;
    $sql = "SELECT * FROM `usuario` WHERE LOGINUSUARIO = '" . $email . "'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $dados = mysqli_fetch_array($result);
        $data = [
            'id' => $dados['IDUSUARIO'],
            'nome' => $dados['NOMEUSUARIO'],
            'email' => $dados['LOGINUSUARIO'],
            'senha' => $dados['SENHAUSUARIO'],
            'nivel' => $dados['NIVELUSUARIO']
        ];
             $statusCode = 200;
     } else {
        $data = ['status' => 'info', 'message' => 'Nenhum usuário encontrado.'];
            responseFail($data,$statusCode);
              return;
    }
    response($data,$statusCode);
    mysqli_close($conn);
}

function handlePostRequest()
{
    global $nome, $email, $conn;
    $statusCode = 404;
    $sql = "INSERT INTO USUARIO(NOMEUSUARIO,LOGINUSUARIO,SENHAUSUARIO,NIVELUSUARIO) VALUES('" . $nome . "','" . $email . "','" . $email . "',3)";
    $result = mysqli_query($conn, $sql);
      
    if (mysqli_num_rows($result) > 0) {
       $statusCode = 201;
    } else {
          $data = ['status' => 'info', 'message' => 'Erro na inclusão.'];
            responseFail($result,$statusCode);
              return;
    }
    response($result,$statusCode);
    mysqli_close($conn);
}


function handleDeleteRequest()
{
    global $nome, $email,$conn,$id;
    $statusCode = 404;
    $sql = "DELETE FROM USUARIO WHERE IDUSUARIO = " . $id . "";
    $result = mysqli_query($conn, $sql);
    if (mysql_affected_rows( $sql) > 0)  {
       $statusCode = 204;
    } else {
          $result = ['status' => 'info', 'message' => 'Erro na exclusão.'];
            responseFail($result,$statusCode);
              return;
    }
          
    http_response_code(204);
    echo json_encode([
        'status' => 'success',
        'message' => 'Recurso deletado com sucesso.'
    ]);
    mysqli_close($conn);
        
    response($result,$statusCode);
    mysqli_close($conn);         
}

function handleUpdateRequest(){
    global $nome, $email, $conn;
    $statusCode = 404;
    $sql = "UPDATE USUARIO SET NOMEUSUARIO = '" . $nome . "UPDATES',LOGINUSUARIO= '" . $email . "UPDATES' WHERE NOMEUSUARIO = '" . $nome . "' AND LOGINUSUARIO= '" . $email . "'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
       $statusCode = 200;
    } else {
          $data = ['status' => 'info', 'message' => 'Erro na alteração.'];
            responseFail($result,$statusCode);
              return;
    }    
    response($result,$statusCode);
    mysqli_close($conn);
}

function response($result,$statusCode){
 http_response_code($statusCode);
    echo json_encode(['data' => $result]);
}

function responseFail($result,$statusCode){
 http_response_code($statusCode);
    echo json_encode($result);
}

function rotaUsuario()
{
    $method = $_SERVER['REQUEST_METHOD'];
    verificaConexao();
    switch ($method) {
        case 'GET':
            handleGetRequest();
            break;
        case 'POST':
            //handlePostRequest();
            handleGetRequest();
            break;
        case 'DELETE':
            handleDeleteRequest();
            break;
        case 'PUT':
            handleUpdateRequest();
            break;
        default:http_response_code(504);
            echo json_encode(['message' => 'Method not supported']);
    }
}


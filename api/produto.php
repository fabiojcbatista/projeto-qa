<?php
// Permite o acesso de qualquer origem
header("Access-Control-Allow-Origin: *");

// Especifica os métodos HTTP permitidos
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

// Especifica os cabeçalhos permitidos
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-type: text/html; charset=utf-8");

require_once("conexao.php");//conectar ao banco


$method = $_SERVER['REQUEST_METHOD'];
$codProduto = 0;
$nmProduto = "";
$vlProduto = "";
$qtProduto = "";
$dtProduto = "";


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
$codProduto = $formData['codProduto'] ?? 'CodProduto não informado';
$nmProduto = $formData['nmProduto'] ?? 'NmProduto não informado';
$vlProduto = $formData['vlProduto'] ?? 'vlProduto não informado';
$dtProduto = $formData['dtProduto'] ?? 'dtProduto não informado';
$qtProduto = $formData['qtProduto'] ?? 'qtProduto não informado';
$mensagem = $formData['mensagem'] ?? 'Mensagem não informada';

// Prepara a resposta
$response = [
    'status' => 'success',
    'codProduto' => htmlspecialchars($codProduto),
    'nmProduto' => htmlspecialchars($nmProduto),
    'dtProduto' => htmlspecialchars($dtProduto),
    'vlProduto' => htmlspecialchars($vlProduto),
    'qtProduto' => htmlspecialchars($qtProduto),
    'mensagem' => htmlspecialchars($mensagem)
];

// Configurar o cabeçalho para JSON
header('Content-Type: application/json');

// Função para lidar com solicitações GET
function handleGetRequestProduto()
{
    $conn = conexao(); // Conexão interna

    if (!$conn) {
        $response = ['status' => 'error', 'message' => 'Falha na conexão com o banco de dados.'];
        echo json_encode($response);
        http_response_code(500);
        exit;
    }

    global $codProduto;

    //$sql = "SELECT * FROM `product` WHERE codProduto = '".$codProduto."'";
    $sql = "SELECT * FROM `product`";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        $response = ['status' => 'error', 'message' => 'Erro na consulta: ' . mysql_error($conn)];
        http_response_code(500);
        echo json_encode($response);
        exit;
    }

    if (mysqli_num_rows($result) > 0) {
        $data = [];
        while ($dados = mysqli_fetch_array($result)) {
            $data[] = [
                'codProduto' => $dados['codProduto'],
                'nmProduto' => $dados['nmProduto'],
                'dtProduto' => $dados['dtProduto'],
                'vlProduto' => $dados['vlProduto'],
                'qtProduto' => $dados['qtProduto']
            ];
        }
        http_response_code(200);
    } else {
        http_response_code(404);
        $data = ['status' => 'info', 'message' => 'Nenhum produto encontrado.'];
    }

    echo json_encode($data);
    mysqli_close($conn);
}

function handlePostRequestProduto()
{
    $conn = conexao();
    if (!$conn) {
        http_response_code(500);
        $response = ['status' => 'error', 'message' => 'Falha na conexão com o banco de dados.'];
        echo json_encode($response);
        exit;
    }
    global $codProduto, $nmProduto, $vlProduto, $qtProduto, $dtProduto;
    //$sql = "INSERT INTO USUARIO(NOMEUSUARIO,LOGINUSUARIO,SENHAUSUARIO,NIVELUSUARIO) VALUES('" . $nome . "','" . $email . "','" . $email . "',3)";
    $sql = "INSERT INTO `product` (codProduto, nmProduto, vlProduto, dtProduto, qtProduto) VALUES
(" . $codProduto . ", '" . $nmProduto . "', " . $vlProduto . ", '" . $dtProduto . "', " . $qtProduto . ")";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        $response = ['status' => 'error', 'message' => 'Erro na cadastro: ' . mysql_error($conn)];
        http_response_code(500);
        exit;
    }

    http_response_code(201);
    echo json_encode([
        'status' => 'success',
        'message' => 'Produto criado com sucesso.',
        'data' => $result
    ]);
    mysqli_close($conn);
}


function handleDeleteRequestProduto()
{
    $conn = conexao();
    if (!$conn) {
        http_response_code(500);
        $response = ['status' => 'error', 'message' => 'Falha na conexão com o banco de dados.'];
        echo json_encode($response);
        exit;
    }
    global $codProduto;
    $sql = "DELETE FROM product WHERE codProduto = " . $codProduto . "";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        $response = ['status' => 'error', 'message' => 'Erro na exclusão: ' . mysql_error($conn)];
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

function handleUpdateRequestProduto()
{
    $conn = conexao();
    if (!$conn) {
        http_response_code(500);
        $response = ['status' => 'error', 'message' => 'Falha na conexão com o banco de dados.'];
        echo json_encode($response);
        exit;
    }
    global $codProduto, $nmProduto,$vlProduto,$qtProduto,$dtProduto;
    $sql = "UPDATE product SET nmProduto= '" . $nmProduto . "', vlProduto=" . $vlProduto . ", dtProduto='" . $dtProduto . "',qtProduto=" . $qtProduto . " WHERE codProduto = " . $codProduto . "";
   
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        $response = ['status' => 'error', 'message' => 'Erro na exclusão: ' . mysql_error($conn)];
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

function rotaProduto()
{
    $method = $_SERVER['REQUEST_METHOD'];
    switch ($method) {
        case 'GET':
            handleGetRequestProduto();
            break;
        case 'POST':
            handlePostRequestProduto();
            break;
        case 'DELETE':
            handleDeleteRequestProduto();
            break;
        case 'PUT':
            handleUpdateRequestProduto();
            break;
        default:
            echo json_encode(['message' => 'Method not supported']);
    }
}


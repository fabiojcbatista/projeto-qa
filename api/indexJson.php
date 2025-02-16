<?php
header("Content-Type: application/json; charset=utf-8");

$apiUrl = 'http://localhost/api/index.php/usuarios?nome=ADM&email=ADM@GMAIL.COM'; 

// Faz a requisição GET para a API
$response = file_get_contents($apiUrl);

// Verifica se a requisição foi bem-sucedida
if ($response === FALSE) {
    echo 'Erro ao acessar a API.';
    exit;
}

// Decodifica a resposta JSON
$formData = json_decode($response, true);
print_r($formData);

echo "Nome: ".$formData['nome'];
echo "Email: ".$formData['email'];

$response = [
    'status' => 'error',
    'message' => 'Método de requisição inválido. Apenas GET é suportado.'
];

require_once("conexao.php");//conectar ao banco
//////////////////////////////
// Verifica o método da requisição
$method = $_SERVER['REQUEST_METHOD'];
$nome="";
$email="";

// Verifica se o método da requisição é GET
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Obtém o conteúdo bruto do corpo da requisição (raw data)
    $inputJSON = file_get_contents('php://input');
    
    // Decodifica o JSON recebido
    $jsonData = json_decode($inputJSON, true);
   // print_r($jsonData);

}


//echo "Form Data: ". $formData;
// Exemplo de campos do formulário que podem ser recebidos
$nome = $jsonData['nome'] ?? 'Nome não informado';
$email = $jsonData['email'] ?? 'Email não informado';
$mensagem = $jsonData['mensagem'] ?? 'Mensagem não informada';

// Prepara a resposta
$response = [
    'status' => 'success',
    'nome' => htmlspecialchars($nome),
    'email' => htmlspecialchars($email),
    'mensagem' => htmlspecialchars($mensagem)
];


// Retorna a resposta como JSON
//echo json_encode($response);
/////////////////////////////

// Configurar o cabeçalho para JSON
header('Content-Type: application/json');

// Função para lidar com solicitações GET
function handleGetRequest() {

   // Obtém a conexão com o banco de dados
   $conn = conexao(); // Conexão interna

   // Verifica se a conexão foi estabelecida corretamente
   if (!$conn) {
       $response = ['status' => 'error', 'message' => 'Falha na conexão com o banco de dados.'];
       echo json_encode($response);
       exit;
   }

  
   global $nome, $email;
   
   
    // Prepara e executa a consulta SQL
    $sql = "SELECT * FROM `usuario` WHERE NOMEUSUARIO = '".$nome."' AND LOGINUSUARIO = '".$email."'";

     // Debugging: imprime a consulta SQL para verificação
   // echo "Consulta SQL: " . $sql;

    $result = mysqli_query($conn, $sql);

    // Verifica se a consulta foi bem-sucedida
    if (!$result) {
        $response = ['status' => 'error', 'message' => 'Erro na consulta: ' . mysql_error($conn)];
        echo json_encode($response);
        exit;
    }

    // Verifica se há resultados
    if (mysqli_num_rows($result) > 0) {
        $dados = mysqli_fetch_array($result);
        $data = [
            'id' => $dados['IDUSUARIO'],
            'nome' => $dados['NOMEUSUARIO'],
            'email' => $dados['LOGINUSUARIO']
        ];
    } else {
        $data = ['status' => 'info', 'message' => 'Nenhum usuário encontrado.'];
    }

    // Retorna o resultado como JSON
    echo json_encode($data);

    // Fecha a conexão
    mysqli_close($conn);
}

// Função para lidar com solicitações POST
function handlePostRequest() {
    $input = json_decode(file_get_contents('php://input'), true);
    if (isset($input['name']) && isset($input['email'])) {

$sql = "INSERT INTO `usuario` (`IDUSUARIO`, `NOMEUSUARIO`, `LOGINUSUARIO`, `SENHAUSUARIO`) VALUES
(120 'ADM', 'ADM', '123')";
$result = mysqli_query(conexao(),$sql);
$total = mysqli_num_rows($result); 
$dados = mysqli_fetch_array($result);  
$id=$dados[0];
$nome_result=$dados[1];
$email_result=$dados[2];

$data = [
    'id' => $id,
    'name' => $nome_result,
    'email' => $email_result
];

$response = [
    'status' => 'success',
    'message' => 'Data received successfully',
    'data' => json_encode($data)
];
    } else {
        $response = [
            'status' => 'error',
            'message' => 'Invalid data'
        ];
    }
    echo json_encode($response);
}

// Determinar o método da solicitação
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        handleGetRequest();
        break;
    case 'POST':
        handlePostRequest();
        break;
    default:
        echo json_encode(['message' => 'Method not supported']);
}
?>

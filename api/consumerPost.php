<?php
header('Content-Type: application/json');

function handlePostRequest() {
        $nome=$_POST['name'];
        $email=$_POST['email'];
    if (isset($_POST['name']) && isset($_POST['name'])) {
        $response = [
            'status' => 'success',
            'message' => 'Data received successfully',
            'data' => '{nome:'.$nome.', email:'.$email.'}'
        ];
    } else {
        $response = [
            'status' => 'error',
            'message' => 'Invalid data'
        ];
    }
    echo json_encode($response);
}

$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'POST') {
    handlePostRequest();
} else {
    echo json_encode(['message' => 'Method not supported']);
}
?>


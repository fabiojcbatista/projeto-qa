<?php header("Content-type: text/html; charset=utf-8");
define('DB_SERVER', 'fdb27.runhosting.com');
define('DB_USERNAME', '3534042_dbempresax');
define('DB_PASSWORD', '2010fabiojcb');
define('DB_NAME', '3534042_dbempresax');

$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
mysqli_set_charset($link, 'utf8');


session_start();

function sessao(){
session_start();
$id=$_SESSION['id']; 
}

function UsuarioLogado($id)
{
	    
	    $sql = "SELECT nomeusuario from usuario where idusuario=$id";                                
		$result = mysqli_query($link,$sql)or die("Erro no banco de dados!"); 
 
		$total = mysqli_num_rows($result); 
		$dados = mysqli_fetch_array($result);  

        $nome=$dados[0];
		echo $nome;
}



?>
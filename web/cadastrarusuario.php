<?php header("Content-type: text/html; charset=utf-8");
require_once('conexao.php');


if (isset($_POST['email'])) {
        $email = htmlspecialchars($_POST['email']);
        echo "Email recebido: " . $email;
    } else {
        echo "Campo 'email' não foi enviado.";
    }

if (isset($_POST['senha'])) {
        $senha = htmlspecialchars($_POST['senha']);
        echo "Senha recebido: " . $senha;
    } else {
        echo "Campo 'senha' não foi enviado.";
    }

$sql = "SELECT * FROM usuario WHERE loginusuario = '".$email."' and SENHAUSUARIO = '".$senha."'";                                
$result = mysqli_query($link,$sql)or die("Erro no banco de dados!"); 
 
$total = mysqli_num_rows($result); 
$dados = mysqli_fetch_array($result);  

$_SESSION['id']=$dados['idusuario'];
$ii=0;
  while($row = mysqli_fetch_array($result)) {
                 
        $ii++;
       }
	   
	if(mysqli_num_rows ($result) > 0 )
	   {
					echo"<script language='javascript' type='text/javascript'>
    window.location.href='produtos.html';</script>";

					
		   
	   }  else
	   {
		   echo "<p fontcolor='red'> Login ou senha inválido!</p>";
					
		   
	   }
            

	?>
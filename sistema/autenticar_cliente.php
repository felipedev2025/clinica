<?php 
@session_set_cookie_params(['httponly' => true]);
@session_start();
@session_regenerate_id(true);

require_once("conexao.php");

$usuario = filter_var($_POST['usuario'], @FILTER_SANITIZE_STRING);
$senha = filter_var($_POST['senha'], @FILTER_SANITIZE_STRING);

$query = $pdo->prepare("SELECT * from pacientes where cpf = :email");
$query->bindValue(":email", "$usuario");
$query->execute();
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas > 0){

	if(!password_verify($senha, $res[0]['senha'])){
		echo '<script>window.alert("Dados Incorretos!!")</script>'; 
		echo '<script>window.location="acesso.php"</script>';  
		exit();
	}

	

	$_SESSION['nome'] = $res[0]['nome'];
	$_SESSION['id'] = $res[0]['id'];	
	$_SESSION['token_0078'] = 'A504030';


	echo '<script>window.location="painel_cliente"</script>';

}else{

	echo '<script>window.alert("Dados Incorretos!!")</script>'; 

	echo '<script>window.location="acesso.php"</script>';  

}





 ?>


<?php 
@session_start();
require_once("../sistema/conexao.php");
$data = date('Y-m-d');
$cpf = @$_POST['cpf'];

if($cpf == ""){
	exit();
}

@$_SESSION['cpf'] = $cpf;


$query = $pdo->query("SELECT * FROM pacientes where cpf LIKE '$cpf' ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
if(@count($res) > 0){
	$nome = $res[0]['nome'];
	$id_cliente = $res[0]['id'];
	$telefone = $res[0]['telefone'];
	
}

echo @$nome.'*'.@$telefone.'*'.@$id_cliente;




?>


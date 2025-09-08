<?php 

$tabela = 'pacientes';

require_once("../conexao.php");



$nome = $_POST['nome'];
$telefone = $_POST['telefone'];
$conf_senha = $_POST['conf_senha'];
$endereco = $_POST['endereco'];
$senha = $_POST['senha'];
$senha_crip = password_hash($senha, PASSWORD_DEFAULT);
$id = $_POST['id_usuario'];


if($conf_senha != $senha){

	echo 'As senhas não se coincidem';

	exit();

}


//validacao telefone

$query = $pdo->query("SELECT * from $tabela where telefone = '$telefone'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$id_reg = @$res[0]['id'];
if(@count($res) > 0 and $id != $id_reg){
	echo 'Telefone já Cadastrado!';
	exit();
}


$query = $pdo->prepare("UPDATE $tabela SET nome = :nome, telefone = :telefone, senha = '$senha_crip', endereco = :endereco where id = '$id'");



$query->bindValue(":nome", "$nome");

$query->bindValue(":telefone", "$telefone");

$query->bindValue(":endereco", "$endereco");

$query->execute();



echo 'Editado com Sucesso';

 ?>
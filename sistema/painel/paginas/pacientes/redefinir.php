<?php 

$tabela = 'pacientes';

require_once("../../../conexao.php");



$id = $_POST['id'];
$senha = '123';
$senha_crip = password_hash($senha, PASSWORD_DEFAULT);


$pdo->query("UPDATE $tabela SET senha = '$senha_crip' WHERE id = '$id' ");

echo 'Excluído com Sucesso';

?>
<?php 
$tabela = 'itens_servicos';
require_once("../../../conexao.php");

$titulo = $_POST['titulo'];
$descricao = $_POST['descricao'];
$ativo = $_POST['ativo'];
$id = $_POST['id'];



if($id == ""){
$query = $pdo->prepare("INSERT INTO $tabela SET titulo = :titulo, descricao = :descricao, ativo = :ativo ");
}else{
$query = $pdo->prepare("UPDATE $tabela SET titulo = :titulo, descricao = :descricao, ativo = :ativo where id = '$id'");
}

$query->bindValue(":titulo", "$titulo");
$query->bindValue(":descricao", "$descricao");
$query->bindValue(":ativo", "$ativo");
$query->execute();

echo 'Salvo com Sucesso';

 ?>
<?php 
$tabela = 'remedios';
require_once("../../../conexao.php");

$codigo = $_POST['codigo'];
$nome = $_POST['nome'];
$nome_quimico = $_POST['nome_quimico'];
$laboratorio = $_POST['laboratorio'];
$forma_farmaceutica = $_POST['forma_farmaceutica'];
$apresentacao = $_POST['apresentacao'];
$unidade = $_POST['unidade'];
$valor_custo = $_POST['valor_custo'];
$valor_venda = $_POST['valor_venda'];
$estoque = $_POST['estoque'];
$estoque_minimo = $_POST['estoque_minimo'];

$antibiotico = $_POST['antibiotico'];
$lote = $_POST['lote'];
$validade = $_POST['validade'];
$obs = $_POST['obs'];

$id = $_POST['id'];

$valor_custo = str_replace(',', '.', $valor_custo);
$valor_custo = str_replace(',', '.', $valor_custo);


if($estoque == ""){
	$estoque = 0;
}

if($estoque_minimo == ""){
	$estoque_minimo = 0;
}

if($id == ""){
$query = $pdo->prepare("INSERT INTO $tabela SET codigo = :codigo, nome = :nome, nome_quimico = :nome_quimico, laboratorio = :laboratorio, forma_farmaceutica = :forma_farmaceutica, apresentacao = :apresentacao, unidade = :unidade, valor_custo = :valor_custo, valor_venda = :valor_venda, estoque = :estoque, estoque_minimo = :estoque_minimo, antibiotico = :antibiotico, obs = :obs, lote = :lote, validade = :validade ");
	
}else{
$query = $pdo->prepare("UPDATE $tabela SET codigo = :codigo, nome = :nome, nome_quimico = :nome_quimico, laboratorio = :laboratorio, forma_farmaceutica = :forma_farmaceutica, apresentacao = :apresentacao, unidade = :unidade, valor_custo = :valor_custo, valor_venda = :valor_venda, estoque = :estoque, estoque_minimo = :estoque_minimo, antibiotico = :antibiotico, obs = :obs, lote = :lote, validade = :validade where id = '$id'");
}
$query->bindValue(":codigo", "$codigo");
$query->bindValue(":nome", "$nome");
$query->bindValue(":nome_quimico", "$nome_quimico");
$query->bindValue(":laboratorio", "$laboratorio");
$query->bindValue(":forma_farmaceutica", "$forma_farmaceutica");
$query->bindValue(":apresentacao", "$apresentacao");
$query->bindValue(":unidade", "$unidade");
$query->bindValue(":valor_custo", "$valor_custo");
$query->bindValue(":valor_venda", "$valor_venda");
$query->bindValue(":estoque", "$estoque");
$query->bindValue(":estoque_minimo", "$estoque_minimo");
$query->bindValue(":antibiotico", "$antibiotico");
$query->bindValue(":obs", "$obs");
$query->bindValue(":lote", "$lote");
$query->bindValue(":validade", "$validade");
$query->execute();

echo 'Salvo com Sucesso';

 ?>
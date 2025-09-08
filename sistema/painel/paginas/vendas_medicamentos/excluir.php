<?php 
$tabela = 'receber';
require_once("../../../conexao.php");

$id = $_POST['id'];



//totalizando a venda
$query = $pdo->query("SELECT * from itens_venda where venda = '$id' order by id asc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas > 0){
for($i=0; $i<$linhas; $i++){	
	$medicamento = $res[$i]['medicamento'];
	$quantidade = $res[$i]['quantidade'];
	
	$query2 = $pdo->query("SELECT * FROM remedios where id = '$medicamento'");
	$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
	$estoque = $res2[0]['estoque'];

	//abater do estoque os itens vendidos
	$novo_estoque = $estoque + $quantidade;
	$pdo->query("UPDATE remedios SET estoque = '$novo_estoque' where id = '$medicamento'");

	}
}

$pdo->query("DELETE FROM itens_venda WHERE venda = '$id' ");
$pdo->query("DELETE FROM $tabela WHERE id = '$id' ");
echo 'Excluído com Sucesso';
?>
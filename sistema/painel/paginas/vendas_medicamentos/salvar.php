<?php 
@session_start();
$id_usuario = @$_SESSION['id'];
$tabela = 'receber';
require_once("../../../conexao.php");

$cliente = $_POST['cliente'];
$data_pgto = $_POST['data_pgto'];
$forma_pgto = $_POST['forma_pgto'];
$desconto = $_POST['desconto'];

if($desconto == ""){
	$desconto = 0;
}

$data_atual = date('Y-m-d');
if(strtotime($data_pgto) > strtotime($data_atual)){
	$pago = 'Não';
	$sql_data_pgto = '';
	$sql_usuario_pgto = '';
}else{
	$pago = 'Sim';
	$sql_data_pgto = ", data_pgto = '$data_pgto' ";
	$sql_usuario_pgto = ", usuario_pgto = '$id_usuario'";
}

//totalizando a venda
$total_valor = 0;
$query = $pdo->query("SELECT * from itens_venda where venda = 0 and usuario = '$id_usuario' order by id asc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas > 0){

$total_valor = 0;
for($i=0; $i<$linhas; $i++){
	$id = $res[$i]['id'];
	$medicamento = $res[$i]['medicamento'];
	$quantidade = $res[$i]['quantidade'];
	$nome_remedio = $res[$i]['nome'];
	$valor = $res[$i]['valor'];
	$quantidade = $res[$i]['quantidade'];
	$total = $res[$i]['total'];

	$total_valor += $total;

	
$query2 = $pdo->query("SELECT * FROM remedios where id = '$medicamento'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
$estoque = $res2[0]['estoque'];



//abater do estoque os itens vendidos
$novo_estoque = $estoque - $quantidade;
$pdo->query("UPDATE remedios SET estoque = '$novo_estoque' where id = '$medicamento'");

}

$total_valor = $total_valor - $desconto;
}

if($total_valor <= 0){
	echo 'O total da venda é zero, Insira os Medicamentos para Efetuar a venda!';
	exit();
}


//verificar caixa aberto
$query1 = $pdo->query("SELECT * from caixas where operador = '$id_usuario' and data_fechamento is null order by id desc limit 1");
$res1 = $query1->fetchAll(PDO::FETCH_ASSOC);
if(@count($res1) > 0){
	$id_caixa = @$res1[0]['id'];
}else{
	$id_caixa = 0;
}


$query = $pdo->prepare("INSERT INTO $tabela SET descricao = 'Nova Venda', cliente = :cliente, valor = '$total_valor', data_lanc = curDate(), data_venc = '$data_pgto' $sql_data_pgto , usuario_lanc = '$id_usuario' $sql_usuario_pgto, frequencia = 0, saida = '$forma_pgto', arquivo = 'sem-foto.png', pago = '$pago', referencia = 'Venda', desconto = :desconto, hora = curTime(), caixa = '$id_caixa' ");
	

$query->bindValue(":cliente", "$cliente");
$query->bindValue(":desconto", "$desconto");
$query->execute();
$id_venda = $pdo->lastInsertId();

echo 'Salvo com Sucesso';

//relacionar os itens vendidos a venda
$pdo->query("UPDATE itens_venda SET venda = '$id_venda' where venda = 0 and usuario = '$id_usuario'");




 ?>
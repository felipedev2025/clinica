<?php 
@session_start();
$id_usuario = @$_SESSION['id'];
$tabela = 'itens_venda';
require_once("../../../conexao.php");

$medicamento = $_POST['medicamento'];
$quantidade = $_POST['quantidade'];
$cliente = $_POST['cliente'];

//verifidar o estoque
$query2 = $pdo->query("SELECT * FROM remedios where id = '$medicamento'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
$estoque_atual = $res2[0]['estoque'];
$nome_remedio = $res2[0]['nome'];
$valor = $res2[0]['valor_venda'];
$total = $valor * $quantidade;


if($quantidade > $estoque_atual){
	echo 'Você só possui '.$estoque_atual.' Itens em estoque desse medicamento!';
	exit();
}


$query = $pdo->prepare("INSERT INTO $tabela SET venda = 0, usuario = '$id_usuario', medicamento = :medicamento, quantidade = :quantidade, paciente = :paciente, data = curDate(), hora = curTime(), valor = '$valor', total = '$total', nome = '$nome_remedio' ");
	
$query->bindValue(":medicamento", "$medicamento");
$query->bindValue(":quantidade", "$quantidade");
$query->bindValue(":paciente", "$cliente");
$query->execute();

echo 'Salvo com Sucesso';

 ?>
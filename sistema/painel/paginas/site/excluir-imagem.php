<?php 
$tabela = 'imagens_portfolio';
require_once("../../../conexao.php");

$id = $_POST['id'];

$query = $pdo->query("SELECT * FROM $tabela where id = '$id'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
$foto = $res[0]['foto'];
if($foto != "sem-foto.png"){
	@unlink('../../../../assets/img/portfolio/imagens/'.$foto);
}

$pdo->query("DELETE FROM $tabela where id = '$id'");

echo 'Excluído com Sucesso';

?>
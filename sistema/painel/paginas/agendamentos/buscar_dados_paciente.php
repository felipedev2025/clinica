<?php 
require_once("../../../conexao.php");
$pagina = 'pacientes';

$paciente = @$_POST['paciente'];


$query = $pdo->query("SELECT * FROM pacientes where id = '$paciente'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);

	$nome = $res[0]['nome'];

	$telefone = $res[0]['telefone'];

	$cpf = $res[0]['cpf'];	

	$endereco = $res[0]['endereco'];	

	$data_cad = $res[0]['data_cad'];

	$data_nasc = $res[0]['data_nasc'];	

	$convenio = $res[0]['convenio'];

	$tipo_sanguineo = $res[0]['tipo_sanguineo'];

	$nome_responsavel = $res[0]['nome_responsavel'];

	$cpf_responsavel = $res[0]['cpf_responsavel'];

	$sexo = $res[0]['sexo'];

	$obs = $res[0]['obs'];

	$estado_civil = $res[0]['estado_civil'];

	$profissao = $res[0]['profissao'];
	$telefone2 = @$res[0]['telefone2'];
	$cartao_sus = @$res[0]['cartao_sus'];


	echo $nome.'*'.$cpf.'*'.$telefone.'*'.$endereco.'*'.$data_nasc.'*'.$nome_responsavel.'*'.$tipo_sanguineo.'*'.$convenio.'*'.$cpf_responsavel.'*'.$sexo.'*'.$obs.'*'.$estado_civil.'*'.$profissao.'*'.$telefone2.'*'.$cartao_sus;


?>


<?php 
@session_start();
$usuario_logado = @$_SESSION['id'].'';
$tabela = 'agendamentos';
require_once("../../../conexao.php");

$id_triagem = $_POST['id'];
$funcionario = $_POST['funcionario'];
$servico = $_POST['servico'];
$obs = $_POST['obs'];
$paciente_consulta = $_POST['paciente_consulta'];
$risco_consulta = $_POST['risco_consulta'];
$id_agendamento = $_POST['id_agendamento'];


if($id_agendamento == "" || $id_agendamento == 0){
    $query = $pdo->prepare("INSERT INTO $tabela SET funcionario = '$funcionario', paciente = '$paciente_consulta', hora = curTime(), data = curDate(), usuario = '$usuario_logado', status = 'Confirmado', obs = :obs, data_lanc = curDate(), servico = '$servico', pago = 'Não', convenio = '0', risco = '$risco_consulta', triagem = '$id_triagem'");
}else{
    $query = $pdo->prepare("UPDATE $tabela SET funcionario = '$funcionario', usuario = '$usuario_logado', obs = :obs,  servico = '$servico', risco = '$risco_consulta' where id = '$id_agendamento'");
}

$query->bindValue(":obs", "$obs");
$query->execute();
if($id_agendamento == "" || $id_agendamento == 0){
	$id_agendamento = $pdo->lastInsertId();
	//atualizar o id_agendamento na triagem
	$pdo->query("UPDATE triagens SET id_agendamento = '$id_agendamento' where id = '$id_triagem'");
}



echo 'Salvo com Sucesso';

 ?>
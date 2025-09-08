<?php 
$tabela = 'triagens';
require_once("../../../conexao.php");

$id = $_POST['id'];
$risco = $_POST['risco'];
$queixa = $_POST['queixa'];
$pa = $_POST['pa'];
$fc = $_POST['fc'];
$fr = $_POST['fr'];
$temperatura = $_POST['temperatura'];
$saturacao = $_POST['saturacao'];
$alergias = $_POST['alergias'];
$medicamentos = $_POST['medicamentos'];
$historico = $_POST['historico'];
$inicio_sintomas = $_POST['inicio_sintomas'];
$condicao_geral = $_POST['condicao_geral'];
$escala_dor = $_POST['escala_dor'];
$id_paciente = $_POST['cliente'];


if($id == ""){
    $query = $pdo->prepare("INSERT INTO $tabela SET id_paciente = :id_paciente, risco = :risco, queixa = :queixa, pa = :pa, fc = :fc, fr = :fr, temperatura = :temperatura, saturacao = :saturacao, alergias = :alergias, medicamentos = :medicamentos, historico = :historico, inicio_sintomas = :inicio_sintomas, condicao_geral = :condicao_geral, escala_dor = :escala_dor, data = curDate(), hora = curTime()");
}else{
    $query = $pdo->prepare("UPDATE $tabela SET id_paciente = :id_paciente, risco = :risco, queixa = :queixa, pa = :pa, fc = :fc, fr = :fr, temperatura = :temperatura, saturacao = :saturacao, alergias = :alergias, medicamentos = :medicamentos, historico = :historico, inicio_sintomas = :inicio_sintomas, condicao_geral = :condicao_geral, escala_dor = :escala_dor where id = '$id'");
}

$query->bindValue(":id_paciente", "$id_paciente");
$query->bindValue(":risco", "$risco");
$query->bindValue(":queixa", "$queixa");
$query->bindValue(":pa", "$pa");
$query->bindValue(":fc", "$fc");
$query->bindValue(":fr", "$fr");
$query->bindValue(":temperatura", "$temperatura");
$query->bindValue(":saturacao", "$saturacao");
$query->bindValue(":alergias", "$alergias");
$query->bindValue(":medicamentos", "$medicamentos");
$query->bindValue(":historico", "$historico");
$query->bindValue(":inicio_sintomas", "$inicio_sintomas");
$query->bindValue(":condicao_geral", "$condicao_geral");
$query->bindValue(":escala_dor", "$escala_dor");
$query->execute();


echo 'Salvo com Sucesso';

 ?>
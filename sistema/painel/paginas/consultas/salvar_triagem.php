<?php 
@session_start();
$id_usuario = $_SESSION['id'];
$tabela = 'triagens';
require_once("../../../conexao.php");

$id_triagem = $_POST['id_triagem'];
$hiposteses = @$_POST['hiposteses'];
$procedimentos_realizados = @$_POST['procedimentos_realizados'];
$conduta_medica = @$_POST['conduta_medica'];
$internacao = @$_POST['internacao'];
$aih = @$_POST['aih'];
$cid_10 = @$_POST['cid_10'];
$motivo_internacao = @$_POST['motivo_internacao'];
$justificativa_clinica = @$_POST['justificativa_clinica'];


$query = $pdo->prepare("UPDATE $tabela SET hiposteses = :hiposteses, procedimentos_realizados = :procedimentos_realizados, conduta_medica = :conduta_medica, internacao = :internacao, aih = :aih, cid_10 = :cid_10, motivo_internacao = :motivo_internacao, justificativa_clinica = :justificativa_clinica WHERE id = '$id_triagem'");


$query->bindValue(":hiposteses", "$hiposteses");
$query->bindValue(":procedimentos_realizados", "$procedimentos_realizados");
$query->bindValue(":conduta_medica", "$conduta_medica");
$query->bindValue(":internacao", "$internacao");
$query->bindValue(":aih", "$aih");
$query->bindValue(":cid_10", "$cid_10");
$query->bindValue(":motivo_internacao", "$motivo_internacao");
$query->bindValue(":justificativa_clinica", "$justificativa_clinica");

$query->execute();


echo 'Salvo com Sucesso';

?>
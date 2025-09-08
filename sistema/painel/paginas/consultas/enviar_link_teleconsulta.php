<?php 
@session_start();
$id_usuario = @$_SESSION['id'];
require_once("../../../conexao.php");

$telefone = $_POST['telefone'];
$link = $_POST['link'];
$procedimento = $_POST['procedimento'];
$paciente = $_POST['paciente'];
$data = $_POST['data'];
$hora = $_POST['hora'];


if($token != ""){

$telefone_envio = '55'.preg_replace('/[ ()-]+/' , '' , $telefone);

$mensagem = '*'.$nome_sistema.'* %0A';
$mensagem .= '👩‍⚕️ Olá *'.$paciente.'*! %0A%0A';
$mensagem .= '*Procedimento:* '.$procedimento.' %0A';
$mensagem .= '*Data:* '.$data.' %0A';
$mensagem .= '*Horário:* '.$hora.' %0A%0A';
$mensagem .= '🔗 *Link de Acesso à Consulta:* %0A'.$link.' %0A%0A';
$mensagem .= '_Por favor, acesse o link para entrar na consulta._ %0A';

require("../../apis/texto.php");
echo 'Link Enviado!';
	
}


 ?>
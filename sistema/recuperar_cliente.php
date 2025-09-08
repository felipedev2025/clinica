<?php 

require_once("conexao.php");

$email = filter_var($_POST['email'], @FILTER_SANITIZE_STRING);

$query = $pdo->prepare("SELECT * from pacientes where cpf = :email");
$query->bindValue(":email", "$email");
$query->execute();

$res = $query->fetchAll(PDO::FETCH_ASSOC);

$linhas = @count($res);

if($linhas > 0){

	$senha = $res[0]['senha'];
	$telefone_cliente = $res[0]['telefone'];
	$nome = $res[0]['nome'];

	$nova_senha = rand(100000, 100000000);
	$senha_crip = password_hash($nova_senha, PASSWORD_DEFAULT);
	$query = $pdo->prepare("UPDATE pacientes SET senha = '$senha_crip' where cpf = :email");
	$query->bindValue(":email", "$email");
	$query->execute();
	


		$telefone_envio = '55'.preg_replace('/[ ()-]+/' , '' , $telefone_cliente);
		$mensagem = '*'.$nome_sistema.'* %0A';
		$mensagem .= '😀 Olá *'.$nome.'*%0A';
		$mensagem .= '_Sua senha foi redefinida_ %0A';
		$mensagem .= 'Utilize a senha '.$nova_senha.' para acessar! %0A%0A';		
		
		$mensagem .= '*Url de Acesso:* '.$url_sistema.'acesso.php %0A';	

		require("painel/apis/texto.php");

	



	echo 'Nova Senha enviada para seu whatsapp';

}else{

echo 'CPF não Cadastrado!';

}	

 ?>


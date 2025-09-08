<?php 

$tabela = 'pacientes';

require_once("../../../conexao.php");


$nome=@$_POST['nome'];
$cpf=@$_POST['cpf'];
$telefone=@$_POST['telefone'];
$telefone2=@$_POST['telefone2'];
$data_nasc=@$_POST['data_nasc'];
$endereco=@$_POST['endereco'];
$tipo_sanguineo=@$_POST['tipo_sanguineo'];
$convenio=@$_POST['convenio'];
$nome_responsavel=@$_POST['nome_responsavel'];
$cpf_responsavel=@$_POST['cpf_responsavel'];
$sexo=@$_POST['sexo'];
$obs=@$_POST['obs'];
$estado_civil=@$_POST['estado_civil'];
$profissao=@$_POST['profissao'];
$cartao_sus=@$_POST['cartao_sus'];

$senha = '123';

$senha_crip = password_hash($senha, PASSWORD_DEFAULT);

$obs = str_replace("'", " ", $obs);

$obs = str_replace('"', ' ', $obs);

$id = @$_POST['id'];






if($id == ""){

$query = $pdo->prepare("INSERT INTO $tabela SET nome = :nome, telefone = :telefone, cpf = :cpf, endereco = :endereco, data_nasc = :data_nasc, tipo_sanguineo = :tipo_sanguineo, data_cad = curDate(), nome_responsavel = :nome_responsavel, cpf_responsavel = :cpf_responsavel, convenio = :convenio, sexo = :sexo, obs = :obs, estado_civil = :estado_civil, profissao = :profissao, telefone2 = :telefone2, senha = '$senha_crip', hora_cad = curTime(), cartao_sus = :cartao_sus");

	

}else{

$query = $pdo->prepare("UPDATE $tabela SET nome = :nome, telefone = :telefone, cpf = :cpf, endereco = :endereco, data_nasc = :data_nasc, tipo_sanguineo = :tipo_sanguineo, nome_responsavel = :nome_responsavel, cpf_responsavel = :cpf_responsavel, convenio = :convenio, sexo = :sexo, obs = :obs, estado_civil = :estado_civil, profissao = :profissao, telefone2 = :telefone2, cartao_sus = :cartao_sus where id = '$id'");

}

$query->bindValue(":nome", "$nome");

$query->bindValue(":cpf", "$cpf");

$query->bindValue(":telefone", "$telefone");

$query->bindValue(":endereco", "$endereco");

$query->bindValue(":data_nasc", "$data_nasc");

$query->bindValue(":tipo_sanguineo", "$tipo_sanguineo");

$query->bindValue(":nome_responsavel", "$nome_responsavel");

$query->bindValue(":cpf_responsavel", "$cpf_responsavel");

$query->bindValue(":convenio", "$convenio");

$query->bindValue(":sexo", "$sexo");

$query->bindValue(":obs", "$obs");

$query->bindValue(":estado_civil", "$estado_civil");

$query->bindValue(":profissao", "$profissao");

$query->bindValue(":telefone2", "$telefone2");
$query->bindValue(":cartao_sus", "$cartao_sus");

$query->execute();



echo 'Salvo com Sucesso';



if($id == "" and $token != ""){

		$telefone_envio = '55'.preg_replace('/[ ()-]+/' , '' , $telefone);
		$mensagem = '*'.$nome_sistema.'* %0A';
		$mensagem .= '😀 Olá *'.$nome.'*%0A';
		$mensagem .= '_Você foi cadastrado em nosso Sistema_ %0A';
		$mensagem .= 'Utilize seu *CPF* e a senha *123* para acessar! %0A%0A';	
		
		$mensagem .= '_Faça seu acesso e troque sua Senha_%0A';
		$mensagem .= '*Url de Acesso:* '.$url_sistema.'acesso.php %0A';	

		require("../../apis/texto.php");

	

}	

 ?>
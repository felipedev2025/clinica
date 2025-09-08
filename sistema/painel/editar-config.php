<?php 

$tabela = 'config';

require_once("../conexao.php");

if($modo_teste == 'Sim'){
	echo 'Em modo de teste esse recurso fica desabilitado!';
	exit();
}

$nome = $_POST['nome_sistema'];

$email = $_POST['email_sistema'];

$telefone = $_POST['telefone_sistema'];

$endereco = $_POST['endereco_sistema'];

$telefone_fixo = $_POST['telefone_fixo'];

$comissao_sistema = $_POST['comissao_sistema'];

$horas_confirmacao = $_POST['horas_confirmacao'];

$token = $_POST['token'];

$instancia = $_POST['instancia'];

$marca_dagua = $_POST['marca_dagua'];

$paciente_receita = $_POST['paciente_receita'];
$ocultar_acessos = $_POST['ocultar_acessos'];
$desativar_marketing = $_POST['desativar_marketing'];
$seletor_api = $_POST['seletor_api'];
$tempo_tela_chamadas = $_POST['tempo_tela_chamadas'];
$tempo_tela_consultas = $_POST['tempo_tela_consultas'];

$agendamento_cliente = $_POST['agendamento_cliente'];
$mapa = $_POST['mapa'];
$porc_servico = $_POST['porc_servico'];
$opcao_pagar = $_POST['opcao_pagar'];
$municipio_sistema = $_POST['municipio_sistema'];
$chave_teleconsulta = $_POST['chave_teleconsulta'];

//foto logo

$caminho = '../img/logo.png';

$imagem_temp = @$_FILES['foto-logo']['tmp_name']; 



if(@$_FILES['foto-logo']['name'] != ""){

	$ext = pathinfo($_FILES['foto-logo']['name'], PATHINFO_EXTENSION);   

	if($ext == 'png'){ 	

				

		move_uploaded_file($imagem_temp, $caminho);

	}else{

		echo 'Extensão de Imagem não permitida!';

		exit();

	}

}





//foto logo rel

$caminho = '../img/logo.jpg';

$imagem_temp = @$_FILES['foto-logo-rel']['tmp_name']; 



if(@$_FILES['foto-logo-rel']['name'] != ""){

	$ext = pathinfo(@$_FILES['foto-logo-rel']['name'], PATHINFO_EXTENSION);   

	if($ext == 'jpg'){ 	

			

		move_uploaded_file($imagem_temp, $caminho);

	}else{

		echo 'Extensão de Imagem não permitida!';

		exit();

	}

}





//foto icone

$caminho = '../img/icone.png';

$imagem_temp = @$_FILES['foto-icone']['tmp_name']; 



if(@$_FILES['foto-icone']['name'] != ""){

	$ext = pathinfo(@$_FILES['foto-icone']['name'], PATHINFO_EXTENSION);   

	if($ext == 'png'){ 	

			

		move_uploaded_file($imagem_temp, $caminho);

	}else{

		echo 'Extensão de Imagem não permitida!';

		exit();

	}

}



//foto fundo login
$nome_img = date('d-m-Y H:i:s') . '-' . @$_FILES['fundo_login']['name'];
$nome_img = preg_replace('/[ :]+/', '-', $nome_img);
$caminho = '../img/'.$nome_img;
$imagem_temp = @$_FILES['fundo_login']['tmp_name']; 

if(@$_FILES['fundo_login']['name'] != ""){
	$ext = pathinfo(@$_FILES['fundo_login']['name'], PATHINFO_EXTENSION);   
	if($ext == 'jpg' || $ext == 'jpeg' || $ext == 'JPG' || $ext == 'png' || $ext == 'PNG'|| $ext == 'gif' || $ext == 'GIF' || $ext == 'webp' || $ext == 'WEBP'){			
		move_uploaded_file($imagem_temp, $caminho);
		$fundo_login = $nome_img;

		$query = $pdo->query("SELECT * FROM config");
		$res = $query->fetchAll(PDO::FETCH_ASSOC);
		$fundo_login_antigo = @$res[0]['fundo_login'];

		if($fundo_login_antigo != "sem-foto.png"){
			@unlink('../img/'.$fundo_login_antigo);
		} 

	}else{
		echo 'Extensão de Imagem não permitida!';
		exit();
	}
}


$query = $pdo->prepare("UPDATE $tabela SET nome = :nome, email = :email, telefone = :telefone, endereco = :endereco, telefone_fixo = :telefone_fixo, token = :token, instancia = :instancia, horas_confirmacao = :horas_confirmacao, comissao = :comissao_sistema, marca_dagua = :marca_dagua, paciente_receita = :paciente_receita, ocultar_acessos = :ocultar_acessos, desativar_marketing = :desativar_marketing, seletor_api = '$seletor_api', tempo_tela_chamadas = '$tempo_tela_chamadas', tempo_tela_consultas = '$tempo_tela_consultas', agendamento_cliente = '$agendamento_cliente', mapa = '$mapa', porc_servico = '$porc_servico', fundo_login = '$fundo_login', opcao_pagar = '$opcao_pagar', municipio_sistema = :municipio_sistema, chave_teleconsulta = :chave_teleconsulta where id = 1");



$query->bindValue(":nome", "$nome");

$query->bindValue(":email", "$email");

$query->bindValue(":telefone", "$telefone");

$query->bindValue(":endereco", "$endereco");

$query->bindValue(":comissao_sistema", "$comissao_sistema");

$query->bindValue(":telefone_fixo", "$telefone_fixo");

$query->bindValue(":token", "$token");

$query->bindValue(":instancia", "$instancia");

$query->bindValue(":horas_confirmacao", "$horas_confirmacao");

$query->bindValue(":marca_dagua", "$marca_dagua");

$query->bindValue(":paciente_receita", "$paciente_receita");
$query->bindValue(":ocultar_acessos", "$ocultar_acessos");
$query->bindValue(":desativar_marketing", "$desativar_marketing");
$query->bindValue(":municipio_sistema", "$municipio_sistema");
$query->bindValue(":chave_teleconsulta", "$chave_teleconsulta");
$query->execute();



echo 'Editado com Sucesso';

 ?>
<?php 

$id_conta = @$_GET['id_agd'];
if($id_conta != ""){
	  if(@$porc_servico > 0){ 
	  	echo 'Faça o pagamento antes de ir para o agendamento';
	  	exit();
	  }
	 require("../conexao.php");
	 $valor_pago = '0';
	 $query = $pdo->query("SELECT * FROM agendamentos_temp where id = '$id_conta'");
}else{
	 $query = $pdo->query("SELECT * FROM agendamentos_temp where ref_pix = '$ref_pix'");
}
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$total_reg = @count($res);
	$cliente = $res[0]['cliente'];
	$servico = $res[0]['servico'];
	$funcionario = $res[0]['funcionario'];
	$data = $res[0]['data'];
	$hora = $res[0]['hora'];
	$obs = $res[0]['obs'];
	$data_lanc = $res[0]['data_lanc'];
	$usuario = $res[0]['usuario'];
	$status = $res[0]['status'];	
	$hash = $res[0]['hash'];
	$ref_pix = $res[0]['ref_pix'];
	$data_agd = $res[0]['data'];
	$hora_do_agd = $res[0]['hora'];
	$valor = $res[0]['valor_pago'];

	$query = $pdo->query("SELECT * FROM usuarios where id = '$funcionario'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$comissao_func = $res[0]['comissao'];
$nome_profissional = $res[0]['nome'];

$comissao = $comissao_sistema;
if($comissao_func > 0){
	$comissao = $comissao_func;
}


	$query = $pdo->query("SELECT * FROM procedimentos where id = '$servico'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$nome_servico = $res[0]['nome'];
$valor_total_servico = $res[0]['valor'];

$valor_comissao = ($comissao * $valor_total_servico) / 100;






	if($valor > 0){
		$valor_pago = $valor;
	}

	
	$pago_agd = 'Não';
	

	if(@$forma_pgto == "pix"){
		$forma_pgto = "Pix";
	}else{
		$forma_pgto = "Cartão de Crédito";
	}

	$query = $pdo->query("SELECT * FROM procedimentos where id = '$servico' ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$nome_serv = @$res[0]['nome'];
$tempo = @$res[0]['tempo'];
$preparo = $res[0]['preparo'];

$servico_conc = $nome_serv." (Site)";

       



        $query = $pdo->query("INSERT INTO agendamentos SET funcionario = '$funcionario', paciente = '$cliente', hora = '$hora', data = '$data', usuario = '0', status = 'Agendado', obs = '$obs', data_lanc = curDate(), servico = '$servico', hash = '$hash', ref_pix = '$ref_pix', valor_pago = '$valor_pago', pago = 'Não', convenio = '0', retorno = 'Não'");

        
        $ult_id = $pdo->lastInsertId();

        if($id_conta == ""){     

$pdo->query("INSERT INTO receber SET descricao = '$servico_conc', referencia = 'Procedimento', valor = '$valor_pago', data_lanc = curDate(), data_venc = curDate(), data_pgto = curDate(), usuario_lanc = '0', usuario_pgto = '0', arquivo = 'sem-foto.png', cliente = '$cliente', pago = 'Sim', id_ref = '$servico', saida = '$forma_pgto', hora = curTime()");


	if($comissao > 0){
	//lançar a conta a pagar para a comissão do funcionário
	$pdo->query("INSERT INTO pagar SET descricao = '$servico_conc', referencia = 'Comissão', valor = '$valor_comissao', data_lanc = curDate(), data_venc = curDate(), usuario_lanc = '0', arquivo = 'sem-foto.png', pago = 'Não', funcionario = '$funcionario', id_ref = '$servico'");

	}

     	}




$dataF = implode('/', array_reverse(explode('-', $data)));
$horaF = date("H:i", @strtotime($hora));       



$query = $pdo->query("SELECT * FROM usuarios where id = '$funcionario'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$intervalo = @$res[0]['intervalo'];
$nome_func = @$res[0]['nome'];
$tel_func = @$res[0]['telefone'];

$hora_minutos = @strtotime("+$tempo minutes", @strtotime($hora));			
$hora_final_servico = date('H:i:s', $hora_minutos);



$query = $pdo->query("SELECT * FROM pacientes where id = '$cliente' ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$nome = $res[0]['nome'];
$telefone = $res[0]['telefone'];
$tel_cli = $res[0]['telefone'];

$texto_mensagem = 'Novo Agendamento';

$dataF = implode('/', array_reverse(explode('-', $data)));
$horaF = date("H:i", @strtotime($hora));


if($token != ""){
//agendar o alerta de confirmação
$hora_atual = date('H:i:s');
$data_atual = date('Y-m-d');
//$hora_minutos = strtotime("-$minutos_aviso minutes", strtotime($hora));
//$nova_hora = date('H:i:s', $hora_minutos);

$telefone_envio = '55'.preg_replace('/[ ()-]+/' , '' , $telefone);

$mensagem = '*'.$nome_sistema.'*%0A';
$mensagem .= '_'.$texto_mensagem.'_ %0A %0A';
$mensagem .= '*Paciente:* '.$nome.'%0A';
$mensagem .= '*Procedimento:* '.$nome_serv.'%0A';
$mensagem .= '*Data:* '.$dataF.'%0A';
$mensagem .= '*Hora:* '.$horaF.'%0A';
$mensagem .= '*Profissional:* '.$nome_profissional.'%0A';
if($obs != ""){
$mensagem .= '*OBS:* '.$obs.'%0A';
}
if($preparo != ""){
$mensagem .= '%0A*Atenção:* '.$preparo.'%0A';
}
require("../painel/apis/texto.php");
}




if($seletor_api == 'wm'){

	//MENSAGEM DE CONFIRMAÇÃO DO AGENDAMENTO
	if($horas_confirmacao > 0 and $token != ""){
		$mensagem = '*Confirmação de Agendamento* ';
		$mensagem .= '                              _(Digite o número com a opção desejada)_';
		$mensagem .= '                              1.  Digite 1️⃣ para confirmar ✅';		
		$mensagem .= '                              2.  Digite 2️⃣ para Cancelar ❌';
		$id_envio = $ult_id;
		$data_envio = $data_agd.' '.$hora_do_agd;
		
		require("../painel/apis/confirmacao.php");
		$id_agd = $ult_id;		
		$pdo->query("UPDATE agendamentos SET hash = '$id_agd' WHERE id = '$ult_id'");
	}

}else{

	
	if($horas_confirmacao > 0 and $token != ""){		
		$mensagem = '*Confirmação de Agendamento* %0A';
		$mensagem .= '_(Digite o número com a opção desejada)_ %0A';
		$mensagem .= '1.  Digite 1️⃣ para confirmar ✅ %0A';
		$mensagem .= '2.  Digite 2️⃣ para Cancelar ❌ %0A';
		$id_envio = $ult_id;
		$data_envio = $data_agd.' '.$hora_do_agd;

		$data_envio = date('Y-m-d H:i:s', strtotime("-$horas_confirmacao hours",strtotime($data_envio)));
		
		require("../painel/apis/agendar.php");
		$id_agd = $ult_id;		
		$pdo->query("UPDATE agendamentos SET hash = '$hash' WHERE id = '$ult_id'");
	}
}



while (@strtotime($hora) < @strtotime($hora_final_servico)){
		
		$hora_minutos = @strtotime("+$intervalo minutes", @strtotime($hora));			
		$hora = date('H:i:s', $hora_minutos);

		if(@strtotime($hora) < @strtotime($hora_final_servico)){
			$query = $pdo->query("INSERT INTO horarios_agd SET agendamento = '$ult_id', horario = '$hora', funcionario = '$funcionario', data = '$data_agd'");
		}
	

}


if($id_conta != ""){
	$query = $pdo->query("DELETE FROM agendamentos_temp where id = '$id_conta'");
	echo "<script>window.location='../painel_cliente'</script>";
}else{
	$query = $pdo->query("DELETE FROM agendamentos_temp where ref_pix = '$ref_pix'");
}


 ?>
<?php 

require_once("../../../conexao.php");

$tabela = 'agendamentos';

$data_hoje = date('Y-m-d');



@session_start();

$id_usuario = $_SESSION['id'];

$query2 = $pdo->query("SELECT * FROM usuarios where id = '$id_usuario'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
$nome_sala = @$res2[0]['sala'];

$dataInicial = @$_POST['dataInicial'];

$dataFinal = @$_POST['dataFinal'];

$status = '%'.@$_POST['status'].'%';

$funcionario = $id_usuario;



$hora_atual = date('H:i:s');



$query2 = $pdo->query("SELECT * FROM usuarios where id = '$funcionario'");

		$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);

		$total_reg2 = @count($res2);

		if($total_reg2 > 0){

			$nome_func2 = $res2[0]['nome'];

		}else{

			$nome_func2 = 'Sem Referência!';

		}



$agendados = 0;

$confirmados = 0;

$finalizados = 0;



if($status == "%%"){

	$query = $pdo->query("SELECT * FROM $tabela where data >= '$dataInicial' and data <= '$dataFinal' and status != 'Finalizado' and funcionario = '$funcionario' ORDER BY data asc, hora asc");

}else{

	$query = $pdo->query("SELECT * FROM $tabela where data >= '$dataInicial' and data <= '$dataFinal' and status LIKE '$status' and funcionario = '$funcionario' ORDER BY data asc, hora asc");

}



$res = $query->fetchAll(PDO::FETCH_ASSOC);

$total_reg = @count($res);

if($total_reg > 0){



echo <<<HTML

	<small>

	<table class="table table-hover" id="tabela">

	<thead> 

	<tr> 

	<th>Procedimento</th>	

	<th class="">Paciente</th>
	<th class="esc">Triagem</th> 	

	<th class="esc">Data</th>		

	<th class="">Hora</th>	

	<th class="esc">Status</th>

	

	<th class="esc">Ações</th>

	</tr> 

	</thead> 

	<tbody>	

HTML;



for($i=0; $i < $total_reg; $i++){

	foreach ($res[$i] as $key => $value){}

	$id = $res[$i]['id'];

$funcionario = $res[$i]['funcionario'];

$cliente = $res[$i]['paciente'];

$hora = $res[$i]['hora'];

$data = $res[$i]['data'];

$usuario = $res[$i]['usuario'];

$data_lanc = $res[$i]['data_lanc'];

$obs = $res[$i]['obs'];

$status = $res[$i]['status'];

$servico = $res[$i]['servico'];

$pago = $res[$i]['pago'];

$tipo_pagamento = $res[$i]['tipo_pagamento'];

$retorno = $res[$i]['retorno'];
$risco = $res[$i]['risco'];
$id_triagem = $res[$i]['triagem'];

$ocultar_risco = '';
if($risco == 'Vermelho'){
	$classe_risco = '#FF0000'; // Vermelho - Emergência
}else if($risco == 'Laranja'){
	$classe_risco = '#FF8000'; // Laranja - Muita Urgência
}else if($risco == 'Amarelo'){
	$classe_risco = '#FFFF00'; // Amarelo - Urgência
}else if($risco == 'Verde'){
	$classe_risco = '#00CC00'; // Verde - Pouca Urgência
}else if($risco == 'Azul'){
	$classe_risco = '#3399FF'; // Azul - Não Urgente
}else{
	$classe_risco = '#000000'; // Cor padrão (preto) se não houver risco definido
	$ocultar_risco = 'none';
}


$query2 = $pdo->query("SELECT * from triagens where id = '$id_triagem' ");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
$hiposteses = @$res2[0]['hiposteses'];
$procedimentos_realizados = @$res2[0]['procedimentos_realizados'];
$conduta_medica = @$res2[0]['conduta_medica'];
$internacao = @$res2[0]['internacao'];
$aih = @$res2[0]['aih'];
$cid_10 = @$res2[0]['cid_10'];
$motivo_internacao = @$res2[0]['motivo_internacao'];
$justificativa_clinica = @$res2[0]['justificativa_clinica'];


$dataF = implode('/', array_reverse(explode('-', $data)));

$horaF = date("H:i", strtotime($hora));





if($status == 'Concluído'){		

	$classe_linha = '';

}else{		

	$classe_linha = 'text-muted';

}



$ocultar_confirmacao = '';



if($status == 'Agendado'){

	$imagem = 'text-danger';

	$classe_status = '';

	$imagemClasse = 'red';	

	$ocultar_confirmacao = '';

}else if($status == 'Finalizado'){

	$imagem = 'verde';

	$imagemClasse = 'green';

	$classe_status = 'ocultar';

	$ocultar_confirmacao = 'ocultar';

}else if($status == 'Confirmado'){

	$imagem = 'text-primary';

	$imagemClasse = 'blue';

	$classe_status = 'ocultar';

	$ocultar_confirmacao = '';

}



if($tipo_pagamento != ''){

	$classe_pago = 'icone-money.png';

	$ocultar_pago = 'ocultar';

}else{

	$classe_pago = 'icone-money-red.png';

	$ocultar_pago = '';

}



$query2 = $pdo->query("SELECT * FROM usuarios where id = '$usuario'");

$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);

if(@count($res2) > 0){

	$nome_usu = $res2[0]['nome'];

}else{

	$nome_usu = 'Sem Usuário';

}



$query2 = $pdo->query("SELECT * FROM usuarios where id = '$funcionario'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
if(@count($res2) > 0){
	$nome_medico = $res2[0]['nome'];
	$link_teleconsulta = $res2[0]['link_teleconsulta'];
	if($link_teleconsulta != ""){
		$chave_teleconsulta = $link_teleconsulta;
	}
}else{
	$nome_medico = 'Sem Usuário';
	$link_teleconsulta = "";
}


$query2 = $pdo->query("SELECT * FROM procedimentos where id = '$servico'");

$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);

if(@count($res2) > 0){

	$nome_serv = $res2[0]['nome'];

	$valor_serv = $res2[0]['valor'];

	$aceita_convenio = $res2[0]['convenio'];

}else{

	$nome_serv = 'Não Lançado';

	$valor_serv = '';

	$aceita_convenio = $res2[0]['convenio'];

}





$query2 = $pdo->query("SELECT * FROM pacientes where id = '$cliente'");

$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);

if(@count($res2) > 0){

	$nome_paciente = @$res2[0]['nome'];

	$telefone_paciente = @$res2[0]['telefone'];	

	$nome_paciente = @$res2[0]['nome'];

	$endereco_paciente = @$res2[0]['endereco'];

	$data_nasc = @$res2[0]['data_nasc'];

	$tipo_sanguineo = @$res2[0]['tipo_sanguineo'];

	$nome_responsavel = @$res2[0]['nome_responsavel'];

	$convenio = @$res2[0]['convenio'];

	$sexo = @$res2[0]['sexo'];

	$obs_paciente = @$res2[0]['obs'];

	$profissao = @$res2[0]['profissao'];

	$estado_civil = @$res2[0]['estado_civil'];



	//idade do paciente

	// separando yyyy, mm, ddd

    list($ano, $mes, $dia) = explode('-', $data_nasc);

    // data atual

    $hoje = mktime(0, 0, 0, date('m'), date('d'), date('Y'));

    // Descobre a unix timestamp da data de nascimento do fulano

    $nascimento = mktime( 0, 0, 0, $mes, $dia, $ano);

    // cálculo

    $idade = floor((((($hoje - $nascimento) / 60) / 60) / 24) / 365.25);



    

	$data_nascF = implode('/', array_reverse(explode('-', $data_nasc)));

	

	$query2 = $pdo->query("SELECT * from convenios where id = '$convenio'");

$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);

$linhas2 = @count($res2);

if($linhas2 > 0){

	$nome_convenio = $res2[0]['nome'];

}else{

	$nome_convenio = 'Particular';

}



}





$classe_hora = '';

if(strtotime($hora_atual) > strtotime($hora) and $status != 'Finalizado' and strtotime($data_hoje) == strtotime($data)){

	$classe_hora = 'text-danger';

}



$classe_obs = '';

if($obs == ""){

	$classe_obs = 'ocultar';

}





$classe_retorno = 'ocultar';

if($retorno == "Sim"){

	$classe_retorno = '';

}


//trazer ultimo relatorio medico dessa consulta
$query2 = $pdo->query("SELECT * FROM relatorios where agendamento = '$id' order by id desc limit 1");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
$texto_rel = @$res2[0]['texto'];

$texto_relF = @rawurlencode($texto_rel);


$ocultar_teleconsulta = 'none';
if($chave_teleconsulta != ""){
	$ocultar_teleconsulta = '';
}

 // Definir a data e hora da consulta para verificação
    $data_hora_consulta = "{$data} {$horaF}";

// Verificar se a consulta está dentro do horário permitido (15 minutos antes)
    $classe_teleconsulta = 'text-primary'; // Cor padrão (azul)
    if (strcasecmp(trim($status), 'Confirmado') === 0 && !empty($data_hora_consulta)) {
        $agora = new DateTime();
        $consulta = new DateTime($data_hora_consulta);
        $consulta->modify('-15 minutes'); // Libera 15 minutos antes
        if ($agora >= $consulta) {
            $classe_teleconsulta = 'text-success'; // Cor verde quando livre para atender
        }
    }

echo <<<HTML

<tr class="">

<td><i class="fa fa-square {$imagem}"></i> {$nome_serv} <span class="{$classe_retorno}" style="color:blue">(Retorno)</span></td>

<td class="">

<a title="Dados do Paciente" href="#" onclick="mostrar('{$nome_paciente}','{$telefone_paciente}','{$endereco_paciente}','{$data_nascF}','{$tipo_sanguineo}','{$nome_responsavel}','{$nome_convenio}', '{$sexo}','{$obs_paciente}','{$idade}','{$id}','{$cliente}','{$profissao}','{$estado_civil}')" title="Mostrar Dados">

 {$nome_paciente}

</a>

</td>
<td class="esc">
  <a href="#" title="Ver Triagem" onclick="triagem('{$id_triagem}', '{$nome_paciente}', '{$hiposteses}', '{$procedimentos_realizados}', '{$conduta_medica}', '{$internacao}', '{$aih}', '{$cid_10}', '{$motivo_internacao}', '{$justificativa_clinica}')">
    <i class="fa fa-circle mr-1 " style="color:{$classe_risco}; display:{$ocultar_risco}"></i> {$risco}
  </a>
</td>


<td class="esc">{$dataF}</td>

<td class=" {$classe_hora}">{$horaF}</td>

<td class="esc"><div style="color:#FFF; background:{$imagemClasse}; padding:0px; width:75px; text-align: center; font-size: 12px; ">{$status}</div></td>



<td class="esc">

		

		<li class="dropdown head-dpdn2" style="display: inline-block;">

		<a href="#" class="dropdown-toggle {$ocultar_confirmacao}" data-toggle="dropdown" aria-expanded="false"><big><i class="fa fa-trash-o text-danger"></i></big></a>



		<ul class="dropdown-menu" style="margin-left:-230px;">

		<li>

		<div class="notification_desc2">

		<p>Confirmar Exclusão? <a href="#" onclick="excluir('{$id}')"><span class="text-danger">Sim</span></a></p>

		</div>

		</li>										

		</ul>

		</li>







		<li class="dropdown head-dpdn2" style="display: inline-block;">

		<a title="Finalizar Consulta" href="#" class="dropdown-toggle {$ocultar_confirmacao}" data-toggle="dropdown" aria-expanded="false"><big><i class="fa fa-check-square verde"></i></big></a>



		<ul class="dropdown-menu" style="margin-left:-230px;">

		<li>

		<div class="notification_desc2">

		<p>Finalizar Atendimento <a href="#" onclick="baixar('{$id}')"><span class="verde">Sim</span></a></p>

		</div>

		</li>										

		</ul>

		</li>







		<li class="dropdown head-dpdn2" style="display: inline-block;">

		<a title="Observações da Consulta" href="#" class="dropdown-toggle {$classe_obs}" data-toggle="dropdown" aria-expanded="false"><big><i class="fa fa-info-circle text-primary"></i></big></a>



		<ul class="dropdown-menu" style="margin-left:-230px;">

		<li>

		<div class="notification_desc2">

		<p><b>OBS:</b> {$obs}<br> </p>

		</div>

		</li>										

		</ul>

		</li>







		<big><a href="#" onclick="anamnese('{$cliente}', '{$nome_paciente}')" title="Editar Anamnese"><i class="fa fa-stethoscope text-primary"></i></a></big>



		<big><a href="#" onclick="exames('{$cliente}', '{$nome_paciente}')" title="Solicitar Exames"><i class="fa fa-files-o text-success"></i></a></big>





		<big><a href="#" onclick="receita('{$cliente}', '{$nome_paciente}')" title="Gerar Receita"><i class="fa fa-file-pdf-o text-primary"></i></a></big>



		<big><a href="#" onclick="atestado('{$cliente}', '{$nome_paciente}')" title="Gerar Atestado"><i class="fa fa-file-pdf-o text-danger"></i></a></big>

		
		

		<big><a href="#" onclick="relatorioMedico('{$id}', '{$cliente}', '{$nome_paciente}', '{$texto_relF}')" title="Relatório Médico"><i class="fa fa-file-o text-success"></i></a></big>

		<big><a href="#" onclick="mostrar('{$nome_paciente}','{$telefone_paciente}','{$endereco_paciente}','{$data_nascF}','{$tipo_sanguineo}','{$nome_responsavel}','{$nome_convenio}', '{$sexo}','{$obs_paciente}','{$idade}','{$id}','{$cliente}','{$profissao}','{$estado_civil}')" title="Evolução do Paciente" ><i class="fa fa-file-text text-primary"></i></a></big>


		

		

		<form   method="POST" action="rel/prontuario_class.php" target="_blank" style="display:inline-block">
					<input type="hidden" name="id" value="{$cliente}">
					<big><button style="border:none; outline:none; background: transparent; padding:0" title="Prontuário"><i class="fa fa-file-pdf-o " style="color:blue"></i></button></big>
					</form>

					<big><a style="display:{$ocultar_risco}" href="#" onclick="triagem('{$id_triagem}', '{$nome_paciente}', '{$hiposteses}', '{$procedimentos_realizados}', '{$conduta_medica}', '{$internacao}', '{$aih}', '{$cid_10}', '{$motivo_internacao}', '{$justificativa_clinica}')" title="Triagem Paciente"><i class="fa fa-clipboard text-success"></i></a></big>



					 
        <a style="display:{$ocultar_teleconsulta}" href="#" class="action-btn" onclick="abrirTeleconsulta(' $nome_medico', '$nome_paciente', '$chave_teleconsulta', '$data_hora_consulta')" title="Iniciar Telemedicina"><i class="fa fa-video-camera $classe_teleconsulta"></i></a>


        <big><a style="display:{$ocultar_teleconsulta}" href="#" onclick="linkTeleconsulta('{$telefone_paciente}', '{$chave_teleconsulta}', '{$nome_serv}', '{$nome_paciente}', '{$dataF}', '{$horaF}')" title="Enviar Link Teleconsulta"><i class="fa fa-whatsapp text-success"></i></a></big>  


					<big><a href="#" onclick="chamar('{$nome_medico}', '{$nome_paciente}', '{$nome_sala}', '{$id}')" title="Chamar Paciente"><i class="fa fa-desktop text-primary"></i></a></big>




		</td>

</tr>

HTML;



}





echo <<<HTML

</tbody>

<small><div align="center" id="mensagem-excluir"></div></small>

</table>



<br>

<div align="left" style="float:left;">
<big>Consultório: <span style="background:red; color:#FFF; padding-right: 4px; padding-left: 4px">{$nome_sala}</span></big>
</div>	

<div align="right" style="float:right;">

<span style="margin-right: 20px">Agendadas: <span class="text-danger">{$agendados}</span> </span>

<span style="margin-right: 20px">Confirmadas: <span class="text-primary">{$confirmados}</span></span> 

<span>

Finalizadas: <span class="verde">{$finalizados}</span> </span>



</div>

<br>

</small>

HTML;





}else{

	echo '<small>Não possui nenhum registro Cadastrado!</small>';

}



?>



<script type="text/javascript">

	$(document).ready( function () {		



    $('#tabela').DataTable({

    		"ordering": false,

			"stateSave": true

    	});

    $('#tabela_filter label input').focus();

} );

</script>





<script type="text/javascript">

	function mostrar(paciente, telefone, endereco, data_nasc, tipo_sanguineo, nome_responsavel, nome_convenio, sexo, obs_paciente, idade, id, id_paciente, profissao, estado_civil){



		if(nome_responsavel == ""){

			$('#responsavel_div').hide();

		}else{

			$('#responsavel_div').show();

		}



		if(obs_paciente == ""){

			$('#obs_div').hide();

		}else{

			$('#obs_div').show();

		}



		if(profissao == ""){

			profissao = 'Nenhuma!';

		}





		

		$('#nome_dados').text(paciente);

		$('#idade_dados').text(idade + ' anos');

		$('#telefone_dados').text(telefone);	

		$('#data_nasc_dados').text(data_nasc);

		$('#tipo_dados').text(tipo_sanguineo);

		$('#sexo_dados').text(sexo);

		$('#convenio_dados').text(nome_convenio);

		$('#endereco_dados').text(endereco);



		$('#responsavel_dados').text(nome_responsavel);	

		$('#obs_dados').text(obs_paciente);

		$('#profissao_dados').text(profissao);

		$('#estado_civil_dados').text(estado_civil);



		$('#id_con').val(id);

		$('#id_pac').val(id_paciente);



		$('#modalDados').modal('show');

		listarHistorico(id_paciente);

		listarAnaPac(id_paciente);

	}





	function baixar(id){	

    $.ajax({

        url: 'paginas/' + pag + "/baixar.php",

        method: 'POST',

        data: {id},

        dataType: "html",



        success:function(mensagem){

            if (mensagem.trim() == "Baixado com Sucesso") {

                listar();

            } else {

                $('#mensagem-excluir').addClass('text-danger')

                $('#mensagem-excluir').text(mensagem)

            }

        }

    });

}





function listarHistorico(id){

	$.ajax({

        url: 'paginas/' + pag + "/listar_historico.php",

        method: 'POST',

        data: {id},

        dataType: "html",



        success:function(result){

            $("#historico_div").html(result);

            

        }

    });

}



function anamnese(paciente, nome){

		$('#id_pac_ana').val(paciente);	

		$('#nome_permissoes').text(nome);	

		$('#modalAnamnese').modal('show');

		listarAnamnese(paciente);

}



function receita(paciente, nome){

		$('#id_receita').val(paciente);	

		$('#nome_receita').text(nome);	

		$('#modalReceita').modal('show');

		listarRemedios(paciente);

}



function atestado(paciente, nome){

		$('#id_atestado').val(paciente);	

		$('#nome_atestado').text(nome);	

		$('#modalAtestado').modal('show');

		

}



function exames(paciente, nome){

		$('#id_exame').val(paciente);	

		$('#nome_exame').text(nome);	

		$('#modalExames').modal('show');

		listarExames(paciente);

}


function chamar(medico, paciente, sala, id){
	$.ajax({
        url: 'paginas/' + pag + "/salvar_chamada.php",
        method: 'POST',
        data: {medico, paciente, sala, id},
        dataType: "html",

        success:function(result){                        
        	alert(result);
        }

    });
}



function relatorioMedico(id, paciente, nome, texto){
		$('#id_relatorio').val(id);
		$('#id_pac_relatorio').val(paciente);
		$('#nome_relatorio').text(nome);
		$('#trumbowyg-editor').trumbowyg('html', decodeURIComponent(texto));
		
		$('#modalRelatorio').modal('show');		

}



function triagem(id_triagem, nome_paciente, hiposteses, procedimentos_realizados, conduta_medica, internacao, aih, cid_10, motivo_internacao, justificativa_clinica) {
    $('#id_triagem').val(id_triagem);        
    $('#nome_triagem').text(nome_paciente);    

    $('#hiposteses').val(hiposteses);
    $('#procedimentos_realizados').val(procedimentos_realizados);
    $('#conduta_medica').val(conduta_medica).change();
    $('#internacao').val(internacao).change();
    $('#aih').val(aih).change();
    $('#cid_10').val(cid_10);
    $('#motivo_internacao').val(motivo_internacao);
    $('#justificativa_clinica').val(justificativa_clinica);

    $('#id_triagem_relatorio').val(id_triagem);  
    

    listarDadosTriagem(id_triagem);
    $('#modalTriagem').modal('show');        
}



function listarDadosTriagem(id_triagem){
	$.ajax({
        url: 'paginas/' + pag + "/listar_dados_triagem.php",
        method: 'POST',
        data: {id_triagem},
        dataType: "html",

        success:function(result){                        
        	$('#listar_dados_triagem').html(result)
        }

    });
}

</script>




<script type="text/javascript">
	function abrirTeleconsulta(medico, paciente, link, horarioConsulta = null) {
		
    if (!link) {
        alert("Link da telemedicina não disponível.");
        return;
    }

    if (horarioConsulta) {
        const agora = new Date();
        const consulta = new Date(horarioConsulta);
        consulta.setMinutes(consulta.getMinutes() - 15); // Libera 15 min antes

        if (agora < consulta) {
            alert("A consulta ainda não está no horário permitido para iniciar.");
            return;
        }
    }

    // Abre o Google Meet em uma nova aba
    const novaAba = window.open(link, '_blank');
    if (!novaAba || novaAba.closed || typeof novaAba.closed == 'undefined') {
        alert("Não foi possível iniciar a telemedicina. Verifique se o link está correto.");
        return;
    }

    // Exibe uma mensagem com instruções para o médico
    setTimeout(() => {
        alert("Você entrou na sala de telemedicina para a consulta com " + paciente + ". Certifique-se de compartilhar o link da reunião com o paciente. Ao final da consulta, encerre a chamada para evitar que outros pacientes entrem na mesma sala.");
    }, 1000);
}

function iniciarTeleconsulta(id, medico, paciente, link, horarioConsulta = null) {
    console.log("Iniciando teleconsulta: id=" + id + ", medico=" + medico + ", paciente=" + paciente + ", link=" + link + ", horarioConsulta=" + horarioConsulta);

    if (!link) {
        console.log("Link da telemedicina não disponível.");
        alert("Link da telemedicina não disponível.");
        return;
    }

    if (horarioConsulta) {
        console.log("Horario da consulta fornecido: " + horarioConsulta);
        try {
            const agora = new Date();
            const consulta = new Date(horarioConsulta);
            consulta.setMinutes(consulta.getMinutes() - 15); // Libera 15 min antes

            console.log("Agora: " + agora + ", Consulta (15 min antes): " + consulta);

            if (isNaN(consulta.getTime())) {
                console.log("Erro: HorarioConsulta inválido, não foi possível criar objeto Date.");
                alert("Erro: Horário da consulta inválido.");
                return;
            }

            if (agora < consulta) {
                console.log("Consulta ainda não está no horário permitido.");
                alert("A consulta ainda não está no horário permitido para iniciar.");
                return;
            }
        } catch (error) {
            console.log("Erro ao processar horarioConsulta: " + error);
            alert("Erro ao processar o horário da consulta: " + error);
            return;
        }
    }

    console.log("Tentando abrir o Google Meet: " + link);
    // Garantir que o window.open seja chamado diretamente no evento de clique
    setTimeout(() => {
        const novaAba = window.open(link, '_blank');
        if (!novaAba || novaAba.closed || typeof novaAba.closed == 'undefined') {
            console.log("Falha ao abrir nova aba. Pop-up bloqueado?");
            alert("Não foi possível iniciar a telemedicina. Verifique se o link está correto ou se pop-ups estão bloqueados.");
            return;
        }

        console.log("Google Meet aberto com sucesso.");
        // Exibe uma mensagem com instruções para o médico
        setTimeout(() => {
            console.log("Exibindo mensagem de instrução para o médico.");
            alert("Você entrou na sala de telemedicina para a consulta com " + paciente + ". Certifique-se de compartilhar o link da reunião com o paciente. Ao final da consulta, encerre a chamada para evitar que outros pacientes entrem na mesma sala.");
        }, 1000);

        // Marca a consulta como "em andamento" (após abrir o Google Meet)
        console.log("Fazendo fetch para marcar_em_andamento.php?id=" + id);
        fetch('marcar_em_andamento.php?id=' + id)
            .then(response => {
                console.log("Resposta do fetch recebida:", response);
                if (!response.ok) {
                    throw new Error("Erro na requisição: " + response.statusText);
                }
                return response.json();
            })
            .then(data => {
                console.log("Dados recebidos do fetch:", data);
                if (!data.success) {
                    console.log("Erro ao marcar a consulta como em andamento: " + data.message);
                    alert("Erro ao marcar a consulta como em andamento: " + data.message);
                } else {
                    console.log("Consulta marcada como em andamento com sucesso.");
                }
            })
            .catch(error => {
                console.log("Erro no fetch:", error);
                alert("Erro ao marcar a consulta como em andamento: " + error);
            });
    }, 0); // Executa no próximo ciclo de eventos para evitar bloqueio de pop-ups
}



function linkTeleconsulta(telefone, link, procedimento, paciente, data, hora){
	$.ajax({
        url: 'paginas/' + pag + "/enviar_link_teleconsulta.php",
        method: 'POST',
        data: {telefone, link, procedimento, paciente, data, hora},
        dataType: "html",

        success:function(result){                        
        	alertSucesso(result)
        }

    });
}
</script>





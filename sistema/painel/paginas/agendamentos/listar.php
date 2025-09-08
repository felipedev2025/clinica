<?php 
require_once("../../../conexao.php");
@session_start();
$usuario = @$_SESSION['id'];
$funcionario = @$_POST['funcionario'];
$data = @$_POST['data'];
$tabela = @$_POST['tabela'];
if($data == ""){
	$data = date('Y-m-d');
}
if($funcionario == ""){
	$sql_funcionario = "";
}else{
    $sql_funcionario = "funcionario = '$funcionario' and ";
}
if ($tabela == 'card') {
	$esconder_tabela = 'ocultar';
	$esconder_card = '';
}else{
	$esconder_tabela = '';
	$esconder_card = 'ocultar';
}	
$pdo->query("UPDATE agendamentos SET status_cor = 'Em espera' WHERE status_cor = 'Aguardando Confirmação' and status = 'Confirmado'");
$pdo->query("UPDATE agendamentos SET status_cor = 'Finalizado' WHERE status_cor != 'Finalizado' and status = 'Finalizado'");
if ($tabela != 'horarios') {
echo <<<HTML
<small>
HTML;
$query = $pdo->query("SELECT * FROM agendamentos where $sql_funcionario data = '$data' ORDER BY hora asc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0){
	echo <<<HTML
<small>
	<table class="table table-hover {$esconder_tabela}" id="tabela">
	<thead> 
	<tr>
	<th>Hora</th>
	<th>Paciente</th>	
	
	<th>Procedimento</th>
	<th>Pago</th>
	<th>Status</th>		
	
	<th>Ações</th>
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
$st = $res[$i]['status_cor'];
$tipo_pagamento = $res[$i]['tipo_pagamento'];
$retorno = $res[$i]['retorno'];
$novo_status = $res[$i]['status_cor'];
$pgto_parcial = $res[$i]['pgto_parcial'];

$valor_pago = $res[$i]['valor_pago'];
$data_retirada = $res[$i]['data_retirada'];
$risco = $res[$i]['risco'];

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

$valor_pagoF = @number_format($valor_pago, 2, ',', '.');
if($valor_pago > 0 and $status == 'Agendado' and $pgto_parcial == 'Sim'){
	$classe_valor_pago = '';
}else{
	$classe_valor_pago = 'ocultar';
}


$dataF = implode('/', array_reverse(explode('-', $data)));
$horaF = date("H:i", strtotime($hora));
if($status == 'Concluído'){		
	$classe_linha = '';
}else{		
	$classe_linha = 'text-muted';
}
$ocultar_confirmacao = '';
if($status == 'Agendado'){
	$imagem = 'icone-relogio.png';
	$classe_status = '';	
}else if($status == 'Finalizado'){
	$imagem = 'icone-relogio-verde.png';
	$classe_status = 'ocultar';
	$ocultar_confirmacao = 'ocultar';
}if($status == 'Confirmado'){
	$imagem = 'icone-relogio-azul.png';
	$classe_status = 'ocultar';
	$ocultar_confirmacao = 'ocultar';
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
$query2 = $pdo->query("SELECT * FROM procedimentos where id = '$servico'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
if(@count($res2) > 0){
	$nome_serv = $res2[0]['nome'];
	$valor_serv = $res2[0]['valor'];
	$aceita_convenio = $res2[0]['convenio'];
}else{
	$nome_serv = 'Não Lançado';
	$valor_serv = '';
	$aceita_convenio = @$res2[0]['convenio'];
}
$query2 = $pdo->query("SELECT * FROM pacientes where id = '$cliente'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
if(@count($res2) > 0){
$nome_cliente = $res2[0]['nome'];
$telefone_pac = $res2[0]['telefone'];
$data_nasc = $res2[0]['data_nasc'];
$_paciente_nome = $res2[0]['nome'];
$_paciente_telefone = $res2[0]['telefone'];
$_paciente_cpf = $res2[0]['cpf'];
$_paciente_endereco = $res2[0]['endereco'];
$_paciente_data_cad = $res2[0]['data_cad'];
$_paciente_data_nasc = $res2[0]['data_nasc'];
$_paciente_convenio = $res2[0]['convenio'];
$_paciente_tipo_sanguineo = $res2[0]['tipo_sanguineo'];
$_paciente_nome_responsavel = $res2[0]['nome_responsavel'];
$_paciente_cpf_responsavel = $res2[0]['cpf_responsavel'];
$_paciente_sexo = $res2[0]['sexo'];
$_paciente_obs = $res2[0]['obs'];
$_paciente_estado_civil = $res2[0]['estado_civil'];
$_paciente_profissao = $res2[0]['profissao'];
$_paciente_telefone2 = @$res2[0]['telefone2'];
$_paciente_marketing = $res2[0]['marketing'];
if ($_paciente_marketing == 'Não') {
    $_paciente_ocultar_mark = 'ocultar';
} else {
    $_paciente_ocultar_mark = '';
}
$_paciente_tel_pessoaF = '55'.preg_replace('/[ ()-]+/', '', $_paciente_telefone);
$_paciente_data_nascF = implode('/', array_reverse(explode('-', $_paciente_data_nasc)));
$_paciente_data_cadF = implode('/', array_reverse(explode('-', $_paciente_data_cad)));
$query2 = $pdo->query("SELECT * from convenios where id = '$_paciente_convenio'");
$res3 = $query2->fetchAll(PDO::FETCH_ASSOC);
$linhas3 = @count($res3);
if ($linhas3 > 0) {
    $_paciente_nome_convenio = $res3[0]['nome'];
} else {
    $_paciente_nome_convenio = 'Nenhum';
}
list($ano, $mes, $dia) = explode('-', $_paciente_data_nasc);
$hoje = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
$nascimento = mktime(0, 0, 0, $mes, $dia, $ano);
$idade = floor((((($hoje - $nascimento) / 60) / 60) / 24) / 365.25);

}else{
	$nome_cliente = 'Sem Paciente';
	
}
$query2 = $pdo->query("SELECT * FROM usuarios where id = '$funcionario'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
if(@count($res2) > 0){
	$nome_func = $res2[0]['nome'];
	
}else{
	$nome_func = '';
	
}
$tel_whatsF = '55'.@preg_replace('/[ ()-]+/' , '' , @$telefone_pac);
 $nome_func = mb_strimwidth($nome_func, 0, 25, "...");
//retirar aspas do texto do obs
$obs = @str_replace('"', "**", $obs);
if($pago == 'Sim'){
	$classe_pago_texto = 'verde';
}else{
	$classe_pago_texto = 'text-danger';
}


if($valor_serv == $valor_pago){
	$valor_pagoF = ' Pago';
}else{
	$valor_pagoF = 'R$ '.$valor_pagoF;
}

if($valor_pago > 0){
	$valor_serv = $valor_serv - $valor_pago;
}



echo <<<HTML
			<div class="col-xs-12 col-md-4 widget cardTarefas {$esconder_card}">
        		<div class="r3_counter_box">
				<li class="dropdown head-dpdn2" style="list-style-type: none;">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
		<button type="button" class="close" title="Excluir agendamento" style="margin-top: -10px">
					<span aria-hidden="true"><big>&times;</big></span>
				</button>
				</a>
		<ul class="dropdown-menu" style="margin-left:-30px;">
		<li>
		<div class="notification_desc2">
		<p>Confirmar Exclusão? <a href="#" onclick="excluirAgendamento('{$id}', '{$horaF}')"><span class="text-danger">Sim</span></a></p>
		</div>
		</li>
		</ul>
		</li>
		<div class="row">
        		<div class="col-md-3">
				<li class="dropdown head-dpdn2" style="list-style-type: none;">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
		<img class="icon-rounded-vermelho" src="img/{$imagem}" width="45px" height="45px">
				</a>
		<ul class="dropdown-menu" style="margin-left:-30px;">
		<li>
		<div class="notification_desc2">
		<p>Observações: {$obs}</p>
		</div>
		</li>
		</ul>
		</li>        			 
        		</div>
        		<div class="col-md-9">
        			<h5><strong>{$horaF}</strong> 
        			<li class="dropdown head-dpdn2" style="list-style-type: none; display:inline-block;">
				<a class="{$ocultar_confirmacao}" href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
		<img class="icon-rounded-vermelho" src="img/check-square.png" width="15px" height="15px">
				</a>
		<ul class="dropdown-menu" style="margin-left:-100px;">
		<li>
		<div class="notification_desc2">
		<p>Confirmar Agendamento? <a title="Confirmar Agendamento" href="#" onclick="confirmar('{$id}', '{$horaF}')"><span class="text-success">Sim</span></a></p>
		</div>
		</li>						
		</ul>
		</li>   






        			<a class="{$ocultar_pago}" href="#" onclick="baixar('{$id}', '{$cliente}', '{$nome_serv}', '{$valor_serv}','{$aceita_convenio}','{$funcionario}','{$servico}','{$retorno}')" title="Baixa no Pagamento" class=""> <img class="icon-rounded-vermelho" src="img/{$classe_pago}" width="15px" height="15px"></a>
        			<a class="" href="#" onclick="editar('{$id}','{$cliente}','{$funcionario}','{$servico}','{$data}','{$obs}','{$retorno}','{$pago}','{$data_retirada}')" title="Editar Agendamento" class=""> <img class="icon-rounded-vermelho" src="img/editar.png" width="15px" height="15px"></a>
        			<a class="" href="rel/atendimento_class.php?id={$id}" title="Relatório de Atendimento" target="_blank"><img class="icon-rounded-vermelho" src="img/pdf.png" width="15px" height="15px"></a>

        			</h5>       			
        		</div>
        		</div>     		
       					
        		<hr style="margin-top:-2px; margin-bottom: 3px">
                    <div class="stats esc" align="center">
                      <span>                     
                        <small> {$nome_cliente} <small><span class="text-danger">({$idade} Anos)</span></small>
                        <span class="{$classe_valor_pago} verde" style="font-size: 12px; font-weight: 300; color:green" >({$valor_pagoF})</span> 
                        <br> (<i><span style="color:#061f9c; font-size: 12px">{$nome_serv}</span></i>)</small> <a class="" href="rel/retirada_class.php?id={$id}" title="Retirada de Exames" target="_blank"><img class="icon-rounded-vermelho" src="img/pdf.png" width="15px" height="15px"></a></span>
                    </div>
                </div>
        	</div>
HTML;
if ($st == '' and $status == 'Confirmado') {
	$st = 'Aguardando Paciente';
}else if ($st == ''){
	$st = 'Aguardando Confirmação';
}
if ($status == 'Confirmado') {
	$amarelo = 'text-primary';
	$nao_exibir = '';
}else{
	$amarelo = '';
	$nao_exibir = 'ocultar';
}


if ($status == 'Confirmado') {
	$amarelo = 'text-primary';
	$nao_exibir = '';
}else{
	$amarelo = 'text-danger';
	$nao_exibir = 'ocultar';
}


$status_atual = 'Aguardando Paciente';
if ($st == 'Em espera') {
	$amarelo = 'em-espera';
}else if ($st == 'Em atendimento') {
	$amarelo = 'em-atendimento';
}else if ($st == 'Prioridade') {
	$amarelo = 'Prioridade';
}

$ocultar_protocolo = 'ocultar';
if($data_retirada != ""){
	$ocultar_protocolo = '';
}

echo <<<HTML
<tr>
<td class="esc">{$hora}</td>
<td class="{$amarelo}" id="campoDestino">
<i class="fa fa-circle mr-1 " style="color:{$classe_risco}; display:{$ocultar_risco}"></i> {$nome_cliente} <small><span class="text-danger">({$idade} Anos)</span></small>
</td>
<td class="esc">{$nome_serv} <span class="text-primary"><small>({$nome_func})</small></span></td>
<td class="esc {$classe_pago_texto}">{$pago} <span class="{$classe_valor_pago} verde" style="font-size: 12px; font-weight: 300" >({$valor_pagoF})</span> </td>
<td class="" >
<li class="dropdown head-dpdn2  " style="list-style-type: none; display:inline-block;">
				<a  href="#" class="{$nao_exibir}" data-toggle="dropdown" aria-expanded="false">
		<img class="icon-rounded-vermelho" src="img/editar.png" width="15px" height="15px">
				</a>
		<ul class="dropdown-menu" style="margin-left:-100px;">
		<li>
		<div class="notification_desc2">
		<p><big><b>Alterar Status:</b></big> <br><a title="Em espera" href="#" onclick="alterarCorCelaDestino('#d1a773', 'Em espera', {$id})"><span class="text-success" style="color:#2a2b29">Em espera</span></a><br>
		<a title="Em atendimento" href="#" onclick="alterarCorCelaDestino('#a4db84', 'Em atendimento', {$id})"><span class="text-success" style="color:##2a2b29">Em atendimento</span></a><br>
		<a title="Prioridade" href="#" onclick="alterarCorCelaDestino('#b0c5f5', 'Prioridade', {$id})"><span class="text-success" style="color:##2a2b29">Prioridade</span></a></p>
		</div>
		</li>										
		</ul>
		</li>
{$novo_status}
		
</td>
<td>
<big><a class="" href="http://api.whatsapp.com/send?1=pt_BR&phone={$tel_whatsF}" title="Whatsapp" target="_blank"><i class="fa fa-whatsapp " style="color:green"></i></a></big>
	<big><a class="" href="#" onclick="editar('{$id}','{$cliente}','{$funcionario}','{$servico}','{$data}','{$obs}','{$retorno}','{$pago}','{$data_retirada}')" title="Editar Agendamento" class=""> <img class="icon-rounded-vermelho" src="img/editar.png" width="15px" height="15px"></a>
</big>

		<big><a href="#" onclick="mostrar('{$_paciente_nome}','{$_paciente_telefone}','{$_paciente_endereco}','{$_paciente_data_nascF}','{$_paciente_tipo_sanguineo}','{$_paciente_nome_responsavel}', '{$_paciente_nome_convenio}', '{$_paciente_sexo}','{$_paciente_obs}','{$idade}','{$id}','{$_paciente_profissao}','{$_paciente_estado_civil}','{$_paciente_cpf}','{$_paciente_telefone2}')" title="Mostrar Dados"><i class="fa fa-info-circle text-primary"></i></a></big>


<big><a class="{$ocultar_pago}" href="#" onclick="baixar('{$id}', '{$cliente}', '{$nome_serv}', '{$valor_serv}','{$aceita_convenio}','{$funcionario}','{$servico}','{$retorno}')" title="Baixa no Pagamento" class=""> <img class="icon-rounded-vermelho" src="img/{$classe_pago}" width="15px" height="15px"></a></big>
	<li class="dropdown head-dpdn2" style="list-style-type: none; display:inline-block;">
				<a class="{$ocultar_confirmacao}" href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
		<img class="icon-rounded-vermelho" src="img/check-square.png" width="15px" height="15px">
				</a>
		<ul class="dropdown-menu" style="margin-left:-200px;">
		<li>
		<div class="notification_desc2">
		<p>Confirmar Agendamento? <a title="Confirmar Agendamento" href="#" onclick="confirmar('{$id}', '{$horaF}')"><span class="text-success">Sim</span></a></p>
		</div>
		</li>										
		</ul>
		</li>
		<li class="dropdown head-dpdn2" style="display: inline-block;">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><big><i class="fa fa-trash-o text-danger"></i></big></a>
		<ul class="dropdown-menu" style="margin-left:-230px;">
		<li>
		<div class="notification_desc2">
		<p>Confirmar Exclusão? <a href="#" onclick="excluirAgendamento('{$id}', '{$horaF}')"><span class="text-danger">Sim</span></a></p>
		</div>
		</li>										
		</ul>
</li>



<big><a class="" href="rel/atendimento_class.php?id={$id}" title="Relatório de Atendimento" target="_blank"><i class="fa fa-file-pdf-o " style="color:blue"></i></a></big>

<big><a class="{$ocultar_protocolo}" href="rel/retirada_class.php?id={$id}" title="Protocólo Retirada Exames" target="_blank"><i class="fa fa-file-pdf-o " style="color:purple"></i></a></big>

</td>
</tr>
HTML;
}
}else{
	echo 'Nenhum horário para essa Data!';
}
}else{
	//aqui vai a opcao dos horarios
	echo '<div id="listar_horarios_disp"></div>';
}
?>
<script type="text/javascript">

	function mostrar(paciente, telefone, endereco, data_nasc, tipo_sanguineo, nome_responsavel, nome_convenio, sexo, obs_paciente, idade, id_paciente, profissao, estado_civil, cpf, telefone2){
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
	if(telefone2 == ""){
		$('#tel_div').hide();
	}else{
		$('#tel_div').show();
	}
	if(profissao == ""){
		profissao = 'Nenhuma!';
	}
	$('#nome_dados').text(paciente);
	$('#cpf_dados').text(cpf);
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
	$('#telefone2_dados').text(telefone2);
	$('#id_pac').val(id_paciente);
	$('#modalDados').modal('show');
	
}


	function baixar(id, cliente, servico, valor_servico, convenio, funcionario, id_servico, retorno){
		if(convenio != "Sim"){
			$('#div_convenio').hide();
		}
		$('#procedimento').text("Procedimento");
		if(retorno == "Sim"){
			$('#valor_serv_agd').val("0");
			$('#procedimento').text("Retorno");
		}else{
			$('#valor_serv_agd').val(valor_servico);
		}
	
		$('#id_agd').val(id);
		$('#cliente_agd').val(cliente);		
		$('#servico_agd').val(id_servico);	
			
		$('#funcionario_agd').val(funcionario).change();	
		$('#titulo_servico').text(servico);
		$('#descricao_serv_agd').text(servico);
		$('#modalServico').modal('show');
	}
	function confirmar(id){
		 $.ajax({
        url: 'paginas/' + pag + "/confirmar.php",
        method: 'POST',
        data: {id},
        dataType: "html",
        success:function(mensagem){
             
            if (mensagem.trim() == "Confirmado com Sucesso") {  
                listar();
            } else {
                $('#mensagem-excluir').addClass('text-danger')
                $('#mensagem-excluir').text(mensagem)
            }
        }
    });
	}
	function editar(id, paciente, funcionario, servico, data, obs, retorno, pago_editar, data_retirada){
		$('#mensagem').text('');
    	$('#titulo_inserir').text('Editar Registro');
    	if(retorno == ""){
    		retorno = 'Não';
    	}
    	$('#id').val(id);
    	$('#cliente').val(paciente).change();  	
    	$('#funcionario_modal').val(funcionario).change();
    	$('#data-modal').val(data).change();
    	$('#obs').val(obs);
    	$('#retorno').val(retorno).change();	
    	$('#pago_editar').val(pago_editar);
    	$('#data_retirada').val(data_retirada);
    	setTimeout(function(){
			$('#servico').val(servico).change();	
		}, 500); 
    	
    
    	$('#modalForm').modal('show');
	}
function excluirAgendamento(id){	
    $('#mensagem-excluir').text('Excluindo...')
    
    $.ajax({
        url: 'paginas/' + pag + "/excluir.php",
        method: 'POST',
        data: {id},
        dataType: "html",
        success:function(mensagem){
             //alert(mensagem)
            if (mensagem.trim() == "Excluído com Sucesso") {  
                listar();
                listarHorarios();
            } else {
                $('#mensagem-excluir').addClass('text-danger')
                $('#mensagem-excluir').text(mensagem)
            }
        }
    });
}
</script>
<script type="text/javascript">
function alterarCorCelaDestino(cor, status, id) {
    var campoDestino = document.getElementById('campoDestino');
    campoDestino.style.backgroundColor = cor;
     campoDestino.classList.remove('amarelo');
     $.ajax({
        url: 'paginas/' + pag + "/alterar_stat.php",
        method: 'POST',
        data: {cor,status,id},
        dataType: "html",
        success:function(mensagem){
             //alert(mensagem)
            if (mensagem.trim() == "Alterado com Sucesso") {  
                listar();
                listarHorarios();
            } else {
                $('#mensagem-excluir').addClass('text-danger')
                $('#mensagem-excluir').text(mensagem)
            }
        }
    });
}
   
</script>
<script type="text/javascript">
function alterarCorCelaDestino2(cor) {
    var campoDestino = document.getElementById('campoDestino');
    campoDestino.style.backgroundColor = cor;
     campoDestino.classList.remove('amarelo');
}	
</script>
<script type="text/javascript">
function alterarCorCelaDestino3(cor) {
    var campoDestino = document.getElementById('campoDestino');
    campoDestino.style.backgroundColor = cor;
     campoDestino.classList.remove('amarelo');
}	
</script>
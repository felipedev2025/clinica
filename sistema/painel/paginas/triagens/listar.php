<?php 
$tabela = 'triagens';
require_once("../../../conexao.php");

$dataInicial = @$_POST['p1'];
$dataFinal = @$_POST['p2'];

if($dataInicial == ""){
    exit();
}

$total_exames = 0;

$total_consultas = 0;

$query = $pdo->query("SELECT * from $tabela where (data >= '$dataInicial' and data <= '$dataFinal') order by id desc");

$res = $query->fetchAll(PDO::FETCH_ASSOC);

$linhas = @count($res);

if($linhas > 0){

echo <<<HTML

<small>

	<table class="table table-hover" id="tabela">

	<thead> 

	<tr> 

	<th>Paciente</th>	
	<th class="esc">Risco</th>	
	<th class="esc">Escala Dor</th>	
	<th class="esc">Data</th>
	<th class="esc">Hora</th>	
	<th>Ações</th>
	</tr> 
	</thead> 
	<tbody>	

HTML;

for($i=0; $i<$linhas; $i++){

	$id = $res[$i]['id'];
	$id_paciente = $res[$i]['id_paciente'];
	$risco = $res[$i]['risco'];
	$queixa = $res[$i]['queixa'];
	$pa = $res[$i]['pa'];
	$fc = $res[$i]['fc'];
	$fr = $res[$i]['fr'];
	$temperatura = $res[$i]['temperatura'];
	$saturacao = $res[$i]['saturacao'];
	$alergias = $res[$i]['alergias'];
	$medicamentos = $res[$i]['medicamentos'];
	$historico = $res[$i]['historico'];
	$inicio_sintomas = $res[$i]['inicio_sintomas'];
	$condicao_geral = $res[$i]['condicao_geral'];
	$escala_dor = $res[$i]['escala_dor'];
	$data = $res[$i]['data'];
	$hora = $res[$i]['hora'];
	$id_agendamento = $res[$i]['id_agendamento'];

	$dataF = @implode('/', array_reverse(explode('-', $data)));

	$query2 = $pdo->query("SELECT * FROM pacientes where id = '$id_paciente'");
	$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
	$nome_paciente = @$res2[0]['nome'];


	$query2 = $pdo->query("SELECT * FROM agendamentos where id = '$id_agendamento'");
	$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
	$funcionario_agd = @$res2[0]['funcionario'];
	$servico_agd = @$res2[0]['servico'];
	$obs_agd = @$res2[0]['obs'];


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
}
	

echo <<<HTML

<tr>
<td class=""> {$nome_paciente}</td>
<td class=""><i class="fa fa-square mr-1" style="color:{$classe_risco}"></i> {$risco}</td>
<td class=""> {$escala_dor}</td>
<td class=""> {$dataF}</td>
<td class=""> {$hora}</td>
<td>

	<big><a href="#" onclick="editar('{$id}','{$id_paciente}','{$risco}','{$queixa}','{$pa}','{$fc}','{$fr}','{$temperatura}','{$saturacao}','{$alergias}','{$medicamentos}','{$historico}','{$inicio_sintomas}','{$condicao_geral}','{$escala_dor}')" title="Editar Dados"><i class="fa fa-edit text-primary"></i></a></big>




	<li class="dropdown head-dpdn2" style="display: inline-block;">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><big><i class="fa fa-trash-o text-danger"></i></big></a>
		<ul class="dropdown-menu" style="margin-left:-230px;">
		<li>
		<div class="notification_desc2">
		<p>Confirmar Exclusão? <a href="#" onclick="excluirTriagem('{$id}')"><span class="text-danger">Sim</span></a></p>
		</div>
		</li>
		</ul>
</li>


<big><a href="#" onclick="consulta('{$id}','{$id_paciente}','{$risco}','{$nome_paciente}','{$id_agendamento}','{$funcionario_agd}','{$servico_agd}','{$obs_agd}')" title="Adicionar Consulta"><i class="fa fa-stethoscope text-success"></i></a></big>


<form action="rel/triagem_class.php" target="_blank" method="post" style="display: inline-block;">
<input type="hidden" name="id" value="{$id}">
	<button style="background: transparent; border:none; outline:none" class="" title="Detalhamento da Triagem"><i class="fa fa-file-pdf-o text-primary"></i></button>
</form>




</td>

</tr>

HTML;



}





echo <<<HTML

</tbody>

<small><div align="center" id="mensagem-excluir"></div>

</small>

</table>

<br>

<div align="right">

<span style="margin-right: 50px">Total Exames: <span style="color:red">{$total_exames}</span></span>

<span style="">Total Consultas: <span style="color:blue">{$total_consultas}</span></span>

</div>

HTML;



}else{

	echo '<small>Nenhum Registro Encontrado!</small>';

}

?>







<script type="text/javascript">

	$(document).ready( function () {		

    $('#tabela').DataTable({

    	"language" : {

            //"url" : '//cdn.datatables.net/plug-ins/1.13.2/i18n/pt-BR.json'

        },

        "ordering": false,

		"stateSave": true

    });

} );

</script>



<script type="text/javascript">

	function editar(id, id_paciente, risco, queixa, pa, fc, fr, temperatura, saturacao, alergias, medicamentos, historico, inicio_sintomas, condicao_geral, escala_dor){

    $('#mensagem').text('');
    $('#titulo_inserir').text('Editar Registro');

    $('#id').val(id);
    $('#cliente').val(id_paciente).change();
    $('#risco').val(risco).change();
    $('#queixa').val(queixa);
    $('#pa').val(pa);
    $('#fc').val(fc);
    $('#fr').val(fr);
    $('#temperatura').val(temperatura);
    $('#saturacao').val(saturacao);
    $('#alergias').val(alergias);
    $('#medicamentos').val(medicamentos);
    $('#historico').val(historico);
    $('#inicio_sintomas').val(inicio_sintomas);
    $('#condicao_geral').val(condicao_geral);
    $('#escala_dor').val(escala_dor);

    $('#modalForm').modal('show');
}


	function limparCampos(){

    $('#id').val('');
    $('#cliente').val('').change();
    $('#risco').val('').change();
    $('#queixa').val('');
    $('#pa').val('');
    $('#fc').val('');
    $('#fr').val('');
    $('#temperatura').val('');
    $('#saturacao').val('');
    $('#alergias').val('');
    $('#medicamentos').val('');
    $('#historico').val('');
    $('#inicio_sintomas').val('');
    $('#condicao_geral').val('');
    $('#escala_dor').val('');

    $('#ids').val('');
    $('#btn-deletar').hide();
}



function excluirTriagem(id){	
    $('#mensagem-excluir').text('Excluindo...')
    
    $.ajax({
        url: 'paginas/' + pag + "/excluir.php",
        method: 'POST',
        data: {id},
        dataType: "html",
        success:function(mensagem){
             
            if (mensagem.trim() == "Excluído com Sucesso") {  
                buscar();
            } else {
                $('#mensagem-excluir').addClass('text-danger')
                $('#mensagem-excluir').text(mensagem)
            }
        }
    });
}



function consulta(id, id_paciente, risco, nome_paciente, id_agendamento, funcionario, servico, obs){       

    $('#id_triagem_consulta').val(id);
    $('#paciente_consulta').val(id_paciente);
    $('#risco_consulta').val(risco);
    $('#id_agendamento').val(id_agendamento);
    $('#nome_do_paciente').text(nome_paciente);

    $('#obs').val('');
    $('#funcionario_modal').val('').change();

    if(funcionario != ""){
    	
    	$('#funcionario_modal').val(funcionario).change();
    	setTimeout(function() {
  			$('#servico').val(servico).change();
		}, 800)
    	
    	$('#obs').val(obs);
    }else{
    	setTimeout(function() {
  			listarServicos()
		}, 200)
    }

    
    
    
    $('#modalConsulta').modal('show');
}

</script>
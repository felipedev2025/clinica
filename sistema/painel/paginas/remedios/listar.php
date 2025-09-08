<?php 
$tabela = 'remedios';
require_once("../../../conexao.php");

$filtro = @$_POST['p1'];


$data_atual = date('Y-m-d');
$data30 = date('Y-m-d', strtotime("+1 month",strtotime($data_atual)));

$remedios_vencidos = 0;
$estoque_baixo = 0;

if($filtro == "vencendo"){
	$query = $pdo->query("SELECT * from $tabela where validade >= curDate() and validade <= '$data30' order by id desc");
}else if($filtro == "vencido"){
		$query = $pdo->query("SELECT * from $tabela where validade < curDate() order by id desc");
}else if($filtro == "estoque"){
		$query = $pdo->query("SELECT * from $tabela where estoque_minimo >= estoque order by id desc");
}else{
	$query = $pdo->query("SELECT * from $tabela order by id desc");
}

$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas > 0){
echo <<<HTML
<small>
	<table class="table table-hover" id="tabela">
	<thead> 
	<tr> 
	<th>Nome</th>	
	<th class="esc">Unidade</th>	
	<th class="esc">Estoque</th>	
	<th class="esc">Valor Custo</th>		
	<th class="esc">Lote</th>		
	<th class="esc">Validade</th>	
	<th>Ações</th>
	</tr> 
	</thead> 
	<tbody>	
HTML;

for($i=0; $i<$linhas; $i++){
	$id = $res[$i]['id'];
	$codigo = $res[$i]['codigo'];
	$nome = $res[$i]['nome'];
	$nome_quimico = $res[$i]['nome_quimico'];
	$laboratorio = $res[$i]['laboratorio'];
	$forma_farmaceutica = $res[$i]['forma_farmaceutica'];
	$apresentacao = $res[$i]['apresentacao'];	
	$unidade = $res[$i]['unidade'];	
	$estoque = $res[$i]['estoque'];
	$estoque_minimo = $res[$i]['estoque_minimo'];
	$antibiotico = $res[$i]['antibiotico'];
	$valor_custo = $res[$i]['valor_custo'];
	$valor_venda = $res[$i]['valor_venda'];
	$obs = $res[$i]['obs'];
	$lote = $res[$i]['lote'];
	$validade = $res[$i]['validade'];

	$validadeF = @implode('/', array_reverse(explode('-', $validade)));
	$valor_custoF = number_format($valor_custo, 2, ',', '.');
	$valor_vendaF = number_format($valor_venda, 2, ',', '.');

	
	$classe_estoque = '';
	if($estoque <= $estoque_minimo){
		$classe_estoque = 'text-danger';
		$estoque_baixo += 1;
	}

	$classe_vencida = '';
	if(strtotime($validade) < strtotime($data_atual)){
		$classe_vencida = 'text-danger';
		$remedios_vencidos += 1;
	}

	

echo <<<HTML
<tr>
<td class="{$classe_estoque}">
<input type="checkbox" id="seletor-{$id}" class="form-check-input" onchange="selecionar('{$id}')">
{$nome} <span style="display:none">{$nome_quimico}</span>
</td>
<td class="esc">{$unidade}</td>
<td class="esc {$classe_estoque}">{$estoque}</td>
<td class="esc text-verde">R$ {$valor_custoF}</td>
<td class="esc ">{$lote}</td>
<td class="esc {$classe_vencida}">{$validadeF}</td>

<td>
	<big><a href="#" onclick="editar('{$id}','{$codigo}','{$nome}','{$nome_quimico}','{$laboratorio}','{$forma_farmaceutica}','{$apresentacao}','{$unidade}','{$estoque}','{$estoque_minimo}','{$antibiotico}','{$valor_custo}','{$valor_venda}','{$obs}','{$lote}','{$validade}')" title="Editar Dados"><i class="fa fa-edit text-primary"></i></a></big>

		<big><a href="#" onclick="mostrar('{$codigo}','{$nome}','{$nome_quimico}','{$laboratorio}','{$forma_farmaceutica}','{$apresentacao}','{$unidade}','{$estoque}','{$estoque_minimo}','{$antibiotico}','{$valor_custoF}','{$valor_vendaF}','{$obs}','{$lote}','{$validadeF}')" title="Ver Dados"><i class="fa fa-info-circle text-secondary"></i></a></big>

	<li class="dropdown head-dpdn2" style="display: inline-block;">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><big><i class="fa fa-trash-o text-danger"></i></big></a>

		<ul class="dropdown-menu" style="margin-left:-230px;">
		<li>
		<div class="notification_desc2">
		<p>Confirmar Exclusão? <a href="#" onclick="excluir('{$id}')"><span class="text-danger">Sim</span></a></p>
		</div>
		</li>										
		</ul>
</li>


<big><a href="#" onclick="saida('{$id}','{$nome}', '{$estoque}')" title="Saída de Produto"><i class="fa fa-sign-out text-danger"></i></a></big>

	<big><a href="#" onclick="entrada('{$id}','{$nome}', '{$estoque}')" title="Entrada de Produto"><i class="fa fa-sign-in verde"></i></a></big>

</td>
</tr>
HTML;

}

}else{
	echo '<small>Não possui nenhum cadastro!</small>';
}


echo <<<HTML
</tbody>
<small><div align="center" id="mensagem-excluir"></div></small>
</table>
<br>
<div align="right">Medicamentos Vencidos: <span class="text-danger">{$remedios_vencidos}</span> / Estoque Baixo: <span class="text-primary">{$estoque_baixo}</span></div>
HTML;
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
	function editar(id, codigo, nome, nome_quimico, laboratorio, forma_farmaceutica, apresentacao, unidade, estoque, estoque_minimo, antibiotico, valor_custo, valor_venda, obs, lote, validade){
		$('#mensagem').text('');
    	$('#titulo_inserir').text('Editar Registro');

    	$('#id').val(id);
    	$('#nome').val(nome);
    	$('#codigo').val(codigo);
    	$('#nome_quimico').val(nome_quimico);
    	$('#laboratorio').val(laboratorio);
    	$('#forma_farmaceutica').val(forma_farmaceutica);
    	$('#apresentacao').val(apresentacao);
    	$('#unidade').val(unidade).change();
    	$('#estoque').val(estoque);
    	$('#estoque_minimo').val(estoque_minimo);
    	$('#antibiotico').val(antibiotico).change();
    	$('#valor_custo').val(valor_custo);
    	$('#valor_venda').val(valor_venda);
    	$('#obs').val(obs);
    	$('#lote').val(lote);
    	$('#validade').val(validade); 
    	
    	$('#modalForm').modal('show');
	}


		function mostrar(codigo, nome, nome_quimico, laboratorio, forma_farmaceutica, apresentacao, unidade, estoque, estoque_minimo, antibiotico, valor_custo, valor_venda, obs, lote, validade){		

		$('#nome_mostrar').text(nome);
    	$('#codigo_mostrar').text(codigo);
    	$('#nome_quimico_mostrar').text(nome_quimico);
    	$('#laboratorio_mostrar').text(laboratorio);
    	$('#forma_farmaceutica_mostrar').text(forma_farmaceutica);
    	$('#apresentacao_mostrar').text(apresentacao);
    	$('#unidade_mostrar').text(unidade);
    	$('#estoque_mostrar').text(estoque);
    	$('#estoque_minimo_mostrar').text(estoque_minimo);
    	$('#antibiotico_mostrar').text(antibiotico);
    	$('#valor_custo_mostrar').text(valor_custo);
    	$('#valor_venda_mostrar').text(valor_venda);
    	$('#obs_mostrar').text(obs);
    	$('#lote_mostrar').text(lote);
    	$('#validade_mostrar').text(validade); 

		$('#modalMostrar').modal('show');

	}


	function limparCampos(){
		$('#id').val('');
		$('#codigo').val(''); 
    	$('#nome').val(''); 
    	$('#nome_quimico').val('');
    	$('#forma_farmaceutica').val('');
    	$('#laboratorio').val('');
    	$('#apresentacao').val('');
    	$('#valor_custo').val('');
    	$('#valor_venda').val('');
    	$('#estoque').val('');
    	$('#estoque_minimo').val('');
    
    	$('#lote').val('');
    	$('#validade').val('');
    	$('#obs').val('');
    	   	 	

    	$('#ids').val('');
    	$('#btn-deletar').hide();	
	}

	function selecionar(id){

		var ids = $('#ids').val();

		if($('#seletor-'+id).is(":checked") == true){
			var novo_id = ids + id + '-';
			$('#ids').val(novo_id);
		}else{
			var retirar = ids.replace(id + '-', '');
			$('#ids').val(retirar);
		}

		var ids_final = $('#ids').val();
		if(ids_final == ""){
			$('#btn-deletar').hide();
		}else{
			$('#btn-deletar').show();
		}
	}

	function deletarSel(){
		var ids = $('#ids').val();
		var id = ids.split("-");
		
		for(i=0; i<id.length-1; i++){
			excluir(id[i]);			
		}

		limparCampos();
	}
</script>



<script type="text/javascript">
	function saida(id, nome, estoque){

		$('#nome_saida').text(nome);
		$('#estoque_saida').val(estoque);
		$('#id_saida').val(id);		

		$('#quantidade_saida').val('');
		$('#motivo_saida').val('');

		$('#modalSaida').modal('show');
	}
</script>


<script type="text/javascript">
	function entrada(id, nome, estoque){

		$('#nome_entrada').text(nome);
		$('#estoque_entrada').val(estoque);
		$('#id_entrada').val(id);

		$('#quantidade_entrada').val('');
		$('#motivo_entrada').val('');		

		$('#modalEntrada').modal('show');
	}
</script>
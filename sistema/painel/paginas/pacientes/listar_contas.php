<?php 

require_once("../../../conexao.php");

$pagina = 'receber';

$data_atual = date('Y-m-d');



$total_valor = 0;

$total_valorF = 0;



$id = @$_POST['id'];


		$query = $pdo->query("SELECT * from $pagina where cliente = '$id' order by id desc ");



echo <<<HTML

<small>

HTML;

$total_pago = 0;

$total_pendentes = 0;

$res = $query->fetchAll(PDO::FETCH_ASSOC);

$total_reg = @count($res);

if($total_reg > 0){

echo <<<HTML

	<table class="table table-hover" id="">

		<thead> 

			<tr> 				

					<th>Descrição</th>


				<th class="esc">Valor</th> 

				<th class="esc">Paciente</th> 

				<th class="esc">Vencimento</th> 

				

				<th class="esc">Forma de PGTO</th>

				

			</tr> 

		</thead> 

		<tbody> 

HTML;

for($i=0; $i < $total_reg; $i++){

	foreach ($res[$i] as $key => $value){}

$id = $res[$i]['id'];

$descricao = $res[$i]['descricao'];

$cliente = $res[$i]['cliente'];

$valor = $res[$i]['valor'];

$data_lanc = $res[$i]['data_lanc'];

$data_venc = $res[$i]['data_venc'];

$data_pgto = $res[$i]['data_pgto'];

$usuario_lanc = $res[$i]['usuario_lanc'];

$usuario_pgto = $res[$i]['usuario_pgto'];

$frequencia = $res[$i]['frequencia'];

$saida = $res[$i]['saida'];

$arquivo = $res[$i]['arquivo'];

$pago = $res[$i]['pago'];

$obs = $res[$i]['obs'];

$referencia = $res[$i]['referencia'];

$convenio = $res[$i]['convenio'];






$data_lancF = @implode('/', array_reverse(explode('-', $data_lanc)));

$data_vencF = @implode('/', array_reverse(explode('-', $data_venc)));

$data_pgtoF = @implode('/', array_reverse(explode('-', $data_pgto)));

$valorF = number_format($valor, 2, ',', '.');



$query2 = $pdo->query("SELECT * FROM usuarios where id = '$usuario_lanc'");

$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);

if(@count($res2) > 0){

	$nome_usu_lanc = $res2[0]['nome'];

}else{

	$nome_usu_lanc = 'Sem Usuário';

}





$query2 = $pdo->query("SELECT * FROM usuarios where id = '$usuario_pgto'");

$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);

if(@count($res2) > 0){

	$nome_usu_pgto = $res2[0]['nome'];

}else{

	$nome_usu_pgto = 'Sem Usuário';

}





$query2 = $pdo->query("SELECT * FROM frequencias where dias = '$frequencia'");

$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);

if(@count($res2) > 0){

	$nome_frequencia = $res2[0]['frequencia'];

}else{

	$nome_frequencia = 'Única';

}



$nome_pessoa = 'Sem Registro';

$tipo_pessoa = 'Pessoa';

$pix_pessoa = 'Sem Registro';

$tel_pessoa = 'Sem Registro';



$query2 = $pdo->query("SELECT * FROM pacientes where id = '$cliente'");

$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);

if(@count($res2) > 0){

	$nome_pessoa = $res2[0]['nome'];	

	$tipo_pessoa = 'Paciente';

	$tel_pessoa = $res2[0]['telefone'];

}



$query2 = $pdo->query("SELECT * FROM convenios where id = '$convenio'");

$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);

if(@count($res2) > 0){

	$nome_pessoa = $res2[0]['nome'];	

	$tipo_pessoa = 'Convênio';

	$tel_pessoa = $res2[0]['telefone'];

}





if($pago == 'Sim'){

	$classe_pago = 'verde';

	$ocultar = 'ocultar';

	$total_pago += $valor;

}else{

	$classe_pago = 'text-danger';

	$ocultar = '';

	$total_pendentes += $valor;

}





//PEGAR RESIDUOS DA CONTA

	$total_resid = 0;

	$valor_com_residuos = 0;

	$query2 = $pdo->query("SELECT * FROM valor_parcial WHERE id_conta = '$id' and tipo = 'Receber'");

	$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);

	if(@count($res2) > 0){



		$descricao = '(Resíduo) - ' .$descricao;



		for($i2=0; $i2 < @count($res2); $i2++){

			foreach ($res2[$i2] as $key => $value){} 

				$id_res = $res2[$i2]['id'];

			$valor_resid = $res2[$i2]['valor'];

			$total_resid += $valor_resid;

			$total_pago += $total_resid;

		}





		$valor_com_residuos = $valor + $total_resid;

	}

	if($valor_com_residuos > 0){

		$vlr_antigo_conta = '('.$valor_com_residuos.')';

		$descricao_link = '';

		$descricao_texto = 'd-none';

	}else{

		$vlr_antigo_conta = '';

		$descricao_link = 'd-none';

		$descricao_texto = '';

	}



$total_pagoF = number_format($total_pago, 2, ',', '.');

$total_pendentesF = number_format($total_pendentes, 2, ',', '.');



if($tel_pessoa == "Sem Registro"){

	$ocultar_whats = 'ocultar';

}else{

	$ocultar_whats = '';

}



$tel_pessoaF = '55'.preg_replace('/[ ()-]+/' , '' , $tel_pessoa);



echo <<<HTML

			<tr> 

				<td><i class="fa fa-square {$classe_pago} mr-1"></i> {$descricao}</td> 

					<td class="esc">R$ {$valorF} <small><a href="#" onclick="mostrarResiduos('{$id}')" class="text-danger" title="Ver Resíduos">{$vlr_antigo_conta}</a></small></td>	

					<td class="esc">{$nome_pessoa}</td>

				<td class="esc">{$data_vencF}</td>

				

				<td class="esc">{$saida}</td>

				

			</tr> 

HTML;

}

echo <<<HTML

		</tbody> 

		<small><div align="center" id="mensagem-excluir"></div></small>

	</table>

	<br>

	<div align="right"><span>Total Pendentes: <span class="text-danger">{$total_pendentesF}</span></span> <span style="margin-left: 25px">Total Pago: <span class="verde">{$total_pagoF}</span></span></div>

</small>

HTML;

}else{

	echo 'Não possui nenhuma conta para este Paciente!';

}



?>





<script type="text/javascript">





	$(document).ready( function () {

	  

	    $('#total_itens').text('R$ <?=$total_valorF?>');

	} );





</script>








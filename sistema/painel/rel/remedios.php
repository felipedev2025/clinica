<?php 
include('data_formatada.php');


if ($token_rel != 'DER47005') {
	echo '<script>window.location="../../"</script>';
	exit();
}


$data_atual = date('Y-m-d');
$data30 = date('Y-m-d', strtotime("+1 month",strtotime($data_atual)));

$remedios_vencidos = 0;
$estoque_baixo = 0;

if($filtro == "vencendo"){
	$titulo_rel = ' Vencendo em 30 Dias';
}else if($filtro == "vencido"){
		$titulo_rel = ' Vencidos';
}else if($filtro == "estoque"){
		$titulo_rel = ' com Estoque Baixo';
}else{
	$titulo_rel = ' ';
}


?>

<!DOCTYPE html>

<html>

<head>



<style>



@import url('https://fonts.cdnfonts.com/css/tw-cen-mt-condensed');

@page { margin: 145px 20px 25px 20px; }

#header { position: fixed; left: 0px; top: -110px; bottom: 100px; right: 0px; height: 35px; text-align: center; padding-bottom: 100px; }

#content {margin-top: 0px;}

#footer { position: fixed; left: 0px; bottom: -60px; right: 0px; height: 80px; }

#footer .page:after {content: counter(page, my-sec-counter);}

body {font-family: 'Tw Cen MT', sans-serif;}



.marca{

	position:fixed;

	left:50;

	top:100;

	width:80%;

	opacity:8%;

}



</style>



</head>

<body>

<?php 

if($marca_dagua == 'Sim'){ ?>

<img class="marca" src="<?php echo $url_sistema ?>img/logo.jpg">	

<?php } ?>





<div id="header" >



	<div style="border-style: solid; font-size: 10px; height: 50px;">

		<table style="width: 100%; border: 0px solid #ccc;">

			<tr>

				<td style="border: 1px; solid #000; width: 7%; text-align: left;">

					<img style="margin-top: 7px; margin-left: 7px;" id="imag" src="<?php echo $url_sistema ?>img/logo.jpg" width="120px">

				</td>

				<td style="width: 30%; text-align: left; font-size: 13px;">

					

				</td>

				<td style="width: 1%; text-align: center; font-size: 13px;">

				

				</td>

				<td style="width: 47%; text-align: right; font-size: 9px;padding-right: 10px;">

						<b><big>RELATÓRIO DE MEDICAMENTOS <?php echo mb_strtoupper($titulo_rel) ?></big></b><br>  <br> <?php echo mb_strtoupper($data_hoje) ?>

				</td>

			</tr>		

		</table>

	</div>


		<table id="cabecalhotabela" style="border-bottom-style: solid; font-size: 9px; margin-bottom:10px; width: 100%; table-layout: fixed; margin-top: 20px">
			<thead>			

				<tr id="cabeca" style="margin-left: 0px; background-color:#CCC">
					<td style="width:25%">NOME</td>
					<td style="width:10%">UNIDADE</td>
					<td style="width:10%">ESTOQUE</td>
					<td style="width:10%">NÍVEL MÍNIMO</td>
					<td style="width:10%">VALOR CUSTO</td>
					<td style="width:10%">VALOR VENDA</td>			
					<td style="width:15%">LOTE</td>	
					<td style="width:10%">VALIDADE</td>	

				</tr>

			</thead>

		</table>

</div>


<div id="footer" class="row">
<hr style="margin-bottom: 0;">
	<table style="width:100%;">
		<tr style="width:100%;">
			<td style="width:60%; font-size: 10px; text-align: left;"><?php echo $nome_sistema ?> Telefone: <?php echo $telefone_sistema ?> / Este documento é confidencial!</td>
			<td style="width:40%; font-size: 10px; text-align: right;"><p class="page">Página  </p></td>
		</tr>
	</table>
</div>



<div id="content" style="margin-top: -15px">
		<table style="width: 100%; table-layout: fixed; font-size:8px; text-transform: uppercase;">
			<thead>
				<tbody>
					<?php

$remedios_vencidos = 0;
$estoque_baixo = 0;

if($filtro == "vencendo"){
	$query = $pdo->query("SELECT * from remedios where validade >= curDate() and validade <= '$data30' order by id desc");
}else if($filtro == "vencido"){
		$query = $pdo->query("SELECT * from remedios where validade < curDate() order by id desc");
}else if($filtro == "estoque"){
		$query = $pdo->query("SELECT * from remedios where estoque_minimo >= estoque order by id desc");
}else{
	$query = $pdo->query("SELECT * from remedios order by id desc");
}

$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas > 0){
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
		$classe_estoque = 'red';
		$estoque_baixo += 1;
	}

	$classe_vencida = '';
	if(strtotime($validade) < strtotime($data_atual)){
		$classe_vencida = 'red';
		$remedios_vencidos += 1;
	}

  	 ?>



  	 

      <tr>

<td style="width:25%; color:<?php echo $classe_estoque ?>"><?php echo $nome ?></td>
<td style="width:10%"><?php echo $unidade ?></td>
<td style="width:10%; color:<?php echo $classe_estoque ?>"><?php echo $estoque ?></td>
<td style="width:10%"><?php echo $estoque_minimo ?></td>
<td style="width:10%"><?php echo $valor_custoF ?></td>
<td style="width:10%"><?php echo $valor_vendaF ?></td>
<td style="width:15%"><?php echo $lote ?></td>
<td style="width:10%; color:<?php echo $classe_vencida ?>"><?php echo $validadeF ?></td>

    </tr>

<?php } } ?>

				</tbody>
			</thead>
		</table>

	
</div>
<hr>
		<table>
			<thead>
				<tbody>
					<tr>
						<td style="font-size: 10px; width:300px; text-align: right;"></td>
						<td style="font-size: 10px; width:70px; text-align: right;"></td>

							<td style="font-size: 10px; width:70px; text-align: right;"></td>

								<td style="font-size: 10px; width:140px; text-align: right;"><b>Medicamentos Vencidos: <span style="color:red"> <?php echo $remedios_vencidos ?></span></td>



									<td style="font-size: 10px; width:120px; text-align: right;"><b>Estoque Baixo: <span style="color:green"> <?php echo $estoque_baixo ?></span></td>

						

					</tr>

				</tbody>

			</thead>

		</table>



		<hr>









	



</body>



</html>






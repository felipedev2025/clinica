<?php 
include('data_formatada.php');

if ($token_rel != 'DER47005') {
	echo '<script>window.location="../../"</script>';
	exit();
}


$dataInicialF = implode('/', array_reverse(explode('-', $dataInicial)));
$dataFinalF = implode('/', array_reverse(explode('-', $dataFinal)));	


$datas = "";
if($dataInicial == $dataFinal){
	$datas = $dataInicialF;
}else{
	$datas = $dataInicialF.' à '.$dataFinalF;

}

$texto_filtro = $datas;


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

						<b><big>RELATÓRIO DE TRIAGENS</span></big></b><br> <?php echo mb_strtoupper($texto_filtro) ?> <br> <?php echo mb_strtoupper($data_hoje) ?>

				</td>

			</tr>		

		</table>

	</div>



<br>





		<table id="cabecalhotabela" style="border-bottom-style: solid; font-size: 9px; margin-bottom:10px; width: 100%; table-layout: fixed;">

			<thead>				

				<tr id="cabeca" style="margin-left: 0px; background-color:#CCC">

					<td style="width:40%">PACIENTE</td>
					<td style="width:15%">RISCO</td>
					<td style="width:15%">ESCALA DOR</td>
					<td style="width:15%">DATA</td>	
					<td style="width:15%">HORA</td>					

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



<div id="content" style="margin-top: 0;">







		<table style="width: 100%; table-layout: fixed; font-size:9px; text-transform: uppercase;">

			<thead>

				<tbody>

					<?php



$query = $pdo->query("SELECT * from triagens where (data >= '$dataInicial' and data <= '$dataFinal') order by data asc ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0){
for($i=0; $i < $total_reg; $i++){
	foreach ($res[$i] as $key => $value){}
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

	$dataF = @implode('/', array_reverse(explode('-', $data)));

	$query2 = $pdo->query("SELECT * FROM pacientes where id = '$id_paciente'");
	$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
	$nome_paciente = @$res2[0]['nome'];


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

  	 ?>



  	 

      <tr>



<td style="width:40%"><?php echo $nome_paciente ?></td>
<td style="width:15%; background:<?php echo $classe_risco ?>"><?php echo $risco ?></td>
<td style="width:15%"><?php echo $escala_dor ?></td>
<td style="width:15%"><?php echo $dataF ?></td>
<td style="width:15%"><?php echo $hora ?></td>
    </tr>



<?php } } ?>


				</tbody>	

			</thead>
		</table>

	





</div>

<hr>
</body>



</html>






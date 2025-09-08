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

						<b><big>RELATÓRIO DE VENDAS</span></big></b><br> <?php echo mb_strtoupper($texto_filtro) ?> <br> <?php echo mb_strtoupper($data_hoje) ?>

				</td>

			</tr>		

		</table>

	</div>



<br>





		<table id="cabecalhotabela" style="border-bottom-style: solid; font-size: 9px; margin-bottom:10px; width: 100%; table-layout: fixed;">

			<thead>				

				<tr id="cabeca" style="margin-left: 0px; background-color:#CCC">

					<td style="width:10%">VALOR</td>
					<td style="width:25%">PACIENTE / CLIENTE</td>
					<td style="width:10%">VENCIMENTO</td>
					<td style="width:10%">PAGAMENTO</td>
					<td style="width:20%">FORMA DE PAGAMENTO</td>	
					<td style="width:25%">EFETUADA POR</td>					

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







		<table style="width: 100%; table-layout: fixed; font-size:8px; text-transform: uppercase;">

			<thead>

				<tbody>

					<?php



$query = $pdo->query("SELECT * from receber where (data_venc >= '$dataInicial' and data_venc <= '$dataFinal') and referencia = 'Venda' order by data_venc asc ");
$total_pago = 0;
$total_pendentes = 0;
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0){
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

//extensão do arquivo
$ext = pathinfo($arquivo, PATHINFO_EXTENSION);
if($ext == 'pdf'){
	$tumb_arquivo = 'pdf.png';
}else if($ext == 'rar' || $ext == 'zip'){
	$tumb_arquivo = 'rar.png';
}else if($ext == 'doc' || $ext == 'docx'){
	$tumb_arquivo = 'word.png';
}else{
	$tumb_arquivo = $arquivo;
}


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
	$classe_pago = 'verde.jpg';
	$ocultar = 'ocultar';
	$total_pago += $valor;
}else{
	$classe_pago = 'vermelho.jpg';
	$ocultar = '';
	$total_pendentes += $valor;
}




$total_pagoF = number_format($total_pago, 2, ',', '.');
$total_pendentesF = number_format($total_pendentes, 2, ',', '.');


if($tel_pessoa == "Sem Registro"){
	$ocultar_whats = 'ocultar';
}else{
	$ocultar_whats = '';
}

$tel_pessoaF = '55'.preg_replace('/[ ()-]+/' , '' , $tel_pessoa);

  	 ?>



  	 

      <tr>


<td style="width:10%"><img style="margin-top: 0px" src="<?php echo $url_sistema ?>painel/images/<?php echo $classe_pago ?>" width="8px"> R$ <?php echo $valorF ?></td>
<td style="width:25%"><?php echo $nome_pessoa ?></td>
<td style="width:10%"><?php echo $data_vencF ?></td>
<td style="width:10%"><?php echo $data_pgtoF ?></td>
<td style="width:20%"><?php echo $saida ?></td>
<td style="width:25%"><?php echo $nome_usu_lanc ?></td>
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





								<td style="font-size: 10px; width:140px; text-align: right;"><b>Pendentes: <span style="color:red">R$ <?php echo $total_pendentesF ?></span></td>



									<td style="font-size: 10px; width:120px; text-align: right;"><b>Pagas: <span style="color:green">R$ <?php echo $total_pagoF ?></span></td>

						

					</tr>

				</tbody>

			</thead>

		</table>



</body>



</html>






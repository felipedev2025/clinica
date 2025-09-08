<?php 
$pag = 'saidas';

//verificar se ele tem a permissão de estar nessa página
if(@$saidas == 'ocultar'){
    echo "<script>window.location='../index.php'</script>";
    exit();
}
$data_atual = date('Y-m-d');
 ?>

<div class="row margem_mobile">
	<form method="POST" action="rel/saidas_class.php" target="_blank">
	<span class="esc" style="font-size: 14px">Data Inicial</span>
	<input type="date" id="dataInicial" name="dataInicial" class="form-control" style="width:150px; display:inline-block; margin-right: 20px" onchange="mudarData()" required value="<?php echo $data_atual ?>">

	<span class="esc" style="font-size: 14px">Data Final</span>
	<input type="date" id="dataFinal" name="dataFinal" class="form-control" style="width:150px; display:inline-block;" onchange="mudarData()" required value="<?php echo $data_atual ?>">

	<button class="btn btn-success  botao_rel" type="submit">Relatório</button>


	</form>
</div>

<div class="bs-example widget-shadow" style="padding:15px" id="listar">

</div>


<script type="text/javascript">var pag = "<?=$pag?>"</script>
<script src="js/ajax.js"></script>


<script type="text/javascript">
	function mudarData(){
		var dataInicial = $("#dataInicial").val();
		var dataFinal = $("#dataFinal").val();

		if(dataInicial != "" && dataFinal != ""){			
			listar(dataInicial, dataFinal)
		}
	}
</script>
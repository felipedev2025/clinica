<?php 
$pag = 'aniversariantes';

if(@$aniversariantes == 'ocultar'){

	echo "<script>window.location='../index.php'</script>";

	exit();

}

?>

<div  style="display: inline-block; font-size: 14px; padding:5px; margin-top: 20px!important;">
			<span class="ocultar_mobile" style="">
				<button class="btn btn-primary btn-sm" href="#" onclick="buscar('mes')">Aniversáriantes do Mês</button> / 
				<button class="btn btn-success btn-sm" href="#" onclick="buscar('dia')">Aniversáriantes do Dia</button>
		</div>



<div class="bs-example widget-shadow" style="padding:15px" id="listar">

</div>

<script type="text/javascript">var pag = "<?=$pag?>"</script>

<script src="js/ajax.js"></script>


<script type="text/javascript">

		function buscar(tipo){	

			listar(tipo);
		}

		</script>
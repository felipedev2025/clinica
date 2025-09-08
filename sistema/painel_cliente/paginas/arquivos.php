<?php 
@session_start();
require_once("verificar.php");
require_once("../conexao.php");

$pag = 'arquivos';

?>


<div class="bs-example widget-shadow margem_mobile_top" style="padding:15px; margin-top: -20px">
	<div id="listar">
	</div>	
</div>


<script type="text/javascript">var pag = "<?=$pag?>"</script>

<script src="js/ajax.js"></script>


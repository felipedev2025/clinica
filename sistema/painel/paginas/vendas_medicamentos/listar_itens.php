<?php 
@session_start();
$id_usuario = @$_SESSION['id'];
$tabela = 'itens_venda';
require_once("../../../conexao.php");

$desconto = @$_POST['desconto'];

$query = $pdo->query("SELECT * from $tabela where venda = 0 and usuario = '$id_usuario' order by id asc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas > 0){
echo <<<HTML
<small>
	<table class="table table-hover" id="">
	<thead> 
	<tr> 
	<th>Medicamento</th>	
	<th class="">Quantidade</th>
	<th class="">Valor</th>	
	<th class="">Total</th>		
	<th>Excluir</th>
	</tr> 
	</thead> 
	<tbody>	
HTML;
$total_valor = 0;
for($i=0; $i<$linhas; $i++){
	$id = $res[$i]['id'];
	$medicamento = $res[$i]['medicamento'];
	$quantidade = $res[$i]['quantidade'];
	$valor = $res[$i]['valor'];
	$total = $res[$i]['total'];
	$nome_remedio = $res[$i]['nome'];

$total_valor += $total;

$valorF = number_format($valor, 2, ',', '.');
$totalF = number_format($total, 2, ',', '.');
echo <<<HTML
<tr>
<td>{$nome_remedio}</td>
<td>{$quantidade}</td>
<td>{$valorF}</td>
<td>{$totalF}</td>
<td>
	<li class="dropdown head-dpdn2" style="display: inline-block;">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><big><i class="fa fa-trash-o text-danger"></i></big></a>

		<ul class="dropdown-menu" style="margin-left:-230px;">
		<li>
		<div class="notification_desc2">
		<p>Confirmar Exclusão? <a href="#" onclick="excluirItem('{$id}')"><span class="text-danger">Sim</span></a></p>
		</div>
		</li>										
		</ul>
</li>


</td>
</tr>
HTML;

}

$total_valor = $total_valor - $desconto;
$total_valorF = number_format($total_valor, 2, ',', '.');
}else{
	echo '<small>Não possui nenhum cadastro!</small>';
}


echo <<<HTML
</tbody>

</table>

HTML;
?>


<script type="text/javascript">

$(document).ready( function () {
		var total_valor = "<?=$total_valorF?>";
		$('#total_venda').text(total_valor);
	});
	
function excluirItem(id){	
        
    $.ajax({
        url: 'paginas/' + pag + "/excluir_medicamento.php",
        method: 'POST',
        data: {id},
        dataType: "html",
        success:function(mensagem){             
            listarItens();
        }
    });
}
</script>
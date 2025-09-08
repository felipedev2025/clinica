<?php 
$tabela = 'saidas';
require_once("../../../conexao.php");

$dataInicial = @$_POST['p1'];
$dataFinal = @$_POST['p2'];

if($dataInicial != "" and $dataFinal != ""){
	$query = $pdo->query("SELECT * from $tabela where data >= '$dataInicial' and data <= '$dataFinal' order by id asc");
}else{
	$query = $pdo->query("SELECT * from $tabela order by id desc limit 50");
}

$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas > 0){
echo <<<HTML
<small>
	<table class="table table-hover" id="tabela">
	<thead> 
	<tr> 
	<th>Remédio</th>	
	<th>Quantidade</th>		
	<th class="esc">Motivo</th>
	<th class="esc">Usuário</th>
	<th class="esc">Data</th>	
	<th class="esc">Paciente</th>	
	<th class="esc">Médico</th>	
	<th>Excluir</th>
	</tr> 
	</thead> 
	<tbody>	
HTML;

for($i=0; $i<$linhas; $i++){
	$id = $res[$i]['id'];
	$produto = $res[$i]['produto'];	
	$quantidade = $res[$i]['quantidade'];	
	$motivo = $res[$i]['motivo'];
	$usuario = $res[$i]['usuario'];
	$data = $res[$i]['data'];
	$medico = $res[$i]['medico'];
	$paciente = $res[$i]['paciente'];
	
	
	$dataF = implode('/', array_reverse(@explode('-', $data)));

	$query2 = $pdo->query("SELECT * from remedios where id = '$produto'");
	$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
	$nome_produto = @$res2[0]['nome'];
	$estoque = @$res2[0]['estoque'];

	$query2 = $pdo->query("SELECT * from usuarios where id = '$usuario'");
	$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
	$nome_usuario = @$res2[0]['nome'];

	$query2 = $pdo->query("SELECT * from usuarios where id = '$medico'");
	$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
	$nome_medico = @$res2[0]['nome'];

	$query2 = $pdo->query("SELECT * from pacientes where id = '$paciente'");
	$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
	$nome_paciente = @$res2[0]['nome'];
	

echo <<<HTML
<tr>
<td>{$nome_produto}</td>
<td>{$quantidade}</td>
<td class="esc">{$motivo}</td>
<td class="esc">{$nome_usuario}</td>
<td class="esc">{$dataF}</td>
<td class="esc">{$nome_paciente}</td>
<td class="esc">{$nome_medico}</td>
<td>	

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


<?php 
$tabela = 'itens_servicos';
require_once("../../../conexao.php");
$query = $pdo->query("SELECT * from $tabela order by id desc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas > 0){

echo <<<HTML
<small>
	<table class="table table-hover" id="">
	<thead> 
	<tr>
	<th>Título</th>		
	<th>Descrição</th>
	<th>Ativo</th>
	<th>Ações</th>
	</tr> 
	</thead> 
	<tbody>	
HTML;
for($i=0; $i<$linhas; $i++){
	$id = $res[$i]['id'];
	$titulo = $res[$i]['titulo'];
	$descricao = $res[$i]['descricao'];
	$ativo = $res[$i]['ativo'];
	$descricao = $res[$i]['descricao'];

	//retirar aspas do texto do desc
		$descricao = str_replace('"', "**", $descricao);

echo <<<HTML
<input type="text" id="descricao_{$id}" value="{$descricao}" style="display:none">
<tr>
<td>{$titulo}</td>
<td>{$descricao}</td>
<td>{$ativo}</td>

<td>
	<big><a href="#" onclick="editarItemServico('{$id}','{$titulo}','{$ativo}')" title="Editar Dados"><i class="fa fa-edit text-primary"></i></a></big>

	<li class="dropdown head-dpdn2" style="display: inline-block;">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><big><i class="fa fa-trash-o text-danger"></i></big></a>
		<ul class="dropdown-menu" style="margin-left:-230px;">
		<li>
		<div class="notification_desc2">
		<p>Confirmar Exclusão? <a href="#" onclick="excluirItemServico('{$id}')"><span class="text-danger">Sim</span></a></p>
		</div>
		</li>										
		</ul>
</li>


</td>
</tr>
HTML;
}
echo <<<HTML
</tbody>
<small><div align="center" id="mensagem-excluir"></div></small>
</table>
HTML;
}else{
	echo '<small>Nenhum Registro Encontrado!</small>';
}
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
	function editarItemServico(id, titulo,  ativo){


		
    	$('#id_item_servico').val(id);
    	$('#titulo_item_servico').val(titulo);
    	$('#ativo_item_servico').val(ativo).change();
    	
    	var descricao = $('#descricao_'+id).val();

    		for (let letra of descricao){  				
			if (letra === '*'){
				descricao = descricao.replace('**', '"');
			}			
		}

		$('#descricao_item_servico').val(descricao);
		

		
    	
	}
	

	function excluirItemServico(id){	
     
    $.ajax({
        url: 'paginas/' + pag + "/excluir_item_servico.php",
        method: 'POST',
        data: {id},
        dataType: "html",
        success:function(mensagem){             
            listarItensServicos();
        }
    });
}





	
</script>
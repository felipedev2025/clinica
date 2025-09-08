<?php 
$tabela = 'portfolio';
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
	<th>Ativo</th>
	<th>Imagem</th>
	<th>Ações</th>
	</tr> 
	</thead> 
	<tbody>	
HTML;
for($i=0; $i<$linhas; $i++){
	$id = $res[$i]['id'];
	$titulo = $res[$i]['titulo'];
	$imagem = $res[$i]['imagem'];
	$ativo = $res[$i]['ativo'];
	$descricao = $res[$i]['descricao'];

	//retirar aspas do texto do desc
		$descricao = str_replace('"', "**", $descricao);

echo <<<HTML
<input type="text" id="descricao_{$id}" value="{$descricao}" style="display:none">
<tr>
<td>{$titulo}</td>
<td>{$ativo}</td>
<td><img src="../../assets/img/portfolio/{$imagem}" width="30px"></td>
<td>
	<big><a href="#" onclick="editarItemPortfolio('{$id}','{$titulo}','{$imagem}','{$ativo}')" title="Editar Dados"><i class="fa fa-edit text-primary"></i></a></big>

	<li class="dropdown head-dpdn2" style="display: inline-block;">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><big><i class="fa fa-trash-o text-danger"></i></big></a>
		<ul class="dropdown-menu" style="margin-left:-230px;">
		<li>
		<div class="notification_desc2">
		<p>Confirmar Exclusão? <a href="#" onclick="excluirItemPortfolio('{$id}')"><span class="text-danger">Sim</span></a></p>
		</div>
		</li>										
		</ul>
</li>

<a href="#" onclick="imagensItensPortfolio('{$id}', '{$titulo}')" class='text-dark mr-1' title='Inserir Imagens' style="margin-right:2px"><i class='fa fa-file-image-o'></i></a>	

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
	function editarItemPortfolio(id, titulo, imagem, ativo){


		
    	$('#id_item_portfolio').val(id);
    	$('#titulo_item_portfolio').val(titulo);
    	$('#ativo_item_portfolio').val(ativo).change();
    	
    	var descricao = $('#descricao_'+id).val();

    		for (let letra of descricao){  				
			if (letra === '*'){
				descricao = descricao.replace('**', '"');
			}			
		}

		
		nicEditors.findEditor("descricao_item_portfolio").setContent(descricao);

		$('#target-item_portfolio').attr('src', '../../assets/img/portfolio/' + imagem);
    
    	
	}
	

	function excluirItemPortfolio(id){	
     
    $.ajax({
        url: 'paginas/' + pag + "/excluir_item_portfolio.php",
        method: 'POST',
        data: {id},
        dataType: "html",
        success:function(mensagem){             
            listarItensPortfolio();
        }
    });
}




function imagensItensPortfolio(id, nome){
    $('#id-imagens').val(id);    
    $('#nome-imagens').text(nome);
    $('#modalImagens').modal('show');
    $('#mensagem_fotos').text(''); 
    $('#targetImovel').attr('src','../../assets/img/portfolio/imagens/sem-foto.png');
	$('#imgimovel').val('');
    listarImagens();   
}

	
</script>
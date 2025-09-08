<?php 
$tabela = 'itens_comentarios';
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
	<th>Nome</th>	
	<th>Profissão</th>
	<th>Ativo</th>
	<th>Imagem</th>
	<th>Ações</th>
	</tr> 
	</thead> 
	<tbody>	
HTML;
for($i=0; $i<$linhas; $i++){
	$id = $res[$i]['id'];
	$nome = $res[$i]['nome'];
	$imagem = $res[$i]['imagem'];
	$ativo = $res[$i]['ativo'];
	$descricao = $res[$i]['descricao'];
	$profissao = $res[$i]['profissao'];

	//retirar aspas do texto do desc
		$descricao = str_replace('"', "**", $descricao);

echo <<<HTML
<input type="text" id="descricao_comentario_{$id}" value="{$descricao}" style="display:none">
<tr>
<td>{$nome}</td>
<td>{$profissao}</td>
<td>{$ativo}</td>
<td><img src="../../assets/img/comentario/{$imagem}" width="30px"></td>
<td>
	<big><a href="#" onclick="editarItemComentario('{$id}','{$nome}','{$profissao}','{$imagem}','{$ativo}')" title="Editar Dados"><i class="fa fa-edit text-primary"></i></a></big>

	<li class="dropdown head-dpdn2" style="display: inline-block;">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><big><i class="fa fa-trash-o text-danger"></i></big></a>
		<ul class="dropdown-menu" style="margin-left:-230px;">
		<li>
		<div class="notification_desc2">
		<p>Confirmar Exclusão? <a href="#" onclick="excluirItemComentario('{$id}')"><span class="text-danger">Sim</span></a></p>
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
	function editarItemComentario(id, nome, profissao, imagem, ativo){


		
    	$('#id_item_comentario').val(id);
    	$('#nome_item_comentario').val(nome);
    	$('#profissao_item_comentario').val(profissao);
    	$('#ativo_item_comentario').val(ativo).change();
    	
    	var descricao = $('#descricao_comentario_'+id).val();

    		for (let letra of descricao){  				
			if (letra === '*'){
				descricao = descricao.replace('**', '"');
			}			
		}

		
		$('#descricao_item_comentario').val(descricao);

		$('#target-item_comentario').attr('src', '../../assets/img/comentario/' + imagem);
    
    	
	}
	

	function excluirItemComentario(id){	
     
    $.ajax({
        url: 'paginas/' + pag + "/excluir_item_comentario.php",
        method: 'POST',
        data: {id},
        dataType: "html",
        success:function(mensagem){             
            listarItensComentario();
        }
    });
}




	
</script>
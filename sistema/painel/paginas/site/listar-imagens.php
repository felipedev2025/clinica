<?php 
require_once("../../../conexao.php");

$id = @$_POST['id']; 
$pag = "site";

$query = $pdo->query("SELECT * FROM imagens_portfolio where portfolio = '$id' ");
echo <<<HTML
<div class='row'>
HTML;
$res = $query->fetchAll(PDO::FETCH_ASSOC);

for ($i=0; $i < count($res); $i++) { 
	foreach ($res[$i] as $key => $value) {
	$id = $res[$i]['id'];
	$foto = $res[$i]['foto'];
	}
	echo <<<HTML
	<img class='ml-4 mb-2' src="../../assets/img/portfolio/imagens/{$foto}" width="70">
	<li class="dropdown head-dpdn2" style="display: inline-block; margin-right:15px">
	<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-times text-danger"></i></a>
	<ul class="dropdown-menu">
	<li>
	<div class="notification_desc2">
	<p>Confirmar Exclusão? <a href="#" onclick="excluirImagem('{$id}')"><span class="text-danger">Sim</span></a></p>

	</div>


	</li>

	</ul>
	</li>
	HTML;     

}


echo <<<HTML
</div>
HTML;   
?>




<script type="text/javascript">


	


	function excluirImagem(id){
    
    $.ajax({
        url: 'paginas/site/excluir-imagem.php',
        method: 'POST',
        data: {id},
        dataType: "text",

        success: function (mensagem) {
            $('#mensagem_fotos').text('');
            $('#mensagem_fotos').removeClass()
            if (mensagem.trim() == "Excluído com Sucesso") {                
                listarImagens();                
            } else {

                $('#mensagem_fotos').addClass('text-danger')
                $('#mensagem_fotos').text(mensagem)
            }


        },      

    });
}


</script>



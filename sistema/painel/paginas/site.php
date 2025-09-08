<?php 
$pag = 'site';
if(@$site == 'ocultar'){
	echo "<script>window.location='../index.php'</script>";
	exit();
}

$query = $pdo->query("SELECT * from site order by id limit 1");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);

if($linhas > 0){
	$imagem = @$res[0]['imagem'];
	$texto_imagem = @$res[0]['texto_imagem'];
	$instagram = @$res[0]['instagram'];
	$banner = @$res[0]['banner'];
	$banner_mobile = @$res[0]['banner_mobile'];
	$titulo_banner = @$res[0]['titulo_banner'];
	$subtitulo1 = @$res[0]['subtitulo1'];
	$subtitulo2 = @$res[0]['subtitulo2'];
	$subtitulo3 = @$res[0]['subtitulo3'];
	$subtitulo4 = @$res[0]['subtitulo4'];
	$cor_menu = @$res[0]['cor_menu'];

	$titulo_sobre = @$res[0]['titulo_sobre'];
	$imagem_sobre = @$res[0]['imagem_sobre'];
	$video_sobre = @$res[0]['video_sobre'];
	$mostrar_sobre = @$res[0]['mostrar_sobre'];
	$descricao_sobre = @$res[0]['descricao_sobre'];

	$titulo_portfolio = @$res[0]['titulo_portfolio'];
	$mostrar_portfolio = @$res[0]['mostrar_portfolio'];

	$titulo_servicos = @$res[0]['titulo_servicos'];
	$mostrar_servicos = @$res[0]['mostrar_servicos'];

	$titulo_comentarios = @$res[0]['titulo_comentarios'];
	$mostrar_comentarios = @$res[0]['mostrar_comentarios'];

	if($banner_mobile == ""){
		$banner_mobile = 'sem-foto.png';
	}

}else{
	$pdo->query("INSERT INTO site SET cor_menu = '#020e1f', imagem = 'profile-img.png', texto_imagem = 'Título Logo', instagram = '', banner = 'hero-bg.jpg', titulo_banner = 'Título Banner', subtitulo1 = 'Subtitulo 1', subtitulo2 = 'Subtitulo 2', subtitulo3 = 'Subtitulo 3', subtitulo4 = 'Subtitulo 4', titulo_sobre = 'Título Sobre', imagem_sobre = 'sobre.jpg', video_sobre = '', mostrar_sobre = 'Imagem', descricao_sobre = 'Texto da descrição', titulo_portfolio = 'Título da área Portfolio', mostrar_portfolio = 'Sim', titulo_servicos = 'Título da área Servicos', mostrar_servicos = 'Sim', titulo_comentarios = 'Título da área Comentários', mostrar_comentarios = 'Sim' ");
}



?>


<div style="background: #FFF">
	<small>
		<ul class="nav nav-tabs" id="myTab" role="tablist">
			<li class="nav-item">
				<a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Home</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Sobre</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" id="contact-tab" data-toggle="tab" href="#portfolio" role="tab" aria-controls="portfolio" aria-selected="false">Portfolio</a>
			</li>

			<li class="nav-item">
				<a class="nav-link" id="servicos-tab" data-toggle="tab" href="#servicos" role="tab" aria-controls="servicos" aria-selected="false">Serviços</a>
			</li>

			<li class="nav-item">
				<a class="nav-link" id="servicos-tab" data-toggle="tab" href="#comentarios" role="tab" aria-controls="comentarios" aria-selected="false">Comentários</a>
			</li>
		</ul>
	</small>


	<form id="form_site">
		<div class="tab-content" id="myTabContent">
			<div class="tab-pane fade" id="home" role="tabpanel" aria-labelledby="home-tab" style="padding:10px; margin-top: 10px">

				<div class="row">

					<div class="col-md-2">	
						<label>Cor Menu <i class="fa fa-square" style="color:<?php echo $cor_menu ?>"></i></label>
						<input type="text" class="form-control" id="cor_menu" name="cor_menu" placeholder="Ex #000000" value="<?php echo @$cor_menu ?>">
					</div>

					<div class="col-md-5">	
						<div class="col-md-9">							
							<label>Imagem Logo (Quadrada)</label>
							<input type="file" class="form-control" id="imagem" name="imagem" value="" onchange="carregarImg()">							
						</div>
						<div class="col-md-3">								
							<img src="../../assets/img/<?php echo @$imagem ?>"  width="80px" id="target-imagem">								

						</div>
					</div>

					<div class="col-md-2">	
						<label>Texto Imagem Logo</label>
						<input maxlength="20" type="text" class="form-control" id="texto_imagem" name="texto_imagem" placeholder="Texto abaixo da logo" value="<?php echo @$texto_imagem ?>">
					</div>

					<div class="col-md-3">	
						<label>Instagram</label>
						<input type="text" class="form-control" id="instagram" name="instagram" placeholder="Url Instagram" value="<?php echo @$instagram ?>">
					</div>

				</div>	



				<div class="row">

					<div class="col-md-4">	
						<div class="col-md-8">							
							<label>Imagem Banner (1920 x 1080)</label>
							<input type="file" class="form-control" id="banner" name="banner" value="" onchange="carregarImgBanner()">							
						</div>
						<div class="col-md-4">								
							<img src="../../assets/img/<?php echo @$banner ?>"  width="80px" id="target-banner">								

						</div>
					</div>


						<div class="col-md-4">	
						<div class="col-md-8" style="display:inline-block;">							
							<label>Imagem Banner Mobile <small>(Vertical)</small></label>
							<input type="file" class="form-control" id="banner_mobile" name="banner_mobile" value="" onchange="carregarImgBannerMobile()">							
						</div>
						<div class="col-md-3" style="display:inline-block;">								
							<img src="../../assets/img/<?php echo @$banner_mobile ?>"  style="width:80px" id="target-banner-mobile">								

						</div>
					</div>

					<div class="col-md-4">	
						<label>Título Banner</label>
						<input maxlength="35" type="text" class="form-control" id="titulo_banner" name="titulo_banner" placeholder="Título principal do banner" value="<?php echo @$titulo_banner ?>">
					</div>

						



				</div>



				<div class="row">
					<div class="col-md-3">	
						<label>Subtitulo 1</label>
						<input maxlength="50" type="text" class="form-control" id="subtitulo1" name="subtitulo1" placeholder="Subtitulo se Houver" value="<?php echo @$subtitulo1 ?>">
					</div>	
					<div class="col-md-3">	
						<label>Subtitulo 2</label>
						<input maxlength="50" type="text" class="form-control" id="subtitulo2" name="subtitulo2" placeholder="Subtitulo se Houver" value="<?php echo @$subtitulo2 ?>">
					</div>

					<div class="col-md-3">	
						<label>Subtitulo 3</label>
						<input maxlength="50" type="text" class="form-control" id="subtitulo3" name="subtitulo3" placeholder="Subtitulo se Houver" value="<?php echo @$subtitulo3 ?>">
					</div>

					<div class="col-md-3">	
						<label>Subtitulo 4</label>
						<input maxlength="50" type="text" class="form-control" id="subtitulo4" name="subtitulo4" placeholder="Subtitulo se Houver" value="<?php echo @$subtitulo4 ?>">
					</div>
				</div>	

				<div class="row" align="right" style="padding:10px">
					<button class="btn btn-primary" type="submit">Salvar</button>
				</div>


			</div>


			<div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab" style="padding:10px; margin-top: 10px">						
				<div class="row">
					<div class="col-md-6">	
						<label>Título Sobre</label>
						<input maxlength="50" type="text" class="form-control" id="titulo_sobre" name="titulo_sobre" placeholder="Título Sobre" value="<?php echo @$titulo_sobre ?>">
					</div>


					<div class="col-md-6">	
						<div class="col-md-8">							
							<label>Imagem Sobre (Tamanho Quadrada)</label>
							<input type="file" class="form-control" id="imagem_sobre" name="imagem_sobre" value="" onchange="carregarImgSobre()">							
						</div>
						<div class="col-md-4">								
							<img src="../../assets/img/<?php echo @$imagem_sobre ?>"  width="80px" id="target-sobre">								

						</div>
					</div>


				</div>


				<div class="row">
					
					<div class="col-md-8">	
						<label>Url Vídeo (Incorporada)</label>
						<input maxlength="50" type="text" class="form-control" id="video_sobre" name="video_sobre" placeholder="Título Sobre" value="<?php echo @$video_sobre ?>">
					</div>


					<div class="col-md-4">	
						<label>Mostrar Imagem / Vídeo</label>
						<select class="form-control" name="mostrar_sobre" id="mostrar_sobre">
							<option value="Imagem" <?php if($mostrar_sobre == 'Imagem'){ echo 'selected'; } ?>>Imagem</option>
							<option value="Vídeo" <?php if($mostrar_sobre == 'Vídeo'){ echo 'selected'; } ?>>Vídeo</option>
						</select>						

					</div>
				</div>


				<div class="row">
					<div class="col-md-12">	
						<label>Descrição Sobre</label>
						<textarea class="text_area" name="descricao_sobre" id="descricao_sobre"><?php echo $descricao_sobre ?></textarea>
					</div>
				</div>

				<div class="row" align="right" style="padding:10px">
					<button class="btn btn-primary" type="submit">Salvar</button>
				</div>

			</div>



			<div class="tab-pane fade" id="portfolio" role="tabpanel" aria-labelledby="contact-tab" style="padding:10px; margin-top: 10px">

				<div class="row">
					<div class="col-md-6">	
						<label>Título área Portfólio</label>
						<input maxlength="100" type="text" class="form-control" id="titulo_portfolio" name="titulo_portfolio" placeholder="Título Área Portfólio" value="<?php echo @$titulo_portfolio ?>">
					</div>


					<div class="col-md-3">	
						<label>Mostrar Área Portfólio</label>
						<select class="form-control" name="mostrar_portfolio" id="mostrar_portfolio">
							<option value="Sim" <?php if($mostrar_portfolio == 'Sim'){ echo 'selected'; } ?>>Sim</option>
							<option value="Não" <?php if($mostrar_portfolio == 'Não'){ echo 'selected'; } ?>>Não</option>
						</select>						

					</div>

					<div class="col-md-2" style="margin-top: 23px">
						<button class="btn btn-primary" type="submit">Salvar</button>
					</div>
				</div>


				<div class="row" style="border:1px solid #828282">

					<div class="row" style="margin-top: 10px">

						<div class="col-md-4">	
							<label>Título Item Portfólio</label>
							<input maxlength="100" type="text" class="form-control" id="titulo_item_portfolio" name="titulo_item_portfolio" placeholder="Título Item Portfólio" >
						</div>

						<div class="col-md-2">	
							<label>Ativo</label>
							<select class="form-control" name="ativo_item_portfolio" id="ativo_item_portfolio">
								<option value="Sim" >Sim</option>
								<option value="Não" >Não</option>
							</select>						

						</div>


						<div class="col-md-6">	
							<div class="col-md-8">							
								<label>Imagem Item (Tamanho Quadrada)</label>
								<input type="file" class="form-control" id="imagem_item_portfolio" name="imagem_item_portfolio" value="" onchange="carregarImgItemPortfolio()">							
							</div>
							<div class="col-md-4">								
								<img src="images/sem-foto.png"  width="80px" id="target-item_portfolio">								

							</div>
						</div>
						</div>


						<div class="row">
							<div class="col-md-12">	
								<label>Descrição Item</label>
								<textarea class="text_area" name="descricao_item_portfolio" id="descricao_item_portfolio"></textarea>
							</div>
						</div>

						<input type="hidden" name="id_item_portfolio" id="id_item_portfolio">

						<div class="row" align="right">
							<div class="col-md-12">	
								<button class="btn btn-primary" type="submit">Salvar Item</button>
							</div>
						</div>



					

					<hr>

					<div id="listar_itens_portfolio">
						
					</div>

				</div>
			</div>






			<div class="tab-pane fade" id="servicos" role="tabpanel" aria-labelledby="servicos-tab" style="padding:10px; margin-top: 10px">

				<div class="row">
					<div class="col-md-6">	
						<label>Título área Serviços</label>
						<input maxlength="100" type="text" class="form-control" id="titulo_servicos" name="titulo_servicos" placeholder="Título Área Serviços" value="<?php echo @$titulo_servicos ?>">
					</div>


					<div class="col-md-3">	
						<label>Mostrar Área Serviços</label>
						<select class="form-control" name="mostrar_servicos" id="mostrar_servicos">
							<option value="Sim" <?php if($mostrar_servicos == 'Sim'){ echo 'selected'; } ?>>Sim</option>
							<option value="Não" <?php if($mostrar_servicos == 'Não'){ echo 'selected'; } ?>>Não</option>
						</select>						

					</div>

					<div class="col-md-2" style="margin-top: 23px">
						<button class="btn btn-primary" type="submit">Salvar</button>
					</div>
				</div>


				<div class="row" style="border:1px solid #828282">

					<div class="row" style="margin-top: 10px">

						<div class="col-md-4">	
							<label>Título Item Serviço</label>
							<input maxlength="100" type="text" class="form-control" id="titulo_item_servico" name="titulo_item_servico" placeholder="Título Item Serviço" >
						</div>

						<div class="col-md-2">	
							<label>Ativo</label>
							<select class="form-control" name="ativo_item_servico" id="ativo_item_servico">
								<option value="Sim" >Sim</option>
								<option value="Não" >Não</option>
							</select>						

						</div>


						
						</div>


						<div class="row">
							<div class="col-md-10">	
								<label>Descrição Item</label>
								<input maxlength="120" type="text" class="form-control" id="descricao_item_servico" name="descricao_item_servico" placeholder="Descrição Item Serviço" >
							</div>

							<div class="col-md-2" style="margin-top: 23px">	
								<button onclick="salvarServicos()" class="btn btn-primary" type="button">Salvar Item</button>
							</div>
						</div>

						<input type="hidden" name="id_item_servico" id="id_item_servico">


						<hr>

						<div id="listar_itens_servicos">
						
					</div>

						

				</div>
			</div>





			<div class="tab-pane fade" id="comentarios" role="tabpanel" aria-labelledby="comentarios-tab" style="padding:10px; margin-top: 10px">

				<div class="row">
					<div class="col-md-6">	
						<label>Título área Comentários</label>
						<input maxlength="100" type="text" class="form-control" id="titulo_comentarios" name="titulo_comentarios" placeholder="Título Área Comentários" value="<?php echo @$titulo_comentarios ?>">
					</div>


					<div class="col-md-3">	
						<label>Mostrar Área Comentários</label>
						<select class="form-control" name="mostrar_comentarios" id="mostrar_comentarios">
							<option value="Sim" <?php if($mostrar_comentarios == 'Sim'){ echo 'selected'; } ?>>Sim</option>
							<option value="Não" <?php if($mostrar_comentarios == 'Não'){ echo 'selected'; } ?>>Não</option>
						</select>						

					</div>

					<div class="col-md-2" style="margin-top: 23px">
						<button class="btn btn-primary" type="submit">Salvar</button>
					</div>
				</div>


				<div class="row" style="border:1px solid #828282">

					<div class="row" style="margin-top: 10px">

						<div class="col-md-3">	
							<label>Nome</label>
							<input maxlength="100" type="text" class="form-control" id="nome_item_comentario" name="nome_item_comentario" placeholder="Nome da Pessoa" >
						</div>

							<div class="col-md-2">	
							<label>Profissão</label>
							<input maxlength="100" type="text" class="form-control" id="profissao_item_comentario" name="profissao_item_comentario" placeholder="Outra Informação" >
						</div>

							<div class="col-md-6">	
							<div class="col-md-8">							
								<label>Imagem Item (Tamanho Quadrada)</label>
								<input type="file" class="form-control" id="imagem_item_comentario" name="imagem_item_comentario" value="" onchange="carregarImgItemComentario()">							
							</div>
							<div class="col-md-4">								
								<img src="images/sem-foto.png"  width="80px" id="target-item_comentario">								

							</div>
						</div>

						<div class="col-md-1">	
							<label>Ativo</label>
							<select class="form-control" name="ativo_item_comentario" id="ativo_item_comentario">
								<option value="Sim" >Sim</option>
								<option value="Não" >Não</option>
							</select>						

						</div>




					
						</div>


							<div class="row" style="margin-top: 10px">
									<div class="col-md-10">	
							<label>Descrição Comentário</label>
							<input maxlength="255" type="text" class="form-control" id="descricao_item_comentario" name="descricao_item_comentario" placeholder="Texto Comentário" >
						</div>

						<div class="col-md-2" style="margin-top: 23px">	
								<button class="btn btn-primary" type="submit">Salvar Item</button>
							</div>

							</div>


					

						<input type="hidden" name="id_item_comentario" id="id_item_comentario">

						


					

					<hr>

					<div id="listar_itens_comentario">
						
					</div>

				</div>
			</div>






			

		</div>


		
	</div>

</form>

</div>






<div class="modal" id="modalImagens" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Demais Imagens do Portfólio - <span id="nome-imagens"> </span></h5>
                <button type="button" class="close"  data-dismiss="modal" aria-label="Close" style="margin-top: -15px">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-fotos" method="POST" enctype="multipart/form-data" >
                    <div class="row">
                        <div class="col-md-5">
                            <div class="col-md-12 form-group">
                                <label>Imagens do Imóvel</label>
                                <input type="file" class="form-control-file" id="imgimovel" name="imgimovel[]" multiple="multiple">

                            </div>

                            

                        </div>

                        <div class="col-md-7" id="listar-imagens">

                        </div>




                    </div>

                    <div class="col-md-12" align="right">
                     
                       <input type="hidden" class="form-control" name="id-imagens"  id="id-imagens">

                        <button type="submit" id="btn-fotos" name="btn-fotos" class="btn btn-primary">Salvar</button>

                    </div>

                    <hr>


                    <small>  
                        <div align="center" id="mensagem_fotos" class="">

                        </div>
                    </small>   
                </form>
            </div>

        </div>
    </div>
</div>   




<script type="text/javascript">var pag = "<?=$pag?>"</script>
<script src="js/ajax.js"></script>


<script type="text/javascript">
	$(document).ready( function () {	
	listarItensPortfolio();
	listarItensServicos();
	listarItensComentario();
		$('#home-tab').click();
	});
</script>

<script type="text/javascript">
	function carregarImg() {
		var target = document.getElementById('target-imagem');
		var file = document.querySelector("#imagem").files[0];

		var reader = new FileReader();
		reader.onloadend = function () {
			target.src = reader.result;
		} 
		;
		if (file) {
			reader.readAsDataURL(file);
		} 
		else {
			target.src = "";
		} 

	} 

</script>


<script type="text/javascript">
	function carregarImgBanner() {
		var target = document.getElementById('target-banner');
		var file = document.querySelector("#banner").files[0];
		
		var reader = new FileReader();
		reader.onloadend = function () {
			target.src = reader.result;
		} 
		;
		if (file) {
			reader.readAsDataURL(file);
		} 
		else {
			target.src = "";
		} 

	} 

</script>


<script type="text/javascript">
	$("#form_site").submit(function () {
		event.preventDefault();
		nicEditors.findEditor('descricao_sobre').saveContent();
		nicEditors.findEditor('descricao_item_portfolio').saveContent();
		var formData = new FormData(this);
		$.ajax({
			url: 'paginas/' + pag + "/salvar.php",
			type: 'POST',
			data: formData,
			success: function (mensagem) {
				alert(mensagem);

				$("#id_item_portfolio").val('');
				$("#titulo_item_portfolio").val('');
				$("#imagem_item_portfolio").val('');
				$("#ativo_item_portfolio").val('Sim').change();
				nicEditors.findEditor("descricao_item_portfolio").setContent('');	


				$("#id_item_comentario").val('');
				$("#nome_item_comentario").val('');
				$("#imagem_item_comentario").val('');
				$("#ativo_item_comentario").val('Sim').change();
				$("#profissao_item_comentario").val('');
				$("#descricao_item_comentario").val('');

				listarItensPortfolio()
				listarItensComentario()

				//location.reload();
			},
			cache: false,
			contentType: false,
			processData: false,
		});
	});

</script>


<script type="text/javascript">
	function carregarImgSobre() {
		var target = document.getElementById('target-sobre');
		var file = document.querySelector("#imagem_sobre").files[0];
		
		var reader = new FileReader();
		reader.onloadend = function () {
			target.src = reader.result;
		} 
		;
		if (file) {
			reader.readAsDataURL(file);
		} 
		else {
			target.src = "";
		} 

	} 

</script>



<script type="text/javascript">
	function carregarImgItemPortfolio() {
		var target = document.getElementById('target-item_portfolio');
		var file = document.querySelector("#imagem_item_portfolio").files[0];
		
		var reader = new FileReader();
		reader.onloadend = function () {
			target.src = reader.result;
		} 
		;
		if (file) {
			reader.readAsDataURL(file);
		} 
		else {
			target.src = "";
		} 

	} 

</script>


<script type="text/javascript">
	function carregarImgItemComentario() {
		var target = document.getElementById('target-item_comentario');
		var file = document.querySelector("#imagem_item_comentario").files[0];
		
		var reader = new FileReader();
		reader.onloadend = function () {
			target.src = reader.result;
		} 
		;
		if (file) {
			reader.readAsDataURL(file);
		} 
		else {
			target.src = "";
		} 

	} 

</script>


<script type="text/javascript">
	function listarItensPortfolio(){

    $.ajax({
        url: 'paginas/' + pag + "/listar_itens_portfolio.php",
        method: 'POST',
        data: {},
        dataType: "html",
        success:function(result){
            $("#listar_itens_portfolio").html(result);
           
        }
    });
}
</script>



<script type="text/javascript">
	function listarItensComentario(){

    $.ajax({
        url: 'paginas/' + pag + "/listar_itens_comentario.php",
        method: 'POST',
        data: {},
        dataType: "html",
        success:function(result){
            $("#listar_itens_comentario").html(result);
           
        }
    });
}
</script>


<!--AJAX PARA EXECUTAR A INSERÇÃO DAS DEMAIS FOTOS DO IMÓVEL -->
<script type="text/javascript">


    $("#form-fotos").submit(function () {

        var pag = "<?=$pag?>";
        event.preventDefault();
        var formData = new FormData(this);

        $.ajax({
             url: 'paginas/' + pag + "/inserir-fotos.php",
            type: 'POST',
            data: formData,

            success: function (mensagem) {

                $('#mensagem_fotos').removeClass()

                if (mensagem.trim() == "Inserido com Sucesso") {
                    $('#mensagem_fotos').addClass('text-success');
                    //$('#nome').val('');
                    //$('#cpf').val('');
                    //$('#btn-cancelar-fotos').click();
                    listarImagens();

                } else {

                    $('#mensagem_fotos').addClass('text-danger')

                }

                $('#mensagem_fotos').text(mensagem)

            },

            cache: false,
            contentType: false,
            processData: false,
            xhr: function () {  // Custom XMLHttpRequest
                var myXhr = $.ajaxSettings.xhr();
                if (myXhr.upload) { // Avalia se tem suporte a propriedade upload
                    myXhr.upload.addEventListener('progress', function () {
                        /* faz alguma coisa durante o progresso do upload */
                    }, false);
                }
                return myXhr;
            }
        });
    });



</script>



<!--AJAX PARA LISTAR OS DADOS DAS IMAGENS DOS IMÓVEIS NA MODAL -->
<script type="text/javascript">
			function listarImagens(){
				var id = $('#id-imagens').val();	
				$.ajax({
					url: 'paginas/' + pag + "/listar-imagens.php",
					method: 'POST',
					data: {id},
					dataType: "text",

					success:function(result){
						$("#listar-imagens").html(result);
					}
				});
			}

		</script>



<script type="text/javascript">
	function salvarServicos(){
		var titulo = $("#titulo_item_servico").val();
		var descricao = $("#descricao_item_servico").val();
		var ativo = $("#ativo_item_servico").val();
		var id = $("#id_item_servico").val();

		if(descricao == ""){
			alert("Preencha a Descrição");
			return;
		}

			$.ajax({
					url: 'paginas/' + pag + "/salvar_servicos.php",
					method: 'POST',
					data: {id, titulo, descricao, ativo},
					dataType: "text",

					success:function(result){
						$("#id_item_servico").val('');
				$("#titulo_item_servico").val('');
				$("#descricao_item_servico").val('');
				$("#ativo_item_portfolio").val('Sim').change();
						listarItensServicos();
					}
				});
	}
</script>


<script type="text/javascript">
	function listarItensServicos(){

    $.ajax({
        url: 'paginas/' + pag + "/listar_itens_servicos.php",
        method: 'POST',
        data: {},
        dataType: "html",
        success:function(result){
            $("#listar_itens_servicos").html(result);
           
        }
    });
}
</script>


<script type="text/javascript">
	function carregarImgBannerMobile() {
		var target = document.getElementById('target-banner-mobile');
		var file = document.querySelector("#banner_mobile").files[0];
		
		var reader = new FileReader();
		reader.onloadend = function () {
			target.src = reader.result;
		} 
		;
		if (file) {
			reader.readAsDataURL(file);
		} 
		else {
			target.src = "";
		} 

	} 

</script>

<script src="//js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
<script type="text/javascript">bkLib.onDomLoaded(nicEditors.allTextAreas);</script>
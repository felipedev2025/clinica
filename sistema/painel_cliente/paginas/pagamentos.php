<?php 
$pag = 'pagamentos';
?>



<div class="bs-example widget-shadow" style="padding:15px; margin-top: -20px" id="listar">

	

</div>



	<!-- Modal Arquivos -->

	<div class="modal fade" id="modalArquivos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

		<div class="modal-dialog">

			<div class="modal-content">

				<div class="modal-header">

					<h4 class="modal-title" id="tituloModal">Gestão de Arquivos - <span id="nome-arquivo"> </span></h4>

					<button id="btn-fechar-arquivos" type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -20px">

						<span aria-hidden="true">&times;</span>

					</button>

				</div>

				<form id="form-arquivos" method="post">

					<div class="modal-body">



						<div class="row">

							<div class="col-md-8">						

								<div class="form-group"> 

									<label>Arquivo</label> 

									<input class="form-control" type="file" name="arquivo_conta" onChange="carregarImgArquivos();" id="arquivo_conta">

								</div>	

							</div>

							<div class="col-md-4" style="margin-top:-10px">	

								<div id="divImgArquivos">

									<img src="../painel/images/arquivos/sem-foto.png"  width="60px" id="target-arquivos">									

								</div>					

							</div>









						</div>



						<div class="row" style="margin-top:-40px">

							<div class="col-md-8">

								<input type="text" class="form-control" name="nome-arq"  id="nome-arq" placeholder="Nome do Arquivo * " required>

							</div>



							<div class="col-md-4">										 

								<button type="submit" class="btn btn-primary">Inserir</button>

							</div>

						</div>



						<hr>



						<small><div id="listar-arquivos"></div></small>



						<br>

						<small><div align="center" id="mensagem-arquivo"></div></small>



						<input type="hidden" class="form-control" name="id-arquivo"  id="id-arquivo">





					</div>

				</form>

			</div>

		</div>









		<script type="text/javascript">var pag = "<?=$pag?>"</script>

		<script src="js/ajax.js"></script>




		<script type="text/javascript">

			function carregarImgArquivos() {

				var target = document.getElementById('target-arquivos');

				var file = document.querySelector("#arquivo_conta").files[0];



				var arquivo = file['name'];

				resultado = arquivo.split(".", 2);



				if(resultado[1] === 'pdf'){

					$('#target-arquivos').attr('src', "../painel/images/pdf.png");

					return;

				}



				if(resultado[1] === 'rar' || resultado[1] === 'zip'){

					$('#target-arquivos').attr('src', "../painel/images/rar.png");

					return;

				}



				if(resultado[1] === 'doc' || resultado[1] === 'docx' || resultado[1] === 'txt'){

					$('#target-arquivos').attr('src', "../painel/images/word.png");

					return;

				}





				if(resultado[1] === 'xlsx' || resultado[1] === 'xlsm' || resultado[1] === 'xls'){

					$('#target-arquivos').attr('src', "../painel/images/excel.png");

					return;

				}





				if(resultado[1] === 'xml'){

					$('#target-arquivos').attr('src', "../painel/images/xml.png");

					return;

				}







				var reader = new FileReader();



				reader.onloadend = function () {

					target.src = reader.result;

				};



				if (file) {

					reader.readAsDataURL(file);



				} else {

					target.src = "";

				}

			}

		</script>









		<script type="text/javascript">

			$("#form-arquivos").submit(function () {

				event.preventDefault();

				var formData = new FormData(this);



				$.ajax({

					url: 'paginas/' + pag + "/arquivos.php",

					type: 'POST',

					data: formData,



					success: function (mensagem) {

						$('#mensagem-arquivo').text('');

						$('#mensagem-arquivo').removeClass()

						if (mensagem.trim() == "Inserido com Sucesso") {                    

						//$('#btn-fechar-arquivos').click();

						$('#nome-arq').val('');

						$('#arquivo_conta').val('');

						$('#target-arquivos').attr('src','../painel/images/arquivos/sem-foto.png');

						listarArquivos();

					} else {

						$('#mensagem-arquivo').addClass('text-danger')

						$('#mensagem-arquivo').text(mensagem)

					}



				},



				cache: false,

				contentType: false,

				processData: false,



			});



			});

		</script>



		<script type="text/javascript">

			function listarArquivos(){

				var id = $('#id-arquivo').val();	

				$.ajax({

					url: 'paginas/' + pag + "/listar-arquivos.php",

					method: 'POST',

					data: {id},

					dataType: "text",



					success:function(result){

						$("#listar-arquivos").html(result);

					}

				});

			}



		</script>








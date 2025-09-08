<?php 
require_once("cabecalho.php");
$data_atual = date('Y-m-d');
 ?>

<main id="main">
  <section id="contact" class="contact">
     
        <div class="row" data-aos="fade-in">

      
          <div class="col-lg-12 mt-5 mt-lg-0 d-flex align-items-stretch">
            <form id="form-agenda" method="post" role="form" class="php-email-form">
              <div class="row">
              	<div class="form-group col-md-3">
                  <label for="name">CPF</label>
                  <input type="text" name="cpf" class="form-control" id="cpf" required onblur="buscarDados()">
                </div>
                <div class="form-group col-md-6">
                  <label for="name">Nome</label>
                  <input type="text" name="nome" class="form-control" id="nome" required>
                </div>
                <div class="form-group col-md-3">
                  <label for="name">Telefone</label>
                  <input type="text" class="form-control" name="telefone" id="telefone" required>
                </div>
              </div>

              <div class="row">
	              <div class="form-group col-md-2">
	                <label for="name">Data</label>
	                <input type="date" class="form-control" onchange="listarHorarios()"  name="data" id="data" value="<?php echo $data_atual ?>" required>
	              </div>
             
	              <div class="form-group col-md-5">
	                <label for="name">Procedimento</label>
	               <select onchange="listarFuncionarios()" class="sel2" id="servico" name="servico"  required style="width:100%; height:45px !important"> 
							<option value="">Selecione um Serviço</option>

							<?php 
							$query = $pdo->query("SELECT * FROM procedimentos ORDER BY nome asc");
							$res = $query->fetchAll(PDO::FETCH_ASSOC);
							$total_reg = @count($res);									
							if($total_reg > 0){
								for($i=0; $i < $total_reg; $i++){
									foreach ($res[$i] as $key => $value){}
										$valor = $res[$i]['valor'];
									$valorF = number_format($valor, 2, ',', '.');

									echo '<option value="'.$res[$i]['id'].'">'.$res[$i]['nome'].' - R$ '.$valorF.'</option>';
								}
							}
							?>


						</select>    
	              </div>

	              <div class="form-group col-md-5">
	             	 <label for="name">Profissional</label>	
					<select class="form-control sel2" id="funcionario" name="funcionario" style="width:100%;" onchange="listarHorarios()" required> 				
						<option value="">Selecionar Profissional</option>

					</select>   
				
			</div>



	          </div>


	              <div class="row">
              	<div class="form-group col-md-12">
                  <label for="name">Observações Caso Exista</label>
                  <input type="text" name="obs" class="form-control" id="obs">
                </div>
               
              </div>


	          <div class="form-group"> 
					<small>								
					<div id="listar-horarios">
						
					</div>
				</small>
				</div>	
             

              <div class="my-3">
                <div class="loading">Carregando</div>
                
              </div>
              <div class="text-center"><button id="btn_agendar" type="submit">Confirmar Agendamento</button></div>

              <br>
             <small> <div align="center" id="mensagem"></div></small>

               <input type="hidden" id="nome_func" nome="nome_func">	

            </form>
          </div>

        </div>

    
    </section><!-- End Contact Section -->
</main>


<script src="sistema/painel/js/jquery-1.11.1.min.js"></script>

 <!-- Mascaras JS -->
<script type="text/javascript" src="sistema/painel/js/mascaras.js"></script>
	<!-- Ajax para funcionar Mascaras JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script> 

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
	<style type="text/css">
		.select2-selection__rendered {
			line-height: 45px !important;
			font-size:16px !important;
			color:#666666 !important;
		} 

		.select2-selection {
			height: 45px !important;
			font-size:16px !important;
			color:#666666 !important;
		} 

	</style> 

 <?php 
require_once("rodape.php");
 ?>



<script type="text/javascript">
	$(document).ready(function() {
		
		$('.sel2').select2({
			
		});

		listarFuncionarios();
	});
</script>

<script type="text/javascript">
	
	function buscarDados(){
		var cpf = $('#cpf').val();	
				
		$.ajax({
			url: "ajax/listar_dados.php",
			method: 'POST',
			data: {cpf},
			dataType: "text",

			success:function(result){
				var split = result.split("*");						
				
				$("#nome").val(split[0]);
				$("#telefone").val(split[1]);					
				
			}
		});	




	}
</script>



<script type="text/javascript">
	function listarFuncionarios(){	
		var serv = $("#servico").val();
		
		$.ajax({
			url: "ajax/listar-funcionarios.php",
			method: 'POST',
			data: {serv},
			dataType: "text",

			success:function(result){
				
				$("#funcionario").html(result);
			}
		});
	}
</script>




<script type="text/javascript">
	function listarHorarios(){	

		var funcionario = $("#funcionario").val();
		var data = $("#data").val();
		
		
		$.ajax({
			url: "ajax/listar-horarios.php",
			method: 'POST',
			data: {funcionario, data},
			dataType: "text",

			success:function(result){				
				$("#listar-horarios").html(result);			
				
			}
		});
	}
</script>




<script>

	$("#form-agenda").submit(function () {
		event.preventDefault();

		$('#btn_agendar').hide();
		$('#mensagem').text('Carregando!');

		var formData = new FormData(this);

		$.ajax({
			url: "ajax/agendar_temp.php",
			type: 'POST',
			data: formData,

			success: function (mensagem) {

				var msg = mensagem.split('*');
				var id_agd = msg[1];
				
				$('#mensagem').text('');
				$('#mensagem').removeClass()
				if (msg[0].trim() == "Pré Agendado") {                    
					$('#mensagem').text(msg[0])
					//buscarDados();

					window.location="pagamento/"+id_agd+"/100";

				}		

				 else {
					//$('#mensagem').addClass('text-danger')
					$('#mensagem').text(msg[0])
				}

				$('#btn_agendar').show();

			},

			cache: false,
			contentType: false,
			processData: false,

		});

	});

</script>

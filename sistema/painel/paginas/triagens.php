<?php 
$pag = 'triagens';


if(@$triagens == 'ocultar'){
	echo "<script>window.location='../index.php'</script>";
	exit();
}

$data_atual = date('Y-m-d');
$mes_atual = Date('m');
$ano_atual = Date('Y');
$data_inicio_mes = $ano_atual."-".$mes_atual."-01";

if($mes_atual == '4' || $mes_atual == '6' || $mes_atual == '9' || $mes_atual == '11'){
	$dia_final_mes = '30';
}else if($mes_atual == '2'){
	$bissexto = date('L', @mktime(0, 0, 0, 1, 1, $ano_atual));	if($bissexto == 1){
		$dia_final_mes = '29';	}else{
			$dia_final_mes = '28';
		}
	}else{
		$dia_final_mes = '31';
	}
	$data_final_mes = $ano_atual."-".$mes_atual."-".$dia_final_mes;

	?>




	<style>
		.linha-form {
			display: flex;
			flex-wrap: wrap;
			align-items: flex-start;
			justify-content: space-between;
		}

		.grupo-esquerda,
		.grupo-direita {
			display: flex;
			flex-wrap: wrap;
			align-items: center;
			gap: 10px;
		}

		.grupo-direita {
			margin-left: auto;
		}

		#btn-deletar {
			display: none;
		}

		@media (max-width: 768px) {
			.linha-form {
				flex-direction: column;
				align-items: stretch;
			}

			.grupo-esquerda,
			.grupo-direita {
				flex-direction: column;
				align-items: stretch;
				margin-left: 0;
			}

			.grupo-esquerda > * {
				width: 100%;
			}

			.grupo-direita {
				align-items: flex-start;
			}

			.grupo-direita > * {
				width: 100%;
			}
		}
	</style>

	<div class="margem_mobile">
		<form method="POST" action="rel/lista_triagens_class.php" target="_blank">
			<div class="linha-form">

				<!-- Grupo da esquerda -->
				<div class="grupo-esquerda">

					<button type="button" onclick="inserir()" class="btn btn-primary">
						<i class="fa fa-plus"></i> Nova Triagem
					</button>


					<div style="display: flex; align-items: center;">
						<i class="fa fa-calendar-o" title="Data de Vencimento Inicial" style="margin-right: 5px;"></i>
						<input type="date" class="form-control" name="dataInicial" id="dataInicial"
						value="<?php echo $data_atual ?>" required onchange="buscar()">
					</div>

					<div style="display: flex; align-items: center;">
						<i class="fa fa-calendar-o" title="Data de Vencimento Final" style="margin-right: 5px;"></i>
						<input type="date" class="form-control" name="dataFinal" id="dataFinal"
						value="<?php echo $data_atual ?>" required onchange="buscar()">
					</div>
				</div>

				<!-- Grupo da direita -->
				<div class="grupo-direita">
					<button type="submit" class="btn btn-success">Relatório</button>
				</div>

			</div>
		</form>
	</div>


	<div class="bs-example widget-shadow" style="padding:15px" id="listar">

	</div>

	<input type="hidden" id="ids">



	<!-- Modal Perfil -->
<div class="modal fade" id="modalForm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel"><span id="titulo_inserir"></span></h4>
        <button id="btn-fechar" type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -25px">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="form_triagem">
        <div class="modal-body">        

          
          <div class="row">

          	<div class="col-md-6">	
							<div class="form-group"> 
								<label>Paciente</label> 
								<div id="listar_pacientes"></div>							
							</div>		
				</div>	


						<div class="col-md-2" style="margin-top: 22px; margin-left: -10px">
							<button id="btn_cliente" type="button" data-toggle="modal" data-target="#modalPacientes" class="btn btn-primary"> <i class="fa fa-plus"></i> </button>	

							<button id="btn_cliente_editar" onclick="editarPac()" type="button" class="btn btn-info"> <i class="fa fa-edit"></i> </button>		

						</div>


            <div class="col-md-4">
              <label>Classificação de Risco</label>
              <select class="form-control" name="risco" id="risco">  		        
		        <option value="Azul">🔵 Azul – Não Urgente</option>
		        <option value="Verde">🟢 Verde – Pouca Urgência</option>
		        <option value="Amarelo">🟡 Amarelo – Urgência</option>
		        <option value="Laranja">🟠 Laranja – Muita Urgência</option>
		        <option value="Vermelho">🔴 Vermelho – Emergência</option>
              </select>
            </div>
            
          </div>

          <div class="row">
          	<div class="col-md-12">
              <label>Motivo da Procura/Queixa Principal</label>
              <input type="text" class="form-control" id="queixa" name="queixa" placeholder="Descreva a queixa do paciente" required>				
          </div>
          	
          </div>


          <div class="row ">

    <div class="col-md-2">
        <label for="pa">PA (mmHg)</label>
            <input type="text" class="form-control" id="pa" name="pa" placeholder="PA">         
    </div>

    <div class="col-md-2">
        <label for="fc">FC (bpm)</label>
            <input type="number" class="form-control" id="fc" name="fc" placeholder="FC">
          
    </div>

    <div class="col-md-2">
        	<label for="fr">FR (irpm)</label>
            <input type="number" class="form-control" id="fr" name="fr" placeholder="FR">       
    </div>

    <div class="col-md-3">
        	<label for="temperatura">Temperatura (°C)</label>
            <input type="number" step="0.1" class="form-control" id="temperatura" name="temperatura" placeholder="Temperatura">          
    </div>

    <div class="col-md-3">
        	 <label for="saturacao">Saturação (%)</label>
            <input type="number" step="0.1" class="form-control" id="saturacao" name="saturacao" placeholder="Saturação">           
       
    </div>

</div>




 <div class="row">
          	<div class="col-md-6">
              <label>Alergias</label>
              <input type="text" class="form-control" id="alergias" name="alergias" placeholder="Caso tenha alguma alergia" >				
          </div>


          <div class="col-md-6">
              <label>Uso de Medicamentos Atuais</label>
              <input type="text" class="form-control" id="medicamentos" name="medicamentos" placeholder="Caso esteja usando algum medicamento" >				
          </div>
          	
          </div>



 <div class="row">
          	<div class="col-md-8">
              <label>Histórico de Doenças</label>
              <input type="text" class="form-control" id="historico" name="historico" placeholder="Histórico de Doenças" >				
          </div>


          <div class="col-md-4">
              <label>Tempo do Início dos Sintomas</label>
              <input type="text" class="form-control" id="inicio_sintomas" name="inicio_sintomas" placeholder="Ex: Há 3 dias, há um mes, etc" >				
          </div>
          	
          </div>



           <div class="row">
          	<div class="col-md-10">
              <label>Condição Geral do Paciente</label>
              <input type="text" class="form-control" id="condicao_geral" name="condicao_geral" placeholder="Exemplo: Alerta, Sonolento, Inconsciente (pode ser um select ou radio)" >				
          </div>


          <div class="col-md-2">
              <label>Escala de Dor</label>
              <input type="number" class="form-control" id="escala_dor" name="escala_dor" placeholder="De 0 a 10" >				
          </div>
          	
          </div>


          <input type="hidden" class="form-control" id="id" name="id">
          <small><div id="mensagem" align="center"></div></small>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Salvar</button>
        </div>
      </form>
    </div>
  </div>
</div>





<!-- Modal Pacientes -->
<div class="modal fade" id="modalPacientes" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel">Novo Paciente</h4>
        <button id="btn-fechar-pacientes" type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -25px">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="form-pacientes">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-3">
              <label>Nome</label>
              <input type="text" class="form-control" id="nome" name="nome" placeholder="Seu Nome" required>
            </div>
            <div class="col-md-3">
              <label>CPF</label>
              <input type="text" class="form-control" id="cpf" name="cpf" placeholder="CPF">
            </div>
            <div class="col-md-3">
              <label>Telefone</label>
              <input type="text" class="form-control" id="telefone" name="telefone" placeholder="Seu Telefone" required>
            </div>
            <div class="col-md-3">
              <label>Data Nascimento</label>
              <input type="date" class="form-control" id="data_nasc" name="data_nasc" required>
            </div>
          </div>
          <div class="row">
            <div class="col-md-5">
              <label>Profissão</label>
              <input type="text" class="form-control" name="profissao" id="profissao">
            </div>
            <div class="col-md-2">
              <label>Sexo</label>
              <select class="form-control" name="sexo" id="sexo">
                <option value="M">M</option>
                <option value="F">F</option>
              </select>
            </div>
            <div class="col-md-2">
              <label>Tipo Sanguíneo</label>
              <select class="form-control" name="tipo_sanguineo" id="tipo_sanguineo">
                <option value="O">O</option>
                <option value="A">A</option>
                <option value="B">B</option>
                <option value="AB">AB</option>
              </select>
            </div>
            <div class="col-md-3">
              <label>Convênio</label>
              <select class="form-control" name="convenio" id="convenio">
                <option value="0">Nenhum</option>
                <?php 
                $query = $pdo->query("SELECT * from convenios order by id asc");
                $res = $query->fetchAll(PDO::FETCH_ASSOC);
                $linhas = @count($res);
                if($linhas > 0){
                  for($i=0; $i<$linhas; $i++){ ?>
                    <option value="<?php echo $res[$i]['id'] ?>"><?php echo $res[$i]['nome'] ?></option>
                <?php } } ?>
              </select>
            </div>
          </div>
          <div class="row">
            <div class="col-md-8">
              <label>Endereço</label>
              <input type="text" class="form-control" id="endereco" name="endereco" placeholder="Seu Endereço">
            </div>
            <div class="col-md-4">
              <label>Estado Cívil</label>
              <select class="form-control" name="estado_civil" id="estado_civil">
                <option value="Solteiro">Solteiro(a)</option>
                <option value="Casado">Casado(a)</option>
                <option value="Víuvo">Víuvo(a)</option>
                <option value="Divorciado">Divorciado(a)</option>
              </select>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <label>Observações</label>
              <input type="text" class="form-control" name="obs" id="obs_pac">
            </div>
          </div>
          <hr>
          <div class="row">
          		<div class="col-md-3">	
							<label>Cartão SUS</label>
							<input type="text" class="form-control" id="cartao_sus" name="cartao_sus" placeholder="Se Houver">						
						</div>	


            <div class="col-md-5">
              <label>Nome Responsável</label>
              <input type="text" class="form-control" id="nome_responsavel" name="nome_responsavel" placeholder="Seu Nome">
            </div>
            <div class="col-md-3">
              <label>CPF Responsável</label>
              <input type="text" class="form-control" id="cpf_responsavel" name="cpf_responsavel" placeholder="CPF Responsável">
            </div>
          </div>
          <input type="hidden" name="id" id="id_paciente">
          <small><div id="mensagem_pacientes" align="center"></div></small>
        </div>
        <div class="modal-footer">
          <button id="btn_salvar_pacientes" type="submit" class="btn btn-primary">Salvar</button>
        </div>
      </form>
    </div>
  </div>
</div>









<!-- Modal Consulta / Agendamento -->
<div class="modal fade" id="modalConsulta" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
	<div class="modal-dialog" role="document" style="overflow-y: auto; max-height: 90vh;">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="">Consulta: <span id="nome_do_paciente"></span></h4>
				<button id="btn-fechar-consulta" type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -20px">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form method="post" id="form_consulta">
				<div class="modal-body">
					<div class="row">							
						
						<div class="col-md-12 ">
							<div class="form-group">
								<label>Profissional </label> 			
								<select class="form-control sel3" id="funcionario_modal" name="funcionario" style="width:100%;" onchange="listarServicos()"> 
									<?php if($id_func == ""){ ?>
									<option value="">Selecione um Profissional</option>
									<?php 
									$query = $pdo->query("SELECT * FROM usuarios where atendimento = 'Sim' ORDER BY id desc");
									$res = $query->fetchAll(PDO::FETCH_ASSOC);
									$total_reg = @count($res);
									if($total_reg > 0){
										for($i=0; $i < $total_reg; $i++){
											foreach ($res[$i] as $key => $value){}
												echo '<option value="'.$res[$i]['id'].'">'.$res[$i]['nome'].'</option>';
										}
									}
								}else{
									echo '<option value="'.$id_usuario.'">'.$nome_usuario.'</option>';
								}
								?>
								</select>   
							</div> 	
						</div>
					</div>
					<div class="row">	
						<div class="col-md-12">						
							<div class="form-group"> 
								<label>Procedimento</label> 
								<select class="form-control sel3" id="servico" name="servico" style="width:100%;" required></select>    
							</div>						
						</div>					
						
					</div>
					<div class="row">
						<div class="col-md-12">						
							<div class="form-group"> 
								<label>OBS <small>(Máx 100 Caracteres)</small></label> 
								<input maxlength="100" type="text" class="form-control" name="obs" id="obs">
							</div>						
						</div>
						
					</div>
					
					
					<hr>
					<br>
					<input type="hidden" name="id" id="id_triagem_consulta">					
					<input type="hidden" name="paciente_consulta" id="paciente_consulta">
					<input type="hidden" name="risco_consulta" id="risco_consulta">
					<input type="hidden" name="id_agendamento" id="id_agendamento">
									
				</div>
				<div class="modal-footer">
					<button id="btn_salvar_consulta" type="submit" class="btn btn-primary">Salvar</button>
				</div>
			</form>
		</div>
	</div>
</div>




	<script type="text/javascript">var pag = "<?=$pag?>"</script>

	<script src="js/ajax.js"></script>

	<script type="text/javascript">
		$(document).ready( function () {

			setTimeout(function() {
				buscar();
				listarPacientes();
			}, 500)
			$('.sel2').select2({
				dropdownParent: $('#modalForm')
			});	
			$('.sel3').select2({

			dropdownParent: $('#modalConsulta')

		});	
		});



		function buscar(){
			var dataInicial = $('#dataInicial').val();
			var dataFinal = $('#dataFinal').val();
			listar(dataInicial, dataFinal)
		}


	</script>





<script>
	$("#form-pacientes").submit(function () {
		$('#mensagem_pacientes').text('Carregando...');
		$('#btn_salvar_pacientes').hide();
		event.preventDefault();
		var paciente = $('#id_paciente').val();
		var formData = new FormData(this);
		$.ajax({
			url: 'paginas/pacientes/salvar.php',
			type: 'POST',
			data: formData,

			success: function (mensagem) {							

				$('#mensagem_pacientes').text('');
				$('#mensagem_pacientes').removeClass()
				if (mensagem.trim() == "Salvo com Sucesso") {                 
					$('#btn-fechar-pacientes').click();
					if(paciente == ""){
							//listar();					
                	listarPacientes('1');
                }
				
				} else {
					$('#mensagem_pacientes').addClass('text-danger')
					$('#mensagem_pacientes').text(mensagem)
				}

				$('#btn_salvar_pacientes').show();
			},
			cache: false,
			contentType: false,
			processData: false,

		});	});
</script>


<script type="text/javascript">
	function listarPacientes(valor){
	$.ajax({
        url: 'paginas/agendamentos/listar_pacientes.php',
        method: 'POST',
        data: {valor},
        dataType: "html",

        success:function(result){
            $("#listar_pacientes").html(result);           
        }
    });
}



function editarPac(){
	var paciente = $("#cliente").val();	
	if(paciente == ""){
		alert('Selecione um paciente para edição');
		return;
	}

	$('#modalPacientes').modal('show');


	$.ajax({
        url: 'paginas/agendamentos/buscar_dados_paciente.php',
        method: 'POST',
        data: {paciente},
        dataType: "html",

        success:function(result){
        	var dados = result.split("*");

        	$('#id_paciente').val(paciente);

    	$('#nome').val(dados[0]);

    	$('#cpf').val(dados[1]);

    	$('#telefone').val(dados[2]);

    	$('#endereco').val(dados[3]);

    	$('#data_nasc').val(dados[4]);

    	$('#nome_responsavel').val(dados[5]);

    	$('#tipo_sanguineo').val(dados[6]).change();

    	$('#convenio').val(dados[7]).change();

    	$('#cpf_responsavel').val(dados[8]);

    	

    	$('#sexo').val(dados[9]).change();

    	$('#obs_pac').val(dados[10]);

    	$('#estado_civil').val(dados[11]);

    	$('#profissao').val(dados[12]);

    	$('#telefone2').val(dados[13]);
    	$('#cartao_sus').val(dados[14]);

        }
    });
	
}




$("#form_triagem").submit(function () {
    event.preventDefault();
    var formData = new FormData(this);
    $.ajax({
        url: 'paginas/' + pag + "/salvar.php",
        type: 'POST',
        data: formData,
        success: function (mensagem) {
            $('#mensagem').text('');
            $('#mensagem').removeClass()
            if (mensagem.trim() == "Salvo com Sucesso") {
                $('#btn-fechar').click();
                buscar();          
            } else {
                alertWarning(mensagem)
            }
        },
        cache: false,
        contentType: false,
        processData: false,
    });
});



function listarServicos(){	
		var func = $("#funcionario_modal").val();

		$.ajax({
			url: 'paginas/agendamentos/listar-servicos.php',
			method: 'POST',
			data: {func},
			dataType: "text",
			success:function(result){
				$("#servico").html(result);
			}
		});

	}



$("#form_consulta").submit(function () {
    event.preventDefault();
    var formData = new FormData(this);
    $.ajax({
        url: 'paginas/' + pag + "/salvar_consulta.php",
        type: 'POST',
        data: formData,
        success: function (mensagem) {           
           if (mensagem.trim() == "Salvo com Sucesso") {
                $('#btn-fechar-consulta').click();
                buscar();          
            } else {
                alertWarning(mensagem)
            }
        },
        cache: false,
        contentType: false,
        processData: false,
    });
});
</script>
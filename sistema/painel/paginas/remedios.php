<?php 
$pag = 'remedios';

//verificar se ele tem a permissão de estar nessa página
if(@$remedios == 'ocultar'){
    echo "<script>window.location='../index.php'</script>";
    exit();
}
 ?>
<div class="margem_mobile">
<form method="POST" action="rel/remedios_class.php" target="_blank">

<div class="row">
	<div class="col-md-7">
		<a style="display: inline-block;" style="" onclick="inserir()" type="button" class="btn btn-primary"><span class="fa fa-plus"></span> Medicamento</a>

<li class="dropdown head-dpdn2" style="display: inline-block;">		
		<a href="#" data-toggle="dropdown"  class="btn btn-danger dropdown-toggle" id="btn-deletar" style="display:none"><span class="fa fa-trash-o"></span> Deletar</a>

		<ul class="dropdown-menu">
		<li>
		<div class="notification_desc2">
		<p>Excluir Selecionados? <a href="#" onclick="deletarSel()"><span class="text-danger">Sim</span></a></p>
		</div>
		</li>										
		</ul>
</li>


<select class="form-control sel3" name="filtro" id="filtro" style="width:180px; display: inline-block;" onchange="buscar()">
	<option value="">Filtrar Medicamentos</option>
	<option value="estoque">Estoque Baixo</option>
	<option value="vencendo">Vencendo este Mês</option>
	<option value="vencido">Vencidos</option>							 	
</select>	
</div>			

<div class="col-md-5" align="right">
<button type="submit" class="btn btn-success botao_rel" >Relatório</button>
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
			<form id="form">
			<div class="modal-body">
				

					<div class="row">
						<div class="col-md-2">						
								<label>Código</label>
								<input type="text" class="form-control" id="codigo" name="codigo" placeholder="Código de Barras">					
						</div>

						<div class="col-md-5">						
								<label>Nome</label>
								<input type="text" class="form-control" id="nome" name="nome" placeholder="" required>					
						</div>

						<div class="col-md-5">						
								<label>Nome Químico</label>
								<input type="text" class="form-control" id="nome_quimico" name="nome_quimico" placeholder="" required>					
						</div>
					</div>

						<div class="row">
						<div class="col-md-4">						
								<label>Laboratório</label>
								<input type="text" class="form-control" id="laboratorio" name="laboratorio" placeholder="">					
						</div>

						<div class="col-md-4">						
								<label>Forma Farmaceutica</label>
								<input type="text" class="form-control" id="forma_farmaceutica" name="forma_farmaceutica" placeholder="" >					
						</div>

						<div class="col-md-4">						
								<label>Apresentação</label>
								<input type="text" class="form-control" id="apresentacao" name="apresentacao" placeholder="" >					
						</div>
					</div>


					<div class="row">
						<div class="col-md-3">	
							<label>Tipo Unidade</label>
								<select class="form-control" id="unidade" name="unidade" >
									<option value="Caixa">Caixa</option>
									<option value="Frasco">Frasco</option>
									<option value="Cartela">Cartela</option>
									<option value="Cápsula">Cápsula</option>
									<option value="Pacote">Pacote</option>
								</select>	
						</div>

						<div class="col-md-2">	
							<label>Valor Compra</label>
								<input type="text" class="form-control" id="valor_custo" name="valor_custo" placeholder="Valor Compra" >	
						</div>

						<div class="col-md-2">	
							<label>Valor Venda</label>
								<input type="text" class="form-control" id="valor_venda" name="valor_venda" placeholder="Valor Venda" >	
						</div>

						<div class="col-md-2">	
							<label>Estoque</label>
								<input type="number" class="form-control" id="estoque" name="estoque" placeholder="Estoque" <?php if($nivel_usuario != 'Administrador'){ ?> readonly <?php } ?>>	
						</div>

						<div class="col-md-3">	
							<label>Nível Estoque</label>
								<input type="number" class="form-control" id="estoque_minimo" name="estoque_minimo" placeholder="Nível Mínimo" >	
						</div>
					</div>

						

					<div class="row">
						<div class="col-md-3">						
								<label>Antibiótico?</label>
								<select class="form-control" id="antibiotico" name="antibiotico" >
									<option value="Não">Não</option>
									<option value="Sim">Sim</option>									
								</select>					
						</div>

						<div class="col-md-6">						
								<label>Lote</label>
								<input type="text" class="form-control" id="lote" name="lote" placeholder="" >					
						</div>

						<div class="col-md-3">						
								<label>Validade</label>
								<input type="date" class="form-control" id="validade" name="validade" placeholder="" required="">					
						</div>

						
					</div>


					<div class="row">
						<div class="col-md-12">						
								<label>Informações Adicionais</label>
								<input type="text" class="form-control" id="obs" name="obs" placeholder="Demais Observações" >					
						</div>
					</div>


					<input type="hidden" class="form-control" id="id" name="id">					

				<br>
				<small><div id="mensagem" align="center"></div></small>
			</div>
			<div class="modal-footer">       
				<button type="submit" id="btn_salvar" class="btn btn-primary">Salvar</button>
			</div>
			</form>
		</div>
	</div>
</div>








<!-- ModalMostrar -->
<div class="modal fade" id="modalMostrar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="tituloModal"><span id="nome_mostrar"> </span></h4>
				<button id="btn-fechar-excluir" type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -20px">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">	

				<div class="row" style="border-bottom: 1px solid #cac7c7;">	
					<div class="col-md-12">	
						<span><b>Código: </b></span>
						<span id="codigo_mostrar"></span>
					</div>
				</div>

				<div class="row" style="border-bottom: 1px solid #cac7c7;">	
					<div class="col-md-12">	
						<span><b>Nome Químico: </b></span>
						<span id="nome_quimico_mostrar"></span>
					</div>
				</div>

				<div class="row" style="border-bottom: 1px solid #cac7c7;">	
					<div class="col-md-12">	
						<span><b>Laboratório: </b></span>
						<span id="laboratorio_mostrar"></span>
					</div>
				</div>

				<div class="row" style="border-bottom: 1px solid #cac7c7;">	
					<div class="col-md-12">	
						<span><b>Forma Farmaceutica: </b></span>
						<span id="forma_farmaceutica_mostrar"></span>
					</div>
				</div>

				<div class="row" style="border-bottom: 1px solid #cac7c7;">	
					<div class="col-md-12">	
						<span><b>Apresentação: </b></span>
						<span id="apresentacao_mostrar"></span>
					</div>
				</div>

				<div class="row" style="border-bottom: 1px solid #cac7c7;">	
					<div class="col-md-12">	
						<span><b>Unidade: </b></span>
						<span id="unidade_mostrar"></span>
					</div>
				</div>

				<div class="row" style="border-bottom: 1px solid #cac7c7;">	
					<div class="col-md-12">	
						<span><b>Estoque: </b></span>
						<span id="estoque_mostrar"></span>
					</div>
				</div>

				<div class="row" style="border-bottom: 1px solid #cac7c7;">	
					<div class="col-md-12">	
						<span><b>Estoque Mínimo: </b></span>
						<span id="estoque_minimo_mostrar"></span>
					</div>
				</div>

				<div class="row" style="border-bottom: 1px solid #cac7c7;">	
					<div class="col-md-12">	
						<span><b>Antibiótico: </b></span>
						<span id="antibiotico_mostrar"></span>
					</div>
				</div>

				<div class="row" style="border-bottom: 1px solid #cac7c7;">	
					<div class="col-md-12">	
						<span><b>Valor Custo: </b></span>
						<span id="valor_custo_mostrar"></span>
					</div>
				</div>

				<div class="row" style="border-bottom: 1px solid #cac7c7;">	
					<div class="col-md-12">	
						<span><b>Valor Venda: </b></span>
						<span id="valor_venda_mostrar"></span>
					</div>
				</div>

				<div class="row" style="border-bottom: 1px solid #cac7c7;">	
					<div class="col-md-12">	
						<span><b>Observações Adicionais: </b></span>
						<span id="obs_mostrar"></span>
					</div>
				</div>

				<div class="row" style="border-bottom: 1px solid #cac7c7;">	
					<div class="col-md-12">	
						<span><b>Lote: </b></span>
						<span id="lote_mostrar"></span>
					</div>
				</div>

					<div class="row" style="border-bottom: 1px solid #cac7c7;">	
					<div class="col-md-12">	
						<span><b>Validade: </b></span>
						<span id="validade_mostrar"></span>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>





<!-- Modal Saida-->
<div class="modal fade" id="modalSaida" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="exampleModalLabel"><span id="nome_saida"></span></h4>
				<button id="btn-fechar-saida" type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -20px">
					<span aria-hidden="true" >&times;</span>
				</button>
			</div>
			
			<form id="form-saida">
			<div class="modal-body">
				

				<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								
								<input type="number" class="form-control" id="quantidade_saida" name="quantidade_saida" placeholder="Quantidade Saída" required>    
							</div> 	
						</div>

						<div class="col-md-8">
							<div class="form-group">								
								<input type="text" class="form-control" id="motivo_saida" name="motivo_saida" placeholder="Motivo Saída" required>    
							</div> 	
						</div>
						
					</div>	



					<div class="row">

						<div class="col-md-6">
							<div class="form-group">								
								<select class="form-control sel4" id="medico" name="medico" style="width:100%;" > 
									<option value="">Selecione um Médico</option>
									<?php 
									$query = $pdo->query("SELECT * FROM usuarios where atendimento = 'Sim' ORDER BY nome asc");
									$res = $query->fetchAll(PDO::FETCH_ASSOC);
									$total_reg = @count($res);
									if($total_reg > 0){
										for($i=0; $i < $total_reg; $i++){
											foreach ($res[$i] as $key => $value){}
												echo '<option value="'.$res[$i]['id'].'">'.$res[$i]['nome'].'</option>';
										}
									}
									?>
								</select>   
							</div> 	
						</div>


						<div class="col-md-6">
							<div class="form-group">								
								<select class="form-control sel4" id="paciente" name="paciente" style="width:100%;" > 
									<option value="">Selecione um Paciente</option>
									<?php 
									$query = $pdo->query("SELECT * FROM pacientes ORDER BY nome asc");
									$res = $query->fetchAll(PDO::FETCH_ASSOC);
									$total_reg = @count($res);
									if($total_reg > 0){
										for($i=0; $i < $total_reg; $i++){
											foreach ($res[$i] as $key => $value){}
												echo '<option value="'.$res[$i]['id'].'">'.$res[$i]['nome'].'</option>';
										}
									}
									?>
								</select>   
							</div> 	
						</div>

					</div>
				
				<input type="hidden" id="id_saida" name="id">
				<input type="hidden" id="estoque_saida" name="estoque">

				

				<br>
					<small><div id="mensagem-saida" align="center"></div></small>
			</div>

			<div class="modal-footer">       
				<button type="submit" class="btn btn-primary">Salvar</button>
			</div>
			</form>
			
		</div>
	</div>
</div>





<!-- Modal Entrada-->
<div class="modal fade" id="modalEntrada" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="exampleModalLabel"><span id="nome_entrada"></span></h4>
				<button id="btn-fechar-entrada" type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -20px">
					<span aria-hidden="true" >&times;</span>
				</button>
			</div>
			
			<div class="modal-body">
				<form id="form-entrada">

				<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								
								<input type="number" class="form-control" id="quantidade_entrada" name="quantidade_entrada" placeholder="Quantidade Entrada" required>    
							</div> 	
						</div>

						<div class="col-md-5">
							<div class="form-group">								
								<input type="text" class="form-control" id="motivo_entrada" name="motivo_entrada" placeholder="Motivo Entrada" required>    
							</div> 	
						</div>
						<div class="col-md-3">
							<button type="submit" class="btn btn-primary">Salvar</button>
						
						</div>
					</div>	
				
				<input type="hidden" id="id_entrada" name="id">
				<input type="hidden" id="estoque_entrada" name="estoque">

				</form>

				<br>
					<small><div id="mensagem-entrada" align="center"></div></small>
			</div>

			
		</div>
	</div>
</div>







<script type="text/javascript">var pag = "<?=$pag?>"</script>
<script src="js/ajax.js"></script>

<script type="text/javascript">
	$(document).ready( function () {
		$('.sel2').select2({
			dropdownParent: $('#modalForm')
		});

		$('.sel3').select2({
			
		});

		$('.sel4').select2({
			dropdownParent: $('#modalSaida')
		});
	});
</script>


<script type="text/javascript">
	function carregarImg() {
    var target = document.getElementById('target');
    var file = document.querySelector("#foto").files[0];
    
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
	

$("#form-saida").submit(function () {

    event.preventDefault();
    var formData = new FormData(this);

    $.ajax({
        url: 'paginas/' + pag + "/saida.php",
        type: 'POST',
        data: formData,

        success: function (mensagem) {
            $('#mensagem-saida').text('');
            $('#mensagem-saida').removeClass()
            if (mensagem.trim() == "Salvo com Sucesso") {

                $('#btn-fechar-saida').click();
                listar();          

            } else {

                $('#mensagem-saida').addClass('text-danger')
                $('#mensagem-saida').text(mensagem)
            }


        },

        cache: false,
        contentType: false,
        processData: false,

    });

});
</script>





 <script type="text/javascript">
	

$("#form-entrada").submit(function () {

    event.preventDefault();
    var formData = new FormData(this);

    $.ajax({
        url: 'paginas/' + pag + "/entrada.php",
        type: 'POST',
        data: formData,

        success: function (mensagem) {
            $('#mensagem-entrada').text('');
            $('#mensagem-entrada').removeClass()
            if (mensagem.trim() == "Salvo com Sucesso") {

                $('#btn-fechar-entrada').click();
                listar();          

            } else {

                $('#mensagem-entrada').addClass('text-danger')
                $('#mensagem-entrada').text(mensagem)
            }


        },

        cache: false,
        contentType: false,
        processData: false,

    });

});


function buscar(){
	var busca = $('#filtro').val();
	listar(busca)
}
</script>
<?php 
$pag = 'vendas_medicamentos';

//verificar se ele tem a permissão de estar nessa página
if(@$vendas_medicamentos == 'ocultar'){
    echo "<script>window.location='../index.php'</script>";
    exit();
}

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
  <form method="POST" action="rel/vendas_class.php" target="_blank">
    <div class="linha-form">

      <!-- Grupo da esquerda -->
      <div class="grupo-esquerda">

        <button type="button" onclick="inserir()" class="btn btn-primary">
          <i class="fa fa-plus"></i> Nova Venda
        </button>

        

        <div style="display: flex; align-items: center;">
          <i class="fa fa-calendar-o" title="Data de Vencimento Inicial" style="margin-right: 5px;"></i>
          <input type="date" class="form-control" name="dataInicial" id="dataInicial"
            value="<?php echo $data_inicio_mes ?>" required onchange="buscar()">
        </div>

        <div style="display: flex; align-items: center;">
          <i class="fa fa-calendar-o" title="Data de Vencimento Final" style="margin-right: 5px;"></i>
          <input type="date" class="form-control" name="dataFinal" id="dataFinal"
            value="<?php echo $data_final_mes ?>" required onchange="buscar()">
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
<div class="modal fade" id="modalForm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="exampleModalLabel">Venda: R$ <span id="total_venda"></span></span></h4>
				<button id="btn-fechar" type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -25px">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="form_venda">
			<div class="modal-body">
				

					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>Paciente</label>
								<select class="form-control sel2" name="cliente" id="cliente" style="width:100%;">
									<option value="">Selecionar Paciente</option>
									<?php 
									$query = $pdo->query("SELECT * FROM pacientes order by nome asc");
									$res = $query->fetchAll(PDO::FETCH_ASSOC);
									for($i=0; $i < @count($res); $i++){
										foreach ($res[$i] as $key => $value){}	?>	
										<option value="<?php echo $res[$i]['id'] ?>"><?php echo $res[$i]['nome'] ?> - <?php echo $res[$i]['cpf'] ?></option>
									<?php } ?>
								</select>
							</div>				

						</div>
					</div>

						<div class="row">
						<div class="col-md-3">						
								<label>Quantidade</label>
								<input type="text" class="form-control" id="quantidade" name="quantidade" placeholder="" value="1">					
						</div>

						<div class="col-md-8">
							<div class="form-group">
								<label>Medicamento</label>
								<select class="form-control sel2" name="medicamento" id="medicamento" style="width:100%;">									
									<?php 
									$query = $pdo->query("SELECT * FROM remedios where estoque > 0 order by nome asc");
									$res = $query->fetchAll(PDO::FETCH_ASSOC);
									for($i=0; $i < @count($res); $i++){
										foreach ($res[$i] as $key => $value){}	?>	
										<option value="<?php echo $res[$i]['id'] ?>"><?php echo $res[$i]['nome'] ?> / <?php echo $res[$i]['estoque'] ?> Unidades</option>
									<?php } ?>
								</select>
							</div>				

						</div>

						<div class="col-md-1" style="margin-top: 24px; padding:0">						
								<button type="button" onclick="addMedicamento()" class="btn btn-success"><i class="fa fa-check"></i></button>				
						</div>

						
					</div>


					<div class="row">
						
						<div class="col-md-4">						
								<label>Data Pgto</label>
								<input type="date" class="form-control" id="data_pgto" name="data_pgto" placeholder="" required="" value="<?php echo date('Y-m-d') ?>">					
						</div>

						<div class="col-md-4">					
							<div class="form-group"> 
								<label>Forma de Pgto</label> 
								<select class="form-control" name="forma_pgto" id="forma_pgto" required=""> 
									<option value="">Selecionar Forma Pgto</option>
									<?php 
									$query = $pdo->query("SELECT * FROM formas_pgto order by id asc");
									$res = $query->fetchAll(PDO::FETCH_ASSOC);
									for($i=0; $i < @count($res); $i++){
										foreach ($res[$i] as $key => $value){}
											?>	
										<option value="<?php echo $res[$i]['nome'] ?>"><?php echo $res[$i]['nome'] ?></option>
									<?php } ?>
								</select>
							</div>				
						</div>

						<div class="col-md-4">						
								<label>Desconto R$</label>
								<input type="text" class="form-control" id="desconto" name="desconto" placeholder="Desconto em Reais"  value="" onkeyup="listarItens()">					
						</div>	

						
					</div>

					<hr>

					<div id="listar_itens"></div>
											

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
									<img src="images/arquivos/sem-foto.png"  width="60px" id="target-arquivos">		
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
</div>



<!-- Modal -->
<div class="modal fade" id="modalBaixar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <h4 class="modal-title" id="tituloModal">Baixar Conta: <span id="descricao-baixar"></span></h4>
        <button id="btn-fechar-baixar" type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -20px">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form id="form-baixar" method="post">
        <div class="modal-body">

          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Valor <small class="text-muted">(Total ou Parcial)</small></label>
                <input onkeyup="totalizar()" type="text" class="form-control" name="valor-baixar" id="valor-baixar" required>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label>Local Saída</label>
                <select class="form-control sel4" name="saida-baixar" id="saida-baixar" required style="width:100%;">
                  <?php 
                    $query = $pdo->query("SELECT * FROM formas_pgto order by id asc");
                    $res = $query->fetchAll(PDO::FETCH_ASSOC);
                    for($i=0; $i < @count($res); $i++){
                      foreach ($res[$i] as $key => $value){}
                  ?>
                    <option value="<?php echo $res[$i]['nome'] ?>"><?php echo $res[$i]['nome'] ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-4">
              <div class="mb-3">
                <label class="form-label">Multa em R$</label>
                <input onkeyup="totalizar()" type="text" class="form-control" name="valor-multa" id="valor-multa" placeholder="Ex 15.00" value="0">
              </div>
            </div>

            <div class="col-md-4">
              <div class="mb-3">
                <label class="form-label">Júros em R$</label>
                <input onkeyup="totalizar()" type="text" class="form-control" name="valor-juros" id="valor-juros" placeholder="Ex 0.15" value="0">
              </div>
            </div>

            <div class="col-md-4">
              <div class="mb-3">
                <label class="form-label">Desconto em R$</label>
                <input onkeyup="totalizar()" type="text" class="form-control" name="valor-desconto" id="valor-desconto" placeholder="Ex 15.00" value="0">
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Data da Baixa</label>
                <input type="date" class="form-control" name="data-baixar" id="data-baixar" value="<?php echo date('Y-m-d') ?>">
              </div>
            </div>

            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">SubTotal</label>
                <input type="text" class="form-control" name="subtotal" id="subtotal" readonly>
              </div>
            </div>
          </div>

          <small><div id="mensagem-baixar" align="center"></div></small>
          <input type="hidden" class="form-control" name="id-baixar" id="id-baixar">
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Baixar</button>
        </div>
      </form>

    </div>
  </div>
</div>



<script type="text/javascript">var pag = "<?=$pag?>"</script>
<script src="js/ajax.js"></script>

<script type="text/javascript">
	$(document).ready( function () {
		listarItens();
		setTimeout(function() {
  buscar();
}, 500)
		$('.sel2').select2({
			dropdownParent: $('#modalForm')
		});		
	});

function buscar(){
	var dataInicial = $('#dataInicial').val();
	var dataFinal = $('#dataFinal').val();
	listar(dataInicial, dataFinal)
}

function addMedicamento(){
	var medicamento = $('#medicamento').val();
	var quantidade = $('#quantidade').val();
	var cliente = $('#cliente').val();

	if(cliente == ""){
		alertWarning('Selecione um Paciente');
		return;
	}

	if(quantidade == ""){
		alertWarning('Selecione uma Quantidade');
		return;
	}

	if(medicamento == ""){
		alertWarning('Selecione um Medicamento');
		return;
	}


	 $.ajax({
        url: 'paginas/' + pag + "/add_medicamento.php",
        method: 'POST',
        data: {medicamento, quantidade, cliente},
        dataType: "html",
        success:function(result){
        	if(result.trim() === "Salvo com Sucesso"){
        		listarItens();  
        	}else{
        		alertWarning(result)
        	}
                    
        }
    });
}


function listarItens(){
	var desconto = $('#desconto').val();
	if(desconto == ""){
		desconto = 0;
	}

	 $.ajax({
        url: 'paginas/' + pag + "/listar_itens.php",
        method: 'POST',
        data: {desconto},
        dataType: "html",
        success:function(result){
            $("#listar_itens").html(result);            
        }
    });
}




$("#form_venda").submit(function () {

	var cliente = $('#cliente').val();

	if(cliente == ""){
		alertWarning('Selecione um Paciente');
		return;
	}

    event.preventDefault();
    var formData = new FormData(this);
    $.ajax({
        url: 'paginas/' + pag + "/salvar.php",
        type: 'POST',
        data: formData,
        success: function (mensagem) {           
            if (mensagem.trim() == "Salvo com Sucesso") {
                $('#btn-fechar').click();
                buscar(); 
                listarItens();         
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


<script type="text/javascript">
$("#form-baixar").submit(function (event) {
  event.preventDefault();
  var formData = new FormData(this);
  $.ajax({
    url: 'paginas/receber/baixar.php',
    type: 'POST',
    data: formData,
    success: function (mensagem) {
      $('#mensagem-baixar').text('').removeClass();
      if (mensagem.trim() == "Baixado com Sucesso") {
        $('#btn-fechar-baixar').click();
        buscar();
      } else {
        $('#mensagem-baixar').addClass('text-danger').text(mensagem);
      }
    },
    cache: false,
    contentType: false,
    processData: false
  });
});
</script>

<script type="text/javascript">
function totalizar() {
  let valor = $('#valor-baixar').val().replace(",", ".") || 0;
  let desconto = $('#valor-desconto').val().replace(",", ".") || 0;
  let juros = $('#valor-juros').val().replace(",", ".") || 0;
  let multa = $('#valor-multa').val().replace(",", ".") || 0;
  let subtotal = parseFloat(valor) + parseFloat(juros) + parseFloat(multa) - parseFloat(desconto);
  $('#subtotal').val(subtotal);
}
</script>



<script type="text/javascript">
function carregarImgArquivos() {
  const target = document.getElementById('target-arquivos');
  const file = document.querySelector("#arquivo_conta").files[0];
  const arquivo = file['name'];
  const resultado = arquivo.split(".", 2);

  const ext = resultado[1];

  if (ext === 'pdf') {
    $('#target-arquivos').attr('src', "images/pdf.png");
    return;
  }

  if (ext === 'rar' || ext === 'zip') {
    $('#target-arquivos').attr('src', "images/rar.png");
    return;
  }

  if (ext === 'doc' || ext === 'docx' || ext === 'txt') {
    $('#target-arquivos').attr('src', "images/word.png");
    return;
  }

  if (ext === 'xlsx' || ext === 'xlsm' || ext === 'xls') {
    $('#target-arquivos').attr('src', "images/excel.png");
    return;
  }

  if (ext === 'xml') {
    $('#target-arquivos').attr('src', "images/xml.png");
    return;
  }

  const reader = new FileReader();
  reader.onloadend = () => {
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
$("#form-arquivos").submit(function (event) {
  event.preventDefault();
  const formData = new FormData(this);

  $.ajax({
    url: 'paginas/receber/arquivos.php',
    type: 'POST',
    data: formData,
    success: function (mensagem) {
      $('#mensagem-arquivo').text('').removeClass();

      if (mensagem.trim() === "Inserido com Sucesso") {
        $('#nome-arq').val('');
        $('#arquivo_conta').val('');
        $('#target-arquivos').attr('src', 'images/arquivos/sem-foto.png');
        listarArquivos();
      } else {
        $('#mensagem-arquivo').addClass('text-danger').text(mensagem);
      }
    },
    cache: false,
    contentType: false,
    processData: false
  });
});
</script>


		<script type="text/javascript">
			function listarArquivos(){
				var id = $('#id-arquivo').val();	
				$.ajax({
					url: 'paginas/receber/listar-arquivos.php',
					method: 'POST',
					data: {id},
					dataType: "text",
					success:function(result){
						$("#listar-arquivos").html(result);
					}
				});
			}
		</script>

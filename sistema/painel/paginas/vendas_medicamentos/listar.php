<?php 
@session_start();
$nivel = @$_SESSION['nivel'];
$tabela = 'receber';
require_once("../../../conexao.php");

$dataInicial = @$_POST['p1'];
$dataFinal = @$_POST['p2'];

$data_atual = date('Y-m-d');
$data30 = date('Y-m-d', strtotime("+1 month",strtotime($data_atual)));

$remedios_vencidos = 0;
$estoque_baixo = 0;

$ocultar_excluir = 'ocultar';
if($nivel == 'Administrador' || $nivel == 'Gerente'){
	$ocultar_excluir = '';
}

if($dataInicial == ""){
	exit();
}

$query = $pdo->query("SELECT * from $tabela where (data_venc >= '$dataInicial' and data_venc <= '$dataFinal') and referencia = 'Venda' order by id desc ");
$total_pago = 0;
$total_pendentes = 0;
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0){
echo <<<HTML
	<table class="table table-hover" id="tabela">
		<thead> 
			<tr> 				
				
				<th class="esc">Valor</th> 
				<th class="esc">Paciente / Cliente</th> 
				<th class="esc">Vencimento</th> 
				<th class="esc">Pagamento</th>
				<th class="esc">Forma de PGTO</th>								
				<th>Ações</th>
			</tr> 
		</thead> 
		<tbody> 
HTML;

for($i=0; $i < $total_reg; $i++){
	foreach ($res[$i] as $key => $value){}
$id = $res[$i]['id'];
$descricao = $res[$i]['descricao'];
$cliente = $res[$i]['cliente'];
$valor = $res[$i]['valor'];
$data_lanc = $res[$i]['data_lanc'];
$data_venc = $res[$i]['data_venc'];
$data_pgto = $res[$i]['data_pgto'];
$usuario_lanc = $res[$i]['usuario_lanc'];
$usuario_pgto = $res[$i]['usuario_pgto'];
$frequencia = $res[$i]['frequencia'];
$saida = $res[$i]['saida'];
$arquivo = $res[$i]['arquivo'];
$pago = $res[$i]['pago'];
$obs = $res[$i]['obs'];
$referencia = $res[$i]['referencia'];
$convenio = $res[$i]['convenio'];

//extensão do arquivo
$ext = pathinfo($arquivo, PATHINFO_EXTENSION);
if($ext == 'pdf'){
	$tumb_arquivo = 'pdf.png';
}else if($ext == 'rar' || $ext == 'zip'){
	$tumb_arquivo = 'rar.png';
}else if($ext == 'doc' || $ext == 'docx'){
	$tumb_arquivo = 'word.png';
}else{
	$tumb_arquivo = $arquivo;
}


$data_lancF = @implode('/', array_reverse(explode('-', $data_lanc)));
$data_vencF = @implode('/', array_reverse(explode('-', $data_venc)));
$data_pgtoF = @implode('/', array_reverse(explode('-', $data_pgto)));
$valorF = number_format($valor, 2, ',', '.');


$query2 = $pdo->query("SELECT * FROM usuarios where id = '$usuario_lanc'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
if(@count($res2) > 0){
	$nome_usu_lanc = $res2[0]['nome'];
}else{
	$nome_usu_lanc = 'Sem Usuário';
}


$query2 = $pdo->query("SELECT * FROM usuarios where id = '$usuario_pgto'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
if(@count($res2) > 0){
	$nome_usu_pgto = $res2[0]['nome'];
}else{
	$nome_usu_pgto = 'Sem Usuário';
}

$query2 = $pdo->query("SELECT * FROM frequencias where dias = '$frequencia'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
if(@count($res2) > 0){
	$nome_frequencia = $res2[0]['frequencia'];
}else{
	$nome_frequencia = 'Única';
}


$nome_pessoa = 'Sem Registro';
$tipo_pessoa = 'Pessoa';
$pix_pessoa = 'Sem Registro';
$tel_pessoa = 'Sem Registro';

$query2 = $pdo->query("SELECT * FROM pacientes where id = '$cliente'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
if(@count($res2) > 0){
	$nome_pessoa = $res2[0]['nome'];	
	$tipo_pessoa = 'Paciente';
	$tel_pessoa = $res2[0]['telefone'];
}

$query2 = $pdo->query("SELECT * FROM convenios where id = '$convenio'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
if(@count($res2) > 0){
	$nome_pessoa = $res2[0]['nome'];	
	$tipo_pessoa = 'Convênio';
	$tel_pessoa = $res2[0]['telefone'];
}


if($pago == 'Sim'){
	$classe_pago = 'verde';
	$ocultar = 'ocultar';
	$total_pago += $valor;
}else{
	$classe_pago = 'text-danger';
	$ocultar = '';
	$total_pendentes += $valor;
}




$total_pagoF = number_format($total_pago, 2, ',', '.');
$total_pendentesF = number_format($total_pendentes, 2, ',', '.');


if($tel_pessoa == "Sem Registro"){
	$ocultar_whats = 'ocultar';
}else{
	$ocultar_whats = '';
}

$tel_pessoaF = '55'.preg_replace('/[ ()-]+/' , '' , $tel_pessoa);

echo <<<HTML

			<tr> 

				

					<td class="esc"><i class="fa fa-square {$classe_pago} mr-1"></i> R$ {$valorF} </td>	

					<td class="esc">{$nome_pessoa}</td>

				<td class="esc">{$data_vencF}</td>

				<td class="esc">{$data_pgtoF}</td>

				<td class="esc">{$saida}</td>

				

				<td>				

				

		<li class="dropdown head-dpdn2 " style="display: inline-block;">
		<a href="#" class="dropdown-toggle {$ocultar_excluir}" data-toggle="dropdown" aria-expanded="false"><big><i class="fa fa-trash-o text-danger "></i></big></a>
		<ul class="dropdown-menu" style="margin-left:-230px;">
		<li>
		<div class="notification_desc2">
		<p>Confirmar Exclusão? <a href="#" onclick="excluirConta('{$id}', '{$descricao}')"><span class="text-danger">Sim</span></a></p>
		</div>
		</li>								
		</ul>
		</li>
				

					<big><a class="{$ocultar}" href="#" onclick="baixar('{$id}', '{$valor}', '{$descricao}', '{$saida}')" title="Baixar Conta"><i class="fa fa-check-square " style="color:#079934"></i></a></big>

					<big><a href="#" onclick="arquivo('{$id}', '{$descricao}')" title="Inserir / Ver Arquivos"><i class="fa fa-file-o " style="color:#22146e"></i></a></big>

					<big><a class="{$ocultar_whats}" href="http://api.whatsapp.com/send?1=pt_BR&phone={$tel_pessoaF}" title="Whatsapp" target="_blank"><i class="fa fa-whatsapp " style="color:green"></i></a></big>

					<a class="" href="rel/comprovante.php?id={$id}&imprimir=Não" target="_blank" title="Ver Comprovante"><i class="fa fa-file-pdf-o text-danger"></i></a>

				</td>  

			</tr> 

HTML;

}

echo <<<HTML

		</tbody> 

		<small><div align="center" id="mensagem-excluir"></div></small>

	</table>

	<br>

	<div align="right"><span>Total Pendentes: <span class="text-danger">{$total_pendentesF}</span></span> <span style="margin-left: 25px">Total Pago: <span class="verde">{$total_pagoF}</span></span></div>

</small>

HTML;

}else{

	echo 'Não possui nenhuma conta para esta data!';

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

	function limparCampos(){
		$('#id').val('');
		$('#quantidade').val('1');
		$('#forma_pgto').val('').change();
		$('#desconto').val('');   	   	 	

    	$('#ids').val('');
    	$('#btn-deletar').hide();	
	}

	</script>


<script type="text/javascript">
	
function baixar(id, valor, descricao, saida){
	$('#id-baixar').val(id);
	$('#descricao-baixar').text(descricao);
	$('#valor-baixar').val(valor);
	$('#saida-baixar').val(saida).change();
	$('#subtotal').val(valor);	

	$('#valor-juros').val('');
	$('#valor-desconto').val('');
	$('#valor-multa').val('');

	$('#modalBaixar').modal('show');
	$('#mensagem-baixar').text('');

}



	function arquivo(id, nome){
    $('#id-arquivo').val(id);    
    $('#nome-arquivo').text(nome);
    $('#modalArquivos').modal('show');
    $('#mensagem-arquivo').text(''); 
    listarArquivos();   

}



function excluirConta(id){
    $('#mensagem-excluir').text('Excluindo...')   

    $.ajax({
        url: 'paginas/' + pag + "/excluir.php",
        method: 'POST',
        data: {id},
        dataType: "html",

        success:function(mensagem){
            if (mensagem.trim() == "Excluído com Sucesso") {   
                buscar();
            } else {
                alertWarning(mensagem)
            }
        }
    });

}

</script>
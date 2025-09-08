<?php 
require_once("../../../conexao.php");
$tabela = 'arquivos';
$data_hoje = date('Y-m-d');

@session_start();
$id_usuario = $_SESSION['id'];



echo <<<HTML

<small>

HTML;

$query = $pdo->query("SELECT * FROM $tabela where id_reg = '$id_usuario' and registro = 'Paciente' order by id desc");

$res = $query->fetchAll(PDO::FETCH_ASSOC);

$total_reg = @count($res);

if($total_reg > 0){

echo <<<HTML

	<table class="table table-hover" id="tabela_arquivos">

		<thead> 

			<tr> 				

				<th>Nome</th>

				<th class="esc">Data</th>				

				<th>Arquivo</th>				

			

			</tr> 

		</thead> 

		<tbody> 

HTML;

for($i=0; $i < $total_reg; $i++){

	foreach ($res[$i] as $key => $value){}

$id = $res[$i]['id'];

$nome = $res[$i]['nome'];

$data_cad = $res[$i]['data_cad'];

$arquivo = $res[$i]['arquivo'];



//extensão do arquivo

$ext = pathinfo($arquivo, PATHINFO_EXTENSION);

if($ext == 'pdf'){

	$tumb_arquivo = 'pdf.png';

}else if($ext == 'rar' || $ext == 'zip'){

	$tumb_arquivo = 'rar.png';

}else if($ext == 'doc' || $ext == 'docx' || $ext == 'txt'){

	$tumb_arquivo = 'word.png';

}else if($ext == 'xlsx' || $ext == 'xlsm' || $ext == 'xls'){

	$tumb_arquivo = 'excel.png';

}else if($ext == 'xml'){

	$tumb_arquivo = 'xml.png';

}else{

	$tumb_arquivo = $arquivo;

}



$data_cadF = implode('/', array_reverse(explode('-', $data_cad)));



echo <<<HTML

			<tr>					

				<td class="">{$nome}</td>

				<td class="esc">{$data_cadF}</td>				

				<td><a href="../painel/images/arquivos/{$arquivo}" target="_blank"><img src="../painel/images/arquivos/{$tumb_arquivo}" width="18px" height="18px"></a></td>

				
			</tr> 

HTML;

}

echo <<<HTML

		</tbody> 

	</table>

</small>

HTML;

}else{

	echo 'Não possui nenhum arquivo cadastrado!';

}



?>
<script type="text/javascript">

	$(document).ready( function () {		

    $('#tabela_arquivos').DataTable({

    	"language" : {

            //"url" : '//cdn.datatables.net/plug-ins/1.13.2/i18n/pt-BR.json'

        },

        "ordering": false,

		"stateSave": true

    });

} );

</script>

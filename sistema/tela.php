<?php 
require_once("conexao.php");

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
	<title><?php echo $nome_sistema ?></title>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">


</head>
<body>

	<?php 


	$itens_por_pagina = 4;

		//PEGAR A PÁGINA ATUAL
		$pagina_pag = intval(@$_GET['pagina']);
		
		$limite = $pagina_pag * $itens_por_pagina;

		//CAMINHO DA PAGINAÇÃO
		$caminho_pag = 'tela.php?'; 

		//BUSCAR NA CONSULTA O ID DO PACIENTE E O ID DO MÉDICO
$res_con = $pdo->query("SELECT * from chamadas order by id desc limit 1");
	$dados_con = $res_con->fetchAll(PDO::FETCH_ASSOC);
	$linhas_con = count($dados_con);

	if($linhas_con > 0){

		$paciente = @$dados_con[0]['paciente'];	
		$consultorio = @$dados_con[0]['sala'];	
		$status = @$dados_con[0]['status'];	

	}


if($status != "Chamando"){

	 ?>

<div class="container-tela">
<big><big>
<table class="table table-lg mt-3">
<thead class="thead-light">
<tr>
<th scope="col">Paciente</th>
<th scope="col">Hora</th>
<th scope="col">Médico</th>
<th scope="col">Consultório</th>


</tr>
</thead>
<tbody>





<?php




	


 		

$res = $pdo->query("SELECT * from agendamentos where data = curDate() and status = 'Confirmado' order by hora asc LIMIT $limite, $itens_por_pagina");


$dados = $res->fetchAll(PDO::FETCH_ASSOC);

//TOTALIZAR OS REGISTROS PARA PAGINAÇÃO
		$res_todos = $pdo->query("SELECT * from agendamentos where data = curDate() and status = 'Confirmado'");
		$dados_total = $res_todos->fetchAll(PDO::FETCH_ASSOC);
		$num_total = count($dados_total);

		//DEFINIR O TOTAL DE PAGINAS
		$num_paginas = ceil($num_total/$itens_por_pagina);
	


for ($i=0; $i < count($dados); $i++) { 
	foreach ($dados[$i] as $key => $value) {
	}

	$id = $dados[$i]['id'];	
	$paciente = $dados[$i]['paciente'];
	$hora = $dados[$i]['hora'];	
	$medico = $dados[$i]['funcionario'];	
	$status = $dados[$i]['status_cor'];

	if($status == ""){
		$status = 'Confirmado';
	}


	//BUSCAR O NOME DO PACIENTE
	$res_valor = $pdo->query("SELECT * from pacientes where id = '$paciente'");
	$dados_valor = $res_valor->fetchAll(PDO::FETCH_ASSOC);
	$linhas = count($dados_valor);

	if($linhas > 0){

		$nome_paciente = $dados_valor[0]['nome'];	

	}


	//BUSCAR O NOME DO MÉDICO
	$res_med = $pdo->query("SELECT * from usuarios where id = '$medico'");
	$dados_med = $res_med->fetchAll(PDO::FETCH_ASSOC);
	$linhas = count($dados_med);

	if($linhas > 0){

		$nome_medico = $dados_med[0]['nome'];	
		$consultorio = $dados_med[0]['sala'];	

	}




	if($status == 'Em atendimento'){
		echo '<tr class="table-success">';
	}else if($status == 'Prioridade'){
		echo '<tr class="table-primary">';
	}else{
		echo '<tr>';
	}

	?>


	<td><?php echo $nome_paciente ?></td>
	<td><?php echo $hora ?></td>	
	<td><?php echo $nome_medico ?></td>
	<td><?php echo $consultorio ?> <small><small>(<?php echo $status ?>)</small></small></td>



	</tr>

<?php } ?>


</tbody>
</table> 



<!--ÁREA DA PÁGINAÇÃO -->
<nav class="paginacao" aria-label="Page navigation example">
          <ul class="pagination">
            <li class="page-item">
              <a class="btn btn-outline-dark btn-sm mr-1" href="<?php echo $caminho_pag; ?>pagina=0&itens=<?php echo $itens_por_pagina ?>" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
                <span class="sr-only">Previous</span>
              </a>
            </li>
            <?php 
            for($i=0;$i<$num_paginas;$i++){
            $estilo = "";
            if($pagina_pag == $i)
              $estilo = "active";
            ?>
             <li class="page-item"><a class="btn btn-outline-dark btn-sm mr-1 <?php echo $estilo; ?>" href="<?php echo $caminho_pag; ?>pagina=<?php echo $i; ?>&itens=<?php echo $itens_por_pagina ?>"><?php echo $i+1; ?></a></li>
          <?php } ?>
            
            <li class="page-item">
              <a class="btn btn-outline-dark btn-sm" href="<?php echo $caminho_pag; ?>pagina=<?php echo $num_paginas-1; ?>&itens=<?php echo $itens_por_pagina ?>" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
                <span class="sr-only">Next</span>
              </a>
            </li>
          </ul>
</nav>



</big></big>
</div>

</body>
</html>








<?php 


}




if(!isset($_GET['pagina']) || $_GET['pagina'] >= (@$num_paginas - 1)){
	echo "<meta HTTP-EQUIV='refresh' CONTENT='$tempo_tela_consultas;URL=tela.php?pagina=0'>"; 
}else{
	$valor = @$_GET['pagina'] + 1;
	echo "<meta HTTP-EQUIV='refresh' CONTENT='$tempo_tela_consultas;URL=tela.php?pagina=$valor'>"; 
}



if(@$status == 'Chamando'){
		echo '<audio autoplay="true">
<source src="img/senha.mp3" type="audio/mpeg" />
</audio>';

$texto = 'text-danger';

	//trocar o status para aguardando

$pdo->query("UPDATE chamadas set status = 'Consultando' where status = 'Chamando' order by id desc limit 1 ");

	

 ?>



<div class="container-tela-chamadas" align="center" style="margin-top: 120px">

	<span style="font-size:115px" class="<?php echo $texto ?>"><?php echo @strtoupper(@$paciente) ?> <br></span>
	<span style="font-size:60px" class="text-secondary">CONSULTÓRIO <?php echo @$consultorio ?><br>

</div>

</body>
</html>




<input type="hidden" id="txt" value="<?php echo @$paciente ?> Consultório <?php echo $consultorio ?>">

<script>
     const synth = window.speechSynthesis;
     var status = "<?=$status?>";
 	
      function voz() {
        let t = document.getElementById('txt').value;
        let voices = synth.getVoices();
        if (voices.length !== 0) {
          console.log("talk");             
          let msg = new SpeechSynthesisUtterance();
          msg.voice = voices[0];      // seleciono a primeira voz
          msg.rate = 1,2;               // velocidade
          msg.pitch = 1;              // tom
          msg.text = t;  // pegando a msg do campo
          msg.lang = "pt-BR"; 
          synth.speak(msg);   
        }
      }   
 
 if(status == 'Chamando'){
 	setTimeout(function() {
  		voz()
}, 1500)  
 }  
 </script>

 <?php } ?>
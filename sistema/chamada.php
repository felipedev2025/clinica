<?php 
require_once("conexao.php");
echo "<meta HTTP-EQUIV='refresh' CONTENT='$tempo_tela_chamadas;URL=chamada.php'>"; 
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
	<title><?php echo $nome_sistema ?></title>

	
	<meta content="text/html; charset=utf-8" http-equiv="Content-Type">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

</head>
<body>




<?php 

//BUSCAR NA CONSULTA O ID DO PACIENTE E O ID DO MÉDICO
$res_con = $pdo->query("SELECT * from chamadas order by id desc limit 1");
	$dados_con = $res_con->fetchAll(PDO::FETCH_ASSOC);
	$linhas_con = count($dados_con);

	if($linhas_con > 0){

		$paciente = @$dados_con[0]['paciente'];	
		$consultorio = @$dados_con[0]['sala'];	
		$status = @$dados_con[0]['status'];	

	}



	if(@$status == 'Chamando'){
		echo '<audio autoplay="true">
<source src="img/senha.mp3" type="audio/mpeg" />
</audio>';

$texto = 'text-danger';

	//trocar o status para aguardando

$pdo->query("UPDATE chamadas set status = 'Consultando' where status = 'Chamando' order by id desc limit 1 ");

	}else{
		$texto = 'text-info';
	}

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
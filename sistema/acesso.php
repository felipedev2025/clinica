<?php 

require_once("conexao.php");
 ?>

 <!DOCTYPE html>

<html>

<head>

	<title><?php echo $nome_sistema ?></title>

	<link rel="stylesheet" type="text/css" href="css/style.css">

	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="shortcut icon" type="image/x-icon" href="img/icone.png">



	<script src="painel/js/jquery-1.11.1.min.js"></script>



</head>

	<?php 
if($fundo_login != "" and $fundo_login != "sem-foto.png"){ ?>
<body style="background: url('img/<?php echo $fundo_login ?>') no-repeat center center fixed; background-size: cover;">
<?php }else{ ?>
<body >
<?php } ?>

	<div class="login">		

		<div class="form">

			<img src="img/logo.png" class="imagem">

			<form method="post" action="autenticar_cliente.php">

				<input type="text" id="cpf" name="usuario" placeholder="Seu CPF" required>

				<input type="password" name="senha" placeholder="Senha" required>

				<button>ACESSAR</button>

				<?php if($token != ""){ ?>

				<div style="margin-top: 15px; font-size: 13px; "><a href="#" onclick="recuperar()" style="color:#666565" title="Recuperar Senha">Recuperar Senha?</a></div>

			<?php } ?>

			</form>	

		</div>

	</div>

</body>

</html>


	<!-- Mascaras JS -->

<script type="text/javascript" src="painel/js/mascaras.js"></script>



<!-- Ajax para funcionar Mascaras JS -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script> 



<script type="text/javascript">

	function recuperar(){

		var email = $('#cpf').val();

		if(email == ""){

			alert("Digite seu CPF!");

			return;

		}



		$.ajax({

	        url: 'recuperar_cliente.php',

	        method: 'POST',

	        data: {email},

	        dataType: "html",



	        success:function(result){

	            if(result == 'Recuperado'){

	            	alert('Confira sua senha no email!')

	            }else{

	            	alert(result)

	            }

	            

	        }

    	});

	}

</script>
<?php 

@session_start();

require_once("../conexao.php");

require_once("verificar.php");



$pag_inicial = 'consultas';


if(@$_GET['pagina'] != ""){

	$pagina = @$_GET['pagina'];

}else{

	$pagina = $pag_inicial;

}


$id_usuario = @$_SESSION['id'];

$query = $pdo->query("SELECT * from pacientes where id = '$id_usuario'");

$res = $query->fetchAll(PDO::FETCH_ASSOC);

$linhas = @count($res);

if($linhas > 0){

	$nome_usuario = $res[0]['nome'];	

	$telefone_usuario = $res[0]['telefone'];

	$senha_usuario = $res[0]['senha'];
	
	$endereco_usuario = $res[0]['endereco'];

	
}



$data_atual = date('Y-m-d');

?>

<!DOCTYPE HTML>

<html>

<head>

	<title><?php echo $nome_sistema ?></title>

	<meta name="viewport" content="width=device-width, initial-scale=1">

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<link rel="shortcut icon" href="../img/icone.png" type="image/x-icon">



	<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>



	<!-- Bootstrap Core CSS -->

	<link href="css/bootstrap.css" rel='stylesheet' type='text/css' />



	<!-- Custom CSS -->

	<link href="css/style.css" rel='stylesheet' type='text/css' />



	<!-- font-awesome icons CSS -->

	<link href="css/font-awesome.css" rel="stylesheet"> 

	<!-- //font-awesome icons CSS-->



	<!-- side nav css file -->

	<link href='css/SidebarNav.min.css' media='all' rel='stylesheet' type='text/css'/>

	<!-- //side nav css file -->



	<link rel="stylesheet" href="css/monthly.css">



	<!-- js-->

	<script src="js/jquery-1.11.1.min.js"></script>

	<script src="js/modernizr.custom.js"></script>



	<!--webfonts-->

	<link href="//fonts.googleapis.com/css?family=PT+Sans:400,400i,700,700i&amp;subset=cyrillic,cyrillic-ext,latin-ext" rel="stylesheet">

	<!--//webfonts--> 



	<!-- chart -->

	<script src="js/Chart.js"></script>

	<!-- //chart -->



	<!-- Metis Menu -->

	<script src="js/metisMenu.min.js"></script>

	<script src="js/custom.js"></script>

	<link href="css/custom.css" rel="stylesheet">

	<!--//Metis Menu -->

	<style>

		#chartdiv {

			width: 100%;

			height: 295px;

		}

	</style>

	<!--pie-chart --><!-- index page sales reviews visitors pie chart -->

	<script src="js/pie-chart.js" type="text/javascript"></script>

	<script type="text/javascript">




		$(document).ready(function () {

			$('#demo-pie-1').pieChart({

				barColor: '#2dde98',

				trackColor: '#eee',

				lineCap: 'round',

				lineWidth: 8,

				onStep: function (from, to, percent) {

					$(this.element).find('.pie-value').text(Math.round(percent) + '%');

				}

			});



			$('#demo-pie-2').pieChart({

				barColor: '#2dacd6',

				trackColor: '#eee',

				lineCap: 'butt',

				lineWidth: 8,

				onStep: function (from, to, percent) {

					$(this.element).find('.pie-value').text(Math.round(percent) + '%');

				}

			});



			$('#demo-pie-3').pieChart({

				barColor: '#d13c2c',

				trackColor: '#eee',

				lineCap: 'square',

				lineWidth: 8,

				onStep: function (from, to, percent) {

					$(this.element).find('.pie-value').text(Math.round(percent) + '%');

				}

			});





		});



	</script>

	<!-- //pie-chart --><!-- index page sales reviews visitors pie chart -->





	<link rel="stylesheet" type="text/css" href="DataTables/datatables.min.css"/> <script src="DataTables/datatables.min.js"></script>



	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>



	<style type="text/css">

		.select2-selection__rendered {

			line-height: 36px !important;

			font-size:16px !important;

			color:#666666 !important;



		}



		.select2-selection {

			height: 36px !important;

			font-size:16px !important;

			color:#666666 !important;



		}

	</style> 

	

</head> 

<body class="cbp-spmenu-push">

	<div class="main-content">

		<div class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left" id="cbp-spmenu-s1">

			<!--left-fixed -navigation-->

			<aside class="sidebar-left" style="overflow: scroll; height:100%; scrollbar-width: thin;">

				<nav class="navbar navbar-inverse">

					<div class="navbar-header">

						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".collapse" aria-expanded="false">

							<span class="sr-only">Toggle navigation</span>

							<span class="icon-bar"></span>

							<span class="icon-bar"></span>

							<span class="icon-bar"></span>

						</button>

						<h1><a class="navbar-brand" href="index.php"><span class="fa fa-stethoscope"></span> Sistema<span class="dashboard_text"><?php echo $nome_sistema ?></span></a></h1>

					</div>

					<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

						<ul class="sidebar-menu">

							<li class="header">MENU NAVEGAÇÃO</li>

							
							<li class="treeview">
								<a href="consultas">
									<i class="fa fa-stethoscope"></i> <span>Consultas</span>
								</a>
							</li>

							<li class="treeview">
								<a href="pagamentos">
									<i class="fa fa-usd"></i> <span>Meus Pagamentos</span>
								</a>
							</li>

					
									<li class="treeview">
								<a href="arquivos">
									<i class="fa fa-file"></i> <span>Meus Arquivos</span>
								</a>
							</li>


							<li class="treeview">
								<a href="../../agendamento">
									<i class="fa fa-calendar"></i> <span>Novo Agendamento</span>
								</a>
							</li>



						</ul>

					</div>

					<!-- /.navbar-collapse -->

				</nav>

			</aside>

		</div>

		<!--left-fixed -navigation-->

		

		<!-- header-starts -->

		<div class="sticky-header header-section ">

			<div class="header-left">

				<!--toggle button start-->

				<button id="showLeftPush" data-toggle="collapse" data-target=".collapse"><i class="fa fa-bars"></i></button>

				<!--toggle button end-->

				<div class="profile_details_left"><!--notifications of menu start -->

					<ul class="nofitications-dropdown">

						

							</ul>

							<div class="clearfix"> </div>

						</div>



					</div>

					<div class="header-right">



						<div class="profile_details">		

							<ul>

								<li class="dropdown profile_details_drop">

									<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">

										<div class="profile_img">	

											<span class="prfil-img"><img src="img/usuario.png" alt="" width="50px" height="50px"> </span> 

											<div class="user-name esc">

												<p><?php echo $nome_usuario ?></p>
												

											</div>

											<i class="fa fa-angle-down lnr"></i>

											<i class="fa fa-angle-up lnr"></i>

											<div class="clearfix"></div>	

										</div>	

									</a>

									<ul class="dropdown-menu drp-mnu">									

										<li> <a href="" data-toggle="modal" data-target="#modalPerfil"><i class="fa fa-user"></i> Perfil</a> </li> 								

										<li> <a href="logout.php"><i class="fa fa-sign-out"></i> Sair</a> </li>

									</ul>

								</li>

							</ul>

						</div>

						<div class="clearfix"> </div>				

					</div>

					<div class="clearfix"> </div>	

				</div>

				<!-- //header-ends -->









				<!-- main content start-->

				<div id="page-wrapper" class="">

					<?php 

					require_once('paginas/'.$pagina.'.php');

					?>

				</div>











			</div>



			<!-- new added graphs chart js-->



			<script src="js/Chart.bundle.js"></script>

			<script src="js/utils.js"></script>







			<!-- Classie --><!-- for toggle left push menu script -->

			<script src="js/classie.js"></script>

			<script>

				var menuLeft = document.getElementById( 'cbp-spmenu-s1' ),

				showLeftPush = document.getElementById( 'showLeftPush' ),

				body = document.body;



				showLeftPush.onclick = function() {

					classie.toggle( this, 'active' );

					classie.toggle( body, 'cbp-spmenu-push-toright' );

					classie.toggle( menuLeft, 'cbp-spmenu-open' );

					disableOther( 'showLeftPush' );

				};





				function disableOther( button ) {

					if( button !== 'showLeftPush' ) {

						classie.toggle( showLeftPush, 'disabled' );

					}

				}

			</script>

			<!-- //Classie --><!-- //for toggle left push menu script -->



			<!--scrolling js-->

			<script src="js/jquery.nicescroll.js"></script>

			<script src="js/scripts.js"></script>

			<!--//scrolling js-->



			<!-- side nav js -->

			<script src='js/SidebarNav.min.js' type='text/javascript'></script>

			<script>

				$('.sidebar-menu').SidebarNav()

			</script>

			<!-- //side nav js -->







			<!-- Bootstrap Core JavaScript -->

			<script src="js/bootstrap.js"> </script>

			<!-- //Bootstrap Core JavaScript -->







			<!-- Mascaras JS -->

			<script type="text/javascript" src="js/mascaras.js"></script>



			<!-- Ajax para funcionar Mascaras JS -->

			<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script> 





		</body>

		</html>













		<!-- Modal Perfil -->

		<div class="modal fade" id="modalPerfil" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

			<div class="modal-dialog">

				<div class="modal-content">

					<div class="modal-header">

						<h4 class="modal-title" id="exampleModalLabel">Alterar Dados</h4>

						<button id="btn-fechar-perfil" type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -25px">

							<span aria-hidden="true">&times;</span>

						</button>

					</div>

					<form id="form-perfil">

						<div class="modal-body">





							<div class="row">

								<div class="col-md-12">							

									<label>Nome</label>

									<input type="text" class="form-control" id="nome_perfil" name="nome" placeholder="Seu Nome" value="<?php echo $nome_usuario ?>" required>							

								</div>



							
							</div>





							<div class="row">

								<div class="col-md-4">							

									<label>Telefone</label>

									<input type="text" class="form-control" id="telefone_perfil" name="telefone" placeholder="Seu Telefone" value="<?php echo $telefone_usuario ?>" required>							

								</div>



								<div class="col-md-4">							

									<label>Senha</label>

									<input type="password" class="form-control" id="senha_perfil" name="senha" placeholder="Senha" value="" required>							

								</div>



								<div class="col-md-4">							

									<label>Confirmar Senha</label>

									<input type="password" class="form-control" id="conf_senha_perfil" name="conf_senha" placeholder="Confirmar Senha" value="" required>							

								</div>





							</div>





							<div class="row">

								<div class="col-md-12">	

									<label>Endereço</label>

									<input type="text" class="form-control" id="endereco_perfil" name="endereco" placeholder="Seu Endereço" value="<?php echo $endereco_usuario ?>" >	

								</div>

							</div>







							




							<input type="hidden" name="id_usuario" value="<?php echo $id_usuario ?>">





							<br>

							<small><div id="msg-perfil" align="center"></div></small>

						</div>

						<div class="modal-footer">       

							<button type="submit" class="btn btn-primary">Salvar</button>

						</div>

					</form>

				</div>

			</div>

		</div>
















			<script type="text/javascript">

				$(document).ready(function() {

					$('.sel170').select2({
						dropdownParent: $('#modalRelAgendamento')


					});

					$('.sel190').select2({
						dropdownParent: $('#modalRelProcedimento')


					});

				});

			</script>




			<script type="text/javascript">

				function carregarImgPerfil() {

					var target = document.getElementById('target-usu');

					var file = document.querySelector("#foto_perfil").files[0];



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

				$("#form-perfil").submit(function () {



					event.preventDefault();

					var formData = new FormData(this);



					$.ajax({

						url: "editar-perfil.php",

						type: 'POST',

						data: formData,



						success: function (mensagem) {

							$('#msg-perfil').text('');

							$('#msg-perfil').removeClass()

							if (mensagem.trim() == "Editado com Sucesso") {



								$('#btn-fechar-perfil').click();

								location.reload();				





							} else {



								$('#msg-perfil').addClass('text-danger')

								$('#msg-perfil').text(mensagem)

							}





						},



						cache: false,

						contentType: false,

						processData: false,



					});



				});

			</script>













			<script type="text/javascript">

				$("#form-config").submit(function () {



					event.preventDefault();

					var formData = new FormData(this);



					$.ajax({

						url: "editar-config.php",

						type: 'POST',

						data: formData,



						success: function (mensagem) {

							$('#msg-config').text('');

							$('#msg-config').removeClass()

							if (mensagem.trim() == "Editado com Sucesso") {



								$('#btn-fechar-config').click();

								location.reload();				





							} else {



								$('#msg-config').addClass('text-danger')

								$('#msg-config').text(mensagem)

							}





						},



						cache: false,

						contentType: false,

						processData: false,



					});



				});

			</script>









			<script type="text/javascript">

				function carregarImgLogo() {

					var target = document.getElementById('target-logo');

					var file = document.querySelector("#foto-logo").files[0];



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

				function carregarImgLogoRel() {

					var target = document.getElementById('target-logo-rel');

					var file = document.querySelector("#foto-logo-rel").files[0];



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

				function carregarImgIcone() {

					var target = document.getElementById('target-icone');

					var file = document.querySelector("#foto-icone").files[0];



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

				$("#form_conve").submit(function () {



					event.preventDefault();

					var formData = new FormData(this);



					$.ajax({

						url: "lancar_valor.php",

						type: 'POST',

						data: formData,



						success: function (mensagem) {

							$('#msg-conve').text('');

							$('#msg-conve').removeClass()

							if (mensagem.trim() == "Salvo com Sucesso") {



								$('#btn-fechar-conve').click();

								window.location="index.php?pagina=receber"				





							} else {



								$('#msg-conve').addClass('text-danger')

								$('#msg-conve').text(mensagem)

							}





						},



						cache: false,

						contentType: false,

						processData: false,



					});



				});

			</script>






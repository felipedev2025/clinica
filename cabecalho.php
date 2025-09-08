<?php
require_once("sistema/conexao.php");

$query = $pdo->query("SELECT * from site order by id limit 1");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
  $imagem = @$res[0]['imagem'];
  $texto_imagem = @$res[0]['texto_imagem'];
  $instagram = @$res[0]['instagram'];
  $banner = @$res[0]['banner'];
  $banner_mobile = @$res[0]['banner_mobile'];
  $titulo_banner = @$res[0]['titulo_banner'];
  $subtitulo1 = @$res[0]['subtitulo1'];
  $subtitulo2 = @$res[0]['subtitulo2'];
  $subtitulo3 = @$res[0]['subtitulo3'];
  $subtitulo4 = @$res[0]['subtitulo4'];
  $cor_menu = @$res[0]['cor_menu'];

  $titulo_sobre = @$res[0]['titulo_sobre'];
  $imagem_sobre = @$res[0]['imagem_sobre'];
  $video_sobre = @$res[0]['video_sobre'];
  $mostrar_sobre = @$res[0]['mostrar_sobre'];
  $descricao_sobre = @$res[0]['descricao_sobre'];

  $titulo_portfolio = @$res[0]['titulo_portfolio'];
  $mostrar_portfolio = @$res[0]['mostrar_portfolio'];

  $titulo_servicos = @$res[0]['titulo_servicos'];
  $mostrar_servicos = @$res[0]['mostrar_servicos'];

  $titulo_comentarios = @$res[0]['titulo_comentarios'];
  $mostrar_comentarios = @$res[0]['mostrar_comentarios'];


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title><?php echo $nome_sistema ?></title>
  <meta content="Template Modelo Site Hugo Vasconcelos" name="description">
  <meta content="sistemas hugo, sistemas portal hugocursos, portal hugocursos" name="keywords">

  <!-- Favicons -->
  <link href="sistema/img/icone.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

</head>

<body>

  <!-- ======= Mobile nav toggle button ======= -->
  <i class="bi bi-list mobile-nav-toggle d-xl-none"></i>

  <!-- ======= Header ======= -->
  <header id="header" style="background:<?php echo $cor_menu ?>">

    <a style="position:fixed; top:20px; right:20px; color:#FFF; font-size: 13px" href="sistema/" class="nav-link scrollto"><i class="bx bx-lock"></i> <span>Acesso Sistema</span></a>

    <div class="d-flex flex-column">

      <div class="profile">
        <img src="assets/img/<?php echo $imagem ?>" alt="" class="img-fluid rounded-circle">
        <h1 class="text-light"><a href="index.php"><?php echo $texto_imagem ?></a></h1>
        <div class="social-links mt-3 text-center">
          
          <a title="Whatsapp" target="_blank" href="http://api.whatsapp.com/send?1=pt_BR&phone=<?php echo $whatsapp_sistema ?>" class="facebook"><i class="bx bxl-whatsapp"></i></a>
          <a title="Instagram" target="_blank" href="<?php echo $instagram ?>" class="instagram"><i class="bx bxl-instagram"></i></a>
         
        </div>
      </div>

      <nav id="navbar" class="nav-menu navbar" style="padding-bottom:80px">
        <ul >
          <li><a href="index.php" class="nav-link scrollto active"><i class="bx bx-home"></i> <span>Home</span></a></li>
          <li><a href="index.php#about" class="nav-link scrollto"><i class="bx bx-user"></i> <span>Sobre</span></a></li>    
          <?php if($mostrar_portfolio == "Sim"){ ?>     
          <li><a href="index.php#portfolio" class="nav-link scrollto"><i class="bx bx-book-content"></i> <span>Portfolio</span></a>
          </li>
        <?php } ?>

         <?php if($mostrar_servicos == "Sim"){ ?>     
          <li><a href="index.php#services" class="nav-link scrollto"><i class="bx bx-server"></i> <span>Serviços</span></a></li>
        <?php } ?>
         <li>
  <a onclick="contatos(event)" href="#" class="nav-link scrollto">
    <i class="bx bx-envelope"></i> <span>Contato</span>
  </a>
</li>

             <?php if($agendamento_cliente == "Sim"){ ?>     
          <li><a href="agendamentos" class="nav-link scrollto"><i class="bx bx-calendar"></i> <span>Agendamento</span></a></li>
        <?php } ?>

        <li><a href="sistema/acesso.php" class="nav-link scrollto"><i class="bx bx-lock"></i> <span>Acesso Painel Cliente</span></a></li>



        </ul>
      </nav><!-- .nav-menu -->
    </div>
  </header><!-- End Header -->


<script type="text/javascript">
 function contatos(event) {
  event.preventDefault(); // Impede o link de rolar para o topo
  const contactSection = document.getElementById('contact');

  if (window.location.pathname.includes("index.php")) {
    // Já está na página, rola suavemente
    if (contactSection) {
      contactSection.scrollIntoView({ behavior: 'smooth' });
    }
  } else {
    // Vai para index.php#contact
    window.location.href = "index.php#contact";
  }
}

</script>
<?php 
require_once("cabecalho.php");
 ?>

  <style type="text/css">
   #hero {  
  background: url('assets/img/<?php echo $banner; ?>') top center no-repeat;
  background-size: cover; /* Garante que a imagem ocupe o container inteiro */
 }

@media (max-width: 768px) {
  #hero {
    background: url('assets/img/<?php echo $banner_mobile; ?>') top center no-repeat;
    background-size: cover; /* Garante que a imagem ocupe o container inteiro */
    filter:none;
    
  }
}
 </style>
  <!-- ======= Hero Section ======= -->
  <section id="hero" class="d-flex flex-column justify-content-center align-items-center" >
    <div class="hero-container" data-aos="fade-in" >
      <h1 class="texto_margem_esquerda" style=""><?php echo $titulo_banner ?></h1>
      <p class="texto_margem_esquerda" ><span class="typed" data-typed-items="<?php echo $subtitulo1 ?>, <?php echo $subtitulo2 ?>, <?php echo $subtitulo3 ?>, <?php echo $subtitulo4 ?>"></span></p>
    </div>
  </section><!-- End Hero -->

  <main id="main">

    <!-- ======= About Section ======= -->
    <section id="about" class="about">
      <div class="container">

        <div class="section-title">
          <h2><?php echo $titulo_sobre ?></h2>
         
        </div>

        <div class="row">
          <div class="col-lg-4" data-aos="fade-right">
            <?php if($mostrar_sobre == 'Imagem'){ ?>
            <img src="assets/img/<?php echo $imagem_sobre ?>" class="img-fluid" alt="">
          <?php }else{ ?>
             <iframe  width="100%" height="200" src="<?php echo $video_sobre ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
          <?php } ?>
          </div>
          <div class="col-lg-8 pt-4 pt-lg-0 content" data-aos="fade-left">
            
            <p class="fst-italic">
              <?php echo $descricao_sobre ?>
            </p>
           
          </div>
        </div>

      </div>
    </section><!-- End About Section -->

 
    <?php if($mostrar_portfolio == "Sim"){ ?>
    <!-- ======= Portfolio Section ======= -->
    <section id="portfolio" class="portfolio section-bg">
      <div class="container">

        <div class="section-title">
          <h2><?php echo $titulo_portfolio ?></h2>
         
        </div>

    
        <div class="row portfolio-container" data-aos="fade-up" data-aos-delay="100">

          <?php 
              $query = $pdo->query("SELECT * from portfolio where ativo = 'Sim' order by id asc");
              $res = $query->fetchAll(PDO::FETCH_ASSOC);
              $linhas = @count($res);
              if($linhas > 0){

                for($i=0; $i<$linhas; $i++){
  $id = $res[$i]['id'];
  $titulo = $res[$i]['titulo'];
  $imagem = $res[$i]['imagem'];
  $ativo = $res[$i]['ativo'];
  $descricao = $res[$i]['descricao'];

           ?>

          <div class="col-lg-4 col-md-6 portfolio-item filter-app">
            <div class="portfolio-wrap">
              <img src="assets/img/portfolio/<?php echo $imagem ?>" class="img-fluid" alt="">
              <div class="portfolio-links">
                <a href="assets/img/portfolio/<?php echo $imagem ?>" data-gallery="portfolioGallery" class="portfolio-lightbox" title="Ver Imagem"><i class="bx bx-plus"></i></a>
                <a href="detalhes-<?php echo $id ?>" title="Ver Detalhes"><i class="bx bx-link"></i></a>
              </div>
            </div>
          </div>  

        <?php } } ?>
          
        </div>

      </div>
    </section><!-- End Portfolio Section -->
  <?php } ?>


<?php if($mostrar_servicos == "Sim"){ ?>
    <!-- ======= Services Section ======= -->
    <section id="services" class="services">
      <div class="container">

        <div class="section-title">
          <h2><?php echo $titulo_servicos ?></h2>
         
        </div>

        <div class="row">

          <?php 

              $query = $pdo->query("SELECT * from itens_servicos where ativo = 'Sim' order by id desc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas > 0){

  for($i=0; $i<$linhas; $i++){
  $id = $res[$i]['id'];
  $titulo = $res[$i]['titulo'];
  $descricao = $res[$i]['descricao'];
  $ativo = $res[$i]['ativo'];
  $descricao = $res[$i]['descricao'];
             ?>
          <div class="col-lg-4 col-md-6 icon-box" data-aos="fade-up">
            <div class="icon"><i class="bi bi-check"></i></div>
            <h4 class="title"><a href=""><?php echo $titulo ?></a></h4>
            <p class="description"><?php echo $descricao ?></p>
          </div>

        <?php } } ?>
        
        </div>

      </div>
    </section><!-- End Services Section -->

  <?php } ?>


<?php if($mostrar_comentarios == "Sim"){ ?>
    <!-- ======= Testimonials Section ======= -->
    <section id="testimonials" class="testimonials section-bg">
      <div class="container">

         <div class="section-title">
          <h2><?php echo $titulo_comentarios ?></h2>
         
        </div>

               <div class="testimonials-slider swiper" data-aos="fade-up" data-aos-delay="100">
          <div class="swiper-wrapper">

            <?php 
              $query = $pdo->query("SELECT * from itens_comentarios order by id desc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$linhas = @count($res);
if($linhas > 0){

  for($i=0; $i<$linhas; $i++){
  $id = $res[$i]['id'];
  $nome = $res[$i]['nome'];
  $imagem = $res[$i]['imagem'];
  $ativo = $res[$i]['ativo'];
  $descricao = $res[$i]['descricao'];
  $profissao = $res[$i]['profissao'];

             ?>

            <div class="swiper-slide">
              <div class="testimonial-item" data-aos="fade-up">
                <p>
                  <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                 <?php echo $descricao ?>
                  <i class="bx bxs-quote-alt-right quote-icon-right"></i>
                </p>
                <img src="assets/img/comentario/<?php echo $imagem ?>" class="testimonial-img" alt="">
                <h3><?php echo $nome ?></h3>
                <h4><?php echo $profissao ?></h4>
              </div>
            </div><!-- End testimonial item -->

           <?php } } ?>

         

          </div>
          <div class="swiper-pagination"></div>
        </div>

      </div>
    </section><!-- End Testimonials Section -->

  <?php } ?>

    <!-- ======= Contact Section ======= -->
    <section id="contact" class="contact">
      <div class="container">

        <div class="section-title">
          <h2>Contatos</h2>
          
        </div>

        <div class="row" data-aos="fade-in">

          <div class="col-lg-5 d-flex align-items-stretch">
            <div class="info">
              <div class="address">
                <i class="bi bi-geo-alt"></i>
                <h4>Endereço:</h4>
                <p><?php echo $endereco_sistema ?></p>
              </div>

              <div class="email">
                <i class="bi bi-envelope"></i>
                <h4>Email:</h4>
                <p><?php echo $email_sistema ?></p>
              </div>

              <div class="phone">
                <i class="bi bi-phone"></i>
                <h4>Telefone:</h4>
                <p><?php echo $telefone_fixo ?></p>
              </div>

              <iframe src="<?php echo $mapa ?>" frameborder="0" style="border:0; width: 100%; height: 290px;" allowfullscreen></iframe>
            </div>

          </div>

          <div class="col-lg-7 mt-5 mt-lg-0 d-flex align-items-stretch">
            <form action="enviar.php" method="post" role="form" class="php-email-form">
              <div class="row">
                <div class="form-group col-md-6">
                  <label for="name">Nome</label>
                  <input type="text" name="nome" class="form-control" id="nome" required>
                </div>
                <div class="form-group col-md-6">
                  <label for="name">Email</label>
                  <input type="email" class="form-control" name="email" id="email" required>
                </div>
              </div>
              <div class="form-group">
                <label for="name">Assunto</label>
                <input type="text" class="form-control" name="assunto" id="assunto" required>
              </div>
              <div class="form-group">
                <label for="name">Mensagem</label>
                <textarea class="form-control" name="mensagem" rows="10" required></textarea>
              </div>
              <div class="my-3">
                <div class="loading">Carregando</div>
                <div class="error-message"></div>
                <div class="sent-message">Sua Mensagem foi enviada</div>
              </div>
              <div class="text-center"><button type="submit">Enviar</button></div>
            </form>
          </div>

        </div>

      </div>
    </section><!-- End Contact Section -->

  </main><!-- End #main -->



<?php 
require_once("rodape.php");
 ?>
<?php 
require_once("cabecalho.php");
$id = $_GET['id'];

 $query = $pdo->query("SELECT * from portfolio where id = '$id'");
              $res = $query->fetchAll(PDO::FETCH_ASSOC);
              $linhas = @count($res);
              if($linhas > 0){

                for($i=0; $i<$linhas; $i++){

  $titulo = $res[0]['titulo'];
  $imagem = $res[0]['imagem'];
  $ativo = $res[0]['ativo'];
  $descricao = $res[0]['descricao'];

}

}else{
  echo 'Sem Registro!';
  exit();
}
 ?>
  <main id="main">

    <!-- ======= Breadcrumbs ======= -->
    <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h2><?php echo $titulo ?></h2>
          <ol>
            <li><a href="index.php">Home</a></li>
            <li>Portfoio Detalhes</li>
          </ol>
        </div>

      </div>
    </section><!-- End Breadcrumbs -->

    <!-- ======= Portfolio Details Section ======= -->
    <section id="portfolio-details" class="portfolio-details">
      <div class="container">

        <div class="row gy-4">

          <div class="col-lg-8">
            <div class="portfolio-details-slider swiper">
              <div class="swiper-wrapper align-items-center">

                <?php 
                  $query = $pdo->query("SELECT * FROM imagens_portfolio where portfolio = '$id' ");
                  $res = $query->fetchAll(PDO::FETCH_ASSOC);

                for ($i=0; $i < count($res); $i++) {                  
                  $id = $res[$i]['id'];
                  $foto = $res[$i]['foto'];
                 
                 ?>

                <div class="swiper-slide">
                  <img src="assets/img/portfolio/imagens/<?php echo $foto ?>" alt="">
                </div>

              <?php } ?>
               

              </div>
              <div class="swiper-pagination"></div>
            </div>
          </div>

          <div class="col-lg-4">
            <div class="portfolio-info">

              <?php echo $descricao ?>
            
            </div>
           
          </div>

        </div>

      </div>
    </section><!-- End Portfolio Details Section -->

  </main><!-- End #main -->

  
<?php 
require_once("rodape.php");
 ?>
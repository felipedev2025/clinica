<?php 
$tabela = 'site';
require_once("../../../conexao.php");

$cor_menu = $_POST['cor_menu'];
$texto_imagem = $_POST['texto_imagem'];
$instagram = $_POST['instagram'];
$titulo_banner = $_POST['titulo_banner'];
$subtitulo1 = $_POST['subtitulo1'];
$subtitulo2 = $_POST['subtitulo2'];
$subtitulo3 = $_POST['subtitulo3'];
$subtitulo4 = $_POST['subtitulo4'];

$titulo_sobre = $_POST['titulo_sobre'];
$video_sobre = $_POST['video_sobre'];
$mostrar_sobre = $_POST['mostrar_sobre'];
$descricao_sobre = $_POST['descricao_sobre'];

$titulo_portfolio = $_POST['titulo_portfolio'];
$mostrar_portfolio = $_POST['mostrar_portfolio'];

$titulo_servicos = $_POST['titulo_servicos'];
$mostrar_servicos = $_POST['mostrar_servicos'];

$titulo_comentarios = @$_POST['titulo_comentarios'];
$mostrar_comentarios = @$_POST['mostrar_comentarios'];

//item portfolio
$titulo_item_portfolio = $_POST['titulo_item_portfolio'];
$ativo_item_portfolio = $_POST['ativo_item_portfolio'];
$descricao_item_portfolio = $_POST['descricao_item_portfolio'];
$id_item_portfolio = $_POST['id_item_portfolio'];


$nome_item_comentario = $_POST['nome_item_comentario'];
$descricao_item_comentario = $_POST['descricao_item_comentario'];
$profissao_item_comentario = $_POST['profissao_item_comentario'];
$ativo_item_comentario = $_POST['ativo_item_comentario'];
$id_item_comentario = $_POST['id_item_comentario'];

if($titulo_item_portfolio != ""){

	$query = $pdo->query("SELECT * FROM portfolio where id = '$id_item_portfolio'");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$total_reg = @count($res);
	if($total_reg > 0){
		$imagem_item_portfolio = @$res[0]['imagem'];
	}else{
		$imagem_item_portfolio = "sem-foto.png";
	}
			

	//SCRIPT PARA SUBIR FOTO NO SERVIDOR
	$nome_img = date('d-m-Y H:i:s') .'-'.@$_FILES['imagem_item_portfolio']['name'];
	$nome_img = preg_replace('/[ :]+/' , '-' , $nome_img);
	$caminho = '../../../../assets/img/portfolio/' .$nome_img;

	$imagem_temp = @$_FILES['imagem_item_portfolio']['tmp_name']; 

	if(@$_FILES['imagem_item_portfolio']['name'] != ""){
		$ext = pathinfo($nome_img, PATHINFO_EXTENSION);   
		if($ext == 'png' or $ext == 'jpg' or $ext == 'jpeg' or $ext == 'gif' or $ext == 'PNG' or $ext == 'JPG' or $ext == 'JPEG' or $ext == 'GIF' or $ext == 'webp'){ 


				//EXCLUO A FOTO ANTERIOR			
				@unlink('../../../../assets/img/portfolio/'.$imagem_item_portfolio);
					
				$imagem_item_portfolio = $nome_img;	

			move_uploaded_file($imagem_temp, $caminho);
		}else{
			echo 'Extensão de Imagem não permitida!';
			exit();

		}

	}

	if($id_item_portfolio == ""){
		$query = $pdo->prepare("INSERT INTO portfolio SET titulo = :titulo, descricao = :descricao, imagem = :imagem, ativo = :ativo ");
	}else{
		$query = $pdo->prepare("UPDATE portfolio SET titulo = :titulo, descricao = :descricao, imagem = :imagem, ativo = :ativo WHERE id = '$id_item_portfolio'");
	}
	
	$query->bindValue(":titulo", "$titulo_item_portfolio");
	$query->bindValue(":descricao", "$descricao_item_portfolio");
	$query->bindValue(":imagem", "$imagem_item_portfolio");
	$query->bindValue(":ativo", "$ativo_item_portfolio");
	$query->execute();


}




if($nome_item_comentario != ""){

	$query = $pdo->query("SELECT * FROM itens_comentarios where id = '$id_item_comentario'");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$total_reg = @count($res);
	if($total_reg > 0){
		$imagem_item_comentario = @$res[0]['imagem'];
	}else{
		$imagem_item_comentario = "sem-foto.png";
	}
			

	//SCRIPT PARA SUBIR FOTO NO SERVIDOR
	$nome_img = date('d-m-Y H:i:s') .'-'.@$_FILES['imagem_item_comentario']['name'];
	$nome_img = preg_replace('/[ :]+/' , '-' , $nome_img);
	$caminho = '../../../../assets/img/comentario/' .$nome_img;

	$imagem_temp = @$_FILES['imagem_item_comentario']['tmp_name']; 

	if(@$_FILES['imagem_item_comentario']['name'] != ""){
		$ext = pathinfo($nome_img, PATHINFO_EXTENSION);   
		if($ext == 'png' or $ext == 'jpg' or $ext == 'jpeg' or $ext == 'gif' or $ext == 'PNG' or $ext == 'JPG' or $ext == 'JPEG' or $ext == 'GIF' or $ext == 'webp'){ 


				//EXCLUO A FOTO ANTERIOR			
				@unlink('../../../../assets/img/comentario/'.$imagem_item_comentario);
					
				$imagem_item_comentario = $nome_img;	

			move_uploaded_file($imagem_temp, $caminho);
		}else{
			echo 'Extensão de Imagem não permitida!';
			exit();

		}

	}

	if($id_item_comentario == ""){
		$query = $pdo->prepare("INSERT INTO itens_comentarios SET nome = :nome, descricao = :descricao, imagem = :imagem, ativo = :ativo, profissao = :profissao ");
	}else{
		$query = $pdo->prepare("UPDATE itens_comentarios SET nome = :nome, descricao = :descricao, imagem = :imagem, ativo = :ativo, profissao = :profissao WHERE id = '$id_item_comentario'");
	}
	
	$query->bindValue(":nome", "$nome_item_comentario");
	$query->bindValue(":descricao", "$descricao_item_comentario");
	$query->bindValue(":imagem", "$imagem_item_comentario");
	$query->bindValue(":ativo", "$ativo_item_comentario");
	$query->bindValue(":profissao", "$profissao_item_comentario");
	$query->execute();


}

//validar troca da foto

$query = $pdo->query("SELECT * FROM $tabela order by id asc limit 1");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0){
	$imagem = $res[0]['imagem'];
	$banner = $res[0]['banner'];
	$imagem_sobre = $res[0]['imagem_sobre'];
	$banner_mobile = $res[0]['banner_mobile'];

}

//SCRIPT PARA SUBIR FOTO NO SERVIDOR
$nome_img = date('d-m-Y H:i:s') .'-'.@$_FILES['imagem']['name'];
$nome_img = preg_replace('/[ :]+/' , '-' , $nome_img);
$caminho = '../../../../assets/img/' .$nome_img;

$imagem_temp = @$_FILES['imagem']['tmp_name']; 

if(@$_FILES['imagem']['name'] != ""){
	$ext = pathinfo($nome_img, PATHINFO_EXTENSION);   
	if($ext == 'png' or $ext == 'jpg' or $ext == 'jpeg' or $ext == 'gif' or $ext == 'PNG' or $ext == 'JPG' or $ext == 'JPEG' or $ext == 'GIF' or $ext == 'webp'){ 	

			//EXCLUO A FOTO ANTERIOR			
			@unlink('../../../../assets/img/'.$imagem);		

			$imagem = $nome_img;	

		move_uploaded_file($imagem_temp, $caminho);
	}else{
		echo 'Extensão de Imagem não permitida!';
		exit();

	}

}




//SCRIPT PARA SUBIR FOTO NO SERVIDOR
$nome_img = date('d-m-Y H:i:s') .'-'.@$_FILES['banner']['name'];
$nome_img = preg_replace('/[ :]+/' , '-' , $nome_img);
$caminho = '../../../../assets/img/' .$nome_img;

$imagem_temp = @$_FILES['banner']['tmp_name']; 

if(@$_FILES['banner']['name'] != ""){
	$ext = pathinfo($nome_img, PATHINFO_EXTENSION);   
	if($ext == 'png' or $ext == 'jpg' or $ext == 'jpeg' or $ext == 'gif' or $ext == 'PNG' or $ext == 'JPG' or $ext == 'JPEG' or $ext == 'GIF' or $ext == 'webp'){ 	

			//EXCLUO A FOTO ANTERIOR			
			@unlink('../../../../assets/img/'.$banner);		

			$banner = $nome_img;	

		move_uploaded_file($imagem_temp, $caminho);
	}else{
		echo 'Extensão de Imagem não permitida!';
		exit();

	}

}




//SCRIPT PARA SUBIR FOTO NO SERVIDOR
$nome_img = date('d-m-Y H:i:s') .'-'.@$_FILES['imagem_sobre']['name'];
$nome_img = preg_replace('/[ :]+/' , '-' , $nome_img);
$caminho = '../../../../assets/img/' .$nome_img;

$imagem_temp = @$_FILES['imagem_sobre']['tmp_name']; 

if(@$_FILES['imagem_sobre']['name'] != ""){
	$ext = pathinfo($nome_img, PATHINFO_EXTENSION);   
	if($ext == 'png' or $ext == 'jpg' or $ext == 'jpeg' or $ext == 'gif' or $ext == 'PNG' or $ext == 'JPG' or $ext == 'JPEG' or $ext == 'GIF' or $ext == 'webp'){ 	

			//EXCLUO A FOTO ANTERIOR			
			@unlink('../../../../assets/img/'.$imagem_sobre);		

			$imagem_sobre = $nome_img;	

		move_uploaded_file($imagem_temp, $caminho);
	}else{
		echo 'Extensão de Imagem não permitida!';
		exit();

	}

}





//SCRIPT PARA SUBIR FOTO NO SERVIDOR
$nome_img = date('d-m-Y H:i:s') .'-'.@$_FILES['banner_mobile']['name'];
$nome_img = preg_replace('/[ :]+/' , '-' , $nome_img);
$caminho = '../../../../assets/img/' .$nome_img;

$imagem_temp = @$_FILES['banner_mobile']['tmp_name']; 

if(@$_FILES['banner_mobile']['name'] != ""){
	$ext = pathinfo($nome_img, PATHINFO_EXTENSION);   
	if($ext == 'png' or $ext == 'jpg' or $ext == 'jpeg' or $ext == 'gif' or $ext == 'PNG' or $ext == 'JPG' or $ext == 'JPEG' or $ext == 'GIF' or $ext == 'webp'){ 	

			//EXCLUO A FOTO ANTERIOR			
			@unlink('../../../../assets/img/'.$banner_mobile);		

			$banner_mobile = $nome_img;	

		move_uploaded_file($imagem_temp, $caminho);
	}else{
		echo 'Extensão de Imagem não permitida!';
		exit();

	}

}


$query = $pdo->prepare("UPDATE $tabela SET cor_menu = :cor_menu, imagem = :imagem, texto_imagem = :texto_imagem, instagram = :instagram, banner = :banner, titulo_banner = :titulo_banner, subtitulo1 = :subtitulo1, subtitulo2 = :subtitulo2, subtitulo3 = :subtitulo3, subtitulo4 = :subtitulo4, titulo_sobre = :titulo_sobre, imagem_sobre = :imagem_sobre, video_sobre = :video_sobre, mostrar_sobre = :mostrar_sobre, descricao_sobre = :descricao_sobre, titulo_portfolio = :titulo_portfolio, mostrar_portfolio = :mostrar_portfolio, titulo_servicos = :titulo_servicos, mostrar_servicos = :mostrar_servicos, titulo_comentarios = :titulo_comentarios, mostrar_comentarios = :mostrar_comentarios, banner_mobile = '$banner_mobile' ");

$query->bindValue(":cor_menu", "$cor_menu");
$query->bindValue(":imagem", "$imagem");
$query->bindValue(":texto_imagem", "$texto_imagem");
$query->bindValue(":instagram", "$instagram");
$query->bindValue(":banner", "$banner");
$query->bindValue(":titulo_banner", "$titulo_banner");
$query->bindValue(":subtitulo1", "$subtitulo1");
$query->bindValue(":subtitulo2", "$subtitulo2");
$query->bindValue(":subtitulo3", "$subtitulo3");
$query->bindValue(":subtitulo4", "$subtitulo4");

$query->bindValue(":titulo_sobre", "$titulo_sobre");
$query->bindValue(":imagem_sobre", "$imagem_sobre");
$query->bindValue(":video_sobre", "$video_sobre");
$query->bindValue(":mostrar_sobre", "$mostrar_sobre");
$query->bindValue(":descricao_sobre", "$descricao_sobre");

$query->bindValue(":titulo_portfolio", "$titulo_portfolio");
$query->bindValue(":mostrar_portfolio", "$mostrar_portfolio");

$query->bindValue(":titulo_servicos", "$titulo_servicos");
$query->bindValue(":mostrar_servicos", "$mostrar_servicos");

$query->bindValue(":titulo_comentarios", "$titulo_comentarios");
$query->bindValue(":mostrar_comentarios", "$mostrar_comentarios");


$query->execute();

echo 'Salvo com Sucesso';

 ?>
<?php 
@session_start();
$id_usuario = @$_SESSION['id'];
$tabela = 'imagens_portfolio';
require_once("../../../conexao.php");



$id = $_POST['id-imagens'];

for ($i = 0; $i < count(@$_FILES['imgimovel']['name']); $i++){

//SCRIPT PARA SUBIR FOTO NO SERVIDOR
$nome_img = date('d-m-Y H:i:s') .'-'.@$_FILES['imgimovel']['name'][$i];
$nome_img = preg_replace('/[ :]+/' , '-' , $nome_img);
$caminho = '../../../../assets/img/portfolio/imagens/' .$nome_img;

$imagem_temp = @$_FILES['imgimovel']['tmp_name'][$i]; 

if(@$_FILES['imgimovel']['name'][$i] != ""){
	$ext = pathinfo($nome_img, PATHINFO_EXTENSION);   
	if($ext == 'png' or $ext == 'jpg' or $ext == 'jpeg' or $ext == 'gif' or $ext == 'webp' or $ext == 'PNG' or $ext == 'JPG' or $ext == 'JPEG' or $ext == 'GIF' or $ext == 'WEBP'){ 

		if (@$_FILES['imgimovel']['name'][$i] != ""){			

			$foto = $nome_img;
		}

		//pegar o tamanho da imagem
			list($largura, $altura) = getimagesize($imagem_temp);
		 	if($largura > 2000){
		 		echo 'Diminua a imagem para um tamanho de no máximo 2000px de largura!';
		 		exit();
		 	}else{
		 		move_uploaded_file($imagem_temp, $caminho);
		 	}
	}else{
		echo 'Extensão de Imagem não permitida!';
		exit();
	}
}else{
	echo 'Insira uma Imagem!';
	exit();
}

$query = $pdo->query("INSERT INTO $tabela SET portfolio = '$id', foto = '$foto'");

}

echo 'Inserido com Sucesso';

?>
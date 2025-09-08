<?php 
@session_start();
if (@$_SESSION['id'] == ""){
	@session_destroy();
	echo '<script>window.location="../acesso.php"</script>';
	exit();
}

if (@$_SESSION['token_0078'] != "A504030"){
	@session_destroy();
	echo '<script>window.location="../acesso.php"</script>';
	exit();
}

 ?>


<?php 
@session_start();
if (@$_SESSION['id'] == ""){
	@session_destroy();
	echo '<script>window.location="../"</script>';
	exit();
}

if (@$_SESSION['token_0035'] != "A502030"){
	@session_destroy();
	echo '<script>window.location="../"</script>';
	exit();
}

 ?>
<?php
@session_start();
if(isset($_SESSION['useradmin'])){
	$_SESSION = array();
	if(isset($_COOKIE[session_name()])){
		setcookie(session_name(), '', time() - 1000, '/');
	}
	session_destroy();
}
echo '<script>location.href="index";</script>';
?>

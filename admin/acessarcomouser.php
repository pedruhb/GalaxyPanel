<?php include "../galaxyservers/global.php";
if(empty($_SESSION['useradmin'])){
	echo '<script>location.href="../index";</script>';
	return;
}
if (!empty($_SESSION['useradmin'])){

	$_SESSION['nomeusuario'] = gs($_GET['user']);
	$infoserver = $PDO->prepare("SELECT senhavestacp FROM servidores WHERE nomeusuario = '".gs($_GET['user'])."'");
	$infoserver->execute();
	$server = $infoserver->fetch();
	$_SESSION['senhalogin'] = $server['senhavestacp'];
	$_SESSION['senhaatualdb'] = $server['senhavestacp'];
	addlog_admin($_SESSION['useradmin'], "Acessou a conta do usuário: ".$_GET['user']);
	header('Location: ../../principal');

}
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="shortcut icon" href="https://www.phpmyadmin.net/static/favicon.ico" type="image/x-icon" />
	<title>phpMyAdmin</title>
</head>
<?php

include "galaxyservers/global.php";
if(!empty($_SESSION['nomeusuario'])){

	$infoserver = $PDO->prepare("SELECT * FROM servidores WHERE nomeusuario = '".$_SESSION['nomeusuario']."'");
	$infoserver->execute();
	$server = $infoserver->fetch();
	$_SESSION['senhaatualdb'] = $server['senhavestacp'];

	if(empty($_POST['phpmyadmingalaxy']))
		header('Location: /banco-de-dados');	
	?>
	<body style="margin:0px;padding:0px;overflow:hidden">
		<iframe src="<?php echo $phpmyadmin.'?pma_username='.$server['uservestacp']."_hotel".'&pma_password='.$server['senhavestacp'] ?>&db=<?php echo $server['uservestacp']."_hotel"; ?>" frameborder="0" style="height:100%;width:100%;position:absolute;top:0px;left:0px;right:0px;bottom:0px" height="100%" width="100%"></iframe>
	</body>
	<?php } else header('Location: ../index'); ?>
	</html>
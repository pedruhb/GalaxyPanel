
<?php
$filemanagertawk=false;
include "/galaxyservers/global.php";
if(!empty($_SESSION['nomeusuario'])){

	$infoserver = $PDO->prepare("SELECT * FROM servidores WHERE nomeusuario = '".$_SESSION['nomeusuario']."'");
	$infoserver->execute();
	$server = $infoserver->fetch();
	$_SESSION['senhaatualdb'] = $server['senhavestacp'];


	$getvista = $PDO->prepare("SELECT * FROM vista_padrao WHERE id = :id");
	$getvista->bindParam(':id', $_GET['id']);
	$getvista->execute();
	$vista = $getvista->fetch();

	$swflink = "http://swf.galaxyservers.com.br/c_images/reception/";

if(!empty($vista['background_left'])){
	?>
	<style>body{background: url("<?= $swflink.$vista['background_left'];?>"),url("<?= $swflink.$vista['background_right'];?>"),url("<?= $swflink.$vista['background_gradient'];?>"),url("<?= $swflink.$vista['background_horizon'];?>");background-position: left bottom, right bottom,right bottom;background-repeat: no-repeat, no-repeat, repeat;background-color: #68E5FF;}</style>
	<?php }} ?>
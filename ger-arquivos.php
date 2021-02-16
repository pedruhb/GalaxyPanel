<?php
include "galaxyservers/global.php";
if(!empty($_SESSION['nomeusuario'])){

	$infoserver = $PDO->prepare("SELECT * FROM servidores WHERE nomeusuario = '".$_SESSION['nomeusuario']."'");
	$infoserver->execute();
	$server = $infoserver->fetch();
	$_SESSION['senhaatualdb'] = $server['senhavestacp'];

	
	if(isset($_SESSION['subconta'])){
		echo '<div style="display: contents;">
		<div class="col-md-12">
		<center><div class="alert alert-danger background-danger">
		<strong>Erro!</strong> Sua subconta não tem permissão para acessar essa página.
		</div></center>
		</div>
		</div>';
	} else { 

		addlog('Abriu o gerenciador de arquivos');

		$sso = "GALAXY-".rand(100000,9999999).$server['id']."-FILEMANAGER";

		$infoserver = $PDO->prepare("UPDATE servidores SET sso = :sso WHERE nomeusuario = '".$_SESSION['nomeusuario']."'");
		$infoserver->bindParam(":sso", $sso);
		$infoserver->execute();

		header('Location: http://file.galaxyservers.com.br/?sso='.$sso);
		
	}
} 
else 
	header('Location: ../index'); 
?>
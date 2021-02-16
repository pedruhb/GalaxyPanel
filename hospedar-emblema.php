<?php
include "galaxyservers/global.php";
if(!empty($_SESSION['nomeusuario'])){

	$infoserver = $PDO->prepare("SELECT * FROM servidores WHERE nomeusuario = '".$_SESSION['nomeusuario']."'");
	$infoserver->execute();
	$server = $infoserver->fetch();
	$_SESSION['senhaatualdb'] = $server['senhavestacp'];

	?>
	<?php include 'galaxyservers/nav.php';?>
	<div class="pcoded-content">
		<div class="pcoded-inner-content">
			<div class="main-body user-profile">
				<div class="page-wrapper">
					<div class="page-body">
						<div class="card">
							<div class="card-block">
								<div class="m-b-20">
									<h4 class="sub-title">Hospedar emblema</h4>
									<form method="POST" enctype="multipart/form-data">	
										<?php

												if(!permissao("hospemblema")){
													echo '<div style="display: contents;">
													<div class="col-md-12">
													<center><div class="alert alert-danger background-danger" style="width: 30%;">
													<strong>Erro!</strong> Sua subconta não tem permissão para acessar essa página.
													</div></center>
													</div>
													</div>';
												} else {

										if( $_SERVER['REQUEST_METHOD']=='POST' )
										{
											error_reporting(1);
											function limpacodigo($cod){
												$what = array( 'ä','ã','à','á','â','ê','ë','è','é','ï','ì','í','ö','õ','ò','ó','ô','ü','ù','ú','û','À','Á','É','Í','Ó','Ú','ñ','Ñ','ç','Ç',' ','-','(',')',',',';',':','|','!','"','#','$','%','&','/','=','?','~','^','>','<','ª','º','*' );
												$by   = array( 'a','a','a','a','a','e','e','e','e','i','i','i','o','o','o','o','o','u','u','u','u','A','A','E','I','O','U','n','n','c','C','','','','','','','','','','','','','','','','','','','','','','','' ,'');
												return str_replace($what, $by, $cod);
											}
$cod = limpacodigo(strtoupper($server['id'].$_POST['cod'])); /// Gera o código do emblema											$nome = gs($_POST['nome']);
$extensoes_autorizadas = array( '.gif' );
$caminho = './';
$limitar_tamanho = 0;
if ( ! isset( $_FILES['arquivo'] ) ) {
	exit('<script>alert("Nenhum arquivo enviado!");</script>');
}
$arquivo = $_FILES['arquivo'];
$nome_arquivo = $arquivo['name'];
$tamanho_arquivo = $arquivo['size'];
$arquivo_temp = $arquivo['tmp_name'];
$extensao_arquivo = strrchr( $nome_arquivo, '.' );
$destino = $caminho . $nome_arquivo;

if ( $limitar_tamanho && $limitar_tamanho < $tamanho_arquivo ) {
	exit('<script>alert("Arquivo muito grande.");</script>');
} 
if ( ! empty( $extensoes_autorizadas ) && ! in_array( $extensao_arquivo, $extensoes_autorizadas ) ) {
	exit('<script>alert("Tipo de arquivo não permitido.");</script>');
}

$VerificaHospedados = $PDO->prepare("SELECT id FROM emblemas WHERE codigo = '".$cod."';");
$VerificaHospedados->execute();
if($VerificaHospedados->rowCount >= 1){
	echo '<div class="alert alert-danger background-danger">
	<strong>Erro!</strong> Já existe um emblema hospedado com esse código.
	</div>'; 
} else {
	if(strlen($_POST['cod']) > 8){
		echo '<div class="alert alert-danger background-danger"><strong>Erro!</strong> O código deve ter no máximo 8 caracteres.
		</div>';
	} else if(strlen($_POST['cod']) < 2){
		echo '<div class="alert alert-danger background-danger">
		<strong>Erro!</strong> O código deve ter no mínimo 2 caracteres.
		</div>';
	} else {		
		$servidor = $ipftpemblema;
		$caminho_absoluto = $caminhoftpemblema;
		$arquivo = $_FILES['arquivo'];
		$con_id = ftp_connect($servidor) or die( '<script>alert("Não conectou em: '.$servidor.'");</script>');
		ftp_login( $con_id, $userftpemblema, $senhaftpemblema );
		ftp_pasv($con_id, true) or die('<script>alert("Não foi possível entrar no modo passivo.")</script>'); 
		if ( @ftp_put( $con_id, $caminho_absoluto.$cod.'.gif', $arquivo_temp, FTP_BINARY  ) ) {

			echo '<div class="alert alert-success background-success">
			<strong>Successo!</strong> Emblema hospedado com sucesso!
			</div>';

			addlog('Hospedou o emblema '.$cod);

													# Adiciona na badge_definitions          
			$nome = gs($_POST['nome']);
			$desc = gs($_POST['desc']);
			$requi = "";

			$dbh = new PDO( 'mysql:host=' .$iphospedagem. ';dbname=' . $server['uservestacp']."_hotel", $server['uservestacp']."_hotel", $server['senhavestacp']);
			$getMessageUser = $dbh->prepare("INSERT INTO badge_definitions VALUES (:codigo, :requi, :nome)");
			$getMessageUser->bindParam(':codigo', $cod, PDO::PARAM_INT);
			$getMessageUser->bindParam(':requi', $requi, PDO::PARAM_INT);
			$getMessageUser->bindParam(':nome', $nome, PDO::PARAM_INT);
			$getMessageUser->execute();

														# adiciona nome ao emblema
			$stmt = $PDO->prepare('INSERT INTO `emblemas` (`codigo`, `nome`, `descricao`, `usuario`, `timestamp`) VALUES (:cod, :nome, :descr, :usuario, "'.time().'");');
			$stmt->bindParam(':cod', $cod, PDO::PARAM_INT);
			$stmt->bindParam(':nome', $nome, PDO::PARAM_INT);
			$stmt->bindParam(':descr', $desc, PDO::PARAM_INT);
			$stmt->bindParam(':usuario', $_SESSION['nomeusuario'], PDO::PARAM_INT);
			$stmt->execute();

														///atualiza os emblemas no emu
			function AtualizaEmblemasRCON($command, $data, $ipemu, $portamus) {
				$rconData = $command . chr(1) .$data;
				$rcon = socket_create(AF_INET, SOCK_STREAM, getprotobyname('tcp'));
				socket_connect($rcon, $ipemu, $portamus);
				socket_send($rcon, $rconData, strlen($rconData), MSG_DONTROUTE);
				socket_close($rcon);
			}
			AtualizaEmblemasRCON('reloadbadges','', $ipvps, $server['portamus']);
													/////// fim
		} else {
			echo '<div class="alert alert-danger background-danger">
			<strong>Erro!</strong> Erro ao hospedar emblema!
			</div>'; 	} 
			ftp_close( $conexao_ftp );

		}
	}
}
?>
<div class="row">
	<script type="text/javascript">
		function maiuscula(z){
			v = z.value.toUpperCase();
			z.value = v;
		}
	</script>
	<label class="col-sm-4 col-lg-2 col-form-label">Código</label>
	<div class="col-sm-8 col-lg-10">
		<div class="input-group" >
			<span class="input-group-addon" id="basic-addon1" title="Inserimos o id do servidor na frente do código para não ter problemas de emblemas repetidos no servidor."><?php echo strtoupper($server['id']);?></span>
			<input type="text" name="cod" class="FORM-CONTROL-UPPERCASE" onkeyup="maiuscula(this)"  maxlength="6" required>
		</div>
	</div>
</div>
<div class="row">
	<label class="col-sm-4 col-lg-2 col-form-label">Nome</label>
	<div class="col-sm-8 col-lg-10">
		<div class="input-group">																	
			<input type="text" name="nome" class="form-control" placeholder="Nome do emblema" required>
		</div>
	</div>
</div>
<div class="row">
	<label class="col-sm-4 col-lg-2 col-form-label">Descrição</label>
	<div class="col-sm-8 col-lg-10">
		<div class="input-group">
			<input type="text" name="desc" class="form-control" placeholder="Descrição do emblema" required>
		</div>
	</div>
</div>
<div class="row">
	<label class="col-sm-4 col-lg-2 col-form-label">Emblema</label>
	<div class="col-sm-8 col-lg-10">
		<div class="input-group">																	 
			<input  type="file" name="arquivo" id="filer_input" required>
		</div>
	</div>
</div>
</div>
<center><button type="submit" name="hospedar-emblema" style="border-radius: 8px;" class="btn btn-primary m-b-0">Hospedar</button></center>
</form>
<?php }?>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<script type="text/javascript" src="galaxyservers/bower_components/jquery/js/jquery.min.js"></script>
<script type="text/javascript" src="galaxyservers/bower_components/jquery-ui/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="galaxyservers/bower_components/popper.js/js/popper.min.js"></script>
<script type="text/javascript" src="galaxyservers/bower_components/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="galaxyservers/bower_components/jquery-slimscroll/js/jquery.slimscroll.js"></script>
<script type="text/javascript" src="galaxyservers/bower_components/modernizr/js/modernizr.js"></script>
<script type="text/javascript" src="galaxyservers/bower_components/modernizr/js/css-scrollbars.js"></script>
<script src="galaxyservers/assets/pages/jquery.filer/js/jquery.filer.min.js"></script>
<script src="galaxyservers/assets/pages/filer/custom-filer.js" type="text/javascript"></script>
<script src="galaxyservers/assets/pages/filer/jquery.fileuploads.init.js?a=a" type="text/javascript"></script>
<script type="text/javascript" src="galaxyservers/bower_components/i18next/js/i18next.min.js"></script>
<script type="text/javascript" src="galaxyservers/bower_components/i18next-xhr-backend/js/i18nextXHRBackend.min.js"></script>
<script type="text/javascript" src="galaxyservers/bower_components/i18next-browser-languagedetector/js/i18nextBrowserLanguageDetector.min.js"></script>
<script type="text/javascript" src="galaxyservers/bower_components/jquery-i18next/js/jquery-i18next.min.js"></script>
<script src="galaxyservers/assets/js/pcoded.min.js"></script>
<script src="galaxyservers/assets/js/demo-12.js"></script>
<script src="galaxyservers/assets/js/jquery.mCustomScrollbar.concat.min.js"></script>
<script type="text/javascript" src="galaxyservers/assets/js/script.js"></script>
</body>
</html><?php } else header('Location: ../index'); ?>
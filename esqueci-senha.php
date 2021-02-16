<?php include "galaxyservers/global.php";
if(isset($_SESSION['nomeusuario'])){
	echo '<script>location.href="principal";</script>';
}

if(empty($_SESSION['count_login_error']))
	$_SESSION['count_login_error'] = 0

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>GalaxyPanel v<?php echo $versaopainel;?> - Recuperar Senha.</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="description" content="Painel de gerenciamento do GalaxyServer versão <?php echo $versaopainel;?>.">
	<meta name="keywords" content="habbo,galaxy,emulator,plusemu,habbo server">
	<meta property="og:image" content="https://i.imgur.com/km1xrsA.png" />
	<meta name="author" content="GalaxyServers.">
	<link rel="icon" href="galaxyservers/assets/images/favicon.ico" type="image/x-icon">
	<link rel="stylesheet" type="text/css" href="galaxyservers/bower_components/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="galaxyservers/assets/icon/themify-icons/themify-icons.css">
	<link rel="stylesheet" type="text/css" href="galaxyservers/assets/icon/icofont/css/icofont.css">
	<link rel="stylesheet" type="text/css" href="galaxyservers/assets/css/style.css?GalaxyPanel">
</head>
<body class="fix-menu">
	<div class="theme-loader">
		<div class="preloader3 loader-block" style="padding-top:25%">
			<div class="circ1 loader-primary loader-lg"></div>
			<div class="circ2 loader-primary loader-lg"></div>
			<div class="circ3 loader-primary loader-lg"></div>
			<div class="circ4 loader-primary loader-lg"></div>
		</div>
	</div>
	<section class="login p-fixed d-flex text-center bg-primary">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<div class="login-card card-block auth-body mr-auto ml-auto">
						<form class="md-float-material" method="POST" name="login">
							<div class="text-center">
								<br>
								<img src="<?= $logo_login;?>" draggable="false" alt="logo.png" <?= $style_login;?>>
							</div>
							<div class="auth-box">
								<div class="row m-b-20">
									<div class="col-md-12">
										<h3 class="text-left txt-primary">Recupere sua senha</h3>
									</div>
								</div>
								<hr />
								<?php
								if(isset($_POST['recuperar'])){

									if($_SESSION['count_login_error'] >= 10){
										$segundosblock = time() - $_SESSION['last_login_error'];
										if($segundosblock >= 600){
											$continua = true;
										} else {
											$faltasegundos = $segundosblock - 600;
											loginerror("Espere ".str_replace("-", "", $faltasegundos)." segundos para tentar novamente.");
											$continua = false;
										}
									} else {
										$continua = true;
									}
									if($continua){

										if(empty($_POST['email']))
											loginerror("Email vazio.");
										else {
											$email = gs($_POST['email']);
											$contauser = $PDO->prepare("SELECT * FROM servidores WHERE emailcliente = :email");
											$contauser->bindParam(':email', $email);
											$contauser->execute();
											$contauserr = $contauser->fetch();

											if($contauserr['ativo'] == 'N')
												loginerror("A sua conta foi bloqueada, entre em contato com o suporte para saber mais.");

											else if($contauser->rowCount() == 1 && $contauserr['ativo'] == 'Y'){

												require_once('galaxyservers/class.phpmailer.php');

												$dsh = str_replace("http://", null, str_replace("https://", null, $contauserr['linkhotel']));

												$bodygalaxy = file_get_contents('galaxyservers/dadosemail.html');
												$bodygalaxy = str_replace("%usuario%", $contauserr['uservestacp'], $bodygalaxy);
												$bodygalaxy = str_replace("%senha%", $contauserr['senhavestacp'], $bodygalaxy);
												$bodygalaxy = str_replace("%http%", $contauserr['http'], $bodygalaxy);
												$bodygalaxy = str_replace("%link%", $dsh, $bodygalaxy);
												$bodygalaxy = str_replace("%dominiogalaxypanel%", $dominio, $bodygalaxy);
												$mail = new PHPMailer();
												$mail->IsSMTP();
												$mail->SMTPDebug = 0;                       
												$mail->SMTPAuth = true; 
												$mail->SMTPSecure = "tls";
												$mail->Host = $hostemail;
												$mail->Port = $portaemail; 
												$mail->Username = $useremail;
												$mail->Password = $senhaemail; 
												$mail->SetFrom($emailemail, "GalaxyPanel");
												$mail->CharSet = 'UTF-8';
												$mail->Subject = "GalaxyPanel - Dados de ".$contauserr['nomehotel'];
												$mail->AltBody = "GalaxyPanel - Dados de ".$contauserr['nomehotel'];
												$mail->MsgHTML($bodygalaxy);
												$address = $email;
												$mail->AddAddress($address, $contauserr['nomehotel']);
												if($mail->Send()){
													loginsucess("Email com dados enviado.");
													$adicionalog = $PDO->prepare("INSERT INTO `log_servidores` (`log`, `autor`, `ip`, `data`) VALUES ('Enviou dados por email.', '".$contauserr['nomeusuario']."', '".$meuip."', '".time()."');");
													$adicionalog->execute();
												}
												else 
													loginerror("Erro ao enviar email.");

												$_SESSION['count_login_error'] = 0;
												$_SESSION['last_login_error'] = 0;
												
											} else if($contauser->rowCount() > 1){
												loginerror("Tem mais de um hotel cadastrado no seu email! entre em contato com o suporte.");
											}
											else {
												$_SESSION['last_login_error'] = time();
												$_SESSION['count_login_error'] = $_SESSION['count_login_error'] + 1;
												loginerror("Nenhuma conta encontrada com o email indicado. (".$_SESSION['count_login_error'].")");
											}
										}
									}
								}
								?>
								<div class="input-group">
									<input type="text" class="form-control" name="email" placeholder="Seu email">
									<span class="md-line"></span>
								</div>

								<div class="row m-t-30">
									<div class="col-md-12">
										<input type="submit" style="background-color: #7b5eea;border-color: #6c50d6;" value="Recuperar" name="recuperar" class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20" />
									</div>
								</div>
								<hr />
								<div class="row">
									<div class="col-md-10">
										<p class="text-inverse text-left"><b><a href="http://galaxyservers.com.br/">Powered by GalaxyServers.</a></b></p>
									</div>
									<p class="text-inverse text-right"><b><a href="/" style="position: fixed;">Voltar</a></b></p>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>
	<script type="text/javascript" src="galaxyservers/bower_components/jquery/js/jquery.min.js"></script>
	<script type="text/javascript" src="galaxyservers/bower_components/jquery-ui/js/jquery-ui.min.js"></script>
	<script type="text/javascript" src="galaxyservers/bower_components/popper.js/js/popper.min.js"></script>
	<script type="text/javascript" src="galaxyservers/bower_components/bootstrap/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="galaxyservers/bower_components/jquery-slimscroll/js/jquery.slimscroll.js"></script>
	<script type="text/javascript" src="galaxyservers/bower_components/modernizr/js/modernizr.js"></script>
	<script type="text/javascript" src="galaxyservers/bower_components/modernizr/js/css-scrollbars.js"></script>
	<script type="text/javascript" src="galaxyservers/bower_components/i18next/js/i18next.min.js"></script>
	<script type="text/javascript" src="galaxyservers/bower_components/i18next-xhr-backend/js/i18nextXHRBackend.min.js"></script>
	<script type="text/javascript" src="galaxyservers/bower_components/i18next-browser-languagedetector/js/i18nextBrowserLanguageDetector.min.js"></script>
	<script type="text/javascript" src="galaxyservers/bower_components/jquery-i18next/js/jquery-i18next.min.js"></script>
	<script type="text/javascript" src="galaxyservers/assets/js/common-pages.js"></script>
</body>
</html>
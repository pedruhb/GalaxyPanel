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
	<title>GalaxyPanel v<?php echo $versaopainel;?> - Login.</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="description" content="Painel de gerenciamento do GalaxyServer versão <?php echo $versaopainel;?>.">
	<meta name="keywords" content="habbo,galaxy,emulator,plusemu,habbo server">
	<meta property="og:image" content="https://i.imgur.com/HSRqbBz.jpg" />
	<meta name="author" content="GalaxyServers.">
	<link rel="icon" href="https://galaxyservers.com.br/assets/galaxy/favicon.png">
	<link rel="stylesheet" type="text/css" href="galaxyservers/bower_components/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="galaxyservers/assets/icon/themify-icons/themify-icons.css">
	<link rel="stylesheet" type="text/css" href="galaxyservers/assets/icon/icofont/css/icofont.css">
	<link rel="stylesheet" type="text/css" href="galaxyservers/assets/css/style.css?GalaxyPanel">
	<script src="https://kit.fontawesome.com/ef1d1bbf7a.js" crossorigin="anonymous"></script>

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
										<h3 class="text-left txt-primary">Login Cliente</h3>
									</div>
								</div>
								<hr />
								<?php
								if(isset($_POST['login'])){

									if($_SESSION['count_login_error'] >= 10){
										$segundosblock = time() - $_SESSION['last_login_error'];
										if($segundosblock >= 600){
											$continua = true;
										} else {
											$faltasegundos = $segundosblock - 600;
											loginerror("Espere ".str_replace("-", "", $faltasegundos)." segundos para tentar logar novamente.");
											$continua = false;
										}
									} else {
										$continua = true;
									}
									if($continua){
										if(empty($_POST['usuario']))
											loginerror("Usuário vazio.");
										else if (empty($_POST['senha']))
											loginerror("Senha vazia.");
										else {
											$usuario = $_POST['usuario'];
											$senha = $_POST['senha'];
											
											if(strpos($usuario, '_') !== false){

												$contausersub = $PDO->prepare("SELECT id,servidor FROM sub_contas WHERE usuario = :usuario and senha = :senha");
												$contausersub->bindParam(':usuario', $usuario);
												$contausersub->bindParam(':senha', $senha);
												$contausersub->execute();
												$contasub = $contausersub->fetch();
												$totalcontassub = $contausersub->rowCount();

												if($totalcontassub == 1){

													$contauser = $PDO->prepare("SELECT nomeusuario,senhavestacp,ativo FROM servidores where id = :id");
													$contauser->bindParam(':id', $contasub['servidor']);
													$contauser->execute();
													$contauserr = $contauser->fetch();

													if($contauserr['ativo'] == 'N')
														loginerror("Conta do servidor bloqueada.");
													else {
														$_SESSION['nomeusuario'] = $contauserr['nomeusuario'];
														$_SESSION['senhalogin'] = $contauserr['senhavestacp'];
														$_SESSION['senhaatualdb'] = $contauserr['senhavestacp'];
														$_SESSION['subconta'] = $contasub['id'];
														$adicionalog = $PDO->prepare("INSERT INTO `log_servidores` (`log`, `autor`, `ip`, `data`) VALUES ('Sub conta ".$usuario." logou no painel.', '".$_SESSION['nomeusuario']."', '".$meuip."', '".time()."');");
														$adicionalog->execute();
														echo '<meta http-equiv="refresh" content=1;url="principal">';
														$_SESSION['count_login_error'] = 0;
														$_SESSION['last_login_error'] = 0;

														loginsucess("Seja bem vindo ao painel. (sub)");
													}
												} else {
													$_SESSION['last_login_error'] = time();
													$_SESSION['count_login_error'] = $_SESSION['count_login_error'] + 1;
													loginerror("Dados incorretos. (".$_SESSION['count_login_error'].")");
												}

											} else {
												$contauser = $PDO->prepare("SELECT COUNT(ID) as total,nomeusuario,senhavestacp,ativo,login_dados FROM servidores where nomeusuario = :usuario and senhavestacp = :senha");
												$contauser->bindParam(':usuario', $usuario);
												$contauser->bindParam(':senha', $senha);
												$contauser->execute();
												$contauserr = $contauser->fetch();
												if($contauserr['login_dados'] == 'N')
													loginerror("Só pode fazer login por SMS ou Email.");
												else if($contauserr['ativo'] == 'N')
													loginerror("A sua conta foi bloqueada, entre em contato com o suporte para saber mais.");
												else if($contauserr['total'] == 1 && $contauserr['ativo'] == 'Y'){
													if($senha != $contauserr['senhavestacp'])
														loginerror("Erro na escrita da senha.");
													else {
														loginsucess("Seja bem vindo ao painel.");
														$_SESSION['nomeusuario'] = $contauserr['nomeusuario'];
														$_SESSION['senhalogin'] = $senha;
														$_SESSION['senhaatualdb'] = $senha;
														$adicionalog = $PDO->prepare("INSERT INTO `log_servidores` (`log`, `autor`, `ip`, `data`) VALUES ('Logou no painel.', '".$_SESSION['nomeusuario']."', '".$meuip."', '".time()."');");
														$adicionalog->execute();
														echo '<meta http-equiv="refresh" content=1;url="principal">';
														$_SESSION['count_login_error'] = 0;
														$_SESSION['last_login_error'] = 0;
													}
												} else {
													$_SESSION['last_login_error'] = time();
													$_SESSION['count_login_error'] = $_SESSION['count_login_error'] + 1;
													loginerror("Dados incorretos. (".$_SESSION['count_login_error'].")");
												}
											}
										}
									}
								}
								?>
								<div class="input-group">
									<input type="text" class="form-control" name="usuario" placeholder="Nome de usuário">
									<span class="md-line"></span>
								</div>
								<div class="input-group">
									<input type="password" name="senha" class="form-control" placeholder="Senha">
									<span class="md-line"></span>
								</div>
								<div class="row m-t-30">
									<div class="col-md-12">
										<input type="submit" style="background-color: #7b5eea;border-color: #6c50d6;" value="Entrar" name="login" class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20" />
									</div>
								</div>

								<div class="row text-left">
									<div class="col-12">
										<div class="forgot-phone text-right f-right">
											<a href="/esqueci-senha" class="text-right f-w-600 text-inverse"> Esqueci a senha</a>
										</div>			
									</div>
								</div>
								<hr />
								<div class="row m-b-20" style="margin-bottom: -20px;">
									<div class="col-md-6">
										<button onclick="location.href='/login-discord'" type="button" class="btn btn-facebook m-b-20" style="background-color: #7289DA; border-color: #7289DA;"><i class="fab fa-discord"></i> Login via Discord</button>
									</div>
									<div class="col-md-6" style="padding-left: 0px;">
										<button onclick="location.href='/accountkit'" type="button" class="btn btn-twitter m-b-20"><i class="fas fa-user-alt"></i> Login via SMS/Email</button>
									</div>
								</div>

								<hr />

								<div class="row">
									<div class="col-md-10">
										<p class="text-inverse text-left"><b><a href="http://galaxyservers.com.br/">Powered by GalaxyServers.</a></b></p>
									</div>
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
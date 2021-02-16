<?php
if(!defined("GALAXYSERVERS")) { die("Você não pode acessar esse arquivo."); }

if($server['ativo'] == 'N'){
	echo '<script>alert("Seu hotel foi suspenso!");window.location.href = "/sair";</script>';
	return;
}

if(empty($server['nomehotel'])){
	echo '<script>window.location.href = "/sair";</script>';
	return;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title><?php echo $server['nomehotel'];?> - GalaxyPanel v<?php echo $versaopainel;?><?php if(isset($_SESSION['subconta']))echo " - SUBCONTA" ?></title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="description" content="#">
	<meta name="keywords" content="Painel administrativo do Galaxy Server v<?php echo $versaopainel;?>.">
	<meta name="author" content="#">
	<link rel="icon" href="https://galaxyservers.com.br/assets/galaxy/favicon.png">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="<?php echo $dominio;?>/galaxyservers/bower_components/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $dominio;?>/galaxyservers/assets/icon/themify-icons/themify-icons.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $dominio;?>/galaxyservers/assets/icon/icofont/css/icofont.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $dominio;?>/galaxyservers/assets/pages/notification/notification.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $dominio;?>/galaxyservers/assets/pages/menu-search/css/component.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $dominio;?>/galaxyservers/assets/css/style.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $dominio;?>/galaxyservers/assets/css/jquery.mCustomScrollbar.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $dominio;?>/galaxyservers/assets/icon/font-awesome/css/font-awesome.min.css">
	<link href="<?php echo $dominio;?>/galaxyservers/assets/pages/jquery.filer/css/jquery.filer.css" type="text/css" rel="stylesheet" />
	<link href="<?php echo $dominio;?>/galaxyservers/assets/pages/jquery.filer/css/themes/jquery.filer-dragdropbox-theme.css" type="text/css" rel="stylesheet" />
	<link rel="stylesheet" type="text/css" href="<?php echo $dominio;?>/galaxyservers/bower_components/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $dominio;?>/galaxyservers/assets/pages/data-table/css/buttons.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $dominio;?>/galaxyservers/bower_components/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $dominio;?>/galaxyservers/assets/pages/data-table/extensions/autofill/css/autoFill.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $dominio;?>/galaxyservers/assets/pages/data-table/extensions/autofill/css/select.dataTables.min.css">
</head>
<body>
	<div class="theme-loader">			
		<div class="preloader3 loader-block" style="padding-top:25%">
			<div class="circ1 loader-primary loader-lg"></div>
			<div class="circ2 loader-primary loader-lg"></div>
			<div class="circ3 loader-primary loader-lg"></div>
			<div class="circ4 loader-primary loader-lg"></div>
		</div>
	</div>
	<div id="pcoded" class="pcoded">
		<div class="pcoded-overlay-box"></div>
		<div class="pcoded-container navbar-wrapper">
			<nav class="navbar header-navbar pcoded-header">
				<div class="navbar-wrapper">
					<div class="navbar-logo">
						<a class="mobile-menu" id="mobile-collapse" href="#" style=" height: 30px; padding-top: 7.5; ">
							<i class="ti-menu"></i>
						</a>
					</a>
					<a href="<?php echo $dominio;?>/principal">
						<font color="white">
							<script type="text/javascript">
								var width = screen.width;
								if(width < 900)
								{
									
								}
								else {
									document.write('<img class="img-fluid" id="logogalaxy" draggable="false" src="<?= $logo_resto;?>" alt="GalaxyServers" <?= $style_resto;?>>');
								}
							</script>
						</font>
					</a>
				</div>
			</div>
		</nav>
		<div class="pcoded-main-container">
			<div class="pcoded-wrapper">
				<nav class="pcoded-navbar">
					<div class="sidebar_toggle"><a href="#"><i class="icon-close icons"></i></a></div>
					<div class="pcoded-inner-navbar main-menu">
						<div class="">
							<div class="main-menu-header">
								<img class="img-40 img-radius" src="<?php echo $dominio;?>/galaxyservers/assets/images/avatar-4.jpg" alt="<?php echo $server['nomehotel'];?> Hotel">
								<div class="user-details">
									<span><?php echo $server['nomehotel'];?> Hotel</span>
									<?php

									try {
										$PDO2 = new PDO('mysql:host='.$iphospedagem.';dbname='.$server['uservestacp']."_hotel", $server['uservestacp']."_hotel", $server['senhavestacp']);
										$PDO2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
										
										$infoserver2 = $PDO2->prepare("SELECT status FROM server_status");
										$infoserver2->execute();
										$informacao = $infoserver2->fetch();
										$statusint = $informacao['status'];

									} catch(PDOException $e) {
										echo '<script>alert("Erro de conexão ao hotel: ' . utf8_encode($e->getMessage()).'");</script>';
										$statusint = 0;
									} 
									if($statusint == "2" && $server['estado'] == "ligado")
										$status = "ligado";
									else $status = "desligado";

									$plano = $PDO->prepare("SELECT * FROM planos WHERE id = :id");
									$plano->bindParam(":id", $server['plano']);
									$plano->execute();
									$planoi = $plano->fetch();

									?>
									<span style="text-transform: inherit;" >O emulador está <?php echo $status;?>.</span>
								</div>
							</div>
						</div>
						<div class="pcoded-navigatio-lavel" data-i18n="nav.category.navigation">Navegação</div>
						<ul class="pcoded-item pcoded-left-item">
							<li class=" ">
								<a href="<?php echo $dominio;?>/principal">
									<span class="pcoded-micon"><i class="ti-home"></i><b>I</b></span>
									<span class="pcoded-mtext" data-i18n="nav.dash.main">Início</span>
								</a>
							</li>
							<li class="pcoded-hasmenu">
								<a href="javascript:void(0)">
									<span class="pcoded-micon"><i class="fa fa-rocket"></i><b>E</b></span>
									<span class="pcoded-mtext" data-i18n="nav.page_layout.main">Emulador</span>
									<span class="pcoded-mcaret"></span>
								</a>
								<ul class="pcoded-submenu">
									<?php if(permissao("logemulador")){ ?>
										<li class=" ">
											<a href="<?php echo $dominio;?>/log-emu" target="">
												<span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
												<span class="pcoded-mtext" data-i18n="nav.page_layout.box-layout">Log's do emulador</span>
												<span class="pcoded-mcaret"></span>
											</a>
										</li>
									<?php } if(permissao("bemvindo")){ ?>
										<li class=" ">
											<a href="<?php echo $dominio;?>/bemvindo" target="">
												<span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
												<span class="pcoded-mtext" data-i18n="nav.page_layout.box-layout">Mensagem Bem Vindo</span>
												<span class="pcoded-mcaret"></span>
											</a>
										</li>
									<?php } if(permissao("config")){ ?>
										<li class=" ">
											<a href="<?php echo $dominio;?>/config" target="">
												<span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
												<span class="pcoded-mtext" data-i18n="nav.page_layout.rtl">Configurações</span>
												<span class="pcoded-mcaret"></span>
											</a>
										</li>
									<?php }?>
								</ul>
							</li>
							<li class="pcoded-hasmenu">
								<a href="javascript:void(0)">
									<span class="pcoded-micon"><i class="fa fa-picture-o"></i><b>E</b></span>
									<span class="pcoded-mtext" data-i18n="nav.widget.main">Emblemas</span>
									<span class="pcoded-mcaret"></span>
								</a>
								<ul class="pcoded-submenu">
									<?php if(permissao("hospemblema")){ ?>
										<li class="">
											<a href="<?php echo $dominio;?>/hospedar-emblema">
												<span class="pcoded-micon"><i class="ti-angle-right"></i></span>
												<span class="pcoded-mtext" data-i18n="nav.navigate.navbar">Hospedar Emblema</span>
												<span class="pcoded-mcaret"></span>
											</a>
										</li>
									<?php } if(permissao("embhospedados")){ ?>
										<li class="">
											<a href="<?php echo $dominio;?>/emblemas-hospedados">
												<span class="pcoded-micon"><i class="ti-angle-right"></i></span>
												<span class="pcoded-mtext" data-i18n="nav.navigate.navbar-inverse">Emblemas Hospedados</span>
												<span class="pcoded-mcaret"></span>
											</a>
										</li>
									<?php } if(permissao("embgames")){ ?>
										<li class="">
											<a href="<?php echo $dominio;?>/emblemas-game">
												<span class="pcoded-micon"><i class="ti-angle-right"></i></span>
												<span class="pcoded-mtext" data-i18n="nav.navigate.navbar">Emblemas Eventos</span>
												<span class="pcoded-mcaret"></span>
											</a>
										</li>
									<?php }?>
								</ul>
							</li>
							<li class="pcoded-hasmenu">
								<a href="javascript:void(0)">
									<span class="pcoded-micon"><i class="fa fa-star"></i><b>R</b></span>
									<span class="pcoded-mtext" data-i18n="nav.widget.main">Raros LTD</span>
									<span class="pcoded-mcaret"></span>
								</a>
								<ul class="pcoded-submenu">
									<?php if(permissao("addltd")){ ?>
										<li class="">
											<a href="<?php echo $dominio;?>/add-ltd">
												<span class="pcoded-micon"><i class="ti-angle-right"></i></span>
												<span class="pcoded-mtext" data-i18n="nav.navigate.navbar">Adicionar LTD</span>
												<span class="pcoded-mcaret"></span>
											</a>
										</li>
									<?php } if(permissao("gerenciarltd")){ ?>
										<li class="">
											<a href="<?php echo $dominio;?>/raros">
												<span class="pcoded-micon"><i class="ti-angle-right"></i></span>
												<span class="pcoded-mtext" data-i18n="nav.navigate.navbar">Gerenciar raros</span>
												<span class="pcoded-mcaret"></span>
											</a>
										</li>
									<?php }?>
								</ul>
							</li>
							<li class="pcoded-hasmenu">
								<a href="javascript:void(0)">
									<span class="pcoded-micon"><i class="fa fa-server"></i><b>E</b></span>
									<span class="pcoded-mtext" data-i18n="nav.widget.main">Gerenciamento</span>
									<span class="pcoded-mcaret"></span>
								</a>
								<ul class="pcoded-submenu">
									<?php if(!isset($_SESSION['subconta'])){ ?>
										<li class=" ">
											<a href="<?php echo $dominio;?>/banco-de-dados">
												<span class="pcoded-micon"><i class="ti-angle-right"></i></span>
												<span class="pcoded-mtext" data-i18n="nav.navigate.navbar">Banco de dados</span>
												<span class="pcoded-mcaret"></span>
											</a>
										</li>
										<li class=" ">
											<a href="<?php echo $dominio;?>/acesso-ftp">
												<span class="pcoded-micon"><i class="ti-angle-right"></i></span>
												<span class="pcoded-mtext" data-i18n="nav.navigate.navbar-inverse">Arquivos (FTP)</span>
												<span class="pcoded-mcaret"></span>
											</a>
										</li>
										<li class=" ">
											<a href="<?php echo $dominio;?>/ger-arquivos" target="_blank">
												<span class="pcoded-micon"><i class="ti-angle-right"></i></span>
												<span class="pcoded-mtext" data-i18n="nav.navigate.navbar-inverse">Arquivos (File Manager)</span>
												<span class="pcoded-mcaret"></span>
											</a>
										</li>
										<li class=" ">
											<a href="<?php echo $dominio;?>/backups" target="">
												<span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
												<span class="pcoded-mtext" data-i18n="nav.page_layout.box-layout">Backups</span>
												<span class="pcoded-mcaret"></span>
											</a>
										</li>
										<li class=" ">
											<a href="<?php echo $dominio;?>/sql" target="">
												<span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
												<span class="pcoded-mtext" data-i18n="nav.page_layout.box-layout">Executar SQL</span>
												<span class="pcoded-mcaret"></span>
											</a>
										</li>
									<?php }?>
									<?php if($planoi['galaxyhk'] == "true"){ ?>
										<li class=" ">
											<a href="<?php echo $dominio;?>/configurar-hk">
												<span class="pcoded-micon"><i class="ti-angle-right"></i></span>
												<span class="pcoded-mtext" data-i18n="nav.navigate.navbar-inverse">Configurar HK</span>
												<span class="pcoded-mcaret"></span>
											</a>
										</li>
									<?php } ?>
									<?php if(permissao("configcms")){ ?>
										<li class=" ">
											<a href="<?php echo $dominio;?>/configurar-cms">
												<span class="pcoded-micon"><i class="ti-angle-right"></i></span>
												<span class="pcoded-mtext" data-i18n="nav.navigate.navbar-inverse">Config. CMS</span>
												<span class="pcoded-mcaret"></span>
											</a>
										</li>
										<li class=" ">
											<a href="<?php echo $dominio;?>/gerador-logo">
												<span class="pcoded-micon"><i class="ti-angle-right"></i></span>
												<span class="pcoded-mtext" data-i18n="nav.navigate.navbar-inverse">Gerar Logo</span>
												<span class="pcoded-mcaret"></span>
											</a>
										</li>
									<?php } if(permissao("infohotel")){ ?>
										<li class=" ">
											<a href="<?php echo $dominio;?>/info-hotel">
												<span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
												<span class="pcoded-mtext" data-i18n="nav.page_layout.bottom-menu">Informações do hotel</span>
												<span class="pcoded-mcaret"></span>
											</a>
										</li>
									<?php } if(permissao("frank")){ ?>
										<li class=" ">
											<a href="<?php echo $dominio;?>/frank">
												<span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
												<span class="pcoded-mtext" data-i18n="nav.page_layout.bottom-menu">Configurar Frank</span>
												<span class="pcoded-mcaret"></span>
											</a>
										</li>
									<?php }?>
									<?php if(!isset($_SESSION['subconta'])){ ?>
										<li class=" ">
											<a href="<?php echo $dominio;?>/senha">
												<span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
												<span class="pcoded-mtext" data-i18n="nav.page_layout.bottom-menu">Alterar senha</span>
												<span class="pcoded-mcaret"></span>
											</a>
										</li>
										<li class=" ">
											<a href="<?php echo $dominio;?>/dominio">
												<span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
												<span class="pcoded-mtext" data-i18n="nav.page_layout.bottom-menu">Alterar domínio</span>
												<span class="pcoded-mcaret"></span>
											</a>
										</li>
									<?php }?>
									<?php  if(permissao("frontpage")){ ?>
										<?php if($planoi['frontpage'] == "true"){ ?>
											<li class=" ">
												<a href="<?php echo $dominio;?>/frontpage">
													<span class="pcoded-micon"><i class="ti-angle-right"></i></span>
													<span class="pcoded-mtext" data-i18n="nav.navigate.navbar-inverse">Frontpage Catálogo</span>
													<span class="pcoded-mcaret"></span>
												</a>
											</li>
										<?php }} ?>
										<?php  if(permissao("vistas")){ ?>
											<li class=" ">
												<a href="<?php echo $dominio;?>/vistas">
													<span class="pcoded-micon"><i class="ti-angle-right"></i></span>
													<span class="pcoded-mtext" data-i18n="nav.navigate.navbar-inverse">Vistas do hotel</span>
													<span class="pcoded-mcaret"></span>
												</a>
											</li>
										<?php } ?>
										<?php if(permissao("comandos")){ ?>
											<li class="">
												<a href="<?php echo $dominio;?>/comandos">
													<span class="pcoded-micon"><i class="ti-angle-right"></i></span>
													<span class="pcoded-mtext" data-i18n="nav.navigate.navbar">Comandos</span>
													<span class="pcoded-mcaret"></span>
												</a>
											</li>
										<?php } ?>
										<?php if(permissao("catalogo")){ ?>
											<li class="">
												<a href="<?php echo $dominio;?>/catalogo">
													<span class="pcoded-micon"><i class="ti-angle-right"></i></span>
													<span class="pcoded-mtext" data-i18n="nav.navigate.navbar">Catálogo</span>
													<span class="pcoded-mcaret"></span>
												</a>
											</li>
										<?php }?>
										<?php  if(permissao("monetizacao")){ ?>
											<li class="pcoded-hasmenu pcoded-trigger" dropdown-icon="style1" subitem-icon="style6">
												<a href="javascript:void(0)">
													<span class="pcoded-micon"><i class="ti-direction-alt"></i></span>
													<span class="pcoded-mtext" data-i18n="nav.menu-levels.menu-level-22.main">Monetização</span>
													<span class="pcoded-mcaret"></span>
												</a>
												<ul class="pcoded-submenu">
													<li class="">
														<a href="<?php echo $dominio;?>/monetizacao-premiar">
															<span class="pcoded-micon"><i class="ti-angle-right"></i></span>
															<span class="pcoded-mtext" data-i18n="nav.navigate.navbar">Premiar</span>
															<span class="pcoded-mcaret"></span>
														</a>
													</li>
													<li class="">
														<a href="<?php echo $dominio;?>/monetizacao-premiodiario">
															<span class="pcoded-micon"><i class="ti-angle-right"></i></span>
															<span class="pcoded-mtext" data-i18n="nav.navigate.navbar">Premio diário</span>
															<span class="pcoded-mcaret"></span>
														</a>
													</li>
													<li class="">
														<a href="<?php echo $dominio;?>/monetizacao-tempo">
															<span class="pcoded-micon"><i class="ti-angle-right"></i></span>
															<span class="pcoded-mtext" data-i18n="nav.navigate.navbar">Por tempo</span>
															<span class="pcoded-mcaret"></span>
														</a>
													</li>
												</ul>
											</li>
										<?php }?>

										<?php  if(permissao("voucher")){ ?>
											<li class="pcoded-hasmenu pcoded-trigger" dropdown-icon="style1" subitem-icon="style6">
												<a href="javascript:void(0)">
													<span class="pcoded-micon"><i class="ti-direction-alt"></i></span>
													<span class="pcoded-mtext" data-i18n="nav.menu-levels.menu-level-22.main">Voucher</span>
													<span class="pcoded-mcaret"></span>
												</a>
												<ul class="pcoded-submenu">
													<li class="">
														<a href="<?php echo $dominio;?>/gerar-voucher">
															<span class="pcoded-micon"><i class="ti-angle-right"></i></span>
															<span class="pcoded-mtext" data-i18n="nav.navigate.navbar">Criar</span>
															<span class="pcoded-mcaret"></span>
														</a>
													</li>
													<li class="">
														<a href="<?php echo $dominio;?>/vouchers">
															<span class="pcoded-micon"><i class="ti-angle-right"></i></span>
															<span class="pcoded-mtext" data-i18n="nav.navigate.navbar">Gerenciar</span>
															<span class="pcoded-mcaret"></span>
														</a>
													</li>
												</ul>
											</li>
										<?php }?>

										<?php  if(permissao("ranks")){ ?>
											<li class="pcoded-hasmenu pcoded-trigger" dropdown-icon="style1" subitem-icon="style6">
												<a href="javascript:void(0)">
													<span class="pcoded-micon"><i class="ti-direction-alt"></i></span>
													<span class="pcoded-mtext" data-i18n="nav.menu-levels.menu-level-22.main">Permissões</span>
													<span class="pcoded-mcaret"></span>
												</a>
												<ul class="pcoded-submenu">
													<li class="">
														<a href="<?php echo $dominio;?>/ranks">
															<span class="pcoded-micon"><i class="ti-angle-right"></i></span>
															<span class="pcoded-mtext" data-i18n="nav.navigate.navbar">Ver ranks</span>
															<span class="pcoded-mcaret"></span>
														</a>
													</li>
													<li class="">
														<a href="<?php echo $dominio;?>/add-permissao">
															<span class="pcoded-micon"><i class="ti-angle-right"></i></span>
															<span class="pcoded-mtext" data-i18n="nav.navigate.navbar">Adicionar permissão</span>
															<span class="pcoded-mcaret"></span>
														</a>
													</li>
												</ul>
											</li>
										<?php }?>

										<?php if(permissao("editmobis")){ 
											if($planoi['editarmobi'] == "true"){ ?>
												<li class="pcoded-hasmenu pcoded-trigger" dropdown-icon="style1" subitem-icon="style6">
												<a href="javascript:void(0)">
													<span class="pcoded-micon"><i class="ti-direction-alt"></i></span>
													<span class="pcoded-mtext" data-i18n="nav.menu-levels.menu-level-22.main">Edições de mobis</span>
													<span class="pcoded-mcaret"></span>
												</a>
												<ul class="pcoded-submenu">
													<li class="">
														<a href="<?php echo $dominio;?>/modificar-mobi">
															<span class="pcoded-micon"><i class="ti-angle-right"></i></span>
															<span class="pcoded-mtext" data-i18n="nav.navigate.navbar">Editar mobi</span>
															<span class="pcoded-mcaret"></span>
														</a>
													</li>
													<li class="">
														<a href="<?php echo $dominio;?>/mobis-modificados">
															<span class="pcoded-micon"><i class="ti-angle-right"></i></span>
															<span class="pcoded-mtext" data-i18n="nav.navigate.navbar">Ver modificações</span>
															<span class="pcoded-mcaret"></span>
														</a>
													</li>
												</ul>
											</li>
											<?php }} ?>
										</ul>
									</li>
									<?php if(permissao("recms")){ ?>
										<li class="pcoded-hasmenu">
											<a href="javascript:void(0)">
												<span class="pcoded-micon"><i class="fa fa-code	"></i><b>R</b></span>
												<span class="pcoded-mtext" data-i18n="nav.widget.main">Reinstalação</span>
												<span class="pcoded-mcaret"></span>
											</a>
											<ul class="pcoded-submenu">
												<li class=" ">
													<a href="<?php echo $dominio;?>/reinstala-db">
														<span class="pcoded-micon"><i class="ti-angle-right"></i></span>
														<span class="pcoded-mtext" data-i18n="nav.navigate.navbar">Banco de dados</span>
														<span class="pcoded-mcaret"></span>
													</a>
												</li>
												<li class=" ">
													<a href="<?php echo $dominio;?>/reinstala-cms">
														<span class="pcoded-micon"><i class="ti-angle-right"></i></span>
														<span class="pcoded-mtext" data-i18n="nav.navigate.navbar-inverse">CMS</span>
														<span class="pcoded-mcaret"></span>
													</a>
												</li>
												<?php if($planoi['compilar_swf'] == "true"){ ?>
													<li class=" ">
														<a href="<?php echo $dominio;?>/reinstala-camera">
															<span class="pcoded-micon"><i class="ti-angle-right"></i></span>
															<span class="pcoded-mtext" data-i18n="nav.navigate.navbar-inverse">Câmera</span>
															<span class="pcoded-mcaret"></span>
														</a>
													</li>
												<?php } ?>
												<?php if($planoi['galaxyhk'] == "true"){ ?>
													<li class=" ">
														<a href="<?php echo $dominio;?>/reinstalar-hk">
															<span class="pcoded-micon"><i class="ti-angle-right"></i></span>
															<span class="pcoded-mtext" data-i18n="nav.navigate.navbar-inverse">HK</span>
															<span class="pcoded-mcaret"></span>
														</a>
													</li>
												<?php } ?>
												<?php if(permissao("playerradio")){ ?>
													<li class=" ">
														<a href="<?php echo $dominio;?>/player-radio">
															<span class="pcoded-micon"><i class="ti-angle-right"></i></span>
															<span class="pcoded-mtext" data-i18n="nav.navigate.navbar-inverse">Player Rádio</span>
															<span class="pcoded-mcaret"></span>
														</a>
													</li>
												<?php } ?>
													<?php if($planoi['fastfood'] == "true" && permissao("fastfood")){ ?>
													<li class=" ">
														<a href="<?php echo $dominio;?>/fastfood">
															<span class="pcoded-micon"><i class="ti-angle-right"></i></span>
															<span class="pcoded-mtext" data-i18n="nav.navigate.navbar-inverse">Fastfood</span>
															<span class="pcoded-mcaret"></span>
														</a>
													</li>
												<?php } ?>
											</ul>
										</li>
									<?php }?>
									<li class="pcoded-hasmenu">
										<a href="javascript:void(0)">
											<span class="pcoded-micon"><i class="fa fa-upload"></i><b>H</b></span>
											<span class="pcoded-mtext" data-i18n="nav.widget.main">Hospedar</span>
											<span class="pcoded-mcaret"></span>
										</a>
										<ul class="pcoded-submenu">
											<?php if(permissao("hospicone")){ ?>
												<li class="">
													<a href="<?php echo $dominio;?>/hospedar-icone">
														<span class="pcoded-micon"><i class="ti-angle-right"></i></span>
														<span class="pcoded-mtext" data-i18n="nav.navigate.navbar">Hospedar ícone catálogo</span>
														<span class="pcoded-mcaret"></span>
													</a>
												</li>
											<?php } if(permissao("hosplanding")){ ?>
												<li class="">
													<a href="<?php echo $dominio;?>/hospedar-server-landing">
														<span class="pcoded-micon"><i class="ti-angle-right"></i></span>
														<span class="pcoded-mtext" data-i18n="nav.navigate.navbar">Hospedar imagem landing</span>
														<span class="pcoded-mcaret"></span>
													</a>
												</li>
											<?php }?>
											<li class=" ">
												<a href="<?php echo $dominio;?>/hospedar-ads">
													<span class="pcoded-micon"><i class="ti-angle-right"></i></span>
													<span class="pcoded-mtext" data-i18n="nav.navigate.navbar-inverse">Hospedar ADS</span>
													<span class="pcoded-mcaret"></span>
												</a>
											</li>
											<?php  if(permissao("hospswf")){ ?>
												<?php if($planoi['editar_swf'] == "true"){ ?>
													<li class=" ">
														<a href="<?php echo $dominio;?>/hospedar-habbo-swf">
															<span class="pcoded-micon"><i class="ti-angle-right"></i></span>
															<span class="pcoded-mtext" data-i18n="nav.navigate.navbar-inverse">Hospedar Habbo.swf</span>
															<span class="pcoded-mcaret"></span>
														</a>
													</li>
												<?php }} ?>

												<?php  if(permissao("efeitostaff")){ ?>
													<?php if($planoi['enablestaff'] == "true"){ ?>
														<li class=" ">
															<a href="<?php echo $dominio;?>/efeitostaff">
																<span class="pcoded-micon"><i class="ti-angle-right"></i></span>
																<span class="pcoded-mtext" data-i18n="nav.navigate.navbar-inverse">Hospedar Efeito Staff</span>
																<span class="pcoded-mcaret"></span>
															</a>
														</li>
													<?php }} ?>

													<?php if(permissao("hospeha")){ ?>
														<?php if($planoi['imagem_eha'] == "true"){ ?>
															<li class=" ">
																<a href="<?php echo $dominio;?>/imagem-eha">
																	<span class="pcoded-micon"><i class="ti-angle-right"></i></span>
																	<span class="pcoded-mtext" data-i18n="nav.navigate.navbar-inverse">Hospedar Imagem EHA</span>
																	<span class="pcoded-mcaret"></span>
																</a>
															</li>
														<?php }} if(permissao("hospvista")){ ?>
															<?php  if($planoi['editar_vista_client'] == "true"){ ?>
																<li class=" ">
																	<a href="<?php echo $dominio;?>/vista-client">
																		<span class="pcoded-micon"><i class="ti-angle-right"></i></span>
																		<span class="pcoded-mtext" data-i18n="nav.navigate.navbar-inverse">Hospedar Vista Client</span>
																		<span class="pcoded-mcaret"></span>
																	</a>
																</li>
															<?php }}?>
															<?php if(permissao("jukebox")){ ?>
																<?php if($planoi['add_jukebox'] == "true"){ ?>
																	<li class=" ">
																		<a href="<?php echo $dominio;?>/musica-jukebox">
																			<span class="pcoded-micon"><i class="ti-angle-right"></i></span>
																			<span class="pcoded-mtext" data-i18n="nav.navigate.navbar-inverse">Hospedar Jukebox</span>
																			<span class="pcoded-mcaret"></span>
																		</a>
																	</li>
																<?php }} ?>
															</ul>
														</li>

														<li class="pcoded-hasmenu">
															<a href="javascript:void(0)">
																<span class="pcoded-micon"><i class="fa fa-user"></i><b>G</b></span>
																<span class="pcoded-mtext" data-i18n="nav.widget.main">Ger. Usuários</span>
																<span class="pcoded-mcaret"></span>
															</a>
															<ul class="pcoded-submenu">

																<?php if(permissao("usuarios")){ ?>
																	<li class=" ">
																		<a href="<?php echo $dominio;?>/ver-usuarios">
																			<span class="pcoded-micon"><i class="ti-angle-right"></i></span>
																			<span class="pcoded-mtext" data-i18n="nav.dash.main">Ver usuários</span>
																			<span class="pcoded-mcaret"></span>
																		</a>
																	</li>
																	<li class=" ">
																		<a href="<?php echo $dominio;?>/buscar-usuario">
																			<span class="pcoded-micon"><i class="ti-angle-right"></i></span>
																			<span class="pcoded-mtext" data-i18n="nav.dash.main">Buscar usuário</span>
																			<span class="pcoded-mcaret"></span>
																		</a>
																	</li>
																<?php }?>
																<?php if(permissao("darrank")){ ?>
																	<li class=" ">
																		<a href="<?php echo $dominio;?>/dar-rank">
																			<span class="pcoded-micon"><i class="ti-angle-right"></i></span>
																			<span class="pcoded-mtext" data-i18n="nav.dash.main">Dar Rank</span>
																			<span class="pcoded-mcaret"></span>
																		</a>
																	</li>
																<?php }?>
																<?php if(permissao("loginstaff")){ ?>
																	<li class="">
																		<a href="<?php echo $dominio;?>/pinstaff">
																			<span class="pcoded-micon"><i class="ti-angle-right"></i></span>
																			<span class="pcoded-mtext" data-i18n="nav.navigate.navbar">Senha :loginstaff</span>
																			<span class="pcoded-mcaret"></span>
																		</a>
																	</li>														
																<?php } ?>

															</ul>
														</li>
														<?php if(permissao("limpeza")){ ?>
															<li class="pcoded-hasmenu">
																<a href="javascript:void(0)">
																	<span class="pcoded-micon"><i class="fa fa-eraser"></i><b>L</b></span>
																	<span class="pcoded-mtext" data-i18n="nav.widget.main">Limpeza</span>
																	<span class="pcoded-mcaret"></span>
																</a>
																<ul class="pcoded-submenu">

																	<li class="">
																		<a href="<?php echo $dominio;?>/limpar-chatlogs">
																			<span class="pcoded-micon"><i class="ti-angle-right"></i></span>
																			<span class="pcoded-mtext" data-i18n="nav.navigate.navbar">Chatlogs</span>
																			<span class="pcoded-mcaret"></span>
																		</a>
																	</li>
																	<li class="">
																		<a href="<?php echo $dominio;?>/limpar-consolelogs">
																			<span class="pcoded-micon"><i class="ti-angle-right"></i></span>
																			<span class="pcoded-mtext" data-i18n="nav.navigate.navbar">Consolelogs</span>
																			<span class="pcoded-mcaret"></span>
																		</a>
																	</li>
																	<li class="">
																		<a href="<?php echo $dominio;?>/limpar-tradelogs">
																			<span class="pcoded-micon"><i class="ti-angle-right"></i></span>
																			<span class="pcoded-mtext" data-i18n="nav.navigate.navbar">Tradelogs</span>
																			<span class="pcoded-mcaret"></span>
																		</a>
																	</li>
																	<li class="">
																		<a href="<?php echo $dominio;?>/limpar-eventos">
																			<span class="pcoded-micon"><i class="ti-angle-right"></i></span>
																			<span class="pcoded-mtext" data-i18n="nav.navigate.navbar">Pontos de evento</span>
																			<span class="pcoded-mcaret"></span>
																		</a>
																	</li>
																	<li class="">
																		<a href="<?php echo $dominio;?>/limpar-grafico">
																			<span class="pcoded-micon"><i class="ti-angle-right"></i></span>
																			<span class="pcoded-mtext" data-i18n="nav.navigate.navbar">Gráfico</span>
																			<span class="pcoded-mcaret"></span>
																		</a>
																	</li>

																</ul>
															</li>
														<?php }?>
														<?php if(!isset($_SESSION['subconta'])){ ?>
															<li class="pcoded-hasmenu">
																<a href="javascript:void(0)">
																	<span class="pcoded-micon"><i class="fa fa-rocket"></i><b>S</b></span>
																	<span class="pcoded-mtext" data-i18n="nav.page_layout.main">Subcontas</span>
																	<span class="pcoded-mcaret"></span>
																</a>
																<ul class="pcoded-submenu">
																	<li class=" ">
																		<a href="<?php echo $dominio;?>/criar-subconta" target="">
																			<span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
																			<span class="pcoded-mtext" data-i18n="nav.page_layout.box-layout">Adicionar</span>
																			<span class="pcoded-mcaret"></span>
																		</a>
																	</li>
																	<li class=" ">
																		<a href="<?php echo $dominio;?>/ver-subcontas" target="">
																			<span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
																			<span class="pcoded-mtext" data-i18n="nav.page_layout.box-layout">Gerenciar</span>
																			<span class="pcoded-mcaret"></span>
																		</a>
																	</li>
																</ul>
															</li>
														<?php }?>
														<?php if(permissao("botdiscord")){ ?>
															<li class=" ">
																<a href="<?php echo $dominio;?>/bot-discord">
																	<span class="pcoded-micon"><i class="fa fa-android"></i></span>
																	<span class="pcoded-mtext" data-i18n="nav.navigate.navbar-inverse">Bot Discord</span>
																	<span class="pcoded-mcaret"></span>
																</a>
															</li>
														<?php } ?>
														<li class=" ">
															<a target=_blank href="https://cliente.galaxyservers.com.br/index.php?rp=/knowledgebase/1/Habbo">
																<span class="pcoded-micon"><i class="fa fa-question-circle"></i></span>
																<span class="pcoded-mtext" data-i18n="nav.navigate.navbar-inverse">Base de conhecimento</span>
																<span class="pcoded-mcaret"></span>
															</a>
														</li>
														<?php if(permissao("logs")){ ?>
															<li class="  ">
																<a href="<?php echo $dominio;?>/logs">
																	<span class="pcoded-micon"><i class="fa fa-database"></i><b>L</b></span>
																	<span class="pcoded-mtext" data-i18n="nav.dash.main">Log's</span>
																	<span class="pcoded-mcaret"></span>
																</a>
															</li>
														<?php }?>
														<?php if(!isset($_SESSION['subconta'])){ ?>
															<li class=" ">
																<a href="/config-adicionais"> 
																	<span class="pcoded-micon"><i class="fa fa-cogs"></i></span>
																	<span class="pcoded-mtext" data-i18n="nav.navigate.navbar-inverse">Config. Adicionais</span>
																	<span class="pcoded-mcaret"></span>
																</a>
															</li>
														<?php }?>
														<li class=" ">
															<a href="http://radio.galaxyservers.com.br" target="_blank"> 
																<span class="pcoded-micon"><i class="fa fa-music"></i></span>
																<span class="pcoded-mtext" data-i18n="nav.navigate.navbar-inverse">Painel do streaming</span>
																<span class="pcoded-mcaret"></span>
															</a>
														</li>
														<li id="botaosairmobile">
															<a href="/sair" target="">
																<span class="pcoded-micon"><i class="fa fa-sign-out "></i><b>S</b></span>
																<span class="pcoded-mtext" data-i18n="nav.dash.main">Sair</span>
																<span class="pcoded-mcaret"></span>
															</a>
														</li>
													</ul>
												</nav>
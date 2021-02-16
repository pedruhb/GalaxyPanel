<?php
if(!defined("GALAXYSERVERS")) { die("Você não pode acessar esse arquivo."); }

$SelectAdmin = $PDO->prepare("SELECT login FROM admin WHERE login = '".$_SESSION['useradmin']."'");
$SelectAdmin->execute();
$AdminHead = $SelectAdmin->fetch();

if(empty($AdminHead['login'])){
	echo '<script>window.location.href = "/admin/sair";</script>';
	die();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>GalaxyPanel ADM v<?php echo $versaopainel;?>.</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="description" content="#">
	<meta name="keywords" content="Painel administrativo do Galaxy Server v<?php echo $versaopainel;?>.">
	<meta property="og:image" content="https://i.imgur.com/HSRqbBz.jpg" />
	<meta name="author" content="GalaxyServers.">
	<link rel="icon" href="https://galaxyservers.com.br/assets/galaxy/favicon.png">	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600" rel="stylesheet">
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
			<nav class="navbar header-navbar pcoded-header iscollapsed" header-theme="theme1" pcoded-header-position="fixed">
				<div class="navbar-wrapper">
					<div class="navbar-logo" logo-theme="theme1">
						<a class="mobile-menu" id="mobile-collapse" href="#" style=" height: 30px; padding-top: 7.5; ">
							<i class="ti-menu"></i>
						</a>
						<a href="<?php echo $dominio;?>/admin/principal">
							<img class="img-fluid" draggable="false" src="<?= $logo_resto;?>" alt="GalaxyServers" <?= $style_resto;?>>
						</a>
					</div>
					<div class="navbar-container container-fluid">
						<ul class="nav-right">
							<li class="header-notification">
								<a href="sair" class="displayChatbox">
									<i class="icofont icofont-exit"></i>
								</a>
							</li>
						</ul>
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
									<img class="img-40 img-radius" draggable="false" src="<?php echo $dominio;?>/galaxyservers/assets/images/avatar-4.jpg" alt="User-Profile-Image">
									<div class="user-details">
										<span>Olá, <?php echo $_SESSION['useradmin'];?>!</span>
									</div>
								</div>
							</div>
							<div class="pcoded-navigatio-lavel" data-i18n="nav.category.Navegação">Navegação</div>
							<ul class="pcoded-item pcoded-left-item">
								<li class=" ">
									<a href="<?php echo $dominio;?>/admin/principal">
										<span class="pcoded-micon"><i class="ti-home"></i><b>I</b></span>
										<span class="pcoded-mtext" data-i18n="nav.dash.main">Início</span>
									</a>
								</li>
								<li class=" pcoded-hasmenu">
									<a href="javascript:void(0)">
										<span class="pcoded-micon"><i class="fa fa-rocket"></i><b>G</b></span>
										<span class="pcoded-mtext" data-i18n="nav.page_layout.main">Gerenciar</span>
										<span class="pcoded-mcaret"></span>
									</a>
									<ul class="pcoded-submenu">
										<li class=" ">
											<a href="<?php echo $dominio;?>/admin/criar-habbo">
												<span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
												<span class="pcoded-mtext" data-i18n="nav.page_layout.bottom-menu">Criar Habbo</span>
												<span class="pcoded-mcaret"></span>
											</a>
										</li>
										<li class=" ">
											<a href="<?php echo $dominio;?>/admin/ger-todos" target="">
												<span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
												<span class="pcoded-mtext" data-i18n="nav.page_layout.box-layout">Ger. Emulador</span>
												<span class="pcoded-mcaret"></span>
											</a>
										</li>
										<li class=" ">
											<a href="<?php echo $dominio;?>/admin/limpar-sistema" target="">
												<span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
												<span class="pcoded-mtext" data-i18n="nav.page_layout.box-layout">Limpar Emulador</span>
												<span class="pcoded-mcaret"></span>
											</a>
										</li>
										<li class=" ">
											<a href="<?php echo $dominio;?>/admin/ver-contas">
												<span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
												<span class="pcoded-mtext" data-i18n="nav.page_layout.box-layout">Ver contas</span>
												<span class="pcoded-mcaret"></span>
											</a>
										</li>

									</ul>
								</li>
								<li class=" pcoded-hasmenu">
									<a href="javascript:void(0)">
										<span class="pcoded-micon"><i class="fa fa-wrench"></i><b>A</b></span>
										<span class="pcoded-mtext" data-i18n="nav.page_layout.main">Atualizar</span>
										<span class="pcoded-mcaret"></span>
									</a>
									<ul class="pcoded-submenu">
										<li class=" ">
											<a href="<?php echo $dominio;?>/admin/att-emu">
												<span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
												<span class="pcoded-mtext" data-i18n="nav.page_layout.box-layout">Atualizar emulador</span>
												<span class="pcoded-mcaret"></span>
											</a>
										</li>
										<li class=" ">
											<a href="<?php echo $dominio;?>/admin/att-db">
												<span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
												<span class="pcoded-mtext" data-i18n="nav.page_layout.box-layout">Atualizar banco de dados</span>
												<span class="pcoded-mcaret"></span>
											</a>
										</li>
										<li class=" ">
											<a href="<?php echo $dominio;?>/admin/enviar-db">
												<span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
												<span class="pcoded-mtext" data-i18n="nav.page_layout.box-layout">Enviar banco de dados</span>
												<span class="pcoded-mcaret"></span>
											</a>
										</li>

									</ul>
								</li>
								<li class=" pcoded-hasmenu">
									<a href="javascript:void(0)">
										<span class="pcoded-micon"><i class="fa fa-plus-circle"></i><b>E</b></span>
										<span class="pcoded-mtext" data-i18n="nav.page_layout.main">Extras</span>
										<span class="pcoded-mcaret"></span>
									</a>
									<ul class="pcoded-submenu">
										<li class=" ">
											<a href="<?php echo $dominio;?>/admin/noticias">
												<span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
												<span class="pcoded-mtext" data-i18n="nav.page_layout.bottom-menu">Notícias</span>
												<span class="pcoded-mcaret"></span>
											</a>
										</li>
										<li class=" ">
											<a href="<?php echo $dominio;?>/admin/emblemas-games">
												<span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
												<span class="pcoded-mtext" data-i18n="nav.page_layout.bottom-menu">Emblemas Games</span>
												<span class="pcoded-mcaret"></span>
											</a>
										</li>
										<li class=" ">
											<a href="<?php echo $dominio;?>/admin/tutoriais" target="">
												<span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
												<span class="pcoded-mtext" data-i18n="nav.page_layout.box-layout">Tutoriais</span>
												<span class="pcoded-mcaret"></span>
											</a>
										</li>
										<li class=" ">
											<a href="<?php echo $dominio;?>/admin/cms" target="">
												<span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
												<span class="pcoded-mtext" data-i18n="nav.page_layout.box-layout">CMS</span>
												<span class="pcoded-mcaret"></span>
											</a>
										</li>
										<li class=" ">
											<a href="<?php echo $dominio;?>/admin/bans">
												<span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
												<span class="pcoded-mtext" data-i18n="nav.page_layout.box-layout">Ban's</span>
												<span class="pcoded-mcaret"></span>
											</a>
										</li>
									</ul>
								</li>
								<li class=" pcoded-hasmenu">
									<a href="javascript:void(0)">
										<span class="pcoded-micon"><i class="fa fa-eye"></i><b>V</b></span>
										<span class="pcoded-mtext" data-i18n="nav.page_layout.main">Vistas</span>
										<span class="pcoded-mcaret"></span>
									</a>
									<ul class="pcoded-submenu">
										<li class=" ">
											<a href="<?php echo $dominio;?>/admin/att-vista">
												<span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
												<span class="pcoded-mtext" data-i18n="nav.page_layout.box-layout">Atualização do BR</span>
												<span class="pcoded-mcaret"></span>
											</a>
										</li>
										<li class=" ">
											<a href="<?php echo $dominio;?>/admin/vistas">
												<span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
												<span class="pcoded-mtext" data-i18n="nav.page_layout.box-layout">Gerenciar vistas</span>
												<span class="pcoded-mcaret"></span>
											</a>
										</li>
									</ul>
								</li>
								<li class=" pcoded-hasmenu">
									<a href="javascript:void(0)">
										<span class="pcoded-micon"><i class="fa fa-file-text-o"></i><b>L</b></span>
										<span class="pcoded-mtext" data-i18n="nav.page_layout.main">Log's</span>
										<span class="pcoded-mcaret"></span>
									</a>
									<ul class="pcoded-submenu">
										<li class=" ">
											<a href="<?php echo $dominio;?>/admin/log-user">
												<span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
												<span class="pcoded-mtext" data-i18n="nav.page_layout.bottom-menu">User's</span>
												<span class="pcoded-mcaret"></span>
											</a>
										</li>
										<li class=" ">
											<a href="<?php echo $dominio;?>/admin/log-admin">
												<span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
												<span class="pcoded-mtext" data-i18n="nav.page_layout.bottom-menu">Admin</span>
												<span class="pcoded-mcaret"></span>
											</a>
										</li>
										<li class=" ">
											<a href="<?php echo $dominio;?>/admin/error-log">
												<span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
												<span class="pcoded-mtext" data-i18n="nav.page_layout.bottom-menu">Error Log</span>
												<span class="pcoded-mcaret"></span>
											</a>
										</li>
									</ul>
								</li>
								<li class="">
									<a href="<?php echo $dominio;?>/admin/recompila-swf">
										<span class="pcoded-micon"><i class="fa fa-bolt"></i><b>R</b></span>
										<span class="pcoded-mtext" data-i18n="nav.navigate.main">Recompilar SWF</span>
										<span class="pcoded-mcaret"></span>
									</a>
								</li>

								<li class=" pcoded-hasmenu">
									<a href="javascript:void(0)">
										<span class="pcoded-micon"><i class="fa fa-eye"></i><b>B</b></span>
										<span class="pcoded-mtext" data-i18n="nav.page_layout.main">Bot Discord</span>
										<span class="pcoded-mcaret"></span>
									</a>
									<ul class="pcoded-submenu">
										<li class=" ">
											<a href="<?php echo $dominio;?>/admin/ativa-bot">
												<span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
												<span class="pcoded-mtext" data-i18n="nav.page_layout.box-layout">Ativar</span>
												<span class="pcoded-mcaret"></span>
											</a>
										</li>
										<li class=" ">
											<a href="<?php echo $dominio;?>/admin/remover-bot">
												<span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
												<span class="pcoded-mtext" data-i18n="nav.page_layout.box-layout">Remover</span>
												<span class="pcoded-mcaret"></span>
											</a>
										</li>
										<li class=" ">
											<a href="<?php echo $dominio;?>/admin/att-bot">
												<span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
												<span class="pcoded-mtext" data-i18n="nav.page_layout.box-layout">Atualizar</span>
												<span class="pcoded-mcaret"></span>
											</a>
										</li>
									</ul>
								</li>
								
								<li class=" pcoded-hasmenu">
									<a href="javascript:void(0)">
										<span class="pcoded-micon"><i class="fa fa-envelope"></i><b>E</b></span>
										<span class="pcoded-mtext" data-i18n="nav.page_layout.main">Email</span>
										<span class="pcoded-mcaret"></span>
									</a>
									<ul class="pcoded-submenu">
										<li class=" ">
											<a href="<?php echo $dominio;?>/admin/novo-email-habbo">
												<span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
												<span class="pcoded-mtext" data-i18n="nav.page_layout.bottom-menu">Enviar para hotéis</span>
												<span class="pcoded-mcaret"></span>
											</a>
										</li>									
									</ul>
								</li>

								<li class="">
									<a href="<?php echo $dominio;?>/admin/vestacp">
										<span class="pcoded-micon"><i class="fa fa-linux"></i><b>V</b></span>
										<span class="pcoded-mtext" data-i18n="nav.navigate.main">Hospedagem</span>
										<span class="pcoded-mcaret"></span>
									</a>
								</li>
								<li class="">
									<a href="http://ns1.galaxyservers.com.br/phpmyadmin/index.php?pma_username=root" target="_blank">
										<span class="pcoded-micon"><i class="fa fa-database"></i><b>V</b></span>
										<span class="pcoded-mtext" data-i18n="nav.navigate.main">phpMyAdmin</span>
										<span class="pcoded-mcaret"></span>
									</a>
								</li>
							</ul>
						</nav>
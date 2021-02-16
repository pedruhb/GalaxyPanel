<?php
$filemanagertawk = false;
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

		?>

		<?php
		$_SESSION['elfinder-host'] = $ipftp;
		$_SESSION['elfinder-user'] = $server['uservestacp'];
		$_SESSION['elfinder-pass'] = $server['senhavestacp'];
		$_SESSION['elfinder-path'] = "/web/".$server['linkhotel']."/public_html/";
		?>

		<!DOCTYPE html>
		<html>
		<head>
			<title><?php echo $server['nomehotel'];?> - GalaxyPanel v<?php echo $versaopainel;?></title>
			<meta charset="utf-8">
			<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
			<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=2">
			<link rel="stylesheet" href="galaxyservers/filemanager/jquery/jquery-ui-1.12.0.css" type="text/css">
			<link rel="stylesheet" href="galaxyservers/filemanager/css/commands.css"    type="text/css">
			<link rel="stylesheet" href="galaxyservers/filemanager/css/common.css"      type="text/css">
			<link rel="stylesheet" href="galaxyservers/filemanager/css/contextmenu.css" type="text/css">
			<link rel="stylesheet" href="galaxyservers/filemanager/css/cwd.css"         type="text/css">
			<link rel="stylesheet" href="galaxyservers/filemanager/css/dialog.css"      type="text/css">
			<link rel="stylesheet" href="galaxyservers/filemanager/css/fonts.css"       type="text/css">
			<link rel="stylesheet" href="galaxyservers/filemanager/css/navbar.css"      type="text/css">
			<link rel="stylesheet" href="galaxyservers/filemanager/css/places.css"      type="text/css">
			<link rel="stylesheet" href="galaxyservers/filemanager/css/quicklook.css"   type="text/css">
			<link rel="stylesheet" href="galaxyservers/filemanager/css/statusbar.css"   type="text/css">
			<link rel="stylesheet" href="galaxyservers/filemanager/css/theme.css"       type="text/css">
			<link rel="stylesheet" href="galaxyservers/filemanager/css/toast.css"       type="text/css">
			<link rel="stylesheet" href="galaxyservers/filemanager/css/toolbar.css"     type="text/css">
			<script src="galaxyservers/filemanager/jquery/jquery-1.12.4.js" type="text/javascript" charset="utf-8"></script>
			<script src="galaxyservers/filemanager/jquery/jquery-ui-1.12.0.js" type="text/javascript" charset="utf-8"></script>
			<script src="galaxyservers/filemanager/js/elFinder.js"></script>
			<script src="galaxyservers/filemanager/js/elFinder.version.js"></script>
			<script src="galaxyservers/filemanager/js/jquery.elfinder.js"></script>
			<script src="galaxyservers/filemanager/js/elFinder.mimetypes.js"></script>
			<script src="galaxyservers/filemanager/js/elFinder.options.js"></script>
			<script src="galaxyservers/filemanager/js/elFinder.options.netmount.js"></script>
			<script src="galaxyservers/filemanager/js/elFinder.history.js"></script>
			<script src="galaxyservers/filemanager/js/elFinder.command.js"></script>
			<script src="galaxyservers/filemanager/js/elFinder.resources.js"></script>
			<script src="galaxyservers/filemanager/js/jquery.dialogelfinder.js"></script>
			<script src="galaxyservers/filemanager/js/i18n/elfinder.en.js"></script>
			<script src="galaxyservers/filemanager/js/ui/button.js"></script>
			<script src="galaxyservers/filemanager/js/ui/contextmenu.js"></script>
			<script src="galaxyservers/filemanager/js/ui/cwd.js"></script>
			<script src="galaxyservers/filemanager/js/ui/dialog.js"></script>
			<script src="galaxyservers/filemanager/js/ui/fullscreenbutton.js"></script>
			<script src="galaxyservers/filemanager/js/ui/navbar.js"></script>
			<script src="galaxyservers/filemanager/js/ui/navdock.js"></script>
			<script src="galaxyservers/filemanager/js/ui/overlay.js"></script>
			<script src="galaxyservers/filemanager/js/ui/panel.js"></script>
			<script src="galaxyservers/filemanager/js/ui/path.js"></script>
			<script src="galaxyservers/filemanager/js/ui/places.js"></script>
			<script src="galaxyservers/filemanager/js/ui/searchbutton.js"></script>
			<script src="galaxyservers/filemanager/js/ui/sortbutton.js"></script>
			<script src="galaxyservers/filemanager/js/ui/stat.js"></script>
			<script src="galaxyservers/filemanager/js/ui/toast.js"></script>
			<script src="galaxyservers/filemanager/js/ui/toolbar.js"></script>
			<script src="galaxyservers/filemanager/js/ui/tree.js"></script>
			<script src="galaxyservers/filemanager/js/ui/uploadButton.js"></script>
			<script src="galaxyservers/filemanager/js/ui/viewbutton.js"></script>
			<script src="galaxyservers/filemanager/js/ui/workzone.js"></script>
			<script src="galaxyservers/filemanager/js/commands/archive.js"></script>
			<script src="galaxyservers/filemanager/js/commands/back.js"></script>
			<script src="galaxyservers/filemanager/js/commands/copy.js"></script>
			<script src="galaxyservers/filemanager/js/commands/cut.js"></script>
			<script src="galaxyservers/filemanager/js/commands/chmod.js"></script>
			<script src="galaxyservers/filemanager/js/commands/colwidth.js"></script>
			<script src="galaxyservers/filemanager/js/commands/download.js"></script>
			<script src="galaxyservers/filemanager/js/commands/duplicate.js"></script>
			<script src="galaxyservers/filemanager/js/commands/edit.js"></script>
			<script src="galaxyservers/filemanager/js/commands/empty.js"></script>
			<script src="galaxyservers/filemanager/js/commands/extract.js"></script>
			<script src="galaxyservers/filemanager/js/commands/forward.js"></script>
			<script src="galaxyservers/filemanager/js/commands/fullscreen.js"></script>
			<script src="galaxyservers/filemanager/js/commands/getfile.js"></script>
			<script src="galaxyservers/filemanager/js/commands/help.js"></script>
			<script src="galaxyservers/filemanager/js/commands/hidden.js"></script>
			<script src="galaxyservers/filemanager/js/commands/home.js"></script>
			<script src="galaxyservers/filemanager/js/commands/info.js"></script>
			<script src="galaxyservers/filemanager/js/commands/mkdir.js"></script>
			<script src="galaxyservers/filemanager/js/commands/mkfile.js"></script>
			<script src="galaxyservers/filemanager/js/commands/netmount.js"></script>
			<script src="galaxyservers/filemanager/js/commands/open.js"></script>
			<script src="galaxyservers/filemanager/js/commands/opendir.js"></script>
			<script src="galaxyservers/filemanager/js/commands/paste.js"></script>
			<script src="galaxyservers/filemanager/js/commands/places.js"></script>
			<script src="galaxyservers/filemanager/js/commands/quicklook.js"></script>
			<script src="galaxyservers/filemanager/js/commands/quicklook.plugins.js"></script>
			<script src="galaxyservers/filemanager/js/commands/reload.js"></script>
			<script src="galaxyservers/filemanager/js/commands/rename.js"></script>
			<script src="galaxyservers/filemanager/js/commands/resize.js"></script>
			<script src="galaxyservers/filemanager/js/commands/restore.js"></script>
			<script src="galaxyservers/filemanager/js/commands/rm.js"></script>
			<script src="galaxyservers/filemanager/js/commands/search.js"></script>
			<script src="galaxyservers/filemanager/js/commands/selectall.js"></script>
			<script src="galaxyservers/filemanager/js/commands/selectinvert.js"></script>
			<script src="galaxyservers/filemanager/js/commands/selectnone.js"></script>
			<script src="galaxyservers/filemanager/js/commands/sort.js"></script>
			<script src="galaxyservers/filemanager/js/commands/undo.js"></script>
			<script src="galaxyservers/filemanager/js/commands/up.js"></script>
			<script src="galaxyservers/filemanager/js/commands/upload.js"></script>
			<script src="galaxyservers/filemanager/js/commands/view.js"></script>
			<script src="galaxyservers/filemanager/js/proxy/elFinderSupportVer1.js"></script>
			<script src="galaxyservers/filemanager/js/extras/editors.default.js"></script>
			<script src="galaxyservers/filemanager/js/extras/quicklook.googledocs.js"></script>
			<script>
				$(function() {
					$('#elfinder').elfinder(
					{
						cssAutoLoad : false,
						baseUrl : './',
						url : 'galaxyservers/filemanager/php/connector.minimal.php',
						getFileCallback : function(file) {
						},
					},
					function(fm, extraObj) {
						fm.bind('init', function() {
							delete fm.options.rawStringDecoder;
							if (fm.lang === 'ja') {
								fm.loadScript(
									[ fm.baseUrl + 'galaxyservers/filemanager/js/extras/encoding-japanese.min.js' ],
									function() {
										if (window.Encoding && Encoding.convert) {
											fm.options.rawStringDecoder = function(s) {
												return Encoding.convert(s,{to:'UNICODE',type:'string'});
											};
										}
									},
									{ loadType: 'tag' }
									);
							}
						});
						var title = document.title;
						fm.bind('open', function() {
							var path = '',
							cwd  = fm.cwd();
							if (cwd) {
								path = fm.path(cwd.hash) || null;
							}
							document.title = path? path + ':' + title : title;
						}).bind('destroy', function() {
							document.title = title;
						});
					}
					);
				});
			</script>
		</head>
		<body>
			<div id="elfinder"></div>
		</body>
		</html><?php }} else header('Location: ../index'); ?>
<?php
include "galaxyservers/global.php";
if(!empty($_SESSION['nomeusuario'])){

	$infoserver = $PDO->prepare("SELECT * FROM servidores WHERE nomeusuario = '".$_SESSION['nomeusuario']."'");
	$infoserver->execute();
	$server = $infoserver->fetch();
	$_SESSION['senhaatualdb'] = $server['senhavestacp'];

	?>
	<?php 
	include 'galaxyservers/nav.php';
	if($planoi['frontpage'] == "false"){
		if (headers_sent()) {
			die("<script>window.location.href=/index</script>");
		}
		else{
			exit(header("Location: /index"));
		}
		return;
	}
	?>
	<div class="pcoded-content">
		<div class="pcoded-inner-content">
			<div class="main-body user-profile">
				<div class="page-wrapper">
					<div class="page-body">
						<div class="card">
							<div class="card-block">
								<div class="m-b-20">
									<h4 class="sub-title">Altere as configurações do frontpage. <div style="float: right;">Para gerar o id da imagem clique <a href="/upload-frontpage" target="_blank">aqui</a>.</div></h4>

									<form method="POST" enctype="multipart/form-data">	

										<?php
											if(!permissao("frontpage")){
									echo '<div style="display: contents;">
									<div class="col-md-12">
									<center><div class="alert alert-danger background-danger" style="width: 30%;">
									<strong>Erro!</strong> Sua subconta não tem permissão para acessar essa página.
									</div></center>
									</div>
									</div>';
								} else {

										if(isset($_POST['salvar-config'])){

$arquivo_config = "## 1 - a que fica em pé
catalog.index.notice.1=".$_POST['texto1']."
catalog.img.notice.1=catalogue/frontpage/".$_POST['imagem1'].".png
catalog.link.notice.1=".$_POST['link1']."

## 2
catalog.index.notice.2=".$_POST['texto2']."
catalog.img.notice.2=catalogue/frontpage/".$_POST['imagem2'].".png
catalog.link.notice.2=".$_POST['link2']."

## 3
catalog.index.notice.3=".$_POST['texto3']."
catalog.img.notice.3=catalogue/frontpage/".$_POST['imagem3'].".png
catalog.link.notice.3=".$_POST['link3']."

## 4
catalog.index.notice.4=".$_POST['texto4']."
catalog.img.notice.4=catalogue/frontpage/".$_POST['imagem4'].".png
catalog.link.notice.4=".$_POST['link4'];

$arquivo = "galaxyservers/emuladores/".$server['uservestacp']."/Config/catalogo.ini";
$fp = fopen($arquivo, "w");
$escreve = fwrite($fp, $arquivo_config);
fclose($fp);

addlog('Editou a front page do hotel.');

sendRCONCommand2('atualizarfront', '', $ipvps, $server['portamus']);
sendRCONCommand2('reload_catalog', '', $ipvps, $server['portamus']);

										}

										$arquivo = file_get_contents("galaxyservers/emuladores/".$server['uservestacp']."/Config/catalogo.ini");

										$texto_1 = explode("catalog.img.notice.1", explode("catalog.index.notice.1=", $arquivo)[1])[0];
										$texto_2 = explode("catalog.img.notice.2", explode("catalog.index.notice.2=", $arquivo)[1])[0];
										$texto_3 = explode("catalog.img.notice.3", explode("catalog.index.notice.3=", $arquivo)[1])[0];
										$texto_4 = explode("catalog.img.notice.4", explode("catalog.index.notice.4=", $arquivo)[1])[0];

										$imagem_1 = explode("catalog.link.notice.1", explode("catalog.img.notice.1=", $arquivo)[1])[0];
										$imagem_2 = explode("catalog.link.notice.2", explode("catalog.img.notice.2=", $arquivo)[1])[0];
										$imagem_3 = explode("catalog.link.notice.3", explode("catalog.img.notice.3=", $arquivo)[1])[0];
										$imagem_4 = explode("catalog.link.notice.4", explode("catalog.img.notice.4=", $arquivo)[1])[0];


										$link_1 = str_replace("\n", "", explode("#", explode("catalog.link.notice.1=", $arquivo)[1])[0]);
										$link_2 = str_replace("\n", "", explode("#", explode("catalog.link.notice.2=", $arquivo)[1])[0]);
										$link_3 = str_replace("\n", "", explode("#", explode("catalog.link.notice.3=", $arquivo)[1])[0]);
										$link_4 = str_replace("\n", "", explode("#", explode("catalog.link.notice.4=", $arquivo)[1])[0]);


										?>

										<div class="row">
<label class="col-sm-4 col-lg-2 col-form-label">1 - Texto (pé)</label>
<div class="col-sm-8 col-lg-10">
	<div class="input-group">		
		<input type="text" value="<?= $texto_1; ?>" name="texto1" class="form-control" required>
	</div>
</div>
										</div>
										<div class="row">
<label class="col-sm-4 col-lg-2 col-form-label">1 - Imagem ID (pé)</label>
<div class="col-sm-8 col-lg-10">
	<div class="input-group">		
		<input type="text" value="<?= str_replace("catalogue/frontpage/", "", str_replace(".png", "", $imagem_1)); ?>" name="imagem1" class="form-control" required>
	</div>
</div>
										</div>
										<div class="row">
<label class="col-sm-4 col-lg-2 col-form-label">1 - Link (pé)</label>
<div class="col-sm-8 col-lg-10">
	<div class="input-group">
		<select name="link1" class="form-control">
			<?php
			$PDO2 = new PDO('mysql:host='.$iphospedagem.';dbname='.$server['uservestacp']."_hotel", $server['uservestacp']."_hotel", $server['senhavestacp']);
			$selecionacata = $PDO2->prepare("SELECT caption,page_link FROM catalog_pages WHERE page_link != '' ORDER BY id DESC");
			$selecionacata->execute();
			while($cata = $selecionacata->fetch()){

			if(strpos($link_1, $cata['page_link']) !== false)
					$select = "selected";
				else
					$select = "nao";

				echo "<option value=\"".str_replace("\n", "", $cata['page_link'])."\" ".$select.">".str_replace("HOTELNAME", $server['nomehotel'], $cata['caption'])." - ".str_replace("\n", "", $cata['page_link'])."</option>"."\n";
			}
			?>
		</select>
	</div>
</div>
										</div>
										<div class="row">
<label class="col-sm-4 col-lg-2 col-form-label">2 - Texto (deitado)</label>
<div class="col-sm-8 col-lg-10">
	<div class="input-group">		
		<input type="text" value="<?= $texto_2; ?>" name="texto2" class="form-control" required>
	</div>
</div>
										</div>
										<div class="row">
<label class="col-sm-4 col-lg-2 col-form-label">2 - Imagem ID (deitado)</label>
<div class="col-sm-8 col-lg-10">
	<div class="input-group">		
		<input type="text" value="<?= str_replace("catalogue/frontpage/", "", str_replace(".png", "", $imagem_2)); ?>" name="imagem2" class="form-control" required>
	</div>
</div>
										</div>
										<div class="row">
<label class="col-sm-4 col-lg-2 col-form-label">2 - Link (deitado)</label>
<div class="col-sm-8 col-lg-10">
	<div class="input-group">
		<select name="link2" class="form-control">
			<?php
			$selecionacata = $PDO2->prepare("SELECT caption,page_link FROM catalog_pages WHERE page_link != '' ORDER BY id DESC");
			$selecionacata->execute();
			while($cata = $selecionacata->fetch()){

			if(strpos($link_2, $cata['page_link']) !== false)
					$select = "selected";
				else
					$select = "nao";

				echo "<option value=\"".str_replace("\n", "", $cata['page_link'])."\" ".$select.">".str_replace("HOTELNAME", $server['nomehotel'], $cata['caption'])." - ".str_replace("\n", "", $cata['page_link'])."</option>"."\n";
			}
			?>
		</select>	
	</div>
</div>
										</div>
										<div class="row">
<label class="col-sm-4 col-lg-2 col-form-label">3 - Texto (deitado)</label>
<div class="col-sm-8 col-lg-10">
	<div class="input-group">		
		<input type="text" value="<?= $texto_3; ?>" name="texto3" class="form-control" required>
	</div>
</div>
										</div>
										<div class="row">
<label class="col-sm-4 col-lg-2 col-form-label">3 - Imagem ID (deitado)</label>
<div class="col-sm-8 col-lg-10">
	<div class="input-group">		
		<input type="text" value="<?= str_replace("catalogue/frontpage/", "", str_replace(".png", "", $imagem_3)); ?>" name="imagem3" class="form-control" required>
	</div>
</div>
										</div>
										<div class="row">
<label class="col-sm-4 col-lg-2 col-form-label">3 - Link (deitado)</label>
<div class="col-sm-8 col-lg-10">
	<div class="input-group">
		<select name="link3" class="form-control">
			<?php
			$selecionacata = $PDO2->prepare("SELECT caption,page_link FROM catalog_pages WHERE page_link != '' ORDER BY id DESC");
			$selecionacata->execute();
			while($cata = $selecionacata->fetch()){

			if(strpos($link_3, $cata['page_link']) !== false)
					$select = "selected";
				else
					$select = "nao";

				echo "<option value=\"".str_replace("\n", "", $cata['page_link'])."\" ".$select.">".str_replace("HOTELNAME", $server['nomehotel'], $cata['caption'])." - ".str_replace("\n", "", $cata['page_link'])."</option>"."\n";
			}
			?>
		</select>		
	</div>
</div>
</div>
<div class="row">
<label class="col-sm-4 col-lg-2 col-form-label">4 - Texto (deitado)</label>
<div class="col-sm-8 col-lg-10">
	<div class="input-group">		
		<input type="text" value="<?= $texto_4; ?>" name="texto4" class="form-control" required>
	</div>
</div>
										</div>
										<div class="row">
<label class="col-sm-4 col-lg-2 col-form-label">4 - Imagem ID (deitado)</label>
<div class="col-sm-8 col-lg-10">
	<div class="input-group">		
		<input type="text" value="<?= str_replace("catalogue/frontpage/", "", str_replace(".png", "", $imagem_4)); ?>" name="imagem4" class="form-control" required>
	</div>
</div>
										</div>
										<div class="row">
<label class="col-sm-4 col-lg-2 col-form-label">4 - Link (deitado)</label>
<div class="col-sm-8 col-lg-10">
	<div class="input-group">
		<select name="link4" class="form-control">
			<?php
			$selecionacata = $PDO2->prepare("SELECT caption,page_link FROM catalog_pages WHERE page_link != '' ORDER BY id DESC");
			$selecionacata->execute();
			while($cata = $selecionacata->fetch()){

			if(strpos($link_4, $cata['page_link']) !== false)
					$select = "selected";
				else
					$select = "nao";

				echo "<option value=\"".str_replace("\n", "", $cata['page_link'])."\" ".$select.">".str_replace("HOTELNAME", $server['nomehotel'], $cata['caption'])." - ".str_replace("\n", "", $cata['page_link'])."</option>"."\n";
			}
			?>
		</select>		</div>
</div>
										</div>


									</div>
									<center><button type="submit" style="border-radius: 8px;" name="salvar-config" class="btn btn-primary m-b-0">Salvar</button><br><br>Caso você não tenha o frontpage em seu catálogo, execute <a href="https://pastebin.com/raw/t4XW8nf9" target="_blank">esse sql</a> na sua database.<br><a href="https://imgur.com/a/PkljxHW" target="_blank">Clique aqui para ver exemplos de imagens.</a></center>
								</form>
							</div>
						</div>
					</div>
				</div><?php }?>
			</div>
		</div>
	</div>
</div>
</div>
</div>
</div>
<script type="text/javascript" src="../../galaxyservers/bower_components/jquery/js/jquery.min.js"></script>
<script type="text/javascript" src="../../galaxyservers/bower_components/jquery-ui/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="../../galaxyservers/bower_components/popper.js/js/popper.min.js"></script>
<script type="text/javascript" src="../../galaxyservers/bower_components/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../../galaxyservers/bower_components/jquery-slimscroll/js/jquery.slimscroll.js"></script>
<script type="text/javascript" src="../../galaxyservers/bower_components/modernizr/js/modernizr.js"></script>
<script type="text/javascript" src="../../galaxyservers/bower_components/modernizr/js/css-scrollbars.js"></script>
<script src="../../galaxyservers/assets/pages/jquery.filer/js/jquery.filer.min.js"></script>
<script src="../../galaxyservers/assets/pages/filer/custom-filer.js" type="text/javascript"></script>
<script src="../../galaxyservers/assets/pages/filer/jquery.fileuploads.init.js?a=a" type="text/javascript"></script>
<script type="text/javascript" src="../../galaxyservers/bower_components/i18next/js/i18next.min.js"></script>
<script type="text/javascript" src="../../galaxyservers/bower_components/i18next-xhr-backend/js/i18nextXHRBackend.min.js"></script>
<script type="text/javascript" src="../../galaxyservers/bower_components/i18next-browser-languagedetector/js/i18nextBrowserLanguageDetector.min.js"></script>
<script type="text/javascript" src="../../galaxyservers/bower_components/jquery-i18next/js/jquery-i18next.min.js"></script>
<script src="../../galaxyservers/assets/js/pcoded.min.js"></script>
<script src="../../galaxyservers/assets/js/demo-12.js"></script>
<script src="../../galaxyservers/assets/js/jquery.mCustomScrollbar.concat.min.js"></script>
<script type="text/javascript" src="../../galaxyservers/assets/js/script.js"></script>
</body>
</html><?php } else header('Location: ../index'); ?>
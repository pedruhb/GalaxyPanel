<?php include "../galaxyservers/global.php";
if(empty($_SESSION['useradmin'])){
	echo '<script>location.href="index";</script>';
}
if (!empty($_SESSION['useradmin'])){

	include "nav.php";
	?>
	<div class="pcoded-content">
		<div class="pcoded-inner-content">
			<div class="main-body">
				<div class="page-wrapper">
					<div class="page-body">
						<div class="card">
							<div class="card-header">
								<h5>Atualizar vista</h5>
								<span>Atualize a vista dos hotéis.</a></span>
								<div class="card-header-right"><i class="icofont icofont-spinner-alt-5"></i></div>
								<div class="card-header-right">
									<i class="icofont icofont-spinner-alt-5"></i>
								</div>
							</div>
							<div class="card-block">
								<?php
								error_reporting(1);
								if (isset($_POST['attvista']))
								{

								$variables_link = "https://www.habbo.com.br/gamedata/external_variables/".$_POST['token'];

									ini_set('display_errors',1);
									ini_set('display_startup_erros',1);
									error_reporting(E_ALL);

									
									$link_cimages = "http://habboo-a.akamaihd.net/c_images/";
									$pasta_temp = "vista_br_temp/";

									$opcoes = array('http'=>array('method'=>"GET","header" => "User-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36"));
									$contexto = stream_context_create($opcoes);
									$pega_txt = file_get_contents($variables_link, false, $contexto); 

									//$pega_txt = $_POST['variables'];

									$background_back = explode("background_back.uri=", $pega_txt)[1];
									$background_back = explode(".png", $background_back)[0].".png";
									$background_back = str_replace('${image.library.url}', $link_cimages, $background_back);

									$background_background_hotel = explode("background_background_hotel.uri=", $pega_txt)[1];
									$background_background_hotel = explode(".png", $background_background_hotel)[0].".png";
									$background_background_hotel = str_replace('${image.library.url}', $link_cimages, $background_background_hotel);

									$background_front = explode("background_front.uri=", $pega_txt)[1];
									$background_front = explode(".png", $background_front)[0].".png";
									$background_front = str_replace('${image.library.url}', $link_cimages, $background_front);

									$background_gradient = explode("background_gradient.uri=", $pega_txt)[1];
									$background_gradient = explode(".png", $background_gradient)[0].".png";
									$background_gradient = str_replace('${image.library.url}', $link_cimages, $background_gradient);

									$background_gradient_top = explode("background_gradient_top.uri=", $pega_txt)[1];
									$background_gradient_top = explode(".png", $background_gradient_top)[0].".png";
									$background_gradient_top = str_replace('${image.library.url}', $link_cimages, $background_gradient_top);

									$background_horizon = explode("background_horizon.uri=", $pega_txt)[1];
									$background_horizon = explode(".png", $background_horizon)[0].".png";
									$background_horizon = str_replace('${image.library.url}', $link_cimages, $background_horizon);

									$background_hotel_top = explode("background_hotel_top.uri=", $pega_txt)[1];
									$background_hotel_top = explode(".png", $background_hotel_top)[0].".png";
									$background_hotel_top = str_replace('${image.library.url}', $link_cimages, $background_hotel_top);

									$background_left = explode("background_left.uri=", $pega_txt)[1];
									$background_left = explode(".png", $background_left)[0].".png";
									$background_left = str_replace('${image.library.url}', $link_cimages, $background_left);

									$background_right = explode("background_right.uri=", $pega_txt)[1];
									$background_right = explode(".png", $background_right)[0].".png";
									$background_right = str_replace('${image.library.url}', $link_cimages, $background_right);

									echo "background_back: ".$background_back;
									echo '<br>';
									echo "background_background_hotel: ".$background_background_hotel;
									echo '<br>';
									echo "background_front: ".$background_front;
									echo '<br>';
									echo "background_gradient: ".$background_gradient;
									echo '<br>';
									echo "background_gradient_top: ".$background_gradient_top;
									echo '<br>';
									echo "background_horizon: ".$background_horizon;
									echo '<br>';
									echo "background_hotel_top: ".$background_hotel_top;
									echo '<br>';
									echo "background_left: ".$background_left;
									echo '<br>';
									echo "background_right: ".$background_right;

									$selecionatodos1 = $PDO->prepare("SELECT * FROM `vista_padrao` WHERE `background_back` = :1 AND `background_background_hotel` = :2 AND `background_front` = :3 AND `background_gradient` = :4 AND `background_gradient_top` = :5 AND `background_horizon` = :6 AND `background_hotel_top` = :7 AND `background_left` = :8 AND `background_right` = :9");
									$selecionatodos1->bindParam(":1", explode('/', $background_back)[5]);
									$selecionatodos1->bindParam(":2", explode('/', $background_background_hotel)[5]);
									$selecionatodos1->bindParam(":3", explode('/', $background_front)[5]);
									$selecionatodos1->bindParam(":4", explode('/', $background_gradient)[5]);
									$selecionatodos1->bindParam(":5", explode('/', $background_gradient_top)[5]);
									$selecionatodos1->bindParam(":6", explode('/', $background_horizon)[5]);
									$selecionatodos1->bindParam(":7", explode('/', $background_hotel_top)[5]);
									$selecionatodos1->bindParam(":8", explode('/', $background_left)[5]);
									$selecionatodos1->bindParam(":9", explode('/', $background_right)[5]);
									$selecionatodos1->execute();
									if($selecionatodos1->rowCount() > 0){
										echo '<div style="display: contents;">
										<div class="col-md-12">
										<center><div class="alert alert-danger background-danger" style="width: 30%;">
										<strong>Erro!</strong> Já existe esses registros no banco de dados!
										</div></center>
										</div>
										</div>';

									} else {


										if(!file_exists($pasta_temp.explode('/', $background_back)[5]))
											copy($background_back, $pasta_temp.explode('/', $background_back)[5]);

										if(!file_exists($pasta_temp.explode('/', $background_background_hotel)[5]))
											copy($background_background_hotel, $pasta_temp.explode('/', $background_background_hotel)[5]);

										if(!file_exists($pasta_temp.explode('/', $background_front)[5]))
											copy($background_front, $pasta_temp.explode('/', $background_front)[5]);

										if(!file_exists($pasta_temp.explode('/', $background_gradient)[5]))
											copy($background_gradient, $pasta_temp.explode('/', $background_gradient)[5]);

										if(!file_exists($pasta_temp.explode('/', $background_gradient_top)[5]))
											copy($background_gradient_top, $pasta_temp.explode('/', $background_gradient_top)[5]);

										if(!file_exists($pasta_temp.explode('/', $background_horizon)[5]))
											copy($background_horizon, $pasta_temp.explode('/', $background_horizon)[5]);

										if(!file_exists($pasta_temp.explode('/', $background_hotel_top)[5]))
											copy($background_hotel_top, $pasta_temp.explode('/', $background_hotel_top)[5]);

										if(!file_exists($pasta_temp.explode('/', $background_left)[5]))
											copy($background_left, $pasta_temp.explode('/', $background_left)[5]);

										if(!file_exists($pasta_temp.explode('/', $background_right)[5]))
											copy($background_right, $pasta_temp.explode('/', $background_right)[5]);

										$con_id = ftp_connect($ipftpvista) or die( '<div class="alert alert-danger">Não conectou em: '.$ipftpvista.'".</div>');
										ftp_login($con_id, $userftpvista, $senhaftpvista);
										ftp_pasv($con_id, true) or die('<script>alert("Cannot switch to passive mode.")</script>'); 
										ftp_put($con_id, $caminhoftpvista.explode('/', $background_back)[5], $pasta_temp.explode('/', $background_back)[5], FTP_BINARY);
										ftp_put($con_id, $caminhoftpvista.explode('/', $background_background_hotel)[5], $pasta_temp.explode('/', $background_background_hotel)[5], FTP_BINARY);
										ftp_put($con_id, $caminhoftpvista.explode('/', $background_front)[5], $pasta_temp.explode('/', $background_front)[5], FTP_BINARY);
										ftp_put($con_id, $caminhoftpvista.explode('/', $background_gradient)[5], $pasta_temp.explode('/', $background_gradient)[5], FTP_BINARY);
										ftp_put($con_id, $caminhoftpvista.explode('/', $background_gradient_top)[5], $pasta_temp.explode('/', $background_gradient_top)[5], FTP_BINARY);
										ftp_put($con_id, $caminhoftpvista.explode('/', $background_horizon)[5], $pasta_temp.explode('/', $background_horizon)[5], FTP_BINARY);
										ftp_put($con_id, $caminhoftpvista.explode('/', $background_hotel_top)[5], $pasta_temp.explode('/', $background_hotel_top)[5], FTP_BINARY);
										ftp_put($con_id, $caminhoftpvista.explode('/', $background_left)[5], $pasta_temp.explode('/', $background_left)[5], FTP_BINARY);
										ftp_put($con_id, $caminhoftpvista.explode('/', $background_right)[5], $pasta_temp.explode('/', $background_right)[5], FTP_BINARY);
										$time = time();
										$selecionatodos1 = $PDO->prepare("INSERT INTO `vista_padrao` (`background_back`, `background_background_hotel`, `background_front`, `background_gradient`, `background_gradient_top`, `background_horizon`, `background_hotel_top`, `background_left`, `background_right`, `timestamp`, `nome`) VALUES (:1, :2, :3, :4, :5, :6, :7, :8, :9, :10, :n);");
										$selecionatodos1->bindParam(":1", explode('/', $background_back)[5]);
										$selecionatodos1->bindParam(":2", explode('/', $background_background_hotel)[5]);
										$selecionatodos1->bindParam(":3", explode('/', $background_front)[5]);
										$selecionatodos1->bindParam(":4", explode('/', $background_gradient)[5]);
										$selecionatodos1->bindParam(":5", explode('/', $background_gradient_top)[5]);
										$selecionatodos1->bindParam(":6", explode('/', $background_horizon)[5]);
										$selecionatodos1->bindParam(":7", explode('/', $background_hotel_top)[5]);
										$selecionatodos1->bindParam(":8", explode('/', $background_left)[5]);
										$selecionatodos1->bindParam(":9", explode('/', $background_right)[5]);
										$selecionatodos1->bindParam(":10", $time);
										$selecionatodos1->bindValue(":n", utf8_decode($_POST['nome']));
										$selecionatodos1->execute();

										echo '<div style="display: contents;">
										<div class="col-md-12">
										<center><div class="alert alert-success background-success" style="width: 30%;">
										<strong>Sucesso!</strong> Vista atualizada!
										</div></center>
										</div>
										</div>';

										addlog_admin("", "Atualizou a vista!");
									}

								}							
								?>
								<form method="POST">
									<div class="form-group row">
										<label class="col-sm-2 col-form-label">Nome da vista</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" name="nome" value="" placeholder="Exemplo: Natal 2019" required>
										</div>
									</div>

									<div class="form-group row">
										<label class="col-sm-2 col-form-label"><a href="//habbo.com.br/gamedata/external_variables/0" target="_blank">Token variables</a></label>
										<div class="col-sm-10">
											<input type="text" class="form-control" name="token" value="" placeholder="ec0b653b093ffc863cf9323ee201221591e1ba24" required>
										</div>
									</div>

									<!--<div class="form-group row">
										<label class="col-sm-2 col-form-label"><a href="https://www.habbo.com.br/gamedata/external_variables/0">External variables</a></label>
										<div class="col-sm-10">
											<textarea class="form-control" name="variables"></textarea>
										</div>
									</div>-->

									<center><button class="btn btn-primary" style="border-radius: 8px;" type="submit" name="attvista">Atualizar vista da client</button></center>
								</form>
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
<script type="text/javascript" src="../galaxyservers/bower_components/jquery/js/jquery.min.js"></script>
<script type="text/javascript" src="../galaxyservers/bower_components/jquery-ui/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="../galaxyservers/bower_components/popper.js/js/popper.min.js"></script>
<script type="text/javascript" src="../galaxyservers/bower_components/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../galaxyservers/bower_components/jquery-slimscroll/js/jquery.slimscroll.js"></script>
<script type="text/javascript" src="../galaxyservers/bower_components/modernizr/js/modernizr.js"></script>
<script src="../galaxyservers/assets/pages/widget/amchart/amcharts.min.js"></script>
<script src="../galaxyservers/assets/pages/widget/amchart/serial.min.js"></script>
<script type="text/javascript" src="../galaxyservers/bower_components/chart.js/js/Chart.js"></script>
<script type="text/javascript" src="../galaxyservers/assets/pages/todo/todo.js"></script>
<script type="text/javascript" src="../galaxyservers/assets/js/script.js"></script>
<script type="text/javascript" src="../galaxyservers/assets/js/bootstrap-growl.min.js"></script>
<script type="text/javascript" src="../galaxyservers/bower_components/i18next/js/i18next.min.js"></script>
<script type="text/javascript" src="../galaxyservers/bower_components/i18next-xhr-backend/js/i18nextXHRBackend.min.js"></script>
<script type="text/javascript" src="../galaxyservers/bower_components/i18next-browser-languagedetector/js/i18nextBrowserLanguageDetector.min.js"></script>
<script type="text/javascript" src="../galaxyservers/bower_components/jquery-i18next/js/jquery-i18next.min.js"></script>
<script type="text/javascript" src="../galaxyservers/assets/pages/notification/notification.js"></script>
<script type="text/javascript" src="../galaxyservers/assets/pages/dashboard/custom-dashboard.min.js"></script>
<script type="text/javascript" src="../galaxyservers/assets/js/SmoothScroll.js"></script>
<script src="../galaxyservers/assets/js/pcoded.min.js"></script>
<script src="../galaxyservers/assets/js/demo-12.js"></script>
<script src="../galaxyservers/assets/js/jquery.mCustomScrollbar.concat.min.js"></script>
<script type="text/javascript" src="../galaxyservers/assets/js/script.min.js"></script>
</body>
</html>
<?php } ?>
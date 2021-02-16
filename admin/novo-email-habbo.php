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
								<h5>Enviar email</h5>
								<?php
								$selecionatodos = $PDO->prepare("SELECT id FROM servidores;");
								$selecionatodos->execute();
								$selecionatodos = $selecionatodos->rowCount();
								?>
								<span>O email será enviado para <?= $selecionatodos;?> pessoas.</span>
								<div class="card-header-right"><i class="icofont icofont-spinner-alt-5"></i></div>
								<div class="card-header-right">
									<i class="icofont icofont-spinner-alt-5"></i>
								</div>
							</div>
							<div class="card-block">
								<?php
								$ocultaresto = true;
								set_time_limit(0);
								if (isset($_POST['envia_email']))
								{
									$continua = true;
									if($_POST['conteudo_email'] == ""){
										$continua = false;
										loginerror("Você deve digitar algo no conteúdo!");
									}
									if($_POST['titulo_email'] == ""){
										$continua = false;
										loginerror("Você deve digitar algo no título!");
									}
									if($continua){
										include 'template-email-gpanel.php';
										include '../galaxyservers/class.phpmailer.php';

										$paraquem = $_POST['paraquem'];

										if($paraquem == "ativos")
											$SelecionaClientes = $PDO->prepare("SELECT uservestacp,nomehotel,emailcliente FROM servidores WHERE ativo = 'Y';");
										else if($paraquem == "suspensos")
											$SelecionaClientes = $PDO->prepare("SELECT uservestacp,nomehotel,emailcliente FROM servidores  WHERE ativo = 'N';");
										else if($paraquem == "todos")
											$SelecionaClientes = $PDO->prepare("SELECT uservestacp,nomehotel,emailcliente FROM servidores;");

										$SelecionaClientes->execute();

										$i = 0;
										$e = 0;

										while($Clientes = $SelecionaClientes->fetch()){
											$ConteudoEmail = $bodyEmailA;
											$ConteudoEmail = str_replace('%usuario%', $Clientes['uservestacp'], $ConteudoEmail);
											$ConteudoEmail = str_replace('%nomehotel%', $Clientes['nomehotel'], $ConteudoEmail);
											$ConteudoEmail = str_replace('%conteudo%', $_POST['conteudo_email'], $ConteudoEmail);
											$mail = new PHPMailer();
											$mail->IsSMTP();
											$mail->SMTPDebug = 0;                       
											$mail->SMTPAuth = true; 
											$mail->SMTPSecure = "tls";
											$mail->Host = $hostemail;
											$mail->Port = $portaemail; 
											$mail->Username = $useremail;
											$mail->Password = $senhaemail; 
											$mail->SetFrom($useremail, "GalaxyPanel");
											$mail->CharSet = 'UTF-8';
											$mail->Subject = $_POST['titulo_email'];
											$mail->AltBody = $_POST['titulo_email'];
											$mail->MsgHTML($ConteudoEmail);
											$mail->AddAddress($Clientes['emailcliente'], $Clientes['uservestacp']);
											if($mail->Send()){
												$i++;
												echo "Email enviado com sucesso para: ".$Clientes['emailcliente']."<br>";
											}
											else {
												$e++;
												echo "Erro ao enviar email para: ".$Clientes['emailcliente']."<br>";
											}

										}
										echo '<br>';
										echo '<strong>Total de emails enviados: '.$i.'.</strong>';
										echo '<br>';
										echo '<strong>Total de emails com falhas: '.$e.'.</strong>';
										$ocultaresto = false;

										addlog_admin($_SESSION['useradmin'], "Enviou email para ".$paraquem." (Habbos)");

									}
								}
								?>
								<?php if($ocultaresto){ ?>
									<form method="POST">
										<div class="form-group row">
											<label class="col-sm-2 col-form-label">Título</label>
											<div class="col-sm-10">
												<input type="text" name="titulo_email" class="form-control">
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-2 col-form-label">Enviar para</label>
											<div class="col-sm-10">
												<select class="form-control" name="paraquem">
													<option value="todos">Todos os clientes</option>
													<option value="ativos">Clientes ativos</option>
													<option value="suspensos">Clientes suspensos</option>
												</select>
											</div>
										</div>
										<textarea name="conteudo_email"  rows="15" cols="80"></textarea>
										<br>														
										<center><button class="btn btn-primary" style="border-radius: 8px;" type="submit" name="envia_email" >Enviar</button></center>
										<br>
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
<script src="https://cdn.ckeditor.com/4.9.2/full-all/ckeditor.js"></script>
<script src="<?php echo $dominio;?>/galaxyservers/bower_components/datatables.net/js/jquery.dataTables.min.js?"></script>
<script src="<?php echo $dominio;?>/galaxyservers/bower_components/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?php echo $dominio;?>/galaxyservers/assets/pages/data-table/js/jszip.min.js"></script>
<script src="<?php echo $dominio;?>/galaxyservers/assets/pages/data-table/js/pdfmake.min.js"></script>
<script src="<?php echo $dominio;?>/galaxyservers/assets/pages/data-table/js/vfs_fonts.js"></script>
<script src="<?php echo $dominio;?>/galaxyservers/assets/pages/data-table/extensions/autofill/js/dataTables.select.min.js"></script>
<script src="<?php echo $dominio;?>/galaxyservers/bower_components/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="<?php echo $dominio;?>/galaxyservers/bower_components/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo $dominio;?>/galaxyservers/bower_components/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo $dominio;?>/galaxyservers/bower_components/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo $dominio;?>/galaxyservers/bower_components/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
<script src="<?php echo $dominio;?>/galaxyservers/assets/pages/data-table/extensions/autofill/js/extensions-custom.js"></script>
<script>
	CKEDITOR.replace( 'conteudo_email' );
	

	CKEDITOR.replace( textarea );
</script>
</body>
</html>
<?php } ?>
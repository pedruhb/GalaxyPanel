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
							<div class="card-header">
								<h5>Emblemas Hospedados</h5>
								<span>Confira aqui os emblemas hospedados por você!</span>
								<?php

								if(!permissao("embhospedados")){
									echo '<div style="display: contents;">
									<div class="col-md-12">
									<center><div class="alert alert-danger background-danger" style="width: 30%;">
									<strong>Erro!</strong> Sua subconta não tem permissão para acessar essa página.
									</div></center>
									</div>
									</div>';
								} else {

									if(isset($_POST['apagaremblema'])){

										$codigo = $_POST['codigoemblema'];

										try {
											$PDO2 = new PDO('mysql:host='.$iphospedagem.';dbname='.$server['uservestacp']."_hotel", $server['uservestacp']."_hotel", $server['senhavestacp']);
											$PDO2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
										} catch(PDOException $e) {
											echo '<script>alert("Erro de conexão ao hotel: ' . utf8_encode($e->getMessage()).'");</script>';
										}


										$stmt1 = $PDO2->prepare('DELETE FROM user_badges WHERE badge_id = "'.$codigo.'"');
										$stmt1->execute();
										$stmt2 = $PDO2->prepare('DELETE FROM badge_definitions WHERE code = "'.$codigo.'"');
										$stmt2->execute();
										$stmt3 = $PDO->prepare('DELETE FROM emblemas WHERE codigo = "'.$codigo.'"');
										$stmt3->execute();

										$servidor = $ipftpemblema;
										$caminho_absoluto = $caminhoftpemblema;
										$con_id = ftp_connect($servidor) or die( '<script>alert("Não conectou em: '.$servidor.'");</script>');
										ftp_login( $con_id, $userftpemblema, $senhaftpemblema );
										if ( @ftp_delete($con_id, $caminho_absoluto.$codigo.'.gif')) {
											echo '<br><div class="alert alert-success background-success">
											<strong>Successo!</strong> Emblema removido com sucesso!
											</div>';
											addlog('Apagou o emblema '.$codigo);
										} else {
											echo '<br><div class="alert alert-danger background-danger">
											<strong>Erro!</strong> Erro ao remover emblema!
											</div>';													
										} 
										ftp_close( $con_id );
									}
									?>
								</div>
								<div class="card-block">
									<div class="dt-responsive table-responsive" style="  overflow: hidden;">
										<div class="row">
											<div class="col-xs-12 col-sm-12">
												<table id="autofill" class="table table-striped table-bordered nowrap dataTable" role="grid" aria-describedby="autofill_info">
													<thead>
														<tr role="row">
															<th class="sorting_asc" tabindex="0" aria-controls="autofill" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 143px;">Emblema</th>
															<th class="sorting" tabindex="0" aria-controls="autofill" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" style="width: 236px;">Código</th>
															<th class="sorting" tabindex="0" aria-controls="autofill" rowspan="1" colspan="1" aria-label="Office: activate to sort column ascending" style="width: 102px;">Nome</th>
															<th class="sorting" tabindex="0" aria-controls="autofill" rowspan="1" colspan="1" aria-label="Office: activate to sort column ascending" style="width: 102px;">Descrição</th>
															<th class="sorting" tabindex="0" aria-controls="autofill" rowspan="1" colspan="1" aria-label="Office: activate to sort column ascending" style="width: 102px;">Editar</th>
															<th class="sorting" tabindex="0" aria-controls="autofill" rowspan="1" colspan="1" aria-label="Office: activate to sort column ascending" style="width: 102px;">Apagar</th>
														</tr>
													</thead>
													<tbody>
														<?php
														$emblemas = $PDO->prepare("SELECT * FROM emblemas WHERE usuario = '".$_SESSION['nomeusuario']."' ORDER BY id DESC");
														$emblemas->execute();
														while($emblema = $emblemas->fetch()){ 
															$nome = substr_replace($emblema['nome'], (strlen($emblema['nome']) > '40' ? '...' : ''), '40');
															$desc = substr_replace($emblema['descricao'], (strlen($emblema['descricao']) > '40' ? '...' : ''), '40');
															echo '
															<tr>
															<th scope="row"><img src="'.$linkapiemblema.''.$emblema['codigo'].'" width="40" height="40"></th>
															<td >'.$emblema['codigo'].'</td>
															<td  title="'.stripslashes($emblema['nome']).'">'.stripslashes($nome).'</td>
															<td  title="'.stripslashes($emblema['descricao']).'">'.stripslashes($desc).'</td>
															<td><a href="editar-emblema/'.$emblema['codigo'].'"><button class="btn btn-info btn-icon"><i class="icofont icofont-edit" style="padding-left: 5px;"></i></button></a></td>
															<td><form name="apagaremblema" method="POST"><input name="codigoemblema" value="'.$emblema['codigo'].'" type="hidden"><button type="submit" name="apagaremblema" class="btn btn-danger btn-icon"><i class="icofont icofont-trash" style="padding-left: 5px;"></i></button></form></td>
															</tr>
															';}?>
														</tbody>
														<tfoot>
														</tfoot>
													</table></div></div></div>
												</div>
											<?php } ?>
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

<script src="galaxyservers/bower_components/datatables.net/js/jquery.dataTables.min.js?"></script>
<script src="galaxyservers/bower_components/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="galaxyservers/assets/pages/data-table/js/jszip.min.js"></script>
<script src="galaxyservers/assets/pages/data-table/js/pdfmake.min.js"></script>
<script src="galaxyservers/assets/pages/data-table/js/vfs_fonts.js"></script>
<script src="galaxyservers/assets/pages/data-table/extensions/autofill/js/dataTables.select.min.js"></script>
<script src="galaxyservers/bower_components/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="galaxyservers/bower_components/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="galaxyservers/bower_components/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="galaxyservers/bower_components/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="galaxyservers/bower_components/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
<script src="galaxyservers/assets/pages/data-table/extensions/autofill/js/extensions-custom.js"></script>

</body>
</html><?php } else header('Location: ../index'); ?>
<?php
include "/galaxyservers/global.php";
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
							<?php
							if(!permissao("catalogo")){
								echo '<div style="display: contents;">
								<div class="col-md-12">
								<center><div class="alert alert-danger background-danger" style="width: 30%;">
								<strong>Erro!</strong> Sua subconta não tem permissão para acessar essa página.
								</div></center>
								</div>
								</div>';
							} else {
								?>
							<div class="card-header">
								<?php
								$paginas = $PDO2->prepare("SELECT * FROM catalog_pages WHERE id = :pid");
								$paginas->bindParam(":pid", $_GET['id']);
								$paginas->execute();
								$pagina = $paginas->fetch();
								?>
								<h5>Catálogo</h5>
								<span>Editando mobis da página <?php echo '<img draggable="false" src="'.$cimagesswf.'catalogue/icon_'.$pagina['icon_image'].'.png"> '.utf8_encode(str_replace("HOTELNAME", $server['nomehotel'], $pagina['caption']));?></span>
							</div>
							<div class="card-block">
								<div class="dt-responsive table-responsive" style="  overflow: hidden;">
									<div class="row">
										<div class="col-xs-12 col-sm-12">
											<table id="autofill" class="table table-striped table-bordered nowrap dataTable" role="grid" aria-describedby="autofill_info">
												<thead>
													<tr role="row">
														<th class="sorting_asc" tabindex="0" aria-controls="autofill" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 143px;">ID</th>
														<th class="sorting" tabindex="0" aria-controls="autofill" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" style="width: 236px;">Mobi</th>
														<th class="sorting" tabindex="0" aria-controls="autofill" rowspan="1" colspan="1" aria-label="Office: activate to sort column ascending" style="width: 102px;">Créditos</th>
														<th class="sorting" tabindex="0" aria-controls="autofill" rowspan="1" colspan="1" aria-label="Office: activate to sort column ascending" style="width: 102px;">Duckets</th>		
														<th class="sorting" tabindex="0" aria-controls="autofill" rowspan="1" colspan="1" aria-label="Office: activate to sort column ascending" style="width: 102px;">Diamantes</th>
														<th class="sorting" tabindex="0" aria-controls="autofill" rowspan="1" colspan="1" aria-label="Office: activate to sort column ascending" style="width: 102px;">GOTW</th>	
														<th class="sorting" tabindex="0" aria-controls="autofill" rowspan="1" colspan="1" aria-label="Office: activate to sort column ascending" style="width: 102px;">Emblema</th>								
														<th class="sorting" tabindex="0" aria-controls="autofill" rowspan="1" colspan="1" aria-label="Office: activate to sort column ascending" style="width: 102px;">Editar</th>
													</tr>
												</thead>
												<tbody>
													<?php

													try {
														$PDO2 = new PDO('mysql:host='.$iphospedagem.';dbname='.$server['uservestacp']."_hotel".";charset=utf8", $server['uservestacp']."_hotel", $server['senhavestacp']);
														$PDO2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
													} catch(PDOException $e) {
														echo '<script>alert("Erro de conexão ao hotel: ' . utf8_encode($e->getMessage()).'");</script>';
													}


													$paginas = $PDO2->prepare("SELECT *,(SELECT item_name FROM furniture WHERE id = item_id) as itemfurnidata FROM catalog_items WHERE page_id = :pid ORDER BY id");
													$paginas->bindParam(":pid", $_GET['id']);
													$paginas->execute();
													while($pagina = $paginas->fetch())
													{
														echo'<tr>
														<td style="width: 1px;">'.$pagina['id'].'</td>
														<td><img draggable="false" src="'.$linkswf_api.'/dcr/hof_furni/'.$pagina['itemfurnidata'].'_icon.png"> '.$pagina['itemfurnidata'].'</td>
														<td style="width: 1px;">'.$pagina['cost_credits'].'</td>
														<td style="width: 1px;">'.$pagina['cost_pixels'].'</td>
														<td style="width: 1px;">'.$pagina['cost_diamonds'].'</td>
														<td style="width: 1px;">'.$pagina['cost_gotw'].'</td>
														<td style="width: 1px;">'; if(empty($pagina['badge']))echo"Não";else echo $pagina['badge']; echo '</td>
														<td><a href="/edita-mobi/'.$pagina['id'].'"><img draggable="false" src="https://i.imgur.com/xsKtItS.gif"></a></td>
														</tr>
														';}?>
													</tbody>
													<tfoot>
													</tfoot>
												</table></div></div></div>
											</div>
										</div><?php }?>
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
<script type="text/javascript" src="/galaxyservers/bower_components/jquery/js/jquery.min.js"></script>
<script type="text/javascript" src="/galaxyservers/bower_components/jquery-ui/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="/galaxyservers/bower_components/popper.js/js/popper.min.js"></script>
<script type="text/javascript" src="/galaxyservers/bower_components/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/galaxyservers/bower_components/jquery-slimscroll/js/jquery.slimscroll.js"></script>
<script type="text/javascript" src="/galaxyservers/bower_components/modernizr/js/modernizr.js"></script>
<script type="text/javascript" src="/galaxyservers/bower_components/modernizr/js/css-scrollbars.js"></script>
<script src="/galaxyservers/assets/pages/jquery.filer/js/jquery.filer.min.js"></script>
<script src="/galaxyservers/assets/pages/filer/custom-filer.js" type="text/javascript"></script>
<script src="/galaxyservers/assets/pages/filer/jquery.fileuploads.init.js?a=a" type="text/javascript"></script>
<script type="text/javascript" src="/galaxyservers/bower_components/i18next/js/i18next.min.js"></script>
<script type="text/javascript" src="/galaxyservers/bower_components/i18next-xhr-backend/js/i18nextXHRBackend.min.js"></script>
<script type="text/javascript" src="/galaxyservers/bower_components/i18next-browser-languagedetector/js/i18nextBrowserLanguageDetector.min.js"></script>
<script type="text/javascript" src="/galaxyservers/bower_components/jquery-i18next/js/jquery-i18next.min.js"></script>
<script src="/galaxyservers/assets/js/pcoded.min.js"></script>
<script src="/galaxyservers/assets/js/demo-12.js"></script>
<script src="/galaxyservers/assets/js/jquery.mCustomScrollbar.concat.min.js"></script>
<script type="text/javascript" src="/galaxyservers/assets/js/script.js"></script>

<script src="/galaxyservers/bower_components/datatables.net/js/jquery.dataTables.min.js?"></script>
<script src="/galaxyservers/bower_components/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="/galaxyservers/assets/pages/data-table/js/jszip.min.js"></script>
<script src="/galaxyservers/assets/pages/data-table/js/pdfmake.min.js"></script>
<script src="/galaxyservers/assets/pages/data-table/js/vfs_fonts.js"></script>
<script src="/galaxyservers/assets/pages/data-table/extensions/autofill/js/dataTables.select.min.js"></script>
<script src="/galaxyservers/bower_components/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="/galaxyservers/bower_components/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="/galaxyservers/bower_components/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="/galaxyservers/bower_components/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="/galaxyservers/bower_components/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
<script src="/galaxyservers/assets/pages/data-table/extensions/autofill/js/extensions-custom.js"></script>

</body>
</html><?php } else header('Location: ../index'); ?>
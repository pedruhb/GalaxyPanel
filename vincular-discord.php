<?php
include "galaxyservers/global.php";
if(!empty($_SESSION['nomeusuario'])){

	$infoserver = $PDO->prepare("SELECT * FROM servidores WHERE nomeusuario = '".$_SESSION['nomeusuario']."'");
	$infoserver->execute();
	$server = $infoserver->fetch();
	$_SESSION['senhaatualdb'] = $server['senhavestacp'];

	function apiRequest($url, $post=FALSE, $headers=array()) {
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		$response = curl_exec($ch);
		if($post)
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
		$headers[] = 'Accept: application/json';
		if(session('access_token'))
			$headers[] = 'Authorization: Bearer ' . session('access_token');
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		$response = curl_exec($ch);
		return json_decode($response);
	}
	function get($key, $default=NULL) {
		return array_key_exists($key, $_GET) ? $_GET[$key] : $default;
	}
	function session($key, $default=NULL) {
		return array_key_exists($key, $_SESSION) ? $_SESSION[$key] : $default;
	}


	$authorizeURL = 'https://discordapp.com/api/oauth2/authorize';
	$tokenURL = 'https://discordapp.com/api/oauth2/token';
	$apiURLBase = 'https://discordapp.com/api/users/@me';

	?>
	<?php include 'galaxyservers/nav.php';?>
	<div class="pcoded-content">
		<div class="pcoded-inner-content">
			<div class="main-body user-profile">
				<div class="page-wrapper">
					<div class="page-body">
						<div class="card">
							<div class="card-block">
								<div class="m-b-20">
									<h4 class="sub-title">Vinculação com o Discord.</h4>
									<?php
									$ocultar = false;
									if(isset($_SESSION['subconta'])){
										echo '<div style="display: contents;">
										<div class="col-md-12">
										<center><div class="alert alert-danger background-danger" style="width: 30%;">
										<strong>Erro!</strong> Sua subconta não tem permissão para acessar essa página.
										</div></center>
										</div>
										</div>';
									} else {

										function apiRequest2($url, $post=FALSE, $headers=array()) {
											global $token_bot;
											$ch = curl_init($url);
											curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
											curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
											$response = curl_exec($ch);
											if($post)
												curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
											$headers[] = 'Accept: application/json';

											$headers[] = 'Authorization: Bot '.$token_bot;
											curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
											$response = curl_exec($ch);
											return json_decode($response);
										}




										if(isset($_POST['desvincular'])){

											addlog('Desvinculou a conta do Discord.');

											$upateUser2 = $PDO->prepare("UPDATE `servidores` SET discord_id = ''  where `id`= :id");
											$upateUser2->bindValue(':id', $server['id']);
											$upateUser2->execute(); 

											echo '<div class="alert alert-success background-success">
											<strong>Successo!</strong> Conta desvinculada.
											</div>';

											$infoserver = $PDO->prepare("SELECT * FROM servidores WHERE nomeusuario = '".$_SESSION['nomeusuario']."'");
											$infoserver->execute();
											$server = $infoserver->fetch();
										}


										if(get('code')) {
											try{
												if($server['discord_id'] == "" || $server['discord_id'] == null){
													$token = apiRequest($tokenURL, array(
														"grant_type" => "authorization_code",
														'client_id' => OAUTH2_CLIENT_ID,
														'client_secret' => OAUTH2_CLIENT_SECRET,
														'redirect_uri' => 'https://painel.galaxyservers.com.br/vincular-discord',
														'code' => get('code')
													));
													@$logout_token = $token->access_token;
													if(@$token->access_token != null){
														$_SESSION['access_token'] = $token->access_token;

														$user = apiRequest($apiURLBase);

														$upateUser2 = $PDO->prepare("UPDATE `servidores` SET discord_id = :did  where `id`= :id");
														$upateUser2->bindValue(':id', $server['id']);
														$upateUser2->bindValue(':did', $user->id);
														$upateUser2->execute(); 
														addlog('Vinculou o Discord ao painel ('.$user->username.'#'.$user->discriminator.').');

														echo '<div class="alert alert-success background-success">
														<strong>Successo!</strong> Conta vinculada.
														</div>';
													}
												}
											} catch (Exception $e){

											}

										}

										if(isset($_POST['vincular'])){

											$params = array(
												'client_id' => OAUTH2_CLIENT_ID,
												'redirect_uri' => 'https://painel.galaxyservers.com.br/vincular-discord',
												'response_type' => 'code',
												'scope' => 'identify guilds'
											);
											if (headers_sent()) {
												echo "<center><h3>Redirecionando ao Discord...</h3></center>";
												echo '<meta http-equiv="refresh" content=1;https://discordapp.com/api/oauth2/authorize' . '?' . http_build_query($params).'>';
												$ocultar=true;
											}
											else{
												exit(header('Location: https://discordapp.com/api/oauth2/authorize' . '?' . http_build_query($params)));
											}
										}

										$infoserver = $PDO->prepare("SELECT * FROM servidores WHERE nomeusuario = '".$_SESSION['nomeusuario']."'");
										$infoserver->execute();
										$server = $infoserver->fetch();

										if(!isset($server['discord_id']) || $server['discord_id'] == null || $server['discord_id'] == ""){	
											$conta = "Não há discord vinculado.";
											$conta .= '<br><br><button type="submit" style="border-radius: 8px;" name="vincular" class="btn btn-primary m-b-0">Vincular Discord</button>';
										}
										else {
											$infos = apiRequest2("https://discordapp.com/api/users/".$server['discord_id']);
											$conta = "Você tem um discord vinculado: ".$infos->username."#".$infos->discriminator." (". $infos->id.")";
											$conta .= '<br><br><button type="submit" style="border-radius: 8px;" name="desvincular" class="btn btn-primary m-b-0">Desvincular Discord</button>';
										}

										if($ocultar == true)
											$conta = "";
									}
									?>
									<form method="post">
										<center><?= $conta;?></center>
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
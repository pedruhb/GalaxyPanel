<?php include "galaxyservers/global.php";
if(isset($_SESSION['nomeusuario'])){
	echo '<script>location.href="principal";</script>';
}

if(empty($_SESSION['count_login_error']))
	$_SESSION['count_login_error'] = 0;

if(isset($_POST['desvincular'])){
  $_SESSION['access_token'] = null;
}

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
           <div class="text-center">
            <br>
            <img src="<?= $logo_login;?>" draggable="false" alt="logo.png" <?= $style_login;?>>
          </div>
          <div class="auth-box">
            <div class="row m-b-20">
             <div class="col-md-12">
              <h3 class="text-left txt-primary">Login via Discord</h3>
            </div>
          </div>
          <hr />

          <?php
          /*
          ini_set('display_errors', 1);
          ini_set('display_startup_errors', 1);
          ini_set('max_execution_time', 300); 
          error_reporting(E_ALL);

          $authorizeURL = 'https://discordapp.com/api/oauth2/authorize';
          $tokenURL = 'https://discordapp.com/api/oauth2/token';
          $apiURLBase = 'https://discordapp.com/api/users/@me';
          if(get('action') == 'login') {
            $params = array(
              'client_id' => OAUTH2_CLIENT_ID,
              'redirect_uri' => 'https://painel.galaxyservers.com.br/login-discord',
              'response_type' => 'code',
              'scope' => 'identify guilds'
            );
            header('Location: https://discordapp.com/api/oauth2/authorize' . '?' . http_build_query($params));
            die();
          }
          if(get('code')) {
            $token = apiRequest($tokenURL, array(
              "grant_type" => "authorization_code",
              'client_id' => OAUTH2_CLIENT_ID,
              'client_secret' => OAUTH2_CLIENT_SECRET,
              'redirect_uri' => 'https://painel.galaxyservers.com.br/login-discord',
              'code' => get('code')
            ));
            $logout_token = $token->access_token;
            $_SESSION['access_token'] = $token->access_token;
            header('Location: ' . $_SERVER['PHP_SELF']);
            echo "nbbb";
          }
          if(session('access_token')) {
            $user = apiRequest($apiURLBase);
            echo "aaaa";
            $discorduserid =  $user->id;
            if(!empty($discorduserid)){
              $contauser = $PDO->prepare("SELECT nomeusuario,senhavestacp,ativo FROM servidores where discord_id = :tel");
              $contauser->bindParam(':tel', $discorduserid);
              $contauser->execute();
              $contauserr = $contauser->fetch();
              $countserver = $contauser->rowCount();
              if($countserver == 0){
                loginerror("Não há nenhum servidor com esse discord vinculado..");
                $_SESSION['access_token'] = null;
                echo '<p><a href="?action=login">Relogar no Discord.</a></p>';
              }
              else if($countserver > 1){
                loginerror("Há mais de um hotel com esse discord.");
                $_SESSION['access_token'] = null;
              }
              else if($contauserr['ativo'] == 'N'){
                $_SESSION['access_token'] = null;
                loginerror("Conta do servidor bloqueada.");
              }
              else {
                $_SESSION['nomeusuario'] = $contauserr['nomeusuario'];
                $_SESSION['senhalogin'] = $contauserr['senhavestacp'];
                $_SESSION['senhaatualdb'] = $contauserr['senhavestacp'];
                $adicionalog = $PDO->prepare("INSERT INTO `log_servidores` (`log`, `autor`, `ip`, `data`) VALUES ('Logou no painel através do Discord.', '".$_SESSION['nomeusuario']."', '".$meuip."', '".time()."');");
                $adicionalog->execute();
                echo '<meta http-equiv="refresh" content=1;url="principal">';
                loginsucess("Seja bem vindo ao painel.");
              }
            }
          } else {
           // echo '<h3>Faça login no Discord.</h3><br>';
            echo '<a href="?action=login"><img style="width: 80%;"src="https://i.imgur.com/RBfcoBt.png"></a><br><br>';
          }
          if(get('action') == 'logout') {
            $params = array(
              'access_token' => $logout_token
            );
            header('Location: https://discordapp.com/api/oauth2/token/revoke' . '?' . http_build_query($params));
            die();
          }
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
          }*/
          ?>
          <?php

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


          function login_galaxy($discorduserid){
            global $PDO;
            global $_SESSION;
            global $meuip;
            if(!empty($discorduserid)){
              $contauser = $PDO->prepare("SELECT nomeusuario,senhavestacp,ativo FROM servidores where discord_id = :tel");
              $contauser->bindParam(':tel', $discorduserid);
              $contauser->execute();
              $contauserr = $contauser->fetch();
              $countserver = $contauser->rowCount();
              if($countserver == 0){
                loginerror("Não há nenhum servidor com esse discord vinculado..");
                echo '<form method="post">
                <button type="submit" style="border-radius: 8px;" name="desvincular" class="btn btn-primary m-b-0">Sair do Discord.</button>
                </form>';
              }
              else if($countserver > 1){
                loginerror("Há mais de um hotel com esse discord.");
              }
              else if($contauserr['ativo'] == 'N'){
                loginerror("Conta do servidor bloqueada.");
              }
              else {
                $_SESSION['nomeusuario'] = $contauserr['nomeusuario'];
                $_SESSION['senhalogin'] = $contauserr['senhavestacp'];
                $_SESSION['senhaatualdb'] = $contauserr['senhavestacp'];
                $adicionalog = $PDO->prepare("INSERT INTO `log_servidores` (`log`, `autor`, `ip`, `data`) VALUES ('Logou no painel através do Discord.', '".$_SESSION['nomeusuario']."', '".$meuip."', '".time()."');");
                $adicionalog->execute();
                echo '<meta http-equiv="refresh" content=1;url="principal">';
                loginsucess("Seja bem vindo ao painel.");
              }
            } else {
             loginerror("Erro ao obter id do Discord.");
           }
         }

         if(get('code')) {
  // Exchange the auth code for a token
          $token = apiRequest($tokenURL, array(
            "grant_type" => "authorization_code",
            'client_id' => OAUTH2_CLIENT_ID,
            'client_secret' => OAUTH2_CLIENT_SECRET,
            'redirect_uri' => 'https://painel.galaxyservers.com.br/login-discord',
            'code' => get('code')
          ));
          $logout_token = $token->access_token;
          $_SESSION['access_token'] = $token->access_token;
          header('Location: ' . $_SERVER['PHP_SELF']);
        }


        if(session('access_token')) {
          $user = apiRequest($apiURLBase);
          echo '<h3>Conectado como '.$user->username.'#'.$user->discriminator.'</h3><br>';
          login_galaxy($user->id);
        } else {
          echo '<form method="post">
          <button type="submit" style="border-radius: 8px;" name="vincular" class="btn btn-primary m-b-0">Autorizar Discord</button>
          </form>';
        }


        if(isset($_POST['vincular'])){

          $params = array(
            'client_id' => OAUTH2_CLIENT_ID,
            'redirect_uri' => 'https://painel.galaxyservers.com.br/login-discord',
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



        ?>

        <div class="row text-left">
         <div class="col-12">
          <div class="forgot-phone text-right f-right">
            <a href="/index" class="text-right f-w-600 text-inverse"> Login padrão</a>
          </div>									
        </div>
      </div>
      <hr />
      <div class="row">
       <div class="col-md-10">
        <p class="text-inverse text-left"><b><a href="http://galaxyservers.com.br/">Powered by GalaxyServers.</a></b></p>
      </div>
    </div>
  </div>
  <form id="login_success" method="post" action="/accountkit">
   <input id="csrf" type="hidden" name="csrf" />
   <input id="code" type="hidden" name="code" />
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
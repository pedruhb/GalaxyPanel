<?php include "galaxyservers/global.php";
if(isset($_SESSION['nomeusuario'])){
	echo '<script>location.href="principal";</script>';
}

if(empty($_SESSION['count_login_error']))
	$_SESSION['count_login_error'] = 0

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
              <h3 class="text-left txt-primary">Login Cliente</h3>
            </div>
          </div>
          <hr />
          <?php
          if(isset($_POST['code']) || isset($_GET['code'])){

            if(isset($_POST['code']))
              $code = $_POST['code'];
            else if(isset($_GET['code']))
              $code = $_GET['code'];

            $app_id = '464589677358108';
            $secret = 'ca34fde2b70b627959982e02f463ff0d';
            $version = 'v1.1';
            function doCurl($url) {
              $ch = curl_init();
              curl_setopt($ch, CURLOPT_URL, $url);
              curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
              $data = json_decode(curl_exec($ch), true);
              curl_close($ch);
              return $data;
            }
            $token_exchange_url = 'https://graph.accountkit.com/'.$version.'/access_token?'.
            'grant_type=authorization_code'.
            '&code='.$code.
            "&access_token=AA|$app_id|$secret";
            $data = doCurl($token_exchange_url);
            $user_id = $data['id'];
            $user_access_token = $data['access_token'];
            $refresh_interval = $data['token_refresh_interval_sec'];
            $me_endpoint_url = 'https://graph.accountkit.com/'.$version.'/me?'.
            'access_token='.$user_access_token;
            $data = doCurl($me_endpoint_url);
            $phone = isset($data['phone']) ? $data['phone']['number'] : '';
            $email = isset($data['email']) ? $data['email']['address'] : '';
            if(!empty($phone)){
              $contauser = $PDO->prepare("SELECT nomeusuario,senhavestacp,ativo FROM servidores where telefone = :tel");
              $contauser->bindParam(':tel', $phone);
              $contauser->execute();
              $contauserr = $contauser->fetch();
              $countserver = $contauser->rowCount();
              if($countserver == 0)
                loginerror("Não há nenhum servidor com esse telefone.");
              else if($countserver > 1)
                loginerror("Há mais de um hotel com esse email.");
              else if($contauserr['ativo'] == 'N')
                loginerror("Conta do servidor bloqueada.");
              else {
                $_SESSION['nomeusuario'] = $contauserr['nomeusuario'];
                $_SESSION['senhalogin'] = $contauserr['senhavestacp'];
                $_SESSION['senhaatualdb'] = $contauserr['senhavestacp'];
                $adicionalog = $PDO->prepare("INSERT INTO `log_servidores` (`log`, `autor`, `ip`, `data`) VALUES ('Logou no painel através de AccountKit (telefone).', '".$_SESSION['nomeusuario']."', '".$meuip."', '".time()."');");
                $adicionalog->execute();
                echo '<meta http-equiv="refresh" content=1;url="principal">';
                loginsucess("Seja bem vindo ao painel.");
              }
            } else if(!empty($email)){
              $contauser = $PDO->prepare("SELECT nomeusuario,senhavestacp,ativo FROM servidores where emailcliente = :email");
              $contauser->bindParam(':email', $email);
              $contauser->execute();
              $contauserr = $contauser->fetch();
              $countserver = $contauser->rowCount();
              if($countserver == 0)
                loginerror("Não há nenhum servidor com esse email.");
              else if($countserver > 1)
                loginerror("Há mais de um hotel com esse email.");
              else if($contauserr['ativo'] == 'N')
                loginerror("Conta do servidor bloqueada.");
              else {
                $_SESSION['nomeusuario'] = $contauserr['nomeusuario'];
                $_SESSION['senhalogin'] = $contauserr['senhavestacp'];
                $_SESSION['senhaatualdb'] = $contauserr['senhavestacp'];
                $adicionalog = $PDO->prepare("INSERT INTO `log_servidores` (`log`, `autor`, `ip`, `data`) VALUES ('Logou no painel através de AccountKit (email).', '".$_SESSION['nomeusuario']."', '".$meuip."', '".time()."');");
                $adicionalog->execute();
                echo '<meta http-equiv="refresh" content=1;url="principal">';
                loginsucess("Seja bem vindo ao painel.");
              }
            }

          }

          ?>
          <div id="select-modo">
            <input type="submit" style="background-color: #7b5eea;border-color: #6c50d6;"  onclick="loginporemail();" value="Login por email" class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20" />
            <input type="submit" style="background-color: #7b5eea;border-color: #6c50d6;"  onclick="loginporsms();" value="Login por SMS" class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20" />
          </div>
          <div id="login-sms" style="display:none">
            <input value="+55" type="hidden" id="country_code" />
            <div class="input-group">
             <input type="text" class="form-control"  id="phone_number" placeholder="Número de telefone">
             <span class="md-line"></span>
           </div>              
           <div class="row m-t-30">
             <div class="col-md-12">
              <input type="submit" style="background-color: #7b5eea;border-color: #6c50d6;"  onclick="smsLogin();" value="Login" class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20" />
            </div>
          </div>
        </div>
        <div id="login-email" style="display:none">
         <div class="input-group">
           <input type="mail" class="form-control"  id="email" placeholder="Seu email">
           <span class="md-line"></span>
         </div>
         <div class="row m-t-30">
           <div class="col-md-12">
            <input type="submit" style="background-color: #7b5eea;border-color: #6c50d6;"  onclick="emailLogin();" value="Login" class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20" />
          </div>
        </div>
      </div>
      <div class="row text-left">
       <div class="col-12">
        <div class="forgot-phone text-right f-right">
          <a href="/index" class="text-right f-w-600 text-inverse"> Voltar</a>
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

<script type="text/javascript">
  function loginporemail(){
    document.getElementById("select-modo").style.display="none";
    document.getElementById("login-email").style.display="";
  }
  function loginporsms(){
    document.getElementById("select-modo").style.display="none";
    document.getElementById("login-sms").style.display="";
  }
</script>
<!-- HTTPS required. HTTP will give a 403 forbidden response -->
<script src="https://sdk.accountkit.com/pt_BR/sdk.js"></script>
<?php
if(!isset($_SESSION['token-login'])){
  $_SESSION['token-login'] = rand(1,999);
}
?>
<script>
  // initialize Account Kit with CSRF protection
  AccountKit_OnInteractive = function(){
  	AccountKit.init(
  	{
  		appId:"464589677358108", 
  		state:"<?= $_SESSION['token-login'];?>", 
  		version:"v1.1",
  		fbAppEventsEnabled:true,
  		redirect:"https://painel.galaxyservers.com.br/accountkit",
  		debug:true
  	}
  	);
  };

  // login callback
  function loginCallback(response) {
  	if (response.status === "PARTIALLY_AUTHENTICATED") {
  		document.getElementById("code").value = response.code;
  		document.getElementById("csrf").value = response.state;
  		document.getElementById("login_success").submit();
  	}
  	else if (response.status === "NOT_AUTHENTICATED") {
      // handle authentication failure
    }
    else if (response.status === "BAD_PARAMS") {
      // handle bad parameters
    }
  }

  // phone form submission handler
  function smsLogin() {
  	var countryCode = document.getElementById("country_code").value;
  	var phoneNumber = document.getElementById("phone_number").value;
  	AccountKit.login(
  		'PHONE', 
      {countryCode: countryCode, phoneNumber: phoneNumber}, // will use default values if not specified
      loginCallback
      );
  }


  // email form submission handler
  function emailLogin() {
  	var emailAddress = document.getElementById("email").value;
  	AccountKit.login(
  		'EMAIL',
  		{emailAddress: emailAddress},
  		loginCallback
  		);
  }

  
</script>



</body>
</html>
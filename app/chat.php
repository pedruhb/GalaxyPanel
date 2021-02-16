<?php

define('GALAXYSERVERS', 1);	
include "../galaxyservers/config.php";

try {
	$PDO = new PDO('mysql:host=' .$hostname. ';dbname=' . $database, $username, $password);
	$PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
	die('Erro de conexão com o GalaxyPanel');
}

if(!isset($_GET['usuario']) || !isset($_GET['senha']))
	die('Campos não repassados');

if(empty($_GET['usuario']) || empty($_GET['senha']))
	die('Campos não repassados');

$usuario = $_GET['usuario'];
$senha = $_GET['senha'];

$contauser = $PDO->prepare("SELECT COUNT(ID) as total,uservestacp,senhavestacp,ativo,login_dados,emailcliente FROM servidores where uservestacp = :usuario and senhavestacp = :senha");
$contauser->bindParam(':usuario', $usuario);
$contauser->bindParam(':senha', $senha);
$contauser->execute();
$contauserr = $contauser->fetch();


function RconEmuLDR($command, $data, $ipvp2s, $mus) {
	$rconData = $command.chr(1).$data;
	$rcon = @socket_create(AF_INET, SOCK_STREAM, getprotobyname('tcp'));
	@socket_connect($rcon, $ipvp2s, $mus);
	@socket_send($rcon, $rconData, strlen($rconData), MSG_DONTROUTE);
	@socket_close($rcon);
}


if($contauserr['total'] != 1)
	die('Hotel não encontrado');
else if($contauserr['login_dados'] == 'N')
	die('Login com dados desativado');
else if($contauserr['ativo'] == 'N')
	die('Hotel desativado');

?>

<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="minimum-scale=1.0, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, width=device-width, height=device-height" />
	<title></title>
	<script type="text/javascript" src="https://tawk.to/public/scripts/popout.js"></script>
	<script type="text/javascript">
		var Tawk_API = {
			isPopup: true,
			onLoad: function () {
				var dataObj = parseQueryString();

				if (dataObj.tags !== undefined) {
					Tawk_API.addTags(dataObj.tags);
				}

				if (dataObj.event !== undefined) {
					if (dataObj.attrLength !== 0) {
						Tawk_API.addEvent(dataObj.event, dataObj.attributes);
					} else {
						Tawk_API.addEvent(dataObj.event);
					}
				};
			}

		}, Tawk_LoadStart = new Date();

		(function(){
			var s1=document.createElement("script"),
			s0=document.getElementsByTagName("script")[0];

			s1.async=true;
			s1.src='https://embed.tawk.to/5d3e5e529b94cd38bbe9bcc3/default';
			s1.charset='UTF-8';
			s1.setAttribute('crossorigin','*');

			s0.parentNode.insertBefore(s1,s0);
		})();
		Tawk_API.onLoad = function(){
			Tawk_API.addTags(['APP Android', '<?= $contauserr['uservestacp'];?>'], function(error){});
		};

		Tawk_API.onLoad = function(){
			Tawk_API.setAttributes({
				'name': '<?= $contauserr['uservestacp'];?>',
				'email' : '<?= $contauserr['emailcliente'];?>'
			}, function(error){});
		}
	</script>
</head>
<body></body>
</html>
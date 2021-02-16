<?php
if(!defined("GALAXYSERVERS")) { die("Você não pode acessar esse arquivo."); }
/// Painel programado por PHB, feito especificamente para funcionar com o Vesta CP

// Conexão com banco de dados
$hostname = "localhost";
$username = "root";
$password = "H8KTOguzcm@@";
$database = "painel";

/// Domínio do painel
$dominio = "https://painel.galaxyservers.com.br";
$ipvps = "192.99.199.13"; /// Ip da vps do emulador.
$iphospedagem = "192.99.199.14"; /// Ip da vps da hospedagem.
$ipftp = $iphospedagem; /// ip do ftp do hotel
$phpmyadmin = "https://painel.galaxyservers.com.br/pma/index.php"; ///link da index.php phpmyadmin

// Versão do painel
$versaopainel = "3.1";

// uploader de emblema
$ipftpemblema = "54.39.38.163";
$userftpemblema = "admin_emblema";
$senhaftpemblema = "TdC4JJE3dG";
$caminhoftpemblema = "./";
// uploader swf
$ipftpswf = "54.39.38.163";
$userftpswf = "admin_swf";
$userftpswfnotif = "admin_notif";
$senhaftpswf = "m9qTz6dmA3";
$caminhoftpswf = "./";
// atualizar vista
$ipftpvista = "54.39.38.163";
$userftpvista = "admin_vista";
$senhaftpvista = "m9qTz6dmA3";
$caminhoftpvista = "./";

// dados admin VestaCP
$uservestacp = "admin";
$passvestacp = "H8KTOguzcm@@";
$vst_hostname = "http://192.99.199.14:8083/api/";

// Ip que é inserido na client para conexão do emulador
$ipemuclient = "ip.galaxyservers.com.br";

// Configurações SMTP para envio de email
$hostemail = "smtp.hostinger.com.br";
$portaemail = 587;
$useremail = "galaxypanel@galaxyservers.com.br";
$emailemail = $useremail;
$senhaemail = "Kekti0vmser9";


// Alertas de admin no discord!
$discord_alerts = true;
$nome_bot = "GalaxyPanel";
$identifica_discord = 1;
$discord_wh = "https://discordapp.com/api/webhooks/629165361173889025/3oEHMUz5u0D96zFGJPH4KE9gCAy9Lqfv3YeBqB1CUxRDqPWga6CjgYzipDwXThBVLVo5";

### configurações do logo do painel
$logo_login = "https://i.imgur.com/Nsj0OlX.png";
$style_login = "style='width: 50%;'";

$logo_resto = "https://i.imgur.com/Nsj0OlX.png";
$style_resto = "style=\"padding-left: 14px;width: 48%;margin-left: -25%;\"";

## Links SWF
$cimagesswf = "https://swf.galaxyservers.com.br/c_images/";
$linkapiemblema = "https://swf.galaxyservers.com.br/emblema.php?cod=";
$linkswf_api = "http://swf.galaxyservers.com.br";
$linkswf = "swf.galaxyservers.com.br"; /// Link da swf que será inserido.

### discord login
$token_bot = "NjQyODk3ODUzNjUxNDg0Njkx.XcdtCg.CfTYCA0ELTp56LIwUCJjl9Ej93w";
define('OAUTH2_CLIENT_ID', '642897853651484691');
define('OAUTH2_CLIENT_SECRET', '1iMtKTDQTLHpYz1C_u0hdy5sOCzVhcW3');
?>
<?php
$con_id = ftp_connect("54.39.38.163") or die("Não conectou no servidor FTP.");
ftp_login( $con_id, "admin_swf", "m9qTz6dmA3" );
ftp_pasv($con_id, true) or die("Não foi possível entrar no modo passivo."); 
if ( @ftp_put( $con_id, "./"."habbcand".".swf", "C:\/xampp\htdocs\galaxyservers\CompilaHabboSwf\Habbo.swf", FTP_BINARY)) 
{
echo "SWF upada com sucesso";
} else {
echo "Erro ao enviar swf.";
}

?>
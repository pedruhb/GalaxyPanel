<?php
### Inclui os arquivos com as configurações no código
define('GALAXYSERVERS', 1);	
include "galaxyservers/config.php";

### Inicia uma conexão MySQL 
$PDO = new PDO( 'mysql:host=' .$hostname. ';dbname=' . $database, $username, $password);

### Verifica se a key está vazia
$apikey = "";

if(isset($_POST['apikey']))
$apikey = $_POST['apikey'];

if(empty($apikey)){
	exit("API key em branco.");
}

### Verifica se a key é válida
$VerificaKey = $PDO->prepare("SELECT id FROM servidores WHERE apikey = :apikey");
$VerificaKey->bindParam(':apikey', $apikey);
$VerificaKey->execute();
if($VerificaKey->rowCount() == 0){
	exit("Key inválida (".$apikey.").");
}

else if($VerificaKey->rowCount() == 1){

### Pega dados do servidor no painel
	$servidor = $PDO->prepare("SELECT * FROM servidores WHERE apikey = :apikey");
	$servidor->bindParam(':apikey', $apikey);
	$servidor->execute();
	$server = $servidor->fetch();

### Declaração de variáveis que vão ser utilizadas
	function limpacodigo($cod){
		$what = array( 'ä','ã','à','á','â','ê','ë','è','é','ï','ì','í','ö','õ','ò','ó','ô','ü','ù','ú','û','À','Á','É','Í','Ó','Ú','ñ','Ñ','ç','Ç',' ','-','(',')',',',';',':','|','!','"','#','$','%','&','/','=','?','~','^','>','<','ª','º','*' );
		$by   = array( 'a','a','a','a','a','e','e','e','e','i','i','i','o','o','o','o','o','u','u','u','u','A','A','E','I','O','U','n','n','c','C','','','','','','','','','','','','','','','','','','','','','','','' ,'');
		return str_replace($what, $by, $cod);
	}
$cod = limpacodigo(strtoupper($server['id'].$_POST['cod'])); /// Gera o código do emblema$nome = $_POST['nome']; /// Nome do emblema
$nome = $_POST['nome']; /// Nome do emblema
$desc = $_POST['desc']; /// Descrição do emblema
$arquivo = $_FILES['arquivo']; /// Arquivo .gif do emblema
$nome_arquivo = $_POST['filename']; /// Nome real do arquivo
$tamanho_arquivo = $arquivo['size']; /// Tamanho do arquivo
$arquivo_temp = $_FILES['arquivo']['tmp_name']; /// Nome temporário do arquivo
$extensao_arquivo = strrchr($nome_arquivo,'.'); /// Pega extensão do arquivo
$destino =  "./".$cod.".gif"; /// Destino do arquivo no servidor
$extensoes_autorizadas = array('.gif'); /// Extensões autorizadas para upload

### Verifica se a extensão está autorizada
if (!empty($extensoes_autorizadas) && !in_array($extensao_arquivo,$extensoes_autorizadas)){
	exit('Tipo de arquivo não permitido.');
}

if(strlen($_POST['cod']) > 10)
exit('O código deve ter no máximo 10 caracteres.');

if(strlen($_POST['cod']) < 2)
exit('O código deve ter no mínimo 2 caracteres.');

### Verifica se tem outro emblema hospedado com o código inserido
$VerificaHospedados = $PDO->prepare("SELECT id FROM emblemas WHERE codigo = :cod");
$VerificaHospedados->bindParam(':cod', $cod);
$VerificaHospedados->execute();
if($VerificaHospedados->rowCount() >= 1){
	exit('Já existe um emblema hospedado com esse código. Código: '.$cod); 
} 

### Envia via FTP
$con_id = ftp_connect($ipftpemblema) or die( 'Não conectou em: '.$ipftpemblema.'"');
ftp_login($con_id, $userftpemblema, $senhaftpemblema );
ftp_pasv($con_id, true) or die('Não foi possível entrar no modo passivo.'); 
if(@ftp_put($con_id, $destino, $arquivo_temp, FTP_BINARY  ) ) {
	echo "Emblema hospedado com sucesso! Código: ".$cod;

### Adiciona log
	if(!empty($_SERVER["REMOTE_ADDR"]))$meuip=$_SERVER["REMOTE_ADDR"];
	else if(!empty($_SERVER["HTTP_CF_CONNECTING_IP"]))$meuip=$_SERVER["HTTP_CF_CONNECTING_IP"];
	else $meuip = "IP desconhecido";

	$adicionalog = $PDO->prepare("INSERT INTO `log_servidores` (`log`, `autor`, `ip`, `data`) VALUES ('Hospedou um emblema através da API (".addslashes($cod).").', '".$server['nomeusuario']."', '".$meuip."', '".time()."');");
	$adicionalog->execute();

### Adiciona na tabela badge_definitions na db do hotel
	$requi = "";
	$nome22 = utf8_encode($nome);
	$dbh = new PDO( 'mysql:host=' .$iphospedagem. ';dbname=' . $server['uservestacp']."_hotel", $server['uservestacp']."_hotel", $server['senhavestacp']);
	$getMessageUser = $dbh->prepare("INSERT INTO badge_definitions VALUES (:codigo, :requi, :nome)");
	$getMessageUser->bindParam(':codigo', $cod);
	$getMessageUser->bindParam(':requi', $requi);
	$getMessageUser->bindParam(':nome', $nome22);
	$getMessageUser->execute();

### Adiciona na tabela de emblemas do painel, dando nome e descrição
	$stmt = $PDO->prepare('INSERT INTO `emblemas` (`codigo`, `nome`, `descricao`, `usuario`, `timestamp`) VALUES (:cod, :nome, :descr, :usuario, "'.time().'");');
	$stmt->bindParam(':cod', $cod);
	$stmt->bindParam(':nome', $nome);
	$stmt->bindParam(':descr', $desc);
	$stmt->bindParam(':usuario', $server['nomeusuario']);
	$stmt->execute();

### Atualiza as definições de emblemas no emulador
	function AtualizaEmblemasRCON($command, $data, $ipemu, $portamus){
		$rconData = $command . chr(1) .$data;
		$rcon = socket_create(AF_INET, SOCK_STREAM, getprotobyname('tcp'));
		socket_connect($rcon, $ipemu, $portamus);
		socket_send($rcon, $rconData, strlen($rconData), MSG_DONTROUTE);
		socket_close($rcon);
	}
	AtualizaEmblemasRCON('reloadbadges','', $ipvps, $server['portamus']);
} else {
	exit("Erro ao hospedar emblema. ".var_dump($arquivo));
}
ftp_close($con_id); /// Fecha a conexão FTP

}
else {
	exit("Key duplicada.");
}
?>
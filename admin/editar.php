<?php include "../galaxyservers/global.php";
if(empty($_SESSION['useradmin'])){
	echo '<script>location.href="../index";</script>';
}
if (!empty($_SESSION['useradmin'])){

	include "nav.php";
	?>
	<div class="pcoded-content">
		<div class="pcoded-inner-content">
			<div class="main-body">
				<div class="page-wrapper">
					<div class="page-body">
						<div class="">
							<div class="card">
								<div class="card-header">
									<h5>Editar Habbo </h5>
									<span>Aqui você poderá mudar os dados do hotel, no caso de mudança de senha a mesma deve ser mudada na CMS também.</span>
									<div class="card-header-right"><center><form method="POST"><button onclick="return confirm('Tem certeza que deseja excluir esse hotel? não tem como voltar atrás depois.')" name="apagarhp" type="submit" class="btn btn-primary btn-square">Apagar Hotel</button></form></center>
									</div>
									<div class="card-header-right">
<i class="icofont icofont-spinner-alt-5"></i>
									</div>
								</div>
								<div class="card-block">
									<?php
									if (isset($_POST['apagarhp']))
									{
$pegadados1 = $PDO->prepare("SELECT uservestacp,portamus,ativo FROM servidores WHERE id = :id");
$pegadados1->bindParam(':id', $_GET['user']);
$pegadados1->execute();
$dados1 = $pegadados1->fetch();

if(empty($dados1['uservestacp']))
	die('Erro');

$pegadados = $PDO->prepare("DELETE FROM servidores WHERE id = :id");
$pegadados->bindParam(':id', $_GET['user']);
$pegadados->execute();

$pegadados = $PDO->prepare("DELETE FROM log_servidores WHERE autor = :usuario");
$pegadados->bindParam(':usuario', $dados1['uservestacp']);
$pegadados->execute();

$pegadados = $PDO->prepare("DELETE FROM config_servidores WHERE servidor = :id");
$pegadados->bindParam(':id', $_GET['user']);
$pegadados->execute();

$pegadados = $PDO->prepare("DELETE FROM emblemas WHERE usuario = :usuario");
$pegadados->bindParam(':usuario', $dados1['uservestacp']);
$pegadados->execute();

$ApagaSubcontas = $PDO->prepare("SELECT * FROM sub_contas WHERE servidor = :user");
$ApagaSubcontas->bindParam(':user', $_GET['user']);
$ApagaSubcontas->execute();
while($subconta = $ApagaSubcontas->fetch()){
	$ApagaConfig = $PDO->prepare("DELETE FROM sub_contas_perm WHERE id = :id");
	$ApagaConfig->bindParam(':id', $subconta['id']);
	$ApagaConfig->execute();
}
$ApagaConfig = $PDO->prepare("DELETE FROM sub_contas WHERE servidor = :user");
$ApagaConfig->bindParam(':user', $_GET['user']);
$ApagaConfig->execute();

$ApagaConfig = $PDO->prepare("DELETE FROM atualizacoes_servidores WHERE servidor = :user");
$ApagaConfig->bindParam(':user', $_GET['user']);
$ApagaConfig->execute();


echo '<!--';sendRCONCommand('desligaremulador', '', $ipvps, $dados1['portamus']);echo '-->';
if($dados1['ativo'] == 'N'){
### API VESTA CP									
	$postvars = array(
		'user' => $uservestacp,
		'password' => $passvestacp,
		'returncode' => 'yes',
		'cmd' => 'v-unsuspend-user',
		'arg1' => $dados1['uservestacp']
	);
	$postdata = http_build_query($postvars);

        // Unsusupend user account
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $vst_hostname);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($curl, CURLOPT_POST, true);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata);
	$answer = curl_exec($curl);
        #################
}

### API VESTA CP							
$postvars = array(
	'user' => $uservestacp,
	'password' => $passvestacp,
	'returncode' => 'yes',
	'cmd' => 'v-delete-user',
	'arg1' => $dados1['uservestacp'],
);
$postdata = http_build_query($postvars);

// Alter Password USER
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $vst_hostname);
curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata);
$answer = curl_exec($curl);
 //  echo $answer;
#################  
if($answer == "OK")
	echo '<div class="alert alert-success background-success">
<strong>Sucesso!</strong> O hotel foi apagado
</div>';
else if($answer != "OK"){

	if($answer == "0")
		echo '<div class="alert alert-success background-success">
	<strong>Sucesso!</strong> O hotel foi apagado
	</div>';
	else
		echo '<div class="alert alert-success background-success">
	<strong>Sucesso!</strong> O hotel foi apagado, porém com alguns erros... ("'.$answer .'")
	</div>';
}
sleep(5);
function delTree($dir) { 
	$files = array_diff(scandir($dir), array('.','..')); 
	foreach ($files as $file) { 
		(is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file"); 
	} 
	return rmdir($dir); 
}

delTree('../galaxyservers/emuladores/'.$dados1['uservestacp'].'/');


addlog_admin($_SESSION['useradmin'], "Apagou o hotel: ".$dados1['uservestacp']);

									}

									if(isset($_POST['salvaralteracoes'])){

$uservestacp2 = $uservestacp;
$passvestacp2 = $passvestacp;
#### Declaração de var.
$id = $_GET['user'];
$nomehotel = $_POST['nomehotel'];
$senhavestacp = $_POST['senhavestacp'];
$uservestacp = $_POST['uservestacp'];
$http = $_POST['http'];
$emailcliente = $_POST['emailcliente'];
$plano = $_POST['pacote'];

### Altera na DB
$salvaalteracoes = $PDO->prepare("UPDATE `servidores` SET `nomehotel`= :nomehotel, `senhavestacp`= :senhavestacp, `emailcliente`= :emailcliente, `http`= :http, `apikey`='".md5($uservestacp."galaxyservers".$senhavestacp)."', plano = :plano WHERE  `id`= :id");
$salvaalteracoes->bindParam(':id',$id);
$salvaalteracoes->bindParam(':http',$http);
$salvaalteracoes->bindParam(':emailcliente',$emailcliente);
$salvaalteracoes->bindParam(':senhavestacp',$senhavestacp);
$salvaalteracoes->bindParam(':nomehotel',$nomehotel);
$salvaalteracoes->bindParam(':plano',$plano);
$salvaalteracoes->execute();

### Gera novo config.ini e extras.ini com as informações atualizadas
$PegaEstadoAtual = $PDO->prepare("SELECT * FROM config_servidores WHERE servidor = :id");
$PegaEstadoAtual->bindParam(':id', $_GET['user']);
$PegaEstadoAtual->execute();
$EstadoAtual = $PegaEstadoAtual->fetch();
$pegadados = $PDO->prepare("SELECT * FROM servidores WHERE id = :id");
$pegadados->bindParam(':id', $_GET['user']);
$pegadados->execute();
$server = $pegadados->fetch();

$ExtrasConfig = "## Nome dos pontos (GOTW)
coin.points.name=".utf8_decode($EstadoAtual['nomegotw'])."
### Nome moedas
coin.credits.name=".utf8_decode($EstadoAtual['nomemoedas'])."
### Nome duckets
coin.duckets.name=".utf8_decode($EstadoAtual['nomeduckets'])."
### Nome diamantes
coin.diamonds.name=".utf8_decode($EstadoAtual['nomediamantes'])."

## Staffs
staff.effect.inroom=false
staff.mensg.inroom=false

## Camera (cuidado ao mecher nos links)
camera.enable=true
camera.api.http=".$server['http']."://".str_replace("http://", "", str_replace("https://", "",$server['linkhotel']))."/camera/
camera.output.pictures=".$server['http']."://".str_replace("http://", "", str_replace("https://", "",$server['linkhotel']))."/camera/pictures/
camera.picture.purchase.alert.id=false
camera.photo.publish.price.duckets=10
camera.photo.purchase.item_id=1100001495
camera.photo.purchase.price.coins=00
camera.photo.purchase.price.duckets=10
camera.preview.maxcache=1000

## Rank mínimo para ter acesso a ferramente de embaixador
ambassador.minrank=".$EstadoAtual['rankminimoferramentaemb']."

## Emblema staff sobre a cabeça
emblemacabeca.staff=".$EstadoAtual['emblemacabecastaff']."
emblemacabeca.embaixador=".$EstadoAtual['emblemacabecaemb']."

## Configuração dos Quartos
Quartovip=".$EstadoAtual['quartovip']."
Prisao=".$EstadoAtual['quartoprisao']."

## Premio por atividade
PremioPorAtividade=".$EstadoAtual['premioporatividade']."
MensagemAoReceber=true
Moedas=0
Duckets=0
Diamantes=0
Intervalo=".$EstadoAtual['tempoon']."

# Vip 1
Moedasvip=200
Ducketsvip=200
Diamantesvip=0
# Vip 2 
Moedassvip=300
Ducketssvip=300
Diamantessvip=0

# Comando Premiar
Moedaspremiar=0
Ducketspremiar=0
Diamantespremiar=0
Gotwpremiar=0
NiveltotalGames=".$EstadoAtual['nivelmax']."
CodEmblemaNivel=".$EstadoAtual['emblemapremiar']."

### Nick de quem pode usar o comando reiniciar
ReiniciarPermissao=".$EstadoAtual['reiniciargalaxy']."

## Rank que vai aparecer balão embaixador
RankEmbaixador=".$EstadoAtual['rankbalaoemb']."

### Premiação diária
PremiacaoDiaria=".$EstadoAtual['premiodiario']."
MoedasDiaria=0
DucketsDiario=0
DiamantesDiario=0
GotwDiario=0
";

$PrincipalConfig = "### Arquivo de configuração do Galaxy Server!
### Emulador programado por PHB.

## Configuração MYSQL
db.hostname=".$iphospedagem."
db.port=3306
db.username=".$server['uservestacp']."_hotel
db.password=".$server['senhavestacp']."
db.name=".$server['uservestacp']."_hotel

## MySQL pooling setup (controla a quantidade de conexões)
db.pool.minsize=10
db.pool.maxsize=250

## Game TCP/IP Configuração
game.tcp.bindip=".$ipvps."
game.tcp.port=".$server['portatcp']."
game.tcp.conlimit=100000
game.tcp.conperip=3
game.tcp.enablenagles=true

## MUS TCP/IP Configuração
mus.tcp.bindip=".$ipvps."
mus.tcp.port=".$server['portamus']."
mus.tcp.allowedaddr=".$ipvps."

## Client Configuração
client.ping.enabled=1
client.ping.interval=3
client.maxrequests=300

## Configuração do Nome do seu hotel
hotel.name=".$server['nomehotel']."
license=".$server['nomehotel']." Hotel
game.legacy.figure_mutant=1

# Rank Mánimo de Staff
MineRankStaff=7

## Hall da Fama na client (0 = não / 1 = sim)
halldafama=0

## Tipo (1 = gotw/ 2 =diamantes/ 3 = duckets/ 4 =moedas)
tipohall=2";

$CaminhoExtras = "../galaxyservers/emuladores/".$server['uservestacp']."/Config/extras.ini";
$CaminhoConfig = "../galaxyservers/emuladores/".$server['uservestacp']."/Config/config.ini";

$fp = fopen($CaminhoExtras, "w");
$escreve = fwrite($fp, $ExtrasConfig);
fclose($fp);

$fp = fopen($CaminhoConfig, "w");
$escreve = fwrite($fp, $PrincipalConfig);
fclose($fp);

echo '<div class="alert alert-info background-info">
<strong>Sucesso!</strong> Alterações salvas.</code>
</div>'; 

addlog_admin($_SESSION['useradmin'], "Editou o hotel: ".$_POST['uservestacp']);					



		### API VESTA CP									
$postvars = array(
	'user' => $uservestacp2,
	'password' => $passvestacp2,
	'returncode' => 'yes',
	'cmd' => 'v-change-database-password',
	'arg1' => $server['uservestacp'],
	'arg2' => $server['uservestacp'].'_hotel',
	'arg3' => $server['senhavestacp']
);
$postdata = http_build_query($postvars);

        // Alter Password Database MYSQL
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $vst_hostname);
curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata);
$answer = curl_exec($curl);
    //    echo $answer;
        #################

		### API VESTA CP									
$postvars = array(
	'user' => $uservestacp2,
	'password' => $passvestacp2,
	'returncode' => 'yes',
	'cmd' => 'v-change-user-password',
	'arg1' => $server['uservestacp'],
	'arg2' => $server['senhavestacp']
);
$postdata = http_build_query($postvars);

        // Alter Password USER
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $vst_hostname);
curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata);
$answer = curl_exec($curl);
      //  echo $answer;
        #################        

		## altera pacote do hotel
$pegadados = $PDO->prepare("SELECT vesta_package FROM planos WHERE id = :id");
$pegadados->bindParam(':id', $server['plano']);
$pegadados->execute();
$espacohp = $pegadados->fetch()['vesta_package'];
if($espacohp != $_POST['pacote']){
			### API VESTA CP									
	$postvars = array(
		'user' => $uservestacp2,
		'password' => $passvestacp2,
		'returncode' => 'yes',
		'cmd' => 'v-change-user-package',
		'arg1' => $server['uservestacp'],
		'arg2' => $espacohp
	);
	$postdata = http_build_query($postvars);
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $vst_hostname);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($curl, CURLOPT_POST, true);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata);
	$answer = curl_exec($curl);
	if($answer == 'OK' || $answer == 0){
	} else loginerror("Erro ao mudar pacote do hotel!");
}

									}
									$pegadados = $PDO->prepare("SELECT * FROM servidores WHERE id = :id");
									$pegadados->bindParam(':id', $_GET['user']);
									$pegadados->execute();
									$dados = $pegadados->fetch();
									
									if(!isset($dados['nomehotel'])){
loginerror("Conta não encontrada.");
									}else{
?>
<form method="POST">
	<div class="form-group row">
		<label class="col-sm-2 col-form-label">Nome do Hotel</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" name="nomehotel" value="<?= $dados['nomehotel'];?>" placeholder="Somente primeiro nome! exemplo: Space" required>
			<input type="hidden" class="form-control" name="uservestacp" value="<?= $dados['uservestacp'];?>" required>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-2 col-form-label">Usuario</label>
		<div class="col-sm-10">
			<input type="text" id="user" class="form-control"  value="<?= $dados['uservestacp'];?>" disabled>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-2 col-form-label">API Key</label>
		<div class="col-sm-10">
			<input type="text" id="user" class="form-control" value="<?= $dados['apikey'];?>" disabled>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-2 col-form-label">Senha</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" name="senhavestacp"  value="<?= $dados['senhavestacp'];?>" placeholder="spacehp123passvesta2018" required>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-2 col-form-label">HTTP/HTTPS</label>
		<div class="col-sm-10">
			<select class="form-control" name="http">
				<option <?php if($dados['http'] == "http")echo'selected';?> value="http">http://</option>
				<option <?php if($dados['http'] == "https")echo'selected';?> value="https">https://</option>
			</select>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-2 col-form-label">Plano</label>
		<div class="col-sm-10">
			<select class="form-control" name="pacote">				
				<?php
				$getArtdicles = $PDO->prepare("SELECT id,plano FROM planos ORDER BY id");
				$getArtdicles->execute();
				while($dnews = $getArtdicles->fetch())
				{
					?>
					<option <?php if($dados['plano'] == $dnews['id'])echo'selected';?> value="<?php echo $dnews['id']?>"><?php echo utf8_encode($dnews['plano'])?> (<?php echo utf8_encode($dnews['id'])?>)</option>
				<?php } ?>
			</select>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-2 col-form-label">Email</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" name="emailcliente" value="<?= $dados['emailcliente'];?>" placeholder="Email do cliente" required>
		</div>
	</div>
	<center><button name="salvaralteracoes" type="submit" class="btn btn-primary btn-square">Salvar Alterações</button><br><a href="/admin/acessarcomouser/<?= $dados['uservestacp'];?>">Painel de usuário</a></center>
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
<?php }?>
<script type="text/javascript" src="<?php echo $dominio;?>/galaxyservers/bower_components/jquery/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo $dominio;?>/galaxyservers/bower_components/jquery-ui/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php echo $dominio;?>/galaxyservers/bower_components/popper.js/js/popper.min.js"></script>
<script type="text/javascript" src="<?php echo $dominio;?>/galaxyservers/bower_components/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo $dominio;?>/galaxyservers/bower_components/jquery-slimscroll/js/jquery.slimscroll.js"></script>
<script type="text/javascript" src="<?php echo $dominio;?>/galaxyservers/bower_components/modernizr/js/modernizr.js"></script>
<script src="<?php echo $dominio;?>/galaxyservers/assets/pages/widget/amchart/amcharts.min.js"></script>
<script src="<?php echo $dominio;?>/galaxyservers/assets/pages/widget/amchart/serial.min.js"></script>
<script type="text/javascript" src="<?php echo $dominio;?>/galaxyservers/bower_components/chart.js/js/Chart.js"></script>
<script type="text/javascript" src="<?php echo $dominio;?>/galaxyservers/assets/pages/todo/todo.js"></script>
<script type="text/javascript" src="<?php echo $dominio;?>/galaxyservers/assets/js/script.js"></script>
<script type="text/javascript" src="<?php echo $dominio;?>/galaxyservers/assets/js/bootstrap-growl.min.js"></script>
<script type="text/javascript" src="<?php echo $dominio;?>/galaxyservers/bower_components/i18next/js/i18next.min.js"></script>
<script type="text/javascript" src="<?php echo $dominio;?>/galaxyservers/bower_components/i18next-xhr-backend/js/i18nextXHRBackend.min.js"></script>
<script type="text/javascript" src="<?php echo $dominio;?>/galaxyservers/bower_components/i18next-browser-languagedetector/js/i18nextBrowserLanguageDetector.min.js"></script>
<script type="text/javascript" src="<?php echo $dominio;?>/galaxyservers/bower_components/jquery-i18next/js/jquery-i18next.min.js"></script>
<script type="text/javascript" src="<?php echo $dominio;?>/galaxyservers/assets/pages/notification/notification.js"></script>
<script type="text/javascript" src="<?php echo $dominio;?>/galaxyservers/assets/pages/dashboard/custom-dashboard.min.js"></script>
<script type="text/javascript" src="<?php echo $dominio;?>/galaxyservers/assets/js/SmoothScroll.js"></script>
<script src="<?php echo $dominio;?>/galaxyservers/assets/js/pcoded.min.js"></script>
<script src="<?php echo $dominio;?>/galaxyservers/assets/js/demo-12.js"></script>
<script src="<?php echo $dominio;?>/galaxyservers/assets/js/jquery.mCustomScrollbar.concat.min.js"></script>
<script type="text/javascript" src="<?php echo $dominio;?>/galaxyservers/assets/js/script.min.js"></script>
<script type="text/javascript">
	funcaoJavascript = function(){
		var a = document.getElementById('user');
		var b = document.getElementById('db');
		if(a.value == "")
			b.value = a.value;
		else 
			b.value = a.value+"_hotel";
	}
</script>
</body>
</html>
<?php }?>
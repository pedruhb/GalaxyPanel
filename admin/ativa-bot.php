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
									Ativar bot discord
									<span></span>									
									<div class="card-header-right">
										<i class="icofont icofont-spinner-alt-5"></i>
									</div>
								</div>
								<div class="card-block">		
									<?php
									if(isset($_POST['ativa'])){

                   $SelecionaHotel = $PDO->prepare("SELECT * FROM servidores WHERE id = :id");
                   $SelecionaHotel->bindParam(':id', $_POST['hotel_id']);
                   $SelecionaHotel->execute();
                   $hotel = $SelecionaHotel->fetch();

                   function copiaDir($dirFont, $dirDest){

                    if(!file_exists($dirDest)){
                      mkdir($dirDest);
                    }
                    if ($dd = opendir($dirFont)) {
                      while (false !== ($arq = readdir($dd))) {
                        if($arq != "." && $arq != ".."){
                          $pathIn = "$dirFont/$arq";
                          $pathOut = "$dirDest/$arq";
                          if(is_dir($pathIn)){
                           copiaDir($pathIn, $pathOut);
                         }elseif(is_file($pathIn)){
                          copy($pathIn, $pathOut);
                        }
                      }
                    }
                    closedir($dd);
                  }
                }

                   $pasta = "../galaxyservers/emuladores/sourcebot/"; //Pasta source
                   $pastad = "../galaxyservers/emuladores/".$hotel['uservestacp']."/bot_discord/"; //pasta destino
                   $path_completo = "c:/xampp/htdocs/galaxyservers/emuladores/".$hotel['uservestacp']."/bot_discord/";
                   
                   copiaDir($pasta, $pastad);

                   $configuracao = '{ 
                    "token"  : "SEU TOKEN AQUI",
                    "prefix" : ";",
                    "nomehotel" : "'.$hotel['nomehotel'].'",
                    "linkhotel_news" : "'.$hotel['http'].'://'.$hotel['linkhotel'].'/news",
                    "linkhotel" : "'.$hotel['linkhotel'].'",

                    "mensagensentradaesaida" : "desativado",
                    "idcanalbemvindos" : "0",
                    "idcanaladeus" : "0",

                    "verificacao" : "desativado", 
                    "idcanalverificacao" : "0",
                    "nomecargoverificados" : "NOME DO CARGO DE VERIFICADOS AQUI",

                    "hostmysql" : "'.$iphospedagem.'",
                    "usermysql" : "'.$hotel['uservestacp'].'_hotel",
                    "dbmysql" : "'.$hotel['uservestacp'].'_hotel",
                    "passmysql" : "'.$hotel['senhavestacp'].'",

                    "versao" : "1.0",
                    "icone_embed" : "https://i.imgur.com/6Z848W8.png",
                    "linkdiscord" : "LINK DE CONVITE DO SERVIDOR",
                    "corembed" : "7419530",

                    "status_canal" : "desligado",
                    "canal_usersregistrados" : "0",
                    "canal_userson" : "0",
                    "canal_userNoServidor" : "0",

                    "imagem_ship": "https://i.imgur.com/ZWTnaX6.jpg",
                    "proibirlinks": "ativado"

                  }';
                  $fp = fopen($pastad."config.json", "w");
                  $escreve = fwrite($fp, $configuracao);
                  fclose($fp);

                  $desligar = 'cd '.$path_completo.' && forever stop index.js';
                  $fp = fopen($pastad."desligar.bat", "w");
                  $escreve = fwrite($fp, $desligar);
                  fclose($fp);

                  $ligar = "title ".$hotel['uservestacp']." BOT
                  cd ".$path_completo." && forever index.js";
                  $fp = fopen($pastad."ligar.bat", "w");
                  $escreve = fwrite($fp, $ligar);
                  fclose($fp);

                  $ligar = "title ".$hotel['uservestacp']." BOT
                  cd ".$path_completo." && start ligabot.exe";
                  $fp = fopen($pastad."iniciar.bat", "w");
                  $escreve = fwrite($fp, $ligar);
                  fclose($fp);

                  loginsucess("Bot ativo!");

                  addlog_admin($_SESSION['useradmin'], "Ativou o bot para discord do hotel \"".$hotel['uservestacp']."\".");

                  $attStatus = $PDO->prepare("UPDATE servidores SET botdiscord = 'desligado' WHERE id = '".$hotel['id']."';");
                  $attStatus->execute();

                }

                ?>						
                <form method="POST">
                  <div class="form-group row">
                   <label class="col-sm-2 col-form-label">Hotel</label>
                   <div class="col-sm-10">										
                    <select class="form-control" name="hotel_id">
                     <?php


                     $pegadados = $PDO->prepare("SELECT * FROM servidores WHERE ativo = 'Y' and botdiscord = 'desativado';");
                     $pegadados->execute();
                     while($dados = $pegadados->fetch()){
                      ?>
                      <option value="<?= $dados['id'];?>"><?= $dados['uservestacp'];?> | <?= $dados['nomehotel'];?> | <?= $dados['linkhotel'];?> | Plano <?= $dados['plano'];?></option>
                    <?php }?>
                  </select>
                </div>
              </div>							
              <center><button name="ativa" type="submit" class="btn btn-primary btn-square">Ativar</button></center>
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
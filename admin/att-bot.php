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
									Atualizar bot discord
									<span></span>									
									<div class="card-header-right">
										<i class="icofont icofont-spinner-alt-5"></i>
									</div>
								</div>
								<div class="card-block">		
									<?php
									if(isset($_POST['ativa'])){
                    set_time_limit(0);


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

                  $SelecionaHotel = $PDO->prepare("SELECT * FROM servidores WHERE botdiscord not like 'desativado'");
                  $SelecionaHotel->execute();
                  while($hotel = $SelecionaHotel->fetch()){

                   popen("C:/xampp/htdocs/galaxyservers/emuladores/".$hotel['uservestacp']."/bot_discord/desligar.bat", "r"); // desliga o bot
                   sleep(2); // espera 2 segundos

                   $pasta = "../galaxyservers/emuladores/sourcebot/"; //Pasta source
                   $pastad = "../galaxyservers/emuladores/".$hotel['uservestacp']."/bot_discord/"; //pasta destino
                   $path_completo = "c:/xampp/htdocs/galaxyservers/emuladores/".$hotel['uservestacp']."/bot_discord/";

                   copiaDir($pasta, $pastad); // copia codigo novo pra pasta do hotel
                   popen("C:/xampp/htdocs/galaxyservers/emuladores/".$hotel['uservestacp']."/bot_discord/iniciar.bat", "r"); /// liga o bot
                   $attStatus = $PDO->prepare("UPDATE servidores SET botdiscord = 'ligado' WHERE id = '".$hotel['id']."';");
                   $attStatus->execute();

                 }

                 loginsucess("Bots atualizados!");
                 addlog_admin($_SESSION['useradmin'], "Atualizou os bots do discord.");

               }

               ?>						
               <form method="POST">					
                <center><button name="ativa" type="submit" class="btn btn-primary btn-square">Atualizar</button></center>
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
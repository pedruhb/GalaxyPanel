<?php
include "galaxyservers/global.php";
if(!empty($_SESSION['nomeusuario'])){

	$infoserver = $PDO->prepare("SELECT * FROM servidores WHERE nomeusuario = '".$_SESSION['nomeusuario']."'");
	$infoserver->execute();
	$server = $infoserver->fetch();
	$_SESSION['senhaatualdb'] = $server['senhavestacp'];

	?>
    <?php 
    include 'galaxyservers/nav.php';
    if($planoi['add_jukebox'] == "false"){
        if (headers_sent()) {
            die("<script>window.location.href=/index</script>");
        }
        else{
            exit(header("Location: /index"));
        }
        return;
    }
    ?>
    <div class="pcoded-content">
      <div class="pcoded-inner-content">
       <div class="main-body user-profile">
        <div class="page-wrapper">
         <div class="page-body">
          <div class="card">
            <div class="card-header">
                <h5 class="card-header-text">Hospedar música na jukebox</h5>
                <span>Você deve criar uma página no catálogo com o layout "soundmachine" para que apareça na seleção.</span>
            </div>
            <div class="card-block">
               <form method="POST" enctype="multipart/form-data">	
                  <?php
                  if(!permissao("jukebox")){
                    echo '<div style="display: contents;">
                    <div class="col-md-12">
                    <center><div class="alert alert-danger background-danger" style="width: 30%;">
                    <strong>Erro!</strong> Sua subconta não tem permissão para acessar essa página.
                    </div></center>
                    </div>
                    </div>';
                } else {

                  class MP3File
                  {
                     protected $filename;
                     public function __construct($filename)
                     {
                        $this->filename = $filename;
                    }

    public static function formatTime($duration) //as hh:mm:ss
    {
        //return sprintf("%d:%02d", $duration/60, $duration%60);
    	$hours = floor($duration / 3600);
    	$minutes = floor( ($duration - ($hours * 3600)) / 60);
    	$seconds = $duration - ($hours * 3600) - ($minutes * 60);
    	return sprintf("%02d:%02d:%02d", $hours, $minutes, $seconds);
    }

    //Read first mp3 frame only...  use for CBR constant bit rate MP3s
    public function getDurationEstimate()
    {
    	return $this->getDuration($use_cbr_estimate=true);
    }

    //Read entire file, frame by frame... ie: Variable Bit Rate (VBR)
    public function getDuration($use_cbr_estimate=false)
    {
    	$fd = fopen($this->filename, "rb");

    	$duration=0;
    	$block = fread($fd, 100);
    	$offset = $this->skipID3v2Tag($block);
    	fseek($fd, $offset, SEEK_SET);
    	while (!feof($fd))
    	{
    		$block = fread($fd, 10);
    		if (strlen($block)<10) { break; }
            //looking for 1111 1111 111 (frame synchronization bits)
    		else if ($block[0]=="\xff" && (ord($block[1])&0xe0) )
    		{
    			$info = self::parseFrameHeader(substr($block, 0, 4));
                if (empty($info['Framesize'])) { return $duration; } //some corrupt mp3 files
                fseek($fd, $info['Framesize']-10, SEEK_CUR);
                $duration += ( $info['Samples'] / $info['Sampling Rate'] );
            }
            else if (substr($block, 0, 3)=='TAG')
            {
                fseek($fd, 128-10, SEEK_CUR);//skip over id3v1 tag size
            }
            else
            {
            	fseek($fd, -9, SEEK_CUR);
            }
            if ($use_cbr_estimate && !empty($info))
            { 
            	return $this->estimateDuration($info['Bitrate'],$offset); 
            }
        }
        return round($duration);
    }

    private function estimateDuration($bitrate,$offset)
    {
    	$kbps = ($bitrate*1000)/8;
    	$datasize = filesize($this->filename) - $offset;
    	return round($datasize / $kbps);
    }

    private function skipID3v2Tag(&$block)
    {
    	if (substr($block, 0,3)=="ID3")
    	{
    		$id3v2_major_version = ord($block[3]);
    		$id3v2_minor_version = ord($block[4]);
    		$id3v2_flags = ord($block[5]);
    		$flag_unsynchronisation  = $id3v2_flags & 0x80 ? 1 : 0;
    		$flag_extended_header    = $id3v2_flags & 0x40 ? 1 : 0;
    		$flag_experimental_ind   = $id3v2_flags & 0x20 ? 1 : 0;
    		$flag_footer_present     = $id3v2_flags & 0x10 ? 1 : 0;
    		$z0 = ord($block[6]);
    		$z1 = ord($block[7]);
    		$z2 = ord($block[8]);
    		$z3 = ord($block[9]);
    		if ( (($z0&0x80)==0) && (($z1&0x80)==0) && (($z2&0x80)==0) && (($z3&0x80)==0) )
    		{
    			$header_size = 10;
    			$tag_size = (($z0&0x7f) * 2097152) + (($z1&0x7f) * 16384) + (($z2&0x7f) * 128) + ($z3&0x7f);
    			$footer_size = $flag_footer_present ? 10 : 0;
                return $header_size + $tag_size + $footer_size;//bytes to skip
            }
        }
        return 0;
    }

    public static function parseFrameHeader($fourbytes)
    {
    	static $versions = array(
            0x0=>'2.5',0x1=>'x',0x2=>'2',0x3=>'1', // x=>'reserved'
        );
    	static $layers = array(
            0x0=>'x',0x1=>'3',0x2=>'2',0x3=>'1', // x=>'reserved'
        );
    	static $bitrates = array(
    		'V1L1'=>array(0,32,64,96,128,160,192,224,256,288,320,352,384,416,448),
    		'V1L2'=>array(0,32,48,56, 64, 80, 96,112,128,160,192,224,256,320,384),
    		'V1L3'=>array(0,32,40,48, 56, 64, 80, 96,112,128,160,192,224,256,320),
    		'V2L1'=>array(0,32,48,56, 64, 80, 96,112,128,144,160,176,192,224,256),
    		'V2L2'=>array(0, 8,16,24, 32, 40, 48, 56, 64, 80, 96,112,128,144,160),
    		'V2L3'=>array(0, 8,16,24, 32, 40, 48, 56, 64, 80, 96,112,128,144,160),
    	);
    	static $sample_rates = array(
    		'1'   => array(44100,48000,32000),
    		'2'   => array(22050,24000,16000),
    		'2.5' => array(11025,12000, 8000),
    	);
    	static $samples = array(
            1 => array( 1 => 384, 2 =>1152, 3 =>1152, ), //MPEGv1,     Layers 1,2,3
            2 => array( 1 => 384, 2 =>1152, 3 => 576, ), //MPEGv2/2.5, Layers 1,2,3
        );
        //$b0=ord($fourbytes[0]);//will always be 0xff
    	$b1=ord($fourbytes[1]);
    	$b2=ord($fourbytes[2]);
    	$b3=ord($fourbytes[3]);

    	$version_bits = ($b1 & 0x18) >> 3;
    	$version = $versions[$version_bits];
    	$simple_version =  ($version=='2.5' ? 2 : $version);

    	$layer_bits = ($b1 & 0x06) >> 1;
    	$layer = $layers[$layer_bits];

    	$protection_bit = ($b1 & 0x01);
    	$bitrate_key = sprintf('V%dL%d', $simple_version , $layer);
    	$bitrate_idx = ($b2 & 0xf0) >> 4;
    	$bitrate = isset($bitrates[$bitrate_key][$bitrate_idx]) ? $bitrates[$bitrate_key][$bitrate_idx] : 0;

        $sample_rate_idx = ($b2 & 0x0c) >> 2;//0xc => b1100
        $sample_rate = isset($sample_rates[$version][$sample_rate_idx]) ? $sample_rates[$version][$sample_rate_idx] : 0;
        $padding_bit = ($b2 & 0x02) >> 1;
        $private_bit = ($b2 & 0x01);
        $channel_mode_bits = ($b3 & 0xc0) >> 6;
        $mode_extension_bits = ($b3 & 0x30) >> 4;
        $copyright_bit = ($b3 & 0x08) >> 3;
        $original_bit = ($b3 & 0x04) >> 2;
        $emphasis = ($b3 & 0x03);

        $info = array();
        $info['Version'] = $version;//MPEGVersion
        $info['Layer'] = $layer;
        //$info['Protection Bit'] = $protection_bit; //0=> protected by 2 byte CRC, 1=>not protected
        $info['Bitrate'] = $bitrate;
        $info['Sampling Rate'] = $sample_rate;
        //$info['Padding Bit'] = $padding_bit;
        //$info['Private Bit'] = $private_bit;
        //$info['Channel Mode'] = $channel_mode_bits;
        //$info['Mode Extension'] = $mode_extension_bits;
        //$info['Copyright'] = $copyright_bit;
        //$info['Original'] = $original_bit;
        //$info['Emphasis'] = $emphasis;
        $info['Framesize'] = self::framesize($layer, $bitrate, $sample_rate, $padding_bit);
        $info['Samples'] = $samples[$simple_version][$layer];
        return $info;
    }

    private static function framesize($layer, $bitrate,$sample_rate,$padding_bit)
    {
    	if ($layer==1)
    		return intval(((12 * $bitrate*1000 /$sample_rate) + $padding_bit) * 4);
        else //layer 2, 3
        return intval(((144 * $bitrate*1000)/$sample_rate) + $padding_bit);
    }
}
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);
if(isset($_POST['hospedar'])){

	### VARIÁVEIS
	$artista = $_POST['artista'];
	$nomemusica = $_POST['nomemusica'];
	$idcatalogo = $_POST['idcatalogo'];
	$arquivo = $_FILES['arquivo'];

	if(empty($artista)){
		echo '<div class="alert alert-danger background-danger">
		<strong>Erro!</strong> Artista vazio.
		</div>';
	} else if(empty($nomemusica)){
		echo '<div class="alert alert-danger background-danger">
		<strong>Erro!</strong> Nome da música vazio.
		</div>';
	} else if(empty($idcatalogo)){
		echo '<div class="alert alert-danger background-danger">
		<strong>Erro!</strong> ID do catálogo vazio.
		</div>';
	} else if(!isset($arquivo)){
		echo '<div class="alert alert-danger background-danger">
		<strong>Erro!</strong> Nenhum arquivo enviado.
		</div>';
	} else {

		$dbh = new PDO( 'mysql:host=' .$iphospedagem. ';dbname=' . $server['uservestacp']."_hotel", $server['uservestacp']."_hotel", $server['senhavestacp']);

		$getCatalogPages = $dbh->prepare("SELECT id FROM catalog_pages WHERE id = :id");
		$getCatalogPages->bindParam(':id', $idcatalogo);
		$getCatalogPages->execute();
		if($getCatalogPages->rowCount() == 0){
			echo '<div class="alert alert-danger background-danger">
			<strong>Erro!</strong> Nenhuma página encontrada com o id enviado.
			</div>';
		} else {

			$idmusica = $server['id'].substr(time(), 5).$server['id'];

			$nomemusicatemp = "sound_machine_sample_".$idmusica.".mp3";
			$nomemusicatemppath = "galaxyservers/temp_jukemusic/".$nomemusicatemp;

			if(move_uploaded_file($arquivo['tmp_name'], $nomemusicatemppath)){

				$mp3file = new MP3File($nomemusicatemppath);
				$duration = $mp3file->getDurationEstimate();
				$idmusica = substr(time(), 7).$server['id'];
				$duration2 = $duration.':';
				$idmusica2 = '1:'.$idmusica;
				$artistanomemusica = $artista." - ".$nomemusica;

				$utf8nomemusica = utf8_decode($nomemusica);
				$utf8artista = utf8_decode($artista);
				$songdata = "1:".$idmusica.",".$duration.":";

				$InsertJukeBoxSongData = $dbh->prepare("INSERT INTO `jukebox_songs_data` (`id`, `name`, `artist`, `song_data`, `length`) VALUES ('".$idmusica."', :nomemusica, :artista, :songdata, '".$duration."')");
				$InsertJukeBoxSongData->bindParam(':nomemusica', $utf8nomemusica);
				$InsertJukeBoxSongData->bindParam(':artista', $utf8artista);
				$InsertJukeBoxSongData->bindParam(':songdata', $songdata);
				$InsertJukeBoxSongData->execute();

				$InsertCatalogItems = $dbh->prepare("INSERT INTO `catalog_items` (`page_id`, `item_id`, `catalog_name`, `cost_pixels`, `extradata`) VALUES (:idcatalogo, '1007', :artistanome, '65', :idmusica);");
				$InsertCatalogItems->bindParam(':idcatalogo', $idcatalogo);
				$InsertCatalogItems->bindParam(':artistanome', $artistanomemusica);
				$InsertCatalogItems->bindParam(':idmusica', $idmusica);
				$InsertCatalogItems->execute();

				$ch = curl_init('http://swf.galaxyservers.com.br/dcr/hof_furni/mp3/upload.php');
				curl_setopt_array($ch, [    
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_POST => true,
					CURLOPT_POSTFIELDS => [          
						'arquivo' => curl_file_create("c:/xampp/htdocs/".$nomemusicatemppath),
						'nomemusica' => "sound_machine_sample_".$idmusica
					]
				]);
				$resposta = curl_exec($ch);
				curl_close($ch);

				echo '<div class="alert alert-success background-success">
				<strong>Sucesso!</strong> '.$resposta.'.
				</div>';

				addlog('Hospedou uma música na Jukebox.');

				unlink($nomemusicatemppath);

				echo '<!--';
				sendRCONCommand2('reload_jukebox', '', $ipvps, $server['portamus']);
				echo '-->';
				sleep(1);
				echo '<!--';
				sendRCONCommand2('reload_catalog', '', $ipvps, $server['portamus']);
				echo '-->';

			} else {
				echo '<div class="alert alert-danger background-danger">
				<strong>Erro!</strong> Erro ao enviar a música.
				</div>';
			}
		}
	}
}
?>
<div class="row">
	<label class="col-sm-4 col-lg-2 col-form-label">Artista</label>
	<div class="col-sm-8 col-lg-10">
		<div class="input-group">																	
			<input type="text" name="artista" class="form-control" placeholder="Nome do artista." required>
		</div>
	</div>
</div>
<div class="row">
	<label class="col-sm-4 col-lg-2 col-form-label">Nome da música</label>
	<div class="col-sm-8 col-lg-10">
		<div class="input-group">																	
			<input type="text" name="nomemusica" class="form-control" placeholder="Nome da música" required>
		</div>
	</div>
</div>
<div class="row">
    <label class="col-sm-4 col-lg-2 col-form-label">Página</label>
    <div class="col-sm-8 col-lg-10">
        <div class="input-group">
            <select name="idcatalogo" class="form-control">
                <?php
                $getArtdicles = $PDO2->prepare("SELECT id,caption FROM catalog_pages WHERE page_layout = \"soundmachine\" and enabled = \"1\" and visible = \"1\" and page_link != \"ultimas_compras\" ORDER BY id");
                $getArtdicles->execute();
                while($dnews = $getArtdicles->fetch())
                {
                    $nomecata = str_replace("HOTELNAME", $server['nomehotel'], $dnews['caption']);
                    $nomecata = utf8_encode($nomecata);

                    ?>
                    <option value="<?= $dnews['id']?>"><?= $dnews['id']?> - <?= $nomecata;?></option>
                <?php } ?>
            </select>
        </div>
    </div>
</div>
<div class="row">
	<label class="col-sm-4 col-lg-2 col-form-label">Música MP3</label>
	<div class="col-sm-8 col-lg-10">
		<div class="input-group">			
			<div class="jFiler jFiler-theme-default">
				<input type="file" name="arquivo" required="">
			</div>
		</div>
	</div>
</div>
<center><button type="submit" name="hospedar" style="border-radius: 8px;" class="btn btn-primary m-b-0">Hospedar</button></center>
</form>
</div>
</div>
</div>
</div><?php } ?>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<script type="text/javascript" src="galaxyservers/bower_components/jquery/js/jquery.min.js"></script>
<script type="text/javascript" src="galaxyservers/bower_components/jquery-ui/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="galaxyservers/bower_components/popper.js/js/popper.min.js"></script>
<script type="text/javascript" src="galaxyservers/bower_components/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="galaxyservers/bower_components/jquery-slimscroll/js/jquery.slimscroll.js"></script>
<script type="text/javascript" src="galaxyservers/bower_components/modernizr/js/modernizr.js"></script>
<script type="text/javascript" src="galaxyservers/bower_components/modernizr/js/css-scrollbars.js"></script>
<script src="galaxyservers/assets/pages/jquery.filer/js/jquery.filer.min.js"></script>
<script src="galaxyservers/assets/pages/filer/custom-filer.js" type="text/javascript"></script>
<script src="galaxyservers/assets/pages/filer/jquery.fileuploads.init.js?a=a" type="text/javascript"></script>
<script type="text/javascript" src="galaxyservers/bower_components/i18next/js/i18next.min.js"></script>
<script type="text/javascript" src="galaxyservers/bower_components/i18next-xhr-backend/js/i18nextXHRBackend.min.js"></script>
<script type="text/javascript" src="galaxyservers/bower_components/i18next-browser-languagedetector/js/i18nextBrowserLanguageDetector.min.js"></script>
<script type="text/javascript" src="galaxyservers/bower_components/jquery-i18next/js/jquery-i18next.min.js"></script>
<script src="galaxyservers/assets/js/pcoded.min.js"></script>
<script src="galaxyservers/assets/js/demo-12.js"></script>
<script src="galaxyservers/assets/js/jquery.mCustomScrollbar.concat.min.js"></script>
<script type="text/javascript" src="galaxyservers/assets/js/script.js"></script>
</body>
</html><?php } else header('Location: ../index'); ?>
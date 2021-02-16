<?php
if(!empty($_GET['hotel'])){
 $file_name = $_GET['hotel'].'.swf';
 $file_url = 'https://swf.galaxyservers.com.br/gordon/GALAXYSERVERS/' . $file_name."?downgalaxypanel";
 header('Content-Type: application/octet-stream');
 header("Content-Transfer-Encoding: Binary");
 header("Content-disposition: attachment; filename=\"".$file_name."\"");
 readfile($file_url);
 header('Location: /hospedar-habbo-swf');
} else  header('Location: /index');
exit;
?>
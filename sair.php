<?php
session_start();
$_SESSION['nomeusuario'] = NULL;
$_SESSION['subconta'] = NULL;
echo '<script>location.href="index";</script>';
?>
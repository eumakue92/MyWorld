<?php
include "componentes/funciones.php";
seguridad();
header('Content-disposition: attachment; filename='.$_GET['fichero']);
header('Content-type: text/plain');
readfile($_GET['fichero']);
?>
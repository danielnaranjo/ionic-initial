<?php 
	$conex=mysql_connect($server, $user, $pass) or die("<p>Error: No se pudo conectar a la base de datos.</p><script>console.log('Error: No se pudo conectar a la base de datos.')</script>");
	mysql_select_db($bbdd) or die("<p>Error: No se pudo abrir la base de datos.</p><script>console.log('Error: No se pudo abrir la base de datos.')</script>");
?>
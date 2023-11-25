<!-- 
	Acceso para superadmin donde se controla permisos de usuarios autorizados y muestra listado de usuarios registrados
	1.- Comprueba cookie de index.php para identificar permisos
	2.- Indica valores de DDBB con permisos actuales
	3.- Botón que cambie los permisos
	4.- Tabla con dattos de todos los usuarios: nombre, email y autorizado
		4a.- Para usuarios autorizados === 1 cambia color fondo de la celda
	5.- Link to index.php
-->

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="estilo.css">
	<title>Usuarios</title>
</head>
<body>



	<?php 

		include "funciones.php";

		if(!isset($_COOKIE['data']) or ($_COOKIE['data' !== "superadmin"])){
			echo "Hey! Lo siento, no tienes permisos para estar aquí.";
		}else{
			if(isset($_GET['cambiar'])){
				cambiarPermisos();
			}

	?>

	<div>
		<h4>Los permisos son: <span><?php
			echo getPermisos();	?></span></h4>
			<form action="usuarios.php" method="get">
				<label for="cambiar"><input type="submit" value="Cambiar permisos"></label>
			</form>
	</div>

	<?php 
	pintaTablaUsuarios();
		}
	?>

	<a href="index.php">Atrás</a>

</body>
</html>
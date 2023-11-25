<!-- 
	Acceso con NOMBRE USUARIO && EMAIL
	Comprobar tipo usuario & permitir acceso app
	1.- IF superadmin =>  mostrará su nombre && enlace para acceder a USUARIOS.PHP
	2.- IF usuario autorizado => mostrará su nombre && enlace para acceder a ARTICULOS.PHP
	3.- IF usuario registrado && no autorizado => mostrará su nombre && indicará que no tiene permisos acceso
	4.- IF usuario no registrado o datos incorrectos => indicará que el usuario no está registrado
	Almacenará en una COOKIE el tipo de usuario que ha intentado registrarse. 
-->

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Index.php</title>
</head>
<body>

	<form action="index.php" method="post">
		<label for="usuario">Usuario: <input type="text" name="usuario" id="usuario"></label>
		<label for="correo">Email: <input type="email" name="correo" id="correo"></label>
		<button type="submit" id="entrar" name="entrar">Entrar</button>
	</form>


	<?php
		include_once "consultas.php";
		
		if (isset($_POST['entrar'])){

			$nombre = $_POST['usuario'];
			$correo = $_POST['correo'];
			$tipoResultado = $tipoUsuario($nombre, $correo);

			setcookie("data", $tipoResultado, time()+300);

			switch ($tipoResultado) {
				case 'superadmin':
					echo "Bienvenida $nombre. Haz click <a href='usuarios.php'>aquí</a> para acceder al USER PANEL.";
					break;
				case 'autorizado':
					echo "Bienvenida $nombre. Haz click <a href='articulos.php'>aquí</a> para acceder al GARMENT PANEL.";
					break;
				case 'registrado':
					echo "Bienvenida $nombre. Vaya, parece que no tienes permisos de acceso para continuar.";
					break;
				default:
					echo "Oops, parece que no te has registrado aún..";
					break;
			}
		}
	?>
	
	
</body>
</html>
<?php 
	function crearConexion() {
/* 		$host = "localhost";
		$user = "root";
		$pass = "1210";
		$baseDatos = "pac3_daw"; */

		$host = "localhost";
		$user = "system";
		$pass = "1210";
		$baseDatos = "pac3_daw";


		$conexion = mysqli_connect($host, $user, $pass, $baseDatos);

		if (!$conexion) {
			die("Error de conexión: " . mysqli_connect_error());
		}

		return $conexion;
	}


	function cerrarConexion($conexion) {
		mysqli_close($conexion);
	}
?>
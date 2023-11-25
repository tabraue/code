<!-- 
	Control sobre los productos del stock de la tienda
	1.- Comprueba cookie de index.php para identificar permisos
	2.- Muestra tabal con todos los productos con columnas: ID, Nombre, Coste, Precio, Categoría y Acciones
	3.- Click sobre el título de cada columna (excepto Accioens) permite ordenar en función del param pulsado
	4.- IF permisos tiene + opciones:
		* Link to formArticulo.php para añadir producto
		* Link to formArticulo.php para editar producto
		* Link to formArticulo.php para borrar producto
	5.- Link to volver a index.php
 -->

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Articulos</title>
</head>
<body>

	<?php 
		include "funciones.php";
	?>
		<h1>Artículos</h1>
	<?php 
		if(getPermisos() == 1){
			echo "<a href='formArticulos.php?añadir'>Añadir artículo</a>";
		}
	?>

	<?php
		if(!isset($_COOKIE['data']) or ($_COOKIE['data'] !== "autorizado")){
			echo "Hey! Lo siento, no tienes permisos para estar aquí.";
		}else{
			if(!isset($_GET['orden'])){
				$orden = "ProductID";
			}else{
				$orden = $_GET['orden'];
			}
			pintaProductos($orden);
		}
	?>

	<a href="index.php">Atrás</a>

</body>
</html>
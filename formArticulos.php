<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Formulario de artículos</title>
</head>

<body>

	<?php
	include "funciones.php";
	?>

	<?php
	if (!isset($_COOKIE['data']) or ($_COOKIE['data' !== "autorizado"])) {
		echo "Hey! Lo siento, no tienes permisos para estar aquí.";
	} else {
		if (isset($_GET['editar'])) {
			$dataProducto = mysqli_fetch_array(getProducto($_GET['editar']));
		} elseif (isset($_GET['borrar'])) {
			$dataProducto = mysqli_fetch_array(getProducto($_GET['borrar']));
		} else {
			# AÑADIR!
			$dataProducto = [
				"ProductID" => '',
				"Name" => '',
				"Cost" => 0,
				"Price" => 0,
				"categoria" => 'CHAQUETA'
			];
		}
	}
	?>


	<form action="post" action="formArticulos.php">
		<label for="nombre">ID:
			<input type="number" name="productid" id="productid" value="<?php echo $dataProducto["ProductID"]; ?>" disabled>
			<input type="hidden" name="id" id="id" value="<?php echo $dataProducto["ProductID"]; ?>">
		</label>
		<label for="nombre">Nombre: <input type="text" name="nombre" id="nombre" value="<?php echo $dataProducto["Name"]; ?>"></label>
		<label for="coste">Coste: <input type="number" name="coste" id="coste" value="<?php echo $dataProducto["Cost"]; ?>"></label>
		<label for="precio">Precio: <input type="number" name="precio" id="precio" value="<?php echo $dataProducto["Price"]; ?>"></label>
		<label for="categoria">Categoría:
			<select name="categoria" id="categoria">
				<option value="">Categorías</option>
				<?php pintaCategorias($dataProducto["CategoryID"]) ?>
			</select>
		</label>

		<?php
		if (isset($_GET['editar'])) {
			echo '<button type="submit" name="accion" value="editar"></button>';
		} elseif (isset($_GET['borrar'])) {
			echo '<button type="submit" name="accion" value="borrar"></button>';
		} else {
			echo '<button type="submit" name="accion" value="añadir"></button>';
		}
		?>

		<?php
		if (isset($_GET['accion'])) {

			switch ($_GET['accion']) {
				case 'editar':
					if (editarProducto(
						$_GET['id'],
						$_GET['nombre'],
						$_GET['coste'],
						$_GET['precio'],
						$_GET['categoria']
					)) {
						echo "Artículo editado!";
					} else {
						echo "Oops, el artículo no se ha editado.";
					}
					break;
				case 'borrar':
					if (borrarProducto($_GET['id'])) {
						echo 'Artículo borrado!';
					} else {
						echo 'Oops, el artículo no se ha borrado.';
					}
					break;
				case 'añadir':
					if (anadirProducto(
						$_GET['nombre'],
						$_GET['coste'],
						$_GET['precio'],
						$_GET['categoria']
					)) {
						echo 'Artículo añadido!';
					} else {
						echo 'Oops, el artículo no se ha añadido.';
					}
					break;
					break;
				default:
					echo 'Vaya, parece que algo no está saliendo como esperábamos.';
					break;
			}
		}
		?>

	</form>

	<a href="index.php">Atrás</a>

</body>

</html>
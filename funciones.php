<!-- 
	contiene la declaración de las funciones para realizar acciones
	para implementar la funcionalidad en cada una de las páginas de la aplicación.
-->

<?php

include_once "consultas.php";

/**
 * Representa las opciones en HTML según tabla category
 * Contiene de category: Name && CategoryID
 * Muestra seleccionada la opción indicada en $defecto
 */
function pintaCategorias($defecto)
{
	$categorias = getCategorias();

	foreach ($categorias as $row) {
		$selected = ($row['CategoryID'] == $defecto) ? 'selected' : '';
		echo "<option value='{$row['CategoryID']}' {$selected}>{$row['Name']}</option>";
	}
}

/**
 * Representa contenido de la tabla user
 * 		TH => Nombre FullName, Email y Autorizado Enabled
 * IF => Enabled === 1 -> bgColor .rojo CSS
 */
function pintaTablaUsuarios()
{
	$userList = getListaUsuarios();

	if (mysqli_num_rows($userList) > 0) {
		echo "<table>
				<tr>
					<th>Nombre</th>
					<th>Email</th>
					<th>Autorizado</th>
				</tr>";

		foreach ($userList as $row) {
			echo "<tr>
					<td>{$row['FullName']}</td>
					<td>{$row['Email']}</td>
					<td class='" . ($row['Enabled'] == 1 ? 'rojo' : '') . "'>{$row['Enabled']}</td>
				  </tr>";
		}
		echo "</table>";
	} else {
		echo "No hay usuarios para mostrar.";
	}
}

/**
 * Representa contenido de tabla product
 * 		TH => ID ProductID, Nombre Name, Coste Cost, Precio Price, Categoría Name de tabla category, Acciones
 * Muestra resultado ordenado según $orden
 * Columna Acciones: 2 Links para EDITAR & BORRAR
 */
function pintaProductos($orden)
{
	$productos = getproductos($orden);

	echo "
	<table>
		<tr>
			<th><a href='articulos.php?orden=ProductID'>ID</a></th>
			<th><a href='articulos.php?orden=Name'>Nombre</a></th>
			<th><a href='articulos.php?orden=Cost'>Coste</a></th>
			<th><a href='articulos.php?orden=Price'>Precio</a></th>
			<th><a href='articulos.php?orden=categoria'>Categoría</a></th>
			<th>Acciones</th>
		</tr>
		";

	foreach ($productos as $row) {
		echo "
				<tr>
					<td>{$row['ProductID']}</td>
					<td>{$row['Name']}</td>
					<td>{$row['Cost']}</td>
					<td>{$row['Price']}</td>
					<td>{$row['Categoria']}</td>
			";

		if (getPermisos() == 1) {
			echo "
					<td>
						<a href='formArticulos.php?editar={$row['ProductID']}'>editar</a>
						<a href='formArticulos.php?borrar={$row['ProductID']}'>borrar</a>
					</td>
					";
		}else {
			echo "</tr>";
		}
	}

	echo "</table>";
}

?>
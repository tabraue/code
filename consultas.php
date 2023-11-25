<!-- 
	contiene la declaración de las funciones para realizar todas las
	consultas a la base de datos necesarias de la aplicación 
-->

<?php

include_once 'conexion.php'; // != include

/**
 * Recibe FullName && Email
 * Comprueba:
 * 		IF USUARIO existe && permisos
 * RETURN
 * 		String  => IF superadmin === "superadmin"
 * 				=> IF usuario registrado y autorizado === "autorizado"
 * 				=> IF usuario registrado y no autorizado === "registrado"
 * 				=> ELSE	=== "no registrado"
 */
function tipoUsuario($nombre, $correo)
{
	$conexion = crearConexion();

	if(esSuperadmin($nombre, $correo)) {
		return "superadmin";
	}else {
		$query = "SELECT * FROM user WHERE FullName = '$nombre' AND Email = '$correo'";
		$resultado = mysqli_query($conexion, $query);

		cerrarConexion($conexion);

		if($data = mysqli_fetch_array($resultado)) {
			if($data["Enabled"] == 0) {
				return "registrado";
			}elseif ($data["Enabled"] == 1){
				return "autorizado";
			}else{
				return "no registrado";
			}
		}
	}	
}


/**
 * Recibe FullName && Email
 * Comprueba: 
 * 		IF USUARIO existe && permisos === "superadmin"
 * RETUNR
 * 		Boolean => TRUE if permisos === "superadmin"
 * 				=> FALSE else
 */
function esSuperadmin($nombre, $correo)
{
	$conexion = crearConexion();

	$query = "SELECT user.UserID FROM user 
					INNER JOIN setup ON user.UserID = setup.SuperAdmin 
						WHERE user.FullName = '$nombre' AND user.Email = '$correo'";
	$resultado = mysqli_query($conexion, $query);

	if(mysqli_fetch_array($resultado)){
		return true;
	}else {
		return false;
	}

	cerrarConexion($conexion);
}


/**
 * RETURN valor de columna Autenticación de SETUP
 */
function getPermisos()
{
	$conexion = crearConexion();

	$query = "SELECT Autenticación FROM setup";
	$resultado = mysqli_fetch_assoc(mysqli_query($conexion, $query));

	cerrarConexion($conexion);

	return $resultado["Autenticación"];
}


/**
 * Cambia el valor de columna Autenticación de SETUP de 0 - 1 - 0
 */
function cambiarPermisos()
{
	$permisos = getPermisos();

	$conexion = crearConexion();


	if ($permisos == 1) {
		$query = "UPDATE setup SET Autenticación = 0";
	} elseif ($permisos == 0){
		$query = "UPDATE setup SET Autenticación = 1";
	}

	$resultado = mysqli_query($conexion, $query);

	cerrarConexion($conexion);

	// en ppio no es necesario devolver, solo UPDATE  ===>>  return $resultado["Autenticación"];
}


/**
 * RETURN tabla virtual con:
 * 		CategoryID
 * 		Name
 * de tabla category
 */
function getCategorias()
{
	$conexion = crearConexion();

	$query = "SELECT * FROM category"; // ALL porque contiene lo que se pide
	$resultado = mysqli_query($conexion, $query);

	cerrarConexion($conexion);

	return $resultado;
}


/**
 * RETURN tabla virtual con:
 * 		FullName
 * 		Email
 * 		Enabled
 * de todos los usuarios en USER
 */
function getListaUsuarios()
{
	$conexion = crearConexion();

	$query = "SELECT FullName, Email, Enabled FROM user";
	$resultado = mysqli_query($conexion, $query);

	cerrarConexion($conexion);
	
	return $resultado;
}


/**
 * RETURN tabla virtual con los datos del producto con id === id de params
 */
function getProducto($ID)
{
	$conexion = crearConexion();

	$query = "SELECT * FROM product WHERE ProductID = $ID";
	$resultado = mysqli_query($conexion, $query);

	cerrarConexion($conexion);

	return $resultado;
}


/**
 * $orden es el orden de productos
 * RETURN tabla virtual de PRODUCT ordenado y con valores:
 * 		tabla PRODUCT: ProductId, Name, Cost, Price
 * 		tabla CATEGORY: Name
 */
function getProductos($orden)
{
	$conexion = crearConexion();

	$query = "SELECT product.ProductID, 
					 product.Name, 
					 product.Cost, 
					 product.Price, 
					 category.Name as Categoria FROM product 
			  INNER JOIN category 
			  	WHERE product.CategoryID = category.CategoryID ORDER BY $orden";

	$resultado = mysqli_query($conexion, $query);

	cerrarConexion($conexion);

	return $resultado;
}

/**
 * Params son referente a 1 producto
 * Añadir el producto a DDBB y RETURN resultado de query
 */
function anadirProducto($nombre, $coste, $precio, $categoria)
{
	$conexion = crearConexion();

	$query = "INSERT INTO product (Name, Cost, Price, CategoryID) 
						   VALUES ('$nombre', $coste, $precio, $categoria)";

	$resultado = mysqli_query($conexion, $query);

	cerrarConexion($conexion);

	return $resultado;
}

/**
 * id del producto
 * Eliminarlo de DDBB y RETURN resultado de query
 */
function borrarProducto($id)
{
	$conexion = crearConexion();

	$query = "DELETE FROM product WHERE ProductID = $id";
	$resultado = mysqli_query($conexion, $query);

	cerrarConexion($conexion);

	return $resultado;
}

/**
 * Params son referente a 1 producto
 * Actualiza la info de ese producto en DDBB
 * RETURN resultado de query
 */
function editarProducto($id, $nombre, $coste, $precio, $categoria)
{
	$conexion = crearConexion();

	$query = "UPDATE product SET Name = '$nombre', Cost = $coste, Price = $precio, CategoryId = $categoria WHERE ProductID = $id";
	$resultado = mysqli_query($conexion, $query);

	cerrarConexion($conexion);

	return $resultado;
}

?>

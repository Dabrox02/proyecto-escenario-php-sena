<?php
// Nombre:
// CC:
// Curso:
// Ficha
// Taller 4

// IMPORTACION MODULOS
require "acciones.php";
session_start();

// SE VALIDA SI EL SISTEMA GENERO UN ERROR, PARA MOSTRARLO Y LUEGO ELIMINARLO
if (isset($_SESSION["error"])) {
	mostrarError($_SESSION["error"]);
	unset($_SESSION["error"]);
}

// SE VALIDA SI YA SE HAN HECHO MODIFICACIONES DE ASIENTOS CON ANTERIORIDAD, EN CASO NO, SE INICIALIZA TODAS LIBRES.
$arregloAsientos = isset($_SESSION["arreglo_asientos"]) ? $_SESSION["arreglo_asientos"] : cargarAsientos();

// VALIDAMOS QUE SE REALICE UNA PETICION POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["enviar"])) {
	$row = isset($_POST["row"]) && !empty($_POST["row"]);
	$seat = isset($_POST["seat"]) && !empty($_POST["seat"]);
	$option = isset($_POST["option"]) && !empty($_POST["option"]);
	$escenario = isset($_POST["escenario"]) && !empty($_POST["escenario"]);

	// SE VALIDAN QUE LOS DATOS NO ESTEN VACIOS
	if ($row && $seat && $option && $escenario) {
		$row = $_POST["row"];
		$seat = $_POST["seat"];
		$option = $_POST["option"];
		// SE VALIDA SI SE ENVIARON DATOS NUMERICOS
		if (is_numeric($row) && is_numeric($seat)) {
			if ($row >= 1 && $row <= 5 && $seat >= 1 && $seat <= 5) {
				$jsonEscenario = json_decode($_POST["escenario"], true);
				if ($jsonEscenario[$row - 1][$seat - 1] != $option) {
					$arregloAsientos = actualizarAsiento($row - 1, $seat - 1, $option, $jsonEscenario);
					$_SESSION["arreglo_asientos"] = $arregloAsientos;
				} else {
					$_SESSION["error"] = "Ha ocurrido un error: Operacion invalida.";
					$_SESSION["arreglo_asientos"] = $arregloAsientos;
					header('Location: ./');
				}
			} else {
				$_SESSION["error"] = "Ha ocurrido un error: Fila y/o asiento invalido.";
				$_SESSION["arreglo_asientos"] = $arregloAsientos;
				header('Location: ./');
			}
		} else {
			$_SESSION["error"] = "Ha ocurrido un error: Ingrese numeros.";
			$_SESSION["arreglo_asientos"] = $arregloAsientos;
			header('Location: ./');
		}
	} else {
		$_SESSION["error"] = "Ha ocurrido un error: Campos Vacios.";
		$_SESSION["arreglo_asientos"] = $arregloAsientos;
		header('Location: ./');
	}
	// ACA CARGAMOS EL ARREGLO ASIENTOS COMO VACIO Y RECARGA LA PAGINA
} else if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["resetear"])) {
	$_SESSION["arreglo_asientos"] = cargarAsientos();
	header('Location: ./');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Taller 4</title>
	<style>
		* {
			font-family: Arial, Helvetica, sans-serif;
			box-sizing: border-box;
		}

		/* GENERAL */
		.contenido {
			display: flex;
			flex-direction: column;
		}

		.interfaz-escenario {
			margin: auto;
			margin-top: 10px;
		}

		/* ESTILOS ESCENARIO */
		.escenario {
			padding: 10px;
		}

		.escenario * {
			font-size: 20px;
		}

		.tabla-escenario {
			margin: auto;
			border-collapse: collapse;
		}

		.title-cabecero {
			border: 1px solid black;
			margin: 0;
		}

		.title-row-asientos {
			margin: 0;
			text-align: center;
			letter-spacing: 4px;
		}

		.fila td input {
			max-width: 30px;
			min-width: 2vw;
			text-align: center;
		}

		.fila td input[disabled] {
			background-color: black;
			color: white;
		}

		/* ESTILOS INTERFAZ */
		.form-group {
			display: flex;
			flex-direction: row;
			align-items: center;
			justify-content: center;
			margin-bottom: 10px;
		}

		.form-group label {
			font-weight: 600;
			width: 30%;
		}

		.form-group input,
		select {
			width: 30%;
			font-size: 16px;
			text-align: center;
		}

		.form-group button {
			padding: 5px;
			margin: 8px;
			width: 40%;
		}
	</style>
</head>

<body>
	<div class="contenido">
		<?php
		// CARGAMOS ESCENARIO
		require "escenario.php"
		?>
		<div class="escenario">
			<table class="tabla-escenario">
				<tr class="tabla-cabecero">
					<th colspan="7">
						<h3 class="title-cabecero">Escenario</h3>
					</th>
				</tr>
				<tr class="asientos">
					<td colspan="7">
						<div class="title-row-asientos">ASIENTO</div>
					</td>
				</tr>
				<tr class="fila">
					<td></td>
					<td>
						<input type="text" disabled>
					</td>
					<td>
						<input type="text" value="1" disabled>
					</td>
					<td>
						<input type="text" value="2" disabled>
					</td>
					<td>
						<input type="text" value="3" disabled>
					</td>
					<td>
						<input type="text" value="4" disabled>
					</td>
					<td>
						<input type="text" value="5" disabled>
					</td>
				</tr>
				<tr class="fila">
					<td>F</td>
					<td>
						<input type="text" value="1" disabled>
					</td>
					<?php
					// ESTE METODO IMPRIME LA FILA SOLICITADA
					mostrarEscenario($arregloAsientos, 0);
					?>
				</tr>
				<tr class="fila">
					<td>I</td>
					<td>
						<input type="text" value="2" disabled>
					</td>
					<?php
					mostrarEscenario($arregloAsientos, 1);
					?>
				</tr>
				<tr class="fila">
					<td>L</td>
					<td>
						<input type="text" value="3" disabled>
					</td>
					<?php
					mostrarEscenario($arregloAsientos, 2);
					?>
				</tr>
				<tr class="fila">
					<td>A</td>
					<td>
						<input type="text" value="4" disabled>
					</td>
					<?php
					mostrarEscenario($arregloAsientos, 3);
					?>
				</tr>
				<tr class="fila">
					<td></td>
					<td>
						<input type="text" value="5" disabled>
					</td>
					<?php
					mostrarEscenario($arregloAsientos, 4);
					?>
				</tr>
			</table>
		</div>
		<div class="interfaz-escenario">
			<form method="post" action="./">
				<div class="form-group">
					<label for="row">Fila:</label>
					<input type="text" name="row">
				</div>
				<div class="form-group">
					<label for="seat">Asiento: </label>
					<input type="text" name="seat">
				</div>
				<div class="form-group">
					<label for="opcion">Opcion: </label>
					<select name="option" id="opcion">
						<option value="" selected></option>
						<option value="R">Reservar</option>
						<option value="V">Comprar</option>
						<option value="L">Liberar</option>
					</select>
				</div>
				<div>
					<!-- CARGAMOS EL ARREGLO CON LOS ASIENTOS DE FORMA OCULTA -->
					<textarea name="escenario" hidden><?php echo imprimirArreglo($arregloAsientos); ?>
					</textarea>
				</div>
				<div class="form-group">
					<button type="submit" name="enviar">Enviar</button>
					<button type="submit" name="resetear">Borrar</button>
				</div>
			</form>
		</div>
	</div>
</body>

</html>
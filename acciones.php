<?php
// ESTA FUNCION CREA UN ARREGLO BIDIMENSIONAL DE 5 ARREGLOS COMPUESTOS POR 5 ELEMENTOS "L"
function cargarAsientos()
{
	$arregloAsientos = array();
	for ($i = 0; $i < 5; $i++) {
		$fila = array();
		for ($j	= 0; $j < 5; $j++) {
			$fila[$j] = "L";
		}
		$arregloAsientos[$i] = $fila;
	}
	return $arregloAsientos;
}

// ESTA FUNCION VALIDA QUE LOS ASIENTOS VENDIDOS NO PUEDAN SER MODIFICADOS
function actualizarAsiento($fila, $asiento, $opcion, $arregloAsientos)
{
	if ($arregloAsientos[$fila][$asiento] == "L" || $arregloAsientos[$fila][$asiento] == "R") {
		$arregloAsientos[$fila][$asiento] = $opcion;
		return $arregloAsientos;
	} else if ($arregloAsientos[$fila][$asiento] == "V") {
		$_SESSION["error"] = "Asiento Vendido, escoja otro.";
		$_SESSION["arreglo_asientos"] = $arregloAsientos;
		header('Location: ./');
	}
}

// CONVIERTE EL ARREGLO A JSON PARA IMPRIMIRLO EN EL TEXTAREA
function imprimirArreglo($arreglo)
{
	$arregloObjeto = (object)$arreglo;
	return json_encode($arregloObjeto);
}

// MUESTRA UN MENSAJE DE ERROR CON EL TEXTO ENVIADO
function mostrarError($mensaje)
{
	echo '<script type="text/javascript">';
	echo 'alert("' . $mensaje . '");';
	echo '</script>';
}


function print_array($array)
{
	foreach ($array as $key => $value) {
		echo "Fila: " . $key + 1 . "<br>";
		foreach ($value as $key => $valor) {
			echo "" . $key + 1 . "=> " . $valor . "<br>";
		}
	}
}

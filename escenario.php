<?php

// CREA UN TABLE DATA POR CADA ELEMENTO DEL ARREGLO
function mostrarEscenario($arregloEscenario, $fila)
{
	for ($i = 0; $i < 5; $i++) {
		echo "<td>";
		echo "<input type='text' readonly value='" . $arregloEscenario[$fila][$i] . "'>";
		echo "</td>";
	}
}

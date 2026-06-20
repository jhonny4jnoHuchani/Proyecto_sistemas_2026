<?php

if (!function_exists('numToLetras')) {
    function numToLetras($numero) {
        $numero = (int) $numero;
        
        $unidades = ['', 'Uno', 'Dos', 'Tres', 'Cuatro', 'Cinco', 'Seis', 'Siete', 'Ocho', 'Nueve', 'Diez',
                     'Once', 'Doce', 'Trece', 'Catorce', 'Quince', 'Dieciséis', 'Diecisiete', 'Dieciocho', 'Diecinueve', 'Veinte'];
        $decenas = ['', '', 'Veinti', 'Treinta', 'Cuarenta', 'Cincuenta', 'Sesenta', 'Setenta', 'Ochenta', 'Noventa'];
        $centenas = ['', 'Ciento', 'Doscientos', 'Trescientos', 'Cuatrocientos', 'Quinientos', 'Seiscientos', 'Setecientos', 'Ochocientos', 'Novecientos'];
        
        if ($numero == 0) return 'Cero';
        if ($numero == 100) return 'Cien';
        if ($numero <= 20) return $unidades[$numero];
        
        $resultado = '';
        
        if ($numero >= 100) {
            $centena = floor($numero / 100);
            $resultado .= $centenas[$centena] . ' ';
            $numero %= 100;
        }
        
        if ($numero > 0) {
            if ($numero <= 20) {
                $resultado .= $unidades[$numero];
            } else {
                $decena = floor($numero / 10);
                $unidad = $numero % 10;
                if ($decena == 2 && $unidad > 0) {
                    $resultado .= $decenas[$decena] . $unidades[$unidad];
                } else {
                    $resultado .= $decenas[$decena];
                    if ($unidad > 0) {
                        $resultado .= ' y ' . $unidades[$unidad];
                    }
                }
            }
        }
        
        return trim($resultado);
    }
}
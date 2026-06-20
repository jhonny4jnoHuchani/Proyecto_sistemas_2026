<?php

if (!function_exists('menuPorRol')) {
    function menuPorRol($roles, $item) {
        // Devuelve el item sin filtrar (el filtro lo hace array_filter después)
        // Solo ponemos el 'can' para filtrar en tiempo de ejecución
        $roles = is_array($roles) ? $roles : [$roles];
        $item['can'] = $roles;
        return $item;
    }
}
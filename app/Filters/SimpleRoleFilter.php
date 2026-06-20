<?php

namespace App\Filters;

use JeroenNoten\LaravelAdminLte\Menu\Filters\FilterInterface;

class SimpleRoleFilter implements FilterInterface
{
    public function transform($item)
    {
        if (!isset($item['can'])) {
            return $item;
        }

        $roles = (array) $item['can'];
        unset($item['can']);
        
        if (!auth()->check()) {
            $item['restricted'] = true;
            return $item;
        }

        if (!in_array(auth()->user()->rol, $roles)) {
            $item['restricted'] = true;
        }

        return $item;
    }
}
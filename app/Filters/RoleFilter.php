<?php

namespace App\Filters;

use JeroenNoten\LaravelAdminLte\Menu\Builder;
use JeroenNoten\LaravelAdminLte\Menu\Filters\FilterInterface;
use Illuminate\Support\Facades\Auth;

class RoleFilter implements FilterInterface
{
    public function transform($item)
    {
        if (!Auth::check()) {
            $item['restricted'] = true;
            return $item;
        }

        if (isset($item['can'])) {
            if (!in_array(Auth::user()->rol, (array) $item['can'])) {
                $item['restricted'] = true;
                return $item;
            }
            unset($item['can']);
        }

        return $item;
    }
}
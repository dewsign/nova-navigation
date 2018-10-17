<?php

namespace Dewsign\NovaNavigation\Models;

use Illuminate\Support\Facades\View;

class CustomItem extends NavigationItem
{
    public static $viewTemplate = 'nova-navigation::custom';

    public function resolveAction()
    {
        return $this->url;
    }
}

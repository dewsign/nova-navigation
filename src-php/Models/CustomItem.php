<?php

namespace Dewsign\NovaNavigation\Models;

class CustomItem extends NavigationItem
{
    public static $viewTemplate = 'nova-navigation::custom';

    public function resolveAction()
    {
        return $this->url;
    }
}

<?php

namespace Dewsign\NovaNavigation\Support;

use Illuminate\Support\Facades\View;
use Dewsign\NovaNavigation\Models\Navigation;

class RenderEngine
{
    /**
     * Renders a navigation zone
     *
     * @param $spaces
     * @return string
     */
    public static function renderNavigation($zone, $items = null)
    {
        /**
         * If no items have been passed in retrieve them from the Model
         */
        if (!$items) {
            $items = Navigation::active()->whereNull('repeatable_type')->whereZone($zone)->get();
        }

        return View::first([
            "nova-navigation::zone.{$zone}",
            'nova-navigation::zone.default',
        ])->with('items', $items)->with('zone', $zone);
    }
}

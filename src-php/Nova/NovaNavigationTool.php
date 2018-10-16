<?php
namespace Dewsign\NovaNavigation\Nova;

use Laravel\Nova\Nova;
use Laravel\Nova\Tool as NovaTool;
use Dewsign\NovaNavigation\Nova\MainNavigation;
use Dewsign\NovaNavigation\Nova\FooterNavigation;

class NovaNavigationTool extends NovaTool
{
    /**
     * Perform any tasks that need to happen when the tool is booted.
     *
     * @return void
     */
    public function boot()
    {
        Nova::resources([
            MainNavigation::class,
            FooterNavigation::class,
        ]);
    }
}

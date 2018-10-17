<?php

namespace Dewsign\NovaNavigation\Nova\Items;

use Laravel\Nova\Resource;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Epartment\NovaDependencyContainer\HasDependencies;
use Dewsign\NovaRepeaterBlocks\Traits\HasRepeaterBlocks;
use Dewsign\NovaRepeaterBlocks\Traits\IsRepeaterBlockResource;
use Epartment\NovaDependencyContainer\NovaDependencyContainer;

class NavigationItem extends Resource
{
    use HasDependencies;
    use HasRepeaterBlocks;
    use IsRepeaterBlockResource;

    public static function label()
    {
        return __('Navigation Item');
    }

    public function fields(Request $request)
    {
        return [];
    }
}

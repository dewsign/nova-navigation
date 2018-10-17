<?php

namespace Dewsign\NovaNavigation\Nova\Items;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;

class CustomItem extends NavigationItem
{
    public static $model = 'Dewsign\NovaNavigation\Models\CustomItem';

    public static function label()
    {
        return __('Custom Link');
    }

    public function fields(Request $request)
    {
        return [
            Text::make('Url')->rules('required', 'url', 'max:254'),
        ];
    }
}

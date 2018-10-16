<?php

namespace Dewsign\NovaNavigation\Nova;

use Laravel\Nova\Resource;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Epartment\NovaDependencyContainer\HasDependencies;
use Dewsign\NovaRepeaterBlocks\Traits\HasRepeaterBlocks;
use Dewsign\NovaRepeaterBlocks\Traits\IsRepeaterBlockResource;
use Epartment\NovaDependencyContainer\NovaDependencyContainer;

class CustomItem extends Resource
{
    use HasDependencies;
    use HasRepeaterBlocks;
    use IsRepeaterBlockResource;


    public static $model = 'Dewsign\NovaNavigation\Models\CustomItem';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'url',
    ];

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

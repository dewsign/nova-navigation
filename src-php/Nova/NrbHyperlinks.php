<?php

namespace Dewsign\NovaNavigation\Nova;

use Laravel\Nova\Resource;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Select;
use Dewsign\NovaRepeaterBlocks\Models\Repeater;
use Epartment\NovaDependencyContainer\HasDependencies;
use Dewsign\NovaRepeaterBlocks\Traits\IsRepeaterBlockResource;
use Epartment\NovaDependencyContainer\NovaDependencyContainer;
use Dewsign\NovaRepeaterBlocks\Traits\ResourceCanBeContainerised;

class NrbHyperlinks extends Resource
{
    use HasDependencies;
    use IsRepeaterBlockResource;
    use ResourceCanBeContainerised;

    public static $model = 'Dewsign\NovaNavigation\Models\NrbHyperlinks';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

    public static function singularLabel()
    {
        return __('Hyperlinks');
    }

    public static function label()
    {
        return __('Hyperlinks');
    }

    public function fields(Request $request)
    {
        $packageTemplates = Repeater::customTemplates(__DIR__ . '/../Resources/views/hyperlinks');
        $appTemplates = Repeater::customTemplates(resource_path('views/vendor/nova-navigation/hyperlinks'));
        return [
            Select::make('Style')
                ->options(array_merge($packageTemplates, $appTemplates))
                ->displayUsingLabels()
                ->hideFromIndex(),
        ];
    }
}

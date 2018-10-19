<?php

namespace Dewsign\NovaNavigation\Nova;

use Laravel\Nova\Resource;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\MorphTo;
use Laravel\Nova\Fields\MorphMany;
use Silvanite\NovaFieldHidden\Hidden;
use Dewsign\NovaFieldSortable\IsSorted;
use Dewsign\NovaFieldSortable\Sortable;
use Laravel\Nova\Http\Requests\NovaRequest;
use Dewsign\NovaRepeaterBlocks\Fields\Repeater;
use Dewsign\NovaNavigation\Nova\Items\CustomItem;
use Dewsign\NovaRepeaterBlocks\Fields\Polymorphic;

class Navigation extends Repeater
{
    use IsSorted;

    public static $title = 'label';

    public static $displayInNavigation = true;

    public static $zone = 'global';

    public static $model = 'Dewsign\NovaNavigation\Models\Navigation';

    public static $group = 'Navigation';

    public static function label()
    {
        return __('Navigation');
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            Sortable::make('Sort', 'id'),
            ID::make(),
            Boolean::make('Active')->rules('required', 'boolean'),
            MorphTo::make('Parent', 'repeatable')->types(array_wrap(static::class))->onlyOnDetail(),
            Text::make('Title')->rules('nullable', 'max:254')->hideFromIndex(),
            Text::make('Label', function() {
                return $this->label;
            }),
            Hidden::make('Zone')->value(static::$zone),
            Polymorphic::make('Type')->types($request, $this->types($request)),
            MorphMany::make(__('Items'), 'navigations', static::class),
        ];
    }

    // What type of repeater blocks should be made available
    public function types(Request $request)
    {
        if (config('novanavigation.replaceRepeaters', false)) {
            return config('novanavigation.repeaters');
        }

        return array_merge([
            CustomItem::class,
        ], config('novanavigation.repeaters'));
    }

    public static function indexQuery(NovaRequest $request, $query)
    {

        if (static::getResourceIdFromRequest($request)) {
            return $query;
        }

        return $query->where(function ($query) {
            return $query->whereNull('repeatable_type')->whereZone(static::$zone);
        });
    }

    /**
     * Get the resource ID of the current repeater item
     *
     * @param Request $request
     * @return mixed
     */
    protected static function getResourceIdFromRequest(Request $request)
    {
        if ($resourceId = $request->get('viaResourceId')) {
            return $resourceId;
        };

        parse_str(parse_url($request->server->get('HTTP_REFERER'), PHP_URL_QUERY), $params);

        if ($resourceId = array_get($params, 'viaResourceId')) {
            return $resourceId;
        };

        if ($resourceId = $request->route('resourceId')) {
            return $resourceId;
        };

        return null;
    }
}

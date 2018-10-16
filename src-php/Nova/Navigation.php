<?php

namespace Dewsign\NovaNavigation\Nova;

use Laravel\Nova\Resource;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\MorphTo;
use Laravel\Nova\Fields\MorphMany;
use Naxon\NovaFieldSortable\Sortable;
use Benjaminhirsch\NovaSlugField\Slug;
use Laravel\Nova\Fields\BelongsToMany;
use Dewsign\NovaNavigation\Nova\CustomItem;
use Laravel\Nova\Http\Requests\NovaRequest;
use Benjaminhirsch\NovaSlugField\TextWithSlug;
use Dewsign\NovaRepeaterBlocks\Fields\Repeater;
use Dewsign\NovaRepeaterBlocks\Fields\Polymorphic;
use Maxfactor\Support\Webpage\Nova\MetaAttributes;
use Naxon\NovaFieldSortable\Concerns\SortsIndexEntries;
use Silvanite\NovaFieldCloudinary\Fields\CloudinaryImage;

class Navigation extends Repeater
{
    public static $morphTo = [
        'Dewsign\NovaNavigation\Nova\Navigation',
    ];

    public static $title = 'title';

    public static $defaultSortField = 'sort_order';

    public static $displayInNavigation = true;

    public static $zone = 'global';

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
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
            ID::make()->sortable(),
            Boolean::make('Active')->sortable()->rules('required', 'boolean'),
            MorphTo::make('Parent', 'repeatable')->types(array_wrap(static::$morphTo))->onlyOnDetail(),
            Text::make('Title')->sortable()->rules('required'),
            Text::make('Zone')->sortable()->rules('required')->withMeta([
                'value' => static::$zone,
                'hidden' => true,
            ])->onlyOnForms()->hideWhenUpdating(),
            Polymorphic::make('Type')->types($request, [
                CustomItem::class,
            ]),
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
            Navigation::class,
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

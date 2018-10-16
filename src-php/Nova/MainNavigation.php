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

class MainNavigation extends Navigation
{
    public static $morphTo = [
        'Dewsign\NovaNavigation\Nova\MainNavigation',
    ];

    public static $displayInNavigation = true;

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'Dewsign\NovaNavigation\Models\Navigation';

    public static $group = 'Navigation';

    public static $zone = 'main';

    public static function label()
    {
        return __('Main Navigation');
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    // public function fields(Request $request)
    // {
    //     return [
    //         ID::make()->sortable(),
    //         Boolean::make('Active')->sortable()->rules('required', 'boolean'),
    //         MorphTo::make('Parent', 'repeatable')->types(array_wrap(static::$morphTo))->onlyOnDetail(),
    //         Text::make('Title')->sortable()->rules('required'),
    //         Polymorphic::make('Type')->types($request, [
    //             CustomItem::class,
    //         ]),
    //         MorphMany::make(__('Items'), 'navigations', MainNavigation::class),
    //     ];
    // }

    // What type of repeater blocks should be made available
    // public function types(Request $request)
    // {
    //     if (config('novanavigation.replaceRepeaters', false)) {
    //         return config('novanavigation.repeaters');
    //     }

    //     return array_merge([
    //         Navigation::class,
    //     ], config('novanavigation.repeaters'));
    // }
}

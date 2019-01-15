<?php

namespace Dewsign\NovaNavigation\Models;

use Illuminate\Database\Eloquent\Model;
use Dewsign\NovaRepeaterBlocks\Traits\IsRepeaterBlock;
use Dewsign\NovaRepeaterBlocks\Traits\HasRepeaterBlocks;
use Dewsign\NovaRepeaterBlocks\Traits\CanBeContainerised;
use Dewsign\NovaRepeaterBlocks\Repeaters\Common\AvailableBlocks;
use Dewsign\NovaRepeaterBlocks\Repeaters\Common\Blocks\MarkdownBlock;

class NrbHyperlinks extends Model
{
    use IsRepeaterBlock;
    use HasRepeaterBlocks;
    use CanBeContainerised;

    public static $repeaterBlockViewTemplate = 'nova-navigation::hyperlinks';

    public static function types()
    {
        return static::mergeTypes();
    }

    // What type of repeater blocks should be made available
    public static function mergeTypes()
    {
        if (config('novanavigation.replaceRepeaters', false)) {
            return config('novanavigation.repeaters');
        }

        return array_merge([
            \Dewsign\NovaNavigation\Nova\Items\CustomItem::class,
        ], config('novanavigation.repeaters'));
    }

    public static function sourceTypes()
    {
        return [
            \Dewsign\NovaRepeaterBlocks\Fields\Repeater::class,
        ];
    }
}

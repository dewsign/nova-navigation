<?php

namespace Dewsign\NovaNavigation\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\View;
use Illuminate\Database\Eloquent\Model;
use Dewsign\NovaRepeaterBlocks\Traits\IsRepeaterBlock;

class NavigationItem extends Model
{
    use IsRepeaterBlock;

    public const TYPE_MAILTO = 'mailto';
    public const TYPE_TEL = 'tel';
    public const TYPE_EXTERNAL = 'external';
    public const TYPE_INTERNAL = 'internal';
    public const TYPE_DOWNLOAD = 'download';

    public static $viewTemplate = 'nova-navigation::default';

    public function type()
    {
        return $this->morphTo();
    }

    public function getLinkTypeAttribute()
    {
        if (Str::startsWith($this->url, 'mailto:')) {
            return self::TYPE_MAILTO;
        }

        if (Str::startsWith($this->url, 'tel:')) {
            return self::TYPE_TEL;
        }

        if (Str::endsWith($this->url, config('novanavigation.download-types'))) {
            return self::TYPE_DOWNLOAD;
        }

        if (Str::startsWith($this->url, ['http:', 'https:']) && !Str::contains($this->url, config('app.url'))) {
            return self::TYPE_EXTERNAL;
        }

        return self::TYPE_INTERNAL;
    }

    public function resolveView($model)
    {
        return View::make(static::$viewTemplate)
            ->with('item', $this)
            ->with('model', $model)
            ->render();
    }

    public function getExtraInfo()
    {
        return $this->linkType;
    }
}

<?php

namespace Dewsign\NovaNavigation\Models;

use Illuminate\Support\Facades\View;
use Illuminate\Database\Eloquent\Model;
use Dewsign\NovaRepeaterBlocks\Traits\IsRepeaterBlock;

class NavigationItem extends Model
{
    use IsRepeaterBlock;

    public static $viewTemplate = 'nova-navigation::default';

    public function type()
    {
        return $this->morphTo();
    }

    public function resolveView($model)
    {
        return View::make(static::$viewTemplate)
            ->with('item', $this)
            ->with('model', $model)
            ->render();
    }
}

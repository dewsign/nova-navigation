<?php

namespace Dewsign\NovaNavigation\Models;

use Illuminate\Database\Eloquent\Model;
use Dewsign\NovaRepeaterBlocks\Traits\IsRepeaterBlock;

class PlaceholderItem extends Model
{
    use IsRepeaterBlock;

    public static $repeaterBlockViewTemplate = 'nova-navigation::placeholder';

    public function type()
    {
        return $this->morphTo();
    }

    public function resolveAction()
    {
        return '';
    }

    public function resolveLabel()
    {
        return '';
    }
}

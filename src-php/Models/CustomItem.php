<?php

namespace Dewsign\NovaNavigation\Models;

use Illuminate\Database\Eloquent\Model;
use Dewsign\NovaRepeaterBlocks\Traits\IsRepeaterBlock;

class CustomItem extends Model
{
    use IsRepeaterBlock;

    public static $repeaterBlockViewTemplate = 'nova-navigation::custom';
}

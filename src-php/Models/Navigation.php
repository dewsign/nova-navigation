<?php

namespace Dewsign\NovaNavigation\Models;

use Spatie\EloquentSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use Maxfactor\Support\Model\Traits\HasSortOrder;
use Maxfactor\Support\Model\Traits\HasActiveState;
use Dewsign\NovaRepeaterBlocks\Traits\HasRepeaterBlocks;
use Dewsign\NovaRepeaterBlocks\Traits\ResolvesRepeaterTypes;

class Navigation extends Model implements Sortable
{
    use HasSortOrder;
    use HasActiveState;
    use HasRepeaterBlocks;
    use ResolvesRepeaterTypes;

    protected $with = [
        'navigations',
    ];

    public function navigations()
    {
        return $this->morphMany(Navigation::class, 'repeatable')->with('type');
    }

    public function repeatable()
    {
        return $this->morphTo();
    }

    public function type()
    {
        return $this->morphTo();
    }

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($model) {
            optional($model->type)->delete();
        });
    }
}

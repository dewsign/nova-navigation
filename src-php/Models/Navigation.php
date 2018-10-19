<?php

namespace Dewsign\NovaNavigation\Models;

use Spatie\EloquentSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use Maxfactor\Support\Model\Traits\HasSortOrder;
use Maxfactor\Support\Model\Traits\HasActiveState;
use Dewsign\NovaRepeaterBlocks\Traits\HasRepeaterBlocks;

class Navigation extends Model implements Sortable
{
    use HasSortOrder;
    use HasActiveState;
    use HasRepeaterBlocks;

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

    public function getActionAttribute()
    {
        if (!method_exists($this->type, 'resolveAction')) {
            return null;
        }

        return $this->type->resolveAction();
    }

    public function getLabelAttribute()
    {
        if (!method_exists($this->type, 'resolveLabel')) {
            return $this->title;
        }

        return $this->type->resolveLabel($this);
    }

    public function getViewAttribute()
    {
        if (!method_exists($this->type, 'resolveView')) {
            return null;
        }

        return $this->type->resolveView($this);
    }
}

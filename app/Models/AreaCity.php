<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Query\Builder;

/**
 * Class AreaCity
 * @mixin Builder
 */
class AreaCity extends Pivot
{
    use HasFactory;
    public $timestamps = false;

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function plans()
    {
        return $this->hasMany(Plan::class);
    }
}

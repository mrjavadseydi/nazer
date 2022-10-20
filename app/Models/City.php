<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

/**
 * Class City
 * @mixin Builder
 */
class City extends Model
{
    use HasFactory;

    public function areas()
    {
        return $this->belongsToMany(Area::class);
    }
    public function bank(){
        return $this->hasMany(Bank::class);
    }
}

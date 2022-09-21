<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

/**
 * Class Supervisor
 * @mixin Builder
 */
class Supervisor extends Model
{
    use HasFactory;

    public function plans()
    {
        return $this->hasMany(Plan::class);
    }

    public function observes()
    {
        return $this->hasMany(Observe::class);
    }
}

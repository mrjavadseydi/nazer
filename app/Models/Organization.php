<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

/**
 * Class Organization
 * @mixin Builder
 */
class Organization extends Model
{
    use HasFactory;

    public function plans()
    {
        return $this->hasMany(Plan::class);
    }
}

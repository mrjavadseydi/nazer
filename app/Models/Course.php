<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

/**
 * Class Course
 * @mixin Builder
 */
class Course extends Model
{
    use HasFactory;

    public function performers()
    {
        return $this->belongsToMany(Performer::class);
    }
}

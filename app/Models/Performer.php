<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

/**
 * Class Performer
 * @mixin Builder
 */
class Performer extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function plans()
    {
        return $this->hasMany(Plan::class);
    }

    public function observes()
    {
        return $this->hasMany(Observe::class);
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class);
    }
}

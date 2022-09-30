<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

/**
 * Class Plan
 * @mixin Builder
 */
class Plan extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function performer()
    {
        return $this->belongsTo(Performer::class);
    }

    public function supervisor()
    {
        return $this->belongsTo(Supervisor::class);
    }

    public function observes()
    {
        return $this->hasMany(Observe::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function documents()
    {
        return $this->belongsToMany(Document::class);
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function employers()
    {
        return $this->hasMany(Employer::class);
    }

    public function areaCity()
    {
        return $this->belongsTo(AreaCity::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

/**
 * Class Document
 * @mixin Builder
 */
class Document extends Model
{
    use HasFactory;

    public function plans()
    {
        return $this->belongsToMany(Plan::class);
    }

    public function image()
    {
        return $this->hasOne(Image::class);
    }
}

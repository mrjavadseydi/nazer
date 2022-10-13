<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Image extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = [];
    public function planObserve()
    {
        return $this->belongsTo(Observe::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function document()
    {
        return $this->belongsTo(Document::class);
    }
}

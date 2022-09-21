<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

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

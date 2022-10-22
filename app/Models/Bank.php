<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bank extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];
    public function branch(){
        return $this->hasMany(BankBranch::class);
    }
    public function city(){
        return $this->belongsTo(City::class);
    }

}

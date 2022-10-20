<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function branch(){
        return $this->hasMany(BankBranch::class);
    }
    public function city(){
        return $this->belongsTo(City::class);
    }

}

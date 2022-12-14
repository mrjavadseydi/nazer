<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BankBranch extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = [];
    public function city(){
        return $this->belongsTo(City::class);
    }
    public function bank(){
        return $this->belongsTo(Bank::class);
    }
}

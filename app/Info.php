<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Info extends Model
{
    protected $fillable = [
        'age', 'phoneNum', 'city', 'address',  
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'user_id'; 
    public $incrementing = false;      
    protected $fillable = [
        'user_id',
        'refresh_token',
    ];
}

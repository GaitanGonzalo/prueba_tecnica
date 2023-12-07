<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Communes extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_com',
        'description',
        'id_reg',
        'status'
    ];

    public $timestamps = false;

    public function getRouteKeyName(){
        return 'id_com';
    }
}

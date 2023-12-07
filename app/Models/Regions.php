<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Regions extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_reg',
        'description',
        'status'
    ];

    public $timestamps = false;

    public function getRouteKeyName(){
        return 'id_reg';
    }
}

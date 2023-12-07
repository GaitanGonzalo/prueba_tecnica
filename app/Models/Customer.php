<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'dni',
        'id_reg',
        'id_com',
        'email',
        'name',
        'last_name',
        'address',
        'date_reg',
        'status'
    ];
    public $timestamps = false;

    public function getRouteKeyName(){
        return 'dni';
    }

    public function communes()
    {
        return $this->hasOne(Communes::class, 'id_com', 'id_com');
    }

    public function regions()
    {
        return $this->hasOne(Regions::class, 'id_reg', 'id_reg');
    }
}

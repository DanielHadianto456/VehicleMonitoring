<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class driverModel extends Model
{
    use HasFactory;

    protected $table = 'driver';

    public $timestamps = false;

    protected $primaryKey = 'id_driver';
    
    protected $fillable = [
        'name',
        'status',
    ];
}

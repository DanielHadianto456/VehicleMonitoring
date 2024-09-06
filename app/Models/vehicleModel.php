<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class vehicleModel extends Model
{
    use HasFactory;

    protected $table = 'vehicle';
    public $timestamps = false;
    protected $primaryKey = 'id_vehicle';
    protected $fillable = [
        'name',
        'license',
        'owner',
        'type',
        'service_date',
        'status',
    ];
}

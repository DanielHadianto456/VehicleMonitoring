<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ordersModel extends Model
{
    use HasFactory;

    protected $table = 'orders';

    public $timestamps = false;

    protected $primaryKey = 'id_order';

    protected $fillable = [
        'id_driver',
        'id_vehicle',
        'id_user', // aprrover's id
        'admin_consent',
        'approver_consent',
        'date_created'
    ];

    public function driverDetails(){
        return $this->belongsTo(driverModel::class, 'id_driver', 'id_driver');
    }

    public function vehicleDetails(){
        return $this->belongsTo(vehicleModel::class, 'id_vehicle', 'id_vehicle');
    }

    public function approverDetails(){
        return $this->belongsTo(userModel::class, 'id_user', 'id_user');
    }

    public function orderDetails(){
        return $this->hasMany(detailOrderModel::class, 'id_order', 'id_order');
    }
}

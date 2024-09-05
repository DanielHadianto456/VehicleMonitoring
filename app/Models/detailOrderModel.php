<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class detailOrderModel extends Model
{
    use HasFactory;

    protected $table = 'detail_order';

    public $timestamps = false;

    protected $primaryKey = 'id_detail_order';
    
    protected $fillable = [
        'id_order',
        'fuel_usage',
        'used_at',
        'returned_at',
    ];

    public function orderDetails(){
        return $this->BelongsTo(ordersModel::class, 'id_order', 'id_order');
    }
}

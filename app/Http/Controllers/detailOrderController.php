<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ordersModel;
use App\Models\detailOrderModel;
use App\Models\driverModel;
use App\Models\vehicleModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class detailOrderController extends Controller
{
    //Function used to get all details of any orders with it's foreign key values
    public function getDetail(){
        $detail = detailOrderModel::with('orderDetails')->get();
        return response()->json($detail);
    }

    //Function used to get all details of an order based on id_detail_order
    // with it's foreign key values
    public function getDetailId($id){
        $detail = detailOrderModel::with('orderDetails')->find($id); //input id_detail_order
        return response()->json($detail);
    }
    
    //Function used to get all details of an order based on id_order
    // with it's foreign key values
    public function getDetailIdOrder($id){
        $detail = detailOrderModel::where('id_order', $id)::with('orderDetails')->first(); //input id_order
        return response()->json($detail);
    }
}

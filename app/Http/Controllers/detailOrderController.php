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
    public function getDetail()
    {
        $detail = detailOrderModel::with([
            'orderDetails',
            'orderDetails.driverDetails',
            'orderDetails.vehicleDetails',
            'orderDetails.approverDetails',
        ])->get();
        return response()->json($detail);
    }

    //Function used to get all details of an order based on id_detail_order
    // with it's foreign key values
    public function getDetailId($id)
    {
        $detail = detailOrderModel::with([
            'orderDetails',
            'orderDetails.driverDetails',
            'orderDetails.vehicleDetails',
            'orderDetails.approverDetails',
        ])->find($id); //input id_detail_order
        return response()->json($detail);
    }

    //Function used to get all details of an order based on id_order
    // with it's foreign key values
    public function getDetailIdOrder($id)
    {
        $detail = detailOrderModel::where('id_order', $id)::with([
            'orderDetails',
            'orderDetails.driverDetails',
            'orderDetails.vehicleDetails',
            'orderDetails.approverDetails',
        ])->first(); //input id_order
        return response()->json($detail);
    }

    //Function used to make order details
    public function addDetail(Request $req)
    {

        //Retrieves the current user 
        $user = Auth::user();

        //Checks if current user is admin or not
        if ($user->role == 'admin') {
            //Retrieves id_order from $req
            $order = $req->id_order;

            //Checks if an order has been approved by all parties
            $check = ordersModel::where('id_order', $order)->first();

            if ($check->admin_consent == 'approved' && $check->approver_consent == 'approved') {
                $validator = Validator::make($req->all(), [
                    'id_order' => 'required',
                ]);

                //If not, then an error message will be shown
                if ($validator->fails()) {
                    return response()->json($validator->errors()->toJson());
                }

                //If input is correct, then the data will be saved
                $save = detailOrderModel::create([
                    'id_order' => $req->get('id_order'),
                    'used_at' => now(),
                ]);

                if ($save) {
                    return response()->json(['status' => true, 'message' => 'Success']);
                } else {
                    return response()->json(['status' => false, 'message' => 'Failed to save']);
                }
            } else {
                return response()->json(['message' => 'Order not approved'], 401);
            }

        } else {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    }

    //Function used to report in fuel usage and vehicle return
    public function finishOrder(Request $req, $id)
    {

        //Retrieves the current user 
        $user = Auth::user();

        //Checks if current user is admin or not
        if ($user->role == 'admin') {

            //Finds detail that matches with $id provided in the parameter
            $orderDetail = detailOrderModel::find($id);

            //Finds order that matches with id_order provided from $orderDetail
            $order = ordersModel::find($orderDetail->id_order);

            //Validates input for fuel usage
            $validator = Validator::make($req->all(), [
                'fuel_usage' => 'required',
            ]);

            //If not, then an error message will be shown
            if ($validator->fails()) {
                return response()->json($validator->errors()->toJson());
            }

            //If input is correct, then the data will be updated
            $orderDetail->update([
                'returned_at' => now(),
                'fuel_usage' => $req->get('fuel_usage'),
            ]);

            //driver and vehicle are unassigned
            vehicleModel::where('id_vehicle', $order->id_vehicle)->update([
                'status' => 'unassigned',
            ]);
            driverModel::where('id_driver', $order->id_driver)->update([
                'status' => 'unassigned',
            ]);

            //If successful, returns a message
            //else returns an error
            if ($orderDetail) {
                return response()->json(['status' => true, 'message' => 'Success']);
            } else {
                return response()->json(['status' => false, 'message' => 'Failed to update']);
            }

        } else {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    }


}

<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\driverModel;
use Illuminate\Support\Facades\Validator;

class driverController extends Controller
{
    //Function used to get all driver data
    public function getDriver(){
        $order = driverModel::get();
        return response()->json($order);
    }

    //Function used to get specific driver data based on id
    public function getDriverId($id){
        $vehicle = driverModel::find($id);
        return response()->json($vehicle);
    }

    //Function used to add new driver
    public function addDriver(Request $req)
    {   
        //Checks if input is correct or not
        $validator = Validator::make($req->all(), [
            'name' => 'required',
        ]);
        
        //If not, then an error message will be shown
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson());
        }

        //If input is correct, then the data will be saved
        $save = driverModel::create([
            'name' => $req->get('name'),
            'status' => 'unassigned'
        ]);

        //If data is saved, then a success message will be shown
        //else an error message will be shown
        if ($save) {
            return response()->json(['status' => true, 'message' => 'Success']);
        } else {
            return response()->json(['status' => false, 'message' => 'Failed to save']);
        }
    }

    //Function used to update driver data
    public function updateDriver(Request $req, $id)
    {
        //Checks if input is correct or not
        $validator = Validator::make($req->all(), [
            'name' => 'required',
        ]);

        //If not, then an error message will be shown
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson());
        }

        //If input is correct, then the data will be updated
        $update = driverModel::where('id_driver', $id)->update([
            'name' => $req->get('name'),
        ]);

        //If data is saved, then a success message will be shown
        //else an error message will be shown
        if ($update) {
            return response()->json(['status' => true, 'message' => 'Success']);
        } else {
            return response()->json(['status' => false, 'message' => 'Failed to update']);
        }
    }

    //Function used to update driver status into assinged
    public function assignDriver($id)
    {
        //If input is correct, then the data will be updated
        $update = driverModel::where('id_driver', $id)->update([
            'status' => 'assigned'
        ]);

        //If data is saved, then a success message will be shown
        //else an error message will be shown
        if ($update) {
            return response()->json(['status' => true, 'message' => 'Success']);
        } else {
            return response()->json(['status' => false, 'message' => 'Failed to update']);
        }
    }

    //Function used to update driver status into unassinged
    public function unassignDriver($id)
    {
        //If input is correct, then the data will be updated
        $update = driverModel::where('id_driver', $id)->update([
            'status' => 'unassigned'
        ]);

        //If data is saved, then a success message will be shown
        //else an error message will be shown
        if ($update) {
            return response()->json(['status' => true, 'message' => 'Success']);
        } else {
            return response()->json(['status' => false, 'message' => 'Failed to update']);
        }
    }

    //Function used to delete driver
    public function deleteDriver($id){
        //If data is deleted, then a success message will be shown
        $delete = driverModel::where('id_driver', $id)->delete();
        
        if ($delete) {
            return response()->json(['status' => true, 'message' => 'Success']);
        } else {
            return response()->json(['status' => false, 'message' => 'Failed to delete']);
        }
    }
}

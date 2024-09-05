<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\vehicleModel;
use Illuminate\Support\Facades\Validator;

class vehicleController extends Controller
{

    //Function used to get all vehicle data
    public function getVehicle(){
        $order = vehicleModel::get();
        return response()->json($order);
    }

    //Function used to add new vehicle
    public function addVehicle(Request $req)
    {   
        //Checks if input is correct or not
        $validator = Validator::make($req->all(), [
            'license' => 'required',
            'owner' => 'required',
            'type' => 'required',
            'service_date' => 'required',
        ]);
        
        //If not, then an error message will be shown
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson());
        }

        //If input is correct, then the data will be saved
        $save = vehicleModel::create([
            'license' => $req->get('license'),
            'owner' => $req->get('owner'),
            'type' => $req->get('type'),
            'service_date' => $req->get('service_date'),
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

    //Function used to update vehicle data
    public function updateVehicle(Request $req, $id)
    {
        //Checks if input is correct or not
        $validator = Validator::make($req->all(), [
            'license' => 'required',
            'owner' => 'required',
            'type' => 'required',
            'service_date' => 'required',
        ]);

        //If not, then an error message will be shown
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson());
        }

        //If input is correct, then the data will be updated
        $update = vehicleModel::where('id_vehicle', $id)->update([
            'license' => $req->get('license'),
            'owner' => $req->get('owner'),
            'type' => $req->get('type'),
            'service_date' => $req->get('service_date'),
        ]);

        //If data is saved, then a success message will be shown
        //else an error message will be shown
        if ($update) {
            return response()->json(['status' => true, 'message' => 'Success']);
        } else {
            return response()->json(['status' => false, 'message' => 'Failed to update']);
        }
    }

    //Function used to update vehicle status into unassinged
    public function unassignVehicle($id)
    {
        //If input is correct, then the data will be updated
        $update = vehicleModel::where('id_vehicle', $id)->update([
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

    //Function used to delete vehicle
    public function deleteVehicle($id){
        //If data is deleted, then a success message will be shown
        $delete = vehicleModel::where('id_vehicle', $id)->delete();
        
        if ($delete) {
            return response()->json(['status' => true, 'message' => 'Success']);
        } else {
            return response()->json(['status' => false, 'message' => 'Failed to delete']);
        }
    }
}

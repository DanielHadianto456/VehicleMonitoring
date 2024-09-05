<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ordersModel;
use App\Models\driverModel;
use App\Models\vehicleModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class ordersController extends Controller
{
    //Function used to get all order data
    public function getOrder()
    {
        //Joins data from 3 tables
        $order = ordersModel::with(['driverDetails', 'vehicleDetails', 'approverDetails'])->get();
        return response()->json($order);
    }

    //Function used to add new order
    public function addOrder(Request $req)
    {
        //Gets vehicle and driver data based on it's primary key inputed 
        $vehicle = vehicleModel::find($req->get('id_vehicle'));
        $driver = driverModel::find($req->get('id_driver'));

        //Checks if vehicle and driver is already assigned
        //If yes, then an error would show, if not then the code will proceed
        if ($vehicle->status != 'unassigned' || $driver->status != 'unassigned') {
            return response()->json(['status' => false, 'message' => 'Vehicle or Driver already assigned']);
        } else {
            //Checks if input is correct or not
            $validator = Validator::make($req->all(), [
                'id_driver' => 'required',
                'id_vehicle' => 'required',
                'id_user' => 'required',
            ]);

            //If not, then an error message will be shown
            if ($validator->fails()) {
                return response()->json($validator->errors()->toJson());
            }

            //If input is correct, then the data will be saved
            $save = ordersModel::create([
                'id_driver' => $req->get('id_driver'),
                'id_vehicle' => $req->get('id_vehicle'),
                'id_user' => $req->get('id_user'),
                'admin_consent' => 'pending',
                'approver_consent' => 'pending',
            ]);

            //Gives pending status to vehicle and driver
            vehicleModel::where('id_vehicle', $req->get('id_vehicle'))->update([
                'status' => 'pending'
            ]);
            driverModel::where('id_driver', $req->get('id_driver'))->update([
                'status' => 'pending'
            ]);

            //If data is saved, then a success message will be shown
            //else an error message will be shown
            if ($save) {
                return response()->json(['status' => true, 'message' => 'Success']);
            } else {
                return response()->json(['status' => false, 'message' => 'Failed to save']);
            }
        }

    }

    //Function used to update order data
    public function updateOrder(Request $req, $id)
    {
        //Checks if input is correct or not
        $validator = Validator::make($req->all(), [
            'id_driver' => 'required',
            'id_vehicle' => 'required',
            'id_user' => 'required',
        ]);

        //If not, then an error message will be shown
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson());
        }

        //If input is correct, then the data will be updated
        $update = ordersModel::where('id_order', $id)->update([
            'id_driver' => $req->get('id_driver'),
            'id_vehicle' => $req->get('id_vehicle'),
            'id_user' => $req->get('id_user'),
        ]);

        //If data is saved, then a success message will be shown
        //else an error message will be shown
        if ($update) {
            return response()->json(['status' => true, 'message' => 'Success']);
        } else {
            return response()->json(['status' => false, 'message' => 'Failed to update']);
        }
    }

    //Function used to approve order as admin
    public function adminConsentApprove($id)
    {
        //searches current user based on auth
        $user = Auth::user();

        //checks if user is an admin
        if ($user->role == 'admin') {
            //searches selected order based on id to approve
            $approve = ordersModel::where('id_order', $id)->update([
                'admin_consent' => 'approved'
            ]);

            //Calls a method to update driver and vehicle status 
            //based on the approval status from both parties
            $this->updateDriverAndVehicleStatus($id);

            //returns a message upon successful approval
            //else an error message will be shown
            if ($approve) {
                return response()->json(['status' => true, 'message' => 'Success']);
            } else {
                return response()->json(['status' => false, 'message' => 'Failed to update']);
            }
        } else {
            return response()->json(['status' => false, 'message' => 'Unauthorized']);
        }

    }

    //Function used to approve order as approver
    public function approverConsentApprove($id)
    {
        //searches current user based on auth
        $user = Auth::user();

        //checks if user is an approver
        if ($user->role == 'approver') {
            //searches selected order based on id to approve
            $approve = ordersModel::where('id_order', $id)->update([
                'approver_consent' => 'approved'
            ]);

            //Calls a method to update driver and vehicle status 
            //based on the approval status from both parties
            $this->updateDriverAndVehicleStatus($id);

            //returns a message upon successful approval
            //else an error message will be shown
            if ($approve) {
                return response()->json(['status' => true, 'message' => 'Success']);
            } else {
                return response()->json(['status' => false, 'message' => 'Failed to update']);
            }
        } else {
            return response()->json(['status' => false, 'message' => 'Unauthorized']);
        }
    }

    //Function used to disapprove order as admin
    public function adminConsentDisapprove($id)
    {

        //searches current user based on auth
        $user = Auth::user();

        //checks if user is an admin
        if ($user->role == 'admin') {
            //searches selected order based on id to approve
            $update = ordersModel::where('id_order', $id)->update([
                'admin_consent' => 'disapproved'
            ]);

            //Calls a method to update driver and vehicle status 
            //based on the approval status from both parties
            $this->updateDriverAndVehicleStatus($id);

            //returns a message upon successful approval
            //else an error message will be shown
            if ($update) {
                return response()->json(['status' => true, 'message' => 'Success']);
            } else {
                return response()->json(['status' => false, 'message' => 'Failed to update']);
            }
        } else {
            return response()->json(['status' => false, 'message' => 'Unauthorized']);
        }


    }

    //Function used to approve order as approver
    public function approverConsentDisapprove($id)
    {
        //searches current user based on auth
        $user = Auth::user();

        //checks if user is an approver
        if ($user->role == 'approver') {
            //searches selected order based on id to approve
            $update = ordersModel::where('id_order', $id)->update([
                'approver_consent' => 'disapproved'
            ]);

            //Calls a method to update driver and vehicle status 
            //based on the approval status from both parties
            $this->updateDriverAndVehicleStatus($id);

            //returns a message upon successful approval
            //else an error message will be shown
            if ($update) {
                return response()->json(['status' => true, 'message' => 'Success']);
            } else {
                return response()->json(['status' => false, 'message' => 'Failed to update']);
            }
        } else {
            return response()->json(['status' => false, 'message' => 'Unauthorized']);
        }
    }

    //Function used to delete order
    public function deleteOrder($id)
    {
        //Finds order data using primary key that matches with $id
        $order = ordersModel::find($id);

        //Updates the status of vehicle and driver to unassigned
        //based on the driver and vehicle id avaliable in the order data
        vehicleModel::where('id_vehicle', $order->id_vehicle)->update([
            'status' => 'unassigned'
        ]);
        driverModel::where('id_driver', $order->id_driver)->update([
            'status' => 'unassigned'
        ]);

        //Deletes order data
        $delete = $order->delete();

        //returns a message upon successful approval
        //else an error message will be shown
        if ($delete) {
            return response()->json(['status' => true, 'message' => 'Success']);
        } else {
            return response()->json(['status' => false, 'message' => 'Failed to delete']);
        }
    }

    //Function used to update the status of driver and vehicle 
    //into either assigned or unassigned
    private function updateDriverAndVehicleStatus($id)
    {
        // Find the order to get the vehicle and driver IDs
        $order = ordersModel::find($id);

        if (!$order) {
            return response()->json(['status' => false, 'message' => 'Order not found']);
        }

        // Retrieve vehicle and driver IDs
        $vehicleId = $order->id_vehicle;
        $driverId = $order->id_driver;

        // Retrieve vehicle and driver records
        $vehicle = vehicleModel::find($vehicleId);
        $driver = driverModel::find($driverId);

        // Check if vehicle and driver exist
        if (!$vehicle || !$driver) {
            return response()->json(['status' => false, 'message' => 'Vehicle or Driver not found']);
        }

        // Gets both admin and approver consents current status
        $adminConsent = $order->admin_consent;
        $approverConsent = $order->approver_consent;

        // Checks if both consents are approved or not
        if ($adminConsent == 'approved' && $approverConsent == 'approved') {
            // Assigns vehicle and driver if both parties approve
            $vehicle->status = 'assigned';
            $driver->status = 'assigned';
        } elseif ($adminConsent == 'disapproved' && $approverConsent == 'disapproved') {
            // Unassigns vehicle and driver if there's a dissaproval
            $vehicle->status = 'unassigned';
            $driver->status = 'unassigned';
        } else {
            // Pending or other states can be handled here if needed
        }

        // Save the updated vehicle and driver records
        $vehicle->save();
        $driver->save();

    }
}

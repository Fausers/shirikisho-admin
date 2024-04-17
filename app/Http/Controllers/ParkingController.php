<?php

namespace App\Http\Controllers;

use App\Models\Parking;
use App\Models\ServiceModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class ParkingController extends Controller
{
    ## Driver ###
    public function parking()
    {

        $ServicesModel = new ServiceModel();
        $region = $ServicesModel->getRegion();
        return view('parking.parking', compact('region'));
    }

    public function parking_view()
    {
        $parkingModel = new Parking();
        $ServicesModel = new ServiceModel();
        $data = $parkingModel->getAllParking();

        return view('parking.parking_view', compact('data', 'parkingModel', 'ServicesModel'));
    }

    public function saveParking(Request $request)
    {

        try {
            DB::beginTransaction();

            // Explicitly define variables based on form fields
            $hidden_id = $request->input('hidden_id');
            $park_name = $request->input('park_name');
            $number_of_members = $request->input('number_of_members');
            $park_owner = $request->input('park_owner');
            $region_id = $request->input('region_id');
            $district_id = $request->input('district_id');
            $ward_id = $request->input('ward_id');
            $vehicle_type = $request->input('vehicle_type');

            $user_id = Auth::user()->id;


            function generateParkId()
            {
                $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
                $randomString = '';
                $length = 20; // Adjust the length of the driver_id as needed

                // Generate a random string
                for ($i = 0; $i < $length; $i++) {
                    $randomString .= $characters[rand(0, strlen($characters) - 1)];
                }

                // Append the "_DRVER" suffix
                $randomString .= '_PARK';

                return $randomString;
            }

            // Check if driver_id exists, generate a new one if needed
            $parkIdExists = true;
            while ($parkIdExists) {
                $newParkId = generateParkId();
                $existingDriver = DB::table('parking_area')->where('park_id', $newParkId)->first();
                if (!$existingDriver) {
                    $parkIdExists = false;
                }
            }


            if (empty($hidden_id)) :

                ## staff
                $data = [
                    'park_id' => $newParkId,
                    'park_name' => $park_name,
                    'number_of_members' => $number_of_members,
                    'park_owner' => $park_owner,
                    'region_id' => $region_id,
                    'district_id' => $district_id,
                    'ward_id' => $ward_id,
                    'vehicle_type' => $vehicle_type,
                    'created_by' => $user_id,
                    'updated_by' => $user_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
                $insert_id = DB::table('parking_area')->insertGetId($data);

                $message = 'Parking saved successfully';
            // ActivityLog::logActivity($message);

            else :
                ## update inventory
                $data = [
                    'park_name' => $park_name,
                    'number_of_members' => $number_of_members,
                    'park_owner' => $park_owner,
                    'region_id' => $region_id,
                    'district_id' => $district_id,
                    'ward_id' => $ward_id,
                    'vehicle_type' => $vehicle_type,
                    'updated_by' => $user_id,
                    'updated_at' => now(),
                ];

                $condition = [
                    'id' => Crypt::decrypt($hidden_id),
                    'archive' => 0
                ];
                DB::table('parking_area')->where($condition)->update($data);
                $message = 'Parking updated successfully';
            // ActivityLog::logActivity($message);

            endif;

            DB::commit();

            return response()->json(['status' => 200, 'message' => $message]);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json(['status' => 500, 'message' => $e->getMessage()]);
        }
    }


    public function editParking($id)
    {
        $ServicesModel = new ServiceModel();
        $parkingModel = new Parking();
        $data = $parkingModel->getParkingRow($id);

        $region = $ServicesModel->getRegionRow($data->region_id);
        $district = $ServicesModel->getDistrictRow($data->district_id);
        $ward = $ServicesModel->getWardRow($data->ward_id);
        echo json_encode(['data' => $data, 'id' => Crypt::encrypt($id), 'region' => $region, 'district' => $district, 'ward' => $ward]);
    }

    public function deleteParking($id)
    {
        try {
            $parkingModel = new Parking();
            $parkingModel->deleteParking($id);

            $message = 'Parking deleted successfull' . $id;

            // ActivityLog::logActivity($message);

            return response()->json(['status' => 200, 'message' => $message]);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'message' => $e->getMessage()]);
        }
    }

    public function viewParking($id)
    {
        try {
            $parkingModel = new Parking();
            $data = $parkingModel->getParkingRow($id);

            $message = 'Parking successfull fetched';
            return response()->json(['status' => 200, 'message' => $message, 'data' => $data]);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'message' => $e->getMessage()]);
        }
    }
}

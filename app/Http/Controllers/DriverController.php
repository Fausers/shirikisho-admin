<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\NextSMSModel;
use App\Models\UserOTP;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class DriverController extends Controller
{

    ## Driver ###
    public function driver()
    {
        $driverModel = new Driver();

        // $country = $driverModel->getCountry();
        // $user_role = $driverModel->getUserRole();
        return view('driver.driver');
    }

    public function driver_view()
    {
        $driverModel = new Driver();
        $data = $driverModel->getAllDrivers();
        return view('driver.driver_view', compact('data', 'driverModel'));
    }

    public function driverSave(Request $request)
    {
        $request->validate([
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            DB::beginTransaction();

            // Explicitly define variables based on form fields
            $hidden_id = $request->input('hidden_id');
            $full_name = $request->input('full_name');
            $phone_number = $request->input('phone_number');
            $gender = $request->input('gender');
            $dob = $request->input('dob');
            $marital_status = $request->input('marital_status');
            $residence_address = $request->input('residence_address');
            $license_number = $request->input('license_number');
            $vehicle_type = $request->input('vehicle_type');
            $vehicle_number = $request->input('vehicle_number');
            $ownership = $request->input('ownership');
            $vehicle_owner_name = $request->input('vehicle_owner_name');
            $vehicle_owner_phone = $request->input('vehicle_owner_phone');

            $user_id = Auth::user()->id;




            if (empty($hidden_id)) {
                ## Insert new driver

                $existingDriver = DB::table('users')->where('phone_number', $phone_number)->first();

                if ($existingDriver) {
                    // Phone number already exists
                    $message = 'Phone number already exists.';
                    DB::rollBack();
                    return response()->json(['status' => 400, 'message' => $message]);
                }

                // Generate a random numeric string of 6 digits
                // $password = str_pad(rand(0, pow(10, 6) - 1), 6, '0', STR_PAD_LEFT);
                do {
                    $otpCode = mt_rand(100000, 999999);
                } while (UserOTP::where('otp_code', $otpCode)->exists());


                $data = [
                    'full_name' => $full_name,
                    'phone_number' => $phone_number,
                    'gender' => $gender,
                    'dob' => $dob,
                    'marital_status' => $marital_status,
                    'residence_address' => $residence_address,
                    'license_number' => $license_number,
                    'profile_image' => $request->hasFile('profile_image') ? $request->file('profile_image')->store('drivers', 'public') : null,
                    // 'password' => Hash::make($password),
                    'created_by' => $user_id,
                    'updated_by' => $user_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                $insertedDriverId = DB::table('users')->insertGetId($data);



                UserOTP::create([
                    'otp_code' => $otpCode,
                    'user_id' => $user_id,
                    'created_user_id' => $insertedDriverId,
                    'created_by' => $user_id,
                    'updated_by' => $user_id,
                ]);

                $messages = $otpCode . ' Ni Namba yako ya uhakiki';
                $reference = 'Humtech';
                $this->sendSms($phone_number, $messages, $reference);

                $message = 'Driver saved successfully';
            } else {
                ## Update existing driver

                $existingPhoneNumber = DB::table('users')->where('id', Crypt::decrypt($hidden_id))->value('phone_number');
                $existingProfileImage = DB::table('users')->where('id', Crypt::decrypt($hidden_id))->value('profile_image');

                $data = [
                    'full_name' => $full_name,
                    'phone_number' => empty($phone_number) ? $existingPhoneNumber : $phone_number,
                    'gender' => $gender,
                    'dob' => $dob,
                    'marital_status' => $marital_status,
                    'residence_address' => $residence_address,
                    'license_number' => $license_number,
                    'updated_by' => $user_id,
                    'updated_at' => now(),
                    'profile_image' => $request->hasFile('profile_image') ? $request->file('profile_image')->store('drivers', 'public') : ($existingProfileImage ?: null),
                ];

                $condition = [
                    'id' => Crypt::decrypt($hidden_id),
                    'archive' => 0
                ];

                DB::table('users')->where($condition)->update($data);

                $message = 'Driver updated successfully';
            }

            DB::commit();

            return response()->json(['status' => 200, 'message' => $message]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['status' => 500, 'message' => $e->getMessage()]);
        }
    }

    public function updateDrive(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'profile_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gender' => 'required',
            'dob' => 'required',
            'marital_status' => 'required',
            'residence_address' => 'required',
            'license_number' => 'required',
            'vehicle_type' => 'required',
            'vehicle_number' => 'required',
            'ownership' => 'required',
        ]);

        if ($validator->fails()) {
            DB::rollBack();
            return response()->json(['status' => 400, 'message' => 'Validation failed', 'errors' => $validator->errors()], 400);
        }


        try {
            DB::beginTransaction();

            // Update user details
            $user = DB::table('users')->where('id', $id)->first();

            $full_name = $request->input('full_name') ?? $user->full_name;
            $phone_number = $request->input('phone_number') ?? $user->phone_number;
            $gender = $request->input('gender') ?? $user->gender;
            $dob = $request->input('dob') ?? $user->dob;
            $marital_status = $request->input('marital_status') ?? $user->marital_status;
            $residence_address = $request->input('residence_address') ?? $user->residence_address;
            $license_number = $request->input('license_number') ?? $user->license_number;
            $profile_image = $request->hasFile('profile_image') ? $request->file('profile_image')->store('drivers', 'public') : ($user->profile_image ?: null);

            $password = str_pad(rand(0, pow(10, 6) - 1), 6, '0', STR_PAD_LEFT);

            $parking_id = $request->input('parking_id');
            $association_id = $request->input('association_id');
            $health_insurance = $request->input('health_insurance');

            $user_id = Auth::user()->id;


            function generateDriverId()
            {
                $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
                $randomString = '';
                $length = 20; // Adjust the length of the driver_id as needed

                // Generate a random string
                for ($i = 0; $i < $length; $i++) {
                    $randomString .= $characters[rand(0, strlen($characters) - 1)];
                }

                // Append the "_DRVER" suffix
                $randomString .= '_DRVER';

                return $randomString;
            }

            // Check if driver_id exists, generate a new one if needed
            $driverIdExists = true;
            while ($driverIdExists) {
                $newDriverId = generateDriverId();
                $existingDriver = DB::table('users')->where('driver_id', $newDriverId)->first();
                if (!$existingDriver) {
                    $driverIdExists = false;
                }
            }


            $userData = [
                'driver_id' => $newDriverId,
                'full_name' => $full_name,
                'phone_number' => $phone_number,
                'gender' => $gender,
                'dob' => $dob,
                'marital_status' => $marital_status,
                'residence_address' => $residence_address,
                'license_number' => $license_number,
                'password' => Hash::make($password),
                'updated_by' => $user_id,
                'updated_at' => now(),
                'profile_image' => $profile_image,


                'parking_id' => $parking_id,
                'association_id' => $association_id,
                'health_insurance' => $health_insurance,
                'park_id' => $parking_id,
                'chama_id' => $association_id,
            ];

            $userCondition = [
                'id' => $id,
                'archive' => 0
            ];

            DB::table('users')->where($userCondition)->update($userData);

            // Update or insert vehicle details
            $vehicleData = [
                'driver_id' => $newDriverId,
                'vehicle_type' => $request->input('vehicle_type'),
                'vehicle_number' => $request->input('vehicle_number'),
                'vehicle_insurance' => $request->input('vehicle_insurance'),
                'ownership' => $request->input('ownership'),
                'vehicle_owner_name' => $request->input('vehicle_owner_name'),
                'vehicle_owner_phone' => $request->input('vehicle_owner_phone'),
                'user_id' => $id,
                'created_by' => $user_id,
                'updated_by' => $user_id,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            DB::table('user_vehicle')->insert($vehicleData);

            // Update or insert next of kin details
            $nextOfKinData = [
                'driver_id' => $newDriverId,
                'name' => $request->input('next_of_name'),
                'phone' => $request->input('next_of_phone'),
                'user_id' => $id,
                'created_by' => $user_id,
                'updated_by' => $user_id,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            DB::table('next_of_kins')->insert($nextOfKinData);

            DB::commit();

            $messages = 'Hongera kwa kusajiliwa kwenye Mfumo wa Shirikisho, Password yako ni ' . $password;
            $reference = 'Humtech';
            $this->sendSms($phone_number, $messages, $reference);

            return response()->json(['status' => 200, 'message' => 'Driver updated successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['status' => 500, 'message' => $e->getMessage()]);
        }
    }


    public function sendSms($recipientNumber, $message, $reference)
    {

        try {
            $nextSMSModel = new NextSMSModel();
            $result = $nextSMSModel->sendSms($recipientNumber, $message, $reference);

            // Define the status based on the result
            $status = $result ? 'success' : 'failed';
            $httpStatus = $result ? 200 : 422;

            // Return the response with status, message, and HTTP status code
            return response()->json(['status' => $httpStatus, 'message' => $status, 'result' => $result ? 'SMS sent successfully' : 'Failed to send SMS'], $httpStatus);
        } catch (\Exception $e) {
            // Handle any exceptions that occurred during sending the SMS
            return response()->json(['status' => 500, 'message' => 'error',  'result' => $e->getMessage()]);
        }
    }

    public function editDriver($id)
    {
        $driverModel = new Driver();
        $data = $driverModel->getDriverRow($id);
        echo json_encode(['data' => $data,  'id' => Crypt::encrypt($id),]);
    }

    public function viewDiver($id)
    {
        $driverModel = new Driver();
        $data = $driverModel->getDriverRow($id);
        echo json_encode(['data' => $data,  'id' => Crypt::encrypt($id),]);
    }

    public function deleteDriver($id)
    {
        try {
            $driverModel = new Driver();
            $driverModel->deleteDriver($id);

            $message = 'Driver deleted successfull' . $id;

            // ActivityLog::logActivity($message);

            return response()->json(['status' => 200, 'message' => $message]);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'message' => $e->getMessage()]);
        }
    }

    public function getDrivers()
    {

        $drivers = DB::table('users')->get();
        return response()->json(['data' => $drivers, 'messages' => 'successfull fetched']);
    }
}

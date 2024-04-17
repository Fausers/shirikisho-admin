<?php

namespace App\Http\Controllers;

use App\Models\Association;
use App\Models\NextSMSModel;
use App\Models\Parking;
use App\Models\ServiceModel;
use App\Models\User;
use App\Models\UserOTP;
use App\Traits\PhoneNumberTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ApiController extends Controller
{

    private $ServicesModel;

    function __construct()
    {
        $user = Auth::user();
        $ServicesModel = new ServiceModel();
        $this->ServicesModel = $ServicesModel;
    }
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'phone_number' => 'required',
                'password' => 'required',
                'device_name' => 'required',
            ]);

            $phone_format = new PhoneNumberTrait;

            $user = User::where('phone_number', trim($phone_format->clearNumber($request->phone_number),'+'))->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                if (!$user) {
                    DB::rollBack();
                    return response()->json(['status' => 422, 'message' => 'error', 'error' => 'The provided phone number is incorrect.']);
                } else {
                    DB::rollBack();
                    return response()->json(['status' => 422, 'message' => 'error', 'error' => 'The provided password is incorrect.']);
                }
            }



            // Check if OTP already exists for the user
            $existingOTP = UserOTP::where('user_id', $user->id)->first();
            if (empty($existingOTP)) {

                do {
                    $otpCode = mt_rand(100000, 999999);
                } while (UserOTP::where('otp_code', $otpCode)->exists());


                // Send OTP via SMS
                $smsSent = (new NextSMSModel())->sendSms($user->phone_number, $otpCode . " Ni Namba yako ya uhakiki", 'Humtech');

                if ($smsSent) {
                    // Store OTP code in the database
                    UserOTP::create([
                        'otp_code' => $otpCode,
                        'user_id' => $user->id,
                        'created_by' => $user->id,
                        'updated_by' => $user->id,
                    ]);

                    DB::commit();
                    // return response()->json();
                } else {
                    DB::rollBack();
                    return response()->json(['error' => 'Failed to send OTP']);
                }
            } else {
                $expiredOTP = UserOTP::where('user_id', $user->id)
                    ->where('created_at', '<', now()->subMinute())
                    ->delete();

                if ($expiredOTP) {
                    do {
                        $otpCode = mt_rand(100000, 999999);
                    } while (UserOTP::where('otp_code', $otpCode)->exists());


                    // Send OTP via SMS
                    $smsSent = (new NextSMSModel())->sendSms($user->phone_number, $otpCode . " Ni Namba yako ya uhakiki", 'Humtech');

                    if ($smsSent) {
                        // Store OTP code in the database
                        UserOTP::create([
                            'otp_code' => $otpCode,
                            'user_id' => $user->id,
                            'created_by' => $user->id,
                            'updated_by' => $user->id,
                        ]);

                        DB::commit();
                        // return response()->json();
                    } else {
                        DB::rollBack();
                        return response()->json(['error' => 'Failed to send OTP']);
                    }
                }
            }

            DB::commit();

            return response()->json([
                'status' => 200,
                'message' => 'success',
                'token' => $user->createToken($request->device_name)->plainTextToken,
                // 'code' => $otpCode,
                // 'user' => [
                //     'id' => $user->id,
                //     'full_name' => $user->full_name,
                //     'email' => $user->email,
                //     'phone_number' => $user->phone_number,
                //     'gender' => $user->gender,
                //     'status' => $user->status,
                //     'uniform_status' => $user->uniform_status,
                //     'profile_image' => $user->profile_image,
                //     'license_number' => $user->license_number,
                //     'marital_status' => $user->marital_status,
                //     'dob' => $user->dob,
                //     'residence_address' => $user->residence_address,
                //     'parking_id' => $user->parking_id,
                //     'created_at' => $user->created_at,
                //     'updated_at' => $user->updated_at
                // ],
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 422,
                'message' => 'error',
                'error' => $e->getMessage()
            ]);
        }
    }

    public function verifyLoginUser(Request $request)
    {

        // Begin a database transaction
        DB::beginTransaction();

        try {
            $request->validate([
                'login_user' => 'required',
            ]);

            $user = Auth::user();
            $otpCode = $request->input('login_user');


            $userOTP = UserOTP::where('user_id', $user->id)
                ->where('otp_code', $otpCode)
                ->first();

            if ($userOTP) {
                $userLogin = User::where('id', $userOTP->user_id)->first();
                DB::commit();
                return response()->json([
                    'status' => 200,
                    'message' => 'success',
                    'user' => [
                        'id' => $userLogin->id,
                        'first_name' => $userLogin->first_name,
                        'middle_name' => $userLogin->middle_name,
                        'last_name' => $userLogin->last_name,
                        'phone_number' => $userLogin->phone_number,
                        'gender' => $userLogin->gender,
                        'status' => $userLogin->status,
                        'uniform_status' => $userLogin->uniform_status,
                        'profile_image' => $userLogin->profile_image,
                        'license_number' => $userLogin->license_number,
                        'marital_status' => $userLogin->marital_status,
                        'dob' => $userLogin->dob,
                        'residence_address' => $userLogin->residence_address,
                        'parking_id' => $userLogin->parking_id,
                    ],
                ]);
            } else {
                // Handle case where the created user is not found
                return response()->json([
                    'status' => 400,
                    'message' => 'The user associated with the OTP code was not found.',
                    'error' => 'User not found',
                ]);
            }
        } catch (Exception $e) {
            // Handle exceptions
            DB::rollback();
            return response()->json(['status' => 500, 'message' => 'Internal Server Error', 'error' => $e->getMessage()]);
        }
    }
    public function verifyUser(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'identifier' => 'required',
            ]);

            $identifier = $request->input('identifier');

            $user = User::where('phone_number', $identifier)
                ->orWhere('uniform_status', $identifier)
                ->first();

            // Check if the user exists
            if ($user) {
                DB::commit();
                return response()->json([
                    'status' => 200,
                    'message' => 'User verified successfully',
                    'user' => [
                        'id' => $user->id,
                        'full_name' => $user->full_name,
                        'phone_number' => $user->phone_number,
                        'status' => $user->status,
                        'uniform_status' => $user->uniform_status,
                        'profile_image' => $user->profile_image,
                        'parking_id' => $user->parking_id,
                    ],
                ]);
            } else {
                DB::rollBack();
                return response()->json([
                    'status' => 404,
                    'message' => 'User not found',
                ]);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 500,
                'message' => 'Internal Server Error',
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function otpCode(Request $request)
    {
        // Begin a database transaction
        DB::beginTransaction();

        try {
            $request->validate([
                'otp_code' => 'required',
            ]);

            $user = Auth::user();
            $otpCode = $request->input('otp_code');

            // Delete existing OTP if its created_at time is more than one minute ago
            // $existingOTP = UserOTP::where(['user_id' => $user->id, 'otp_code' => $otpCode])
            //     ->where('created_at', '<', now()->subMinute())
            //     ->delete();

            // // Check if the user needs to log in to get a new OTP
            // if ($existingOTP) {
            //     DB::rollBack();
            //     return response()->json(['status' => 200, 'message' => 'OTP has already expired. Please log in to get a new OTP.']);
            // }


            $userOTP = UserOTP::where('user_id', $user->id)
                ->where('otp_code', $otpCode)
                ->first();

            if ($userOTP) {

                $createdUser = User::where('id', $userOTP->created_user_id)->first();

                if ($createdUser) {
                    DB::commit();
                    return response()->json([
                        'status' => 200,
                        'message' => 'success',
                        // Created user
                        'user' => [
                            'id' => $createdUser->id,
                            'full_name' => $createdUser->full_name,
                            'phone_number' => $createdUser->phone_number,
                            'gender' => $createdUser->gender,
                            'status' => $createdUser->status,
                            'uniform_status' => $createdUser->uniform_status,
                            'profile_image' => $createdUser->profile_image,
                            'license_number' => $createdUser->license_number,
                            'marital_status' => $createdUser->marital_status,
                            'dob' => $createdUser->dob,
                            'residence_address' => $createdUser->residence_address,
                            'parking_id' => $createdUser->parking_id,
                        ],
                    ]);
                } else {
                    // Handle case where the created user is not found
                    return response()->json([
                        'status' => 400,
                        'message' => 'The user associated with the OTP code was not found.',
                        'error' => 'User not found',
                    ]);
                }
            } else {
                // Redirect with error message if OTP is invalid
                return response()->json(['status' => 400, 'message' => 'Please enter a valid OTP.', 'error' => 'error',]);
            }
        } catch (Exception $e) {
            // Handle exceptions
            DB::rollback();
            return response()->json(['status' => 500, 'message' => 'Internal Server Error', 'error' => $e->getMessage()]);
        }
    }

    public function getRegion()
    {

        try {

            $data = $this->ServicesModel->getRegion();

            return response()->json(['status' => 200, 'message' => 'Regions fetched successfull', 'data' => $data]);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'message' => $e->getMessage()]);
        }
    }
    public function regionDistrict($id)
    {
        try {
            $data = $this->ServicesModel->getRegionDistrict($id);

            return response()->json(['status' => 200, 'message' => 'Region Districts fetched successfull', 'data' => $data]);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'message' => $e->getMessage()]);
        }
    }
    public function districtWard($id)
    {
        try {
            $data = $this->ServicesModel->getDistrictWard($id);

            return response()->json(['status' => 200, 'message' => 'District Wards fetched successfull', 'data' => $data]);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'message' => $e->getMessage()]);
        }
    }

    public function getParking($wardId)
    {
        try {
            $parkingModel = new Parking();
            $data = $parkingModel->getParking($wardId);
            return response()->json(['status' => 200, 'message' => 'Parking fetched successfully', 'data' => $data]);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'result' => 'error', 'message' => $e->getMessage()]);
        }
    }


    public function getAssociations($districtId)
    {
        try {
            $associationsModel = new Association();
            $data = $associationsModel->getAllAssocciationByDistrict($districtId);
            return response()->json(['status' => 200, 'message' => 'Associations fetched successfully', 'data' => $data]);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'result' => 'error', 'message' => $e->getMessage()]);
        }
    }
}

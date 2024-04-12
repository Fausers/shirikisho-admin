<?php

namespace App\Http\Controllers;

use App\Models\NextSMSModel;
use App\Models\User;
use App\Models\UserOTP;
use Dotenv\Exception\ValidationException;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ApiController extends Controller
{
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'phone_number' => 'required',
                'password' => 'required',
                'device_name' => 'required',
            ]);

            $user = User::where('phone_number', $request->phone_number)->first();

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
            if ($existingOTP) {

                // Generate new OTP code
                do {
                    $otpCode = mt_rand(100000, 999999);
                } while (UserOTP::where('otp_code', $otpCode)->exists());


                // Send OTP via SMS
                $smsSent = (new NextSMSModel())->sendSms($user->phone_number, "Your OTP is: $otpCode", 'OTP');

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
                    // return response()->json(['loginError' => 'Failed to send OTP']);
                }
            }

            DB::commit();

            return response()->json([
                'status' => 200,
                'message' => 'success',
                'token' => $user->createToken($request->device_name)->plainTextToken,
                'user' => [
                    'id' => $user->id,
                    'full_name' => $user->full_name,
                    'email' => $user->email,
                    'phone_number' => $user->phone_number,
                    'gender' => $user->gender,
                    'status' => $user->status,
                    'uniform_status' => $user->uniform_status,
                    'profile_image' => $user->profile_image,
                    'license_number' => $user->license_number,
                    'marital_status' => $user->marital_status,
                    'dob' => $user->dob,
                    'residence_address' => $user->residence_address,
                    'parking_id' => $user->parking_id,
                    'created_at' => $user->created_at,
                    'updated_at' => $user->updated_at
                ],
            ]);
        } catch (ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'status' => 422,
                'message' => 'error',
                'error' => $e->getMessage()
            ]);
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

            $userOTP = UserOTP::where('user_id', $user->id)
                ->where('otp_code', $otpCode)
                ->first();

            if ($userOTP) {

                DB::commit();
                return response()->json([
                    'status' => 200,
                    'message' => 'success',
                    // 'token' => $user->createToken($request->device_name)->plainTextToken,
                    'user' => [
                        'id' => $user->id,
                        'full_name' => $user->full_name,
                        'email' => $user->email,
                        'phone_number' => $user->phone_number,
                        'gender' => $user->gender,
                        'status' => $user->status,
                        'uniform_status' => $user->uniform_status,
                        'profile_image' => $user->profile_image,
                        'license_number' => $user->license_number,
                        'marital_status' => $user->marital_status,
                        'dob' => $user->dob,
                        'residence_address' => $user->residence_address,
                        'parking_id' => $user->parking_id,
                        'created_at' => $user->created_at,
                        'updated_at' => $user->updated_at
                    ],
                ]);
            } else {
                // Redirect with error message if OTP is invalid
                return response()->json(['status' => 400, 'message' => 'Invalid OTP. Please enter a valid OTP.']);
            }
        } catch (Exception $e) {
            // Handle exceptions
            DB::rollback();
            return response()->json(['status' => 500, 'message' => 'Internal Server Error','error' => $e->getMessage()]);
        }
    }
}

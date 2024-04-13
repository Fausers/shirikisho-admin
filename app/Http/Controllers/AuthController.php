<?php

namespace App\Http\Controllers;

use App\Models\NextSMSModel;
use App\Models\UserOTP;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        DB::beginTransaction();

        try {
            $request->validate([
                'phone_number' => 'required',
                'password' => 'required',
            ]);

            if (Auth::attempt(['phone_number' => $request->input('phone_number'), 'password' => $request->input('password')])) {
                // Authentication successful
                $user = Auth::user();

                // Check for OTP within the last minute and delete if found
                $userOTP = UserOTP::where('user_id', $user->id)
                    ->where('created_at', '<', now()->subMinute())
                    ->first();

                // dd($userOTP);
                if ($userOTP != null) {

                    if ($userOTP) {
                        $userOTP->delete();
                    } else {
                        // If no OTP exists within the last minute, navigate to dashboard
                        DB::commit();
                        return redirect('dashboard');
                    }
                }

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
                    return redirect('verifyotp');
                } else {
                    DB::rollBack();
                    return back()->withErrors(['loginError' => 'Failed to send OTP']);
                }
            }

            DB::rollBack();
            return back()->withErrors(['loginError' => 'Invalid username or password']);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['loginError' => 'An unexpected error occurred. Please try again later.']);
        }
    }

    public function otpsubmit(Request $request)
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
                // Check if the OTP code has expired
                $expiredOTP = UserOTP::where('user_id', $user->id)
                    ->where('created_at', '<', now()->subMinute())
                    ->first();

                if ($expiredOTP) {
                    // If OTP has expired, delete it
                    $expiredOTP->delete();
                    DB::commit();
                    return redirect('/');
                } else {
                    // If OTP is valid and not expired, commit transaction and redirect to dashboard
                    DB::commit();
                    return redirect('dashboard');
                }
            } else {
                // Redirect with error message if OTP is invalid
                return redirect()->back()->with('error', 'Invalid OTP. Please enter a valid OTP.');
            }
        } catch (Exception $e) {
            // Handle exceptions
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }




    public function getUserDetails()
    {
        // Retrieve the authenticated user
        $user = Auth::user();

        // Check if a user is logged in
        if ($user) {
            // Return the user details
            return response()->json([
                'id' => $user->id,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'phone_number' => $user->phone_number,
                'gender' => $user->gender,
                'email' => $user->email,
                'role' => $user->role,
                // Add other user details as needed
            ]);
        } else {
            // User not logged in
            return response()->json(['error' => 'User not authenticated'], 401);
        }
    }


    public function logout()
    {
        Auth::logout();

        return redirect('/');
    }

    public function logoutt()
    {
        Auth::logout();
        return response()->json(['message' => 'Successfull logout']);
    }
}

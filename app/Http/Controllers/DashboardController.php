<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('dashboard', compact('user'));
    }

    public function showVerfy()
    {
        $user = Auth::user();
        return view('auth.verifyotp', compact('user'));
    }

    public function getTotalDriversByCreatedAt(Request $request)
    {
        $month = $request->input('month');
        $year = $request->input('year');

        try {
            $userModel = new User();
            $data = $userModel->getTotalDriversByCreatedAt($month, $year);

            // ActivityLog::logActivity($message);

            return response()->json(['status' => 200, 'message' => 'Drivers filtered successfult', 'data' => $data]);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'message' => $e->getMessage()]);
        }
    }
}

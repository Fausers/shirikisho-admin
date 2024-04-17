<?php

namespace App\Http\Controllers;

use App\Models\ServiceModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $ServicesModel = new ServiceModel();
        $userModel = new User();
        $user = Auth::user();
        $region = $ServicesModel->getRegion();

        $dirvierlatest = $userModel->getLastestFiveDriver();
        return view('dashboard', compact('user','region','dirvierlatest'));
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

        $region_id = $request->input('region_id');
        $district_id = $request->input('district_id');
        $ward_id = $request->input('ward_id');

        try {
            $userModel = new User();
            $data = $userModel->getTotalDriversByCreatedAt($month, $year,$region_id,$district_id,$ward_id);

            // ActivityLog::logActivity($message);

            return response()->json(['status' => 200, 'message' => 'Drivers filtered successfult', 'data' => $data]);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'message' => $e->getMessage()]);
        }
    }
}

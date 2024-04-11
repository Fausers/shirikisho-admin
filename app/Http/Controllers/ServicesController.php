<?php

namespace App\Http\Controllers;

use App\Models\ServiceModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class ServicesController extends Controller
{
    private $ServicesModel;

    function __construct()
    {
        $user = Auth::user();
        $ServicesModel = new ServiceModel();
        $this->ServicesModel = $ServicesModel;
    }

    public function region()
    {
        return view('location.region');
    }

    public function region_view()
    {
        $data = $this->ServicesModel->getRegion();
        $ServicesModel = $this->ServicesModel;
        return view('location.region_view', compact('data', 'ServicesModel'));
    }

    public function saveRegion(Request $request)
    {

        try {
            DB::beginTransaction();

            // Explicitly define variables based on form fields
            $hidden_id = $request->input('hidden_id');
            $names = $request->input('name');

            $user_id = Auth::user()->id;

            if (empty($hidden_id)) :

                foreach ($names as $name) {
                    $data = [
                        'name' => $name,
                        'created_by' => $user_id,
                        'updated_by' => $user_id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];

                    DB::table('region')->insert($data);
                }

                $message = 'Region saved successfully';
            // ActivityLog::logActivity($message);

            else :

                $data = [
                    'name' => $names[0],

                    'updated_by' => $user_id,
                ];

                $condition = [
                    'id' => Crypt::decrypt($hidden_id),
                    'archive' => 0
                ];

                // Save patient data
                DB::table('region')->where($condition)->update($data);
                $message = 'Region updated successfully';
            // ActivityLog::logActivity($message);

            endif;

            DB::commit();

            return response()->json(['status' => 200, 'message' => $message]);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json(['status' => 500, 'message' => $e->getMessage()]);
        }
    }


    public function editRegion($id)
    {
        $data = $this->ServicesModel->getRegionRow($id);
        echo json_encode(['data' => $data, 'id' => Crypt::encrypt($id)]);
    }

    public function deleteRegion($id)
    {
        try {
            $data = $this->ServicesModel->deleteRegion($id);

            $message = 'Region deleted successfull' . $id;

            // ActivityLog::logActivity($message);

            return response()->json(['status' => 200, 'message' => $message]);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'message' => $e->getMessage()]);
        }
    }

    // district
    public function district()
    {
        $region = $this->ServicesModel->getRegion();
        return view('location.district', compact('region'));
    }

    public function district_view()
    {
        $data = $this->ServicesModel->getDistrict();
        $ServicesModel = $this->ServicesModel;

        return view('location.district_view', compact('data', 'ServicesModel'));
    }

    public function saveDistrict(Request $request)
    {

        try {
            DB::beginTransaction();

            // Explicitly define variables based on form fields
            $hidden_id = $request->input('hidden_id');
            $region_id = $request->input('region_id');
            $names = $request->input('name');

            $user_id = Auth::user()->id;

            if (empty($hidden_id)) :

                foreach ($names as $name) {
                    $data = [
                        'region_id' => $region_id,
                        'name' => $name,
                        'created_by' => $user_id,
                        'updated_by' => $user_id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];

                    DB::table('district')->insert($data);
                }
                $message = 'District saved successfully';
            //  ActivityLog::logActivity($message);

            else :

                $data = [
                    'region_id' => $region_id,
                    'name' => $names[0],

                    'updated_by' => $user_id,
                ];

                $condition = [
                    'id' => Crypt::decrypt($hidden_id),
                    'archive' => 0
                ];

                // Save patient data
                DB::table('district')->where($condition)->update($data);
                $message = 'District updated successfully';
            //  ActivityLog::logActivity($message);

            endif;

            DB::commit();

            return response()->json(['status' => 200, 'message' => $message]);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json(['status' => 500, 'message' => $e->getMessage()]);
        }
    }


    public function getRegionDistrict($id)
    {
        $data = $this->ServicesModel->getRegionDistrict($id);
        echo json_encode($data);
    }

    public function getDistrictWard($id)
    {
        $data = $this->ServicesModel->getDistrictWard($id);
        echo json_encode($data);
    }


    public function editDistrict($id)
    {

        $data = $this->ServicesModel->getDistrictRow($id);
        $region = $this->ServicesModel->getRegionRow($data->region_id);
        echo json_encode(['data' => $data, 'id' => Crypt::encrypt($id), 'region' => $region]);
    }

    public function deleteDistrict($id)
    {
        try {
            $data = $this->ServicesModel->deleteDistrict($id);

            $message = 'District deleted successfull' . $id;

            //  ActivityLog::logActivity($message);

            return response()->json(['status' => 200, 'message' => $message]);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'message' => $e->getMessage()]);
        }
    }


    public function ward()
    {
        $region = $this->ServicesModel->getRegion();
        return view('location.ward', compact('region'));
    }

    public function ward_view()
    {
        $data = $this->ServicesModel->getWard();
        $ServicesModel = $this->ServicesModel;

        return view('location.ward_view', compact('data', 'ServicesModel'));
    }

    public function saveWard(Request $request)
    {

        try {
            DB::beginTransaction();

            // Explicitly define variables based on form fields
            $hidden_id = $request->input('hidden_id');
            $region_id = $request->input('region_id');
            $district_id = $request->input('district_id');
            $names = $request->input('name');

            $user_id = Auth::user()->id;

            if (empty($hidden_id) && !empty($region_id) && !empty($district_id)) :

                foreach ($names as $name) {
                    $data = [
                        'region_id' => $region_id,
                        'district_id' => $district_id,
                        'name' => $name,
                        'created_by' => $user_id,
                        'updated_by' => $user_id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];

                    DB::table('ward')->insert($data);
                }
                $message = 'Ward saved successfully';

            // ActivityLog::logActivity($message);

            else :

                $data = [
                    'region_id' => $region_id,
                    'district_id' => $district_id,
                    'name' => $names[0],

                    'updated_by' => $user_id,
                ];

                $condition = [
                    'id' => Crypt::decrypt($hidden_id),
                    'archive' => 0
                ];

                // Save patient data
                DB::table('ward')->where($condition)->update($data);
                $message = 'Ward updated successfully';
            // ActivityLog::logActivity($message);

            endif;

            DB::commit();

            return response()->json(['status' => 200, 'message' => $message]);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json(['status' => 500, 'message' => $e->getMessage()]);
        }
    }


    public function editWard($id)
    {

        $data = $this->ServicesModel->getWardRow($id);
        $district = $this->ServicesModel->getDistrictRow($data->district_id);
        echo json_encode(['data' => $data, 'id' => Crypt::encrypt($id), 'district' => $district]);
    }

    public function deleteWard($id)
    {
        try {
            $this->ServicesModel->deleteWard($id);

            $message = 'District deleted successfull' . $id;

            // ActivityLog::logActivity($message);

            return response()->json(['status' => 200, 'message' => $message]);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'message' => $e->getMessage()]);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Association;
use App\Models\ServiceModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class AssociationController extends Controller
{
     public function associations()
     {
 
         $ServicesModel = new ServiceModel();
         $region = $ServicesModel->getRegion();
         return view('association.association', compact('region'));
     }
 
     public function association_view()
     {
         $associationModel = new Association();
         $ServicesModel = new ServiceModel();
         $data = $associationModel->getAllAssociations();
 
         return view('association.association_view', compact('data', 'associationModel', 'ServicesModel'));
     }
 
     public function saveAssociation(Request $request)
     {
 
         try {
             DB::beginTransaction();
 
             // Explicitly define variables based on form fields
             $hidden_id = $request->input('hidden_id');
             $name = $request->input('name');
             $region_id = $request->input('region_id');
             $district_id = $request->input('district_id');
 
             $user_id = Auth::user()->id;
 
             if (empty($hidden_id)) :
 
                 ## staff
                 $data = [
                     'name' => $name,
                     'region_id' => $region_id,
                     'district_id' => $district_id,
                     'created_by' => $user_id,
                     'updated_by' => $user_id,
                     'created_at' => now(),
                     'updated_at' => now(),
                 ];
                 $insert_id = DB::table('associations')->insertGetId($data);
 
                 $message = 'Association saved successfully';
             // ActivityLog::logActivity($message);
 
             else :
                 ## update inventory
                 $data = [
                    'name' => $name,
                    'region_id' => $region_id,
                    'district_id' => $district_id,
                    'updated_by' => $user_id,
                    'updated_at' => now(),
                 ];
 
                 $condition = [
                     'id' => Crypt::decrypt($hidden_id),
                     'archive' => 0
                 ];
                 DB::table('associations')->where($condition)->update($data);
                 $message = 'Association updated successfully';
             // ActivityLog::logActivity($message);
 
             endif;
 
             DB::commit();
 
             return response()->json(['status' => 200, 'message' => $message]);
         } catch (\Exception $e) {
             DB::rollback();
 
             return response()->json(['status' => 500, 'message' => $e->getMessage()]);
         }
     }
 
 
     public function editAssociation($id)
     {
         $ServicesModel = new ServiceModel();
         $associationModel = new Association();
         $data = $associationModel->getAssociationRow($id);
 
         $region = $ServicesModel->getRegionRow($data->region_id);
         $district = $ServicesModel->getDistrictRow($data->district_id);
         echo json_encode(['data' => $data, 'id' => Crypt::encrypt($id), 'region' => $region, 'district' => $district]);
     }
 
     public function deleteAssociation($id)
     {
         try {
             $associationModel = new Association();
             $associationModel->deleteAssociation($id);
 
             $message = 'Association deleted successfull' . $id;
 
             // ActivityLog::logActivity($message);
 
             return response()->json(['status' => 200, 'message' => $message]);
         } catch (\Exception $e) {
             return response()->json(['status' => 500, 'message' => $e->getMessage()]);
         }
     }
 
     public function viewAssociation($id)
     {
         try {
             $associationModel = new Association();
             $data = $associationModel->getAssociationRow($id);
 
             $message = 'Association successfull fetched';
             return response()->json(['status' => 200, 'message' => $message, 'data' => $data]);
         } catch (\Exception $e) {
             return response()->json(['status' => 500, 'message' => $e->getMessage()]);
         }
     }
}

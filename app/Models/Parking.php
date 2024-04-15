<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Parking extends Model
{
    use HasFactory;

    public function getAllParking()
    {
        return DB::table('parking_area')->where('archive', 0)->orderBy('id', 'desc')->get();
    }

    public function getParkingRow($id)
    {
        return DB::table('parking_area')->where(['archive' => 0, 'id' => $id])->first();
    }

    public function deleteParking($id)
    {
        DB::table('parking_area')->where(['archive' => 0, 'id' => $id])->update(['archive' => 1]);
    }

    public function getParking($regionId, $districtId, $wardId)
    {
        return DB::table('parking_area')->where(['archive' => 0, 'region_id' => $regionId, 'district_id' => $districtId, 'ward_id' => $wardId])->orderBy('id', 'desc')->get();
    }
}

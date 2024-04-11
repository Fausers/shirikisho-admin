<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ServiceModel extends Model
{
    use HasFactory;

    public function getRegion()
    {
        return DB::table('region')->where('archive', 0)->orderBy('id', 'desc')->get();
    }

    public function getRegionRow($id)
    {
        return DB::table('region')->where(['archive' => 0, 'id' => $id])->first();
    }

    public function deleteRegion($id)
    {
        DB::table('region')->where(['archive' => 0, 'id' => $id])->update(['archive' => 1]);
    }


    public function getDistrict()
    {
        return DB::table('district')->where('archive', 0)->orderBy('id', 'desc')->get();
    }

    public function getDistrictRow($id)
    {
        return DB::table('district')->where(['archive' => 0, 'id' => $id])->first();
    }

    public function deleteDistrict($id)
    {
        DB::table('district')->where(['archive' => 0, 'id' => $id])->update(['archive' => 1]);
    }

    public function getRegionDistrict($id)
    {
        return DB::table('district')->where(['archive' => 0, 'region_id' => $id])->get();
    }


    public function getDistrictWard($id)
    {
        return DB::table('ward')->where(['archive' => 0, 'district_id' => $id])->get();
    }

    public function getWard()
    {
        return DB::table('ward')->where('archive', 0)->orderBy('id', 'desc')->get();
    }

    public function getWardRow($id)
    {
        return DB::table('ward')->where(['archive' => 0, 'id' => $id])->first();
    }
    public function deleteWard($id)
    {
        DB::table('ward')->where(['archive' => 0, 'id' => $id])->update(['archive' => 1]);
    }


}

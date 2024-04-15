<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Association extends Model
{
    use HasFactory;

    public function getAllAssociations()
    {
        return DB::table('associations')->where('archive', 0)->orderBy('id', 'desc')->get();
    }

    public function getAssociationRow($id)
    {
        return DB::table('associations')->where(['archive' => 0, 'id' => $id])->first();
    }

    public function deleteAssociation($id)
    {
        DB::table('associations')->where(['archive' => 0, 'id' => $id])->update(['archive' => 1]);
    }

    public function getAllAssocciationByDistrict($district_id)
    {
        return DB::table('associations')->where(['archive' => 0, 'district_id' => $district_id])->orderBy('id', 'desc')->get(['id','name']);
    }
}

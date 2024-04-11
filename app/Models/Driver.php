<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Driver extends Model
{
    use HasFactory;

    public function getAllDrivers()
    {
        return DB::table('users')->where(['archive'=> 0,'role' => 2])->get();
    }
    public function getDriverRow($id)
    {
        return DB::table('users')->where(['id' => $id, 'archive' => 0])->first();
    }
    public function deleteDriver($id)
    {
        return DB::table('users')->where(['id' => $id])->update(['archive'=>1]);
    }
}

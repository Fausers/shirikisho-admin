<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserOTP extends Model
{
    use HasFactory;

    protected $table = 'user_otp';
    protected $fillable = [
        'otp_code',
        'user_id',
        'created_by',
        'updated_by',
    ];
}

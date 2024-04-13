<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'full_name',
        'email',
        'phone_number',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getTotalDriversByCreatedAt($month, $year)
    {
        // Get the total number of users grouped by their creation date
        $userCounts = User::query()
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->where('role', 2) // Assuming you want to filter only drivers (role = 2)
            ->selectRaw('DATE(created_at) as created_date, COUNT(*) as total_users')
            ->groupBy('created_date')
            ->orderBy('created_date', 'asc')
            ->get();
    
        return $userCounts;
    }
    
}

<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Carbon\Carbon;
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
        // Get the start and end dates of the specified month
        $startDate = Carbon::createFromDate($year, $month, 1)->startOfMonth();
        $endDate = Carbon::createFromDate($year, $month, 1)->endOfMonth();

        // Create an array to hold the result
        $result = [];

        // Loop through each day of the month
        while ($startDate->lte($endDate)) {
            // Get the total number of users created on the current day
            $totalCount = User::whereDate('created_at', $startDate)
                ->where('role', 2) // Assuming you want to filter only drivers (role = 2)
                ->count();

            // Add the date and total count to the result array
            $result[] = [
                'created_date' => $startDate->toDateString(),
                'day' => $startDate->day,
                'total_users' => $totalCount,
            ];

            // Move to the next day
            $startDate->addDay();
        }

        return $result;
    }
}

<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
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
    public function getTotalDriversByCreatedAt($month, $year, $regionId, $districtId, $wardId)
    {

        // Get the start and end dates of the specified month
        $startDate = Carbon::createFromDate($year, $month, 1)->startOfMonth();
        $endDate = Carbon::createFromDate($year, $month, 1)->endOfMonth();

        // Create an array to hold the result
        $result = [];

        // Query to retrieve total users for each day
        $query = DB::table('users')
            ->join('parking_area', 'users.park_id', '=', 'parking_area.park_id')
            ->selectRaw('DATE(users.created_at) as created_date, COUNT(*) as total_users')
            ->whereBetween('users.created_at', [$startDate, $endDate])
            ->groupBy('created_date');

        // Apply conditions based on the provided region, district, or ward ID
        if (!is_null($regionId)) {
            $query->where('parking_area.region_id', $regionId);
        }
        if (!is_null($districtId)) {
            $query->where('parking_area.district_id', $districtId);
        }
        if (!is_null($wardId)) {
            $query->where('parking_area.ward_id', $wardId);
        }

        // Execute the query
        $userCounts = $query->get();

        // Loop through each day of the month
        while ($startDate->lte($endDate)) {
            // Check if the data for the current day exists in the result
            $userData = $userCounts->firstWhere('created_date', $startDate->toDateString());
            $totalCount = $userData ? $userData->total_users : 0;

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

    public function getLastestFiveDriver()
    {
        $latestUsersWithParking = DB::table('users as u')
            ->select(
                'u.id',
                'u.full_name',
                'u.profile_image',
                'u.park_id',
                'pa.park_name'
            )
            ->join('parking_area as pa', 'u.park_id', '=', 'pa.park_id')
            ->where('u.archive', 0)
            ->where('u.role', 2)
            ->orderByDesc('u.created_at')
            ->limit(5)
            ->get();

        return $latestUsersWithParking;
    }
}

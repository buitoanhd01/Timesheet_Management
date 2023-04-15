<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Employee extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'employees';

    protected $fillable = [
        'employee_code',
        'first_name',
        'last_name',
        'full_name',
        'phone',
        'address',
        'birthday',
        'gender',
        'start_time',
        'end_time',
        'tax_code',
        'employee_type'
    ];

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class, 'employee_id', 'id');
    }

    public function leaves(): HasMany
    {
        return $this->hasMany(Leave::class, 'employee_id', 'id');
    }

    public static function getListCalendars($dateFilter, $currentTab)
    {
        if ($dateFilter) {
            if ($currentTab === 'daily') {
                $dateFilter = date('Y-m-d', strtotime($dateFilter));
                $dataAttendance = self::leftJoin('attendances', 'employees.id', '=' ,'attendances.employee_id')
                                ->select('employees.full_name', 'attendances.*')->where('date', $dateFilter)
                                ->orderBy('id')
                                ->get();
            } else if ($currentTab === 'weekly') {
                $weekEnd = date('Y-m-d', strtotime($dateFilter . '+7 days'));
                $dateFilter = date('Y-m-d', strtotime($dateFilter));
                $dataAttendance = self::leftJoin('attendances', 'employees.id', '=' ,'attendances.employee_id')
                                ->select('employees.full_name', 'attendances.*')->whereBetween('date', [$dateFilter, $weekEnd])
                                ->orderBy('id')
                                ->get();
            } else {
                $dateFilter = date('Y-m', strtotime($dateFilter));
                $dataAttendance = self::leftJoin('attendances', 'employees.id', '=' ,'attendances.employee_id')
                                ->select('employees.full_name', 'attendances.*')->where('date','like', $dateFilter.'%')
                                ->orderBy('id')
                                ->get();
            }
            foreach ($dataAttendance as $data) {
                $data['first_checkin'] = !is_null($data['first_checkin']) ? date('H:i:s', strtotime($data['first_checkin'])) : '';
                $data['last_checkout'] = !is_null($data['last_checkout']) ? date('H:i:s', strtotime($data['last_checkout'])) : '';
            }
            
        } else {
            if ($currentTab === 'daily') {
                $dataAttendance = self::leftJoin('attendances', 'employees.id', '=' ,'attendances.employee_id')
                                ->select('employees.full_name', 'attendances.*')
                                ->orderBy('id')
                                ->get();
            } else if ($currentTab === 'weekly') {
                $weekEnd = date('Y-m-d', strtotime(date('Y-m-d') . '+7 days'));
                $dateFilter = date('Y-m-d');
                $dataAttendance = self::leftJoin('attendances', 'employees.id', '=' ,'attendances.employee_id')
                                ->select('employees.full_name', 'attendances.*')->whereBetween('date', [$dateFilter, $weekEnd])
                                ->orderBy('id')
                                ->get();
            } else {
                $dateFilter = date('Y-m');
                $dataAttendance = self::leftJoin('attendances', 'employees.id', '=' ,'attendances.employee_id')
                                ->select('employees.full_name', 'attendances.*')->where('date','like', $dateFilter.'%')
                                ->orderBy('id')
                                ->get();
            }
            foreach ($dataAttendance as $data) {
                $data['first_checkin'] = !is_null($data['first_checkin']) ? date('H:i:s', strtotime($data['first_checkin'])) : '';
                $data['last_checkout'] = !is_null($data['last_checkout']) ? date('H:i:s', strtotime($data['last_checkout'])) : '';
            }
        }
        return $dataAttendance;
    }

    public static function getCurrentEmployeeID ()
    {
        return self::where('user_id', Auth::user()->id)->value('id');
    }
}

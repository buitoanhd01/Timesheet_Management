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
        'employee_type',
        'status',
        'email',
        'user_id',
        'position_id',
        'department_id',
    ];
    

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class, 'employee_id', 'id');
    }

    // public function users()
    // {
    //     return $this->hasOne(User::class, 'user_id', 'id');
    // }

    public function leaves(): HasMany
    {
        return $this->hasMany(Leave::class, 'employee_id', 'id');
    }

    public static function getListCalendars($dateFilter, $currentTab, $searchValue, $dataFilter)
    {
        if ($dateFilter) {
            if ($currentTab === 'daily') {
                $dateFilter = date('Y-m-d', strtotime($dateFilter));
                $dataAttendance = self::leftJoin('attendances', 'employees.id', '=' ,'attendances.employee_id')
                                ->select('employees.full_name', 'employees.employee_code', 'attendances.*')->where('date', $dateFilter);

            } else if ($currentTab === 'weekly') {
                $weekEnd = date('Y-m-d', strtotime($dateFilter . '+7 days'));
                $dateFilter = date('Y-m-d', strtotime($dateFilter));
                $dataAttendance = self::leftJoin('attendances', 'employees.id', '=' ,'attendances.employee_id')
                                ->select('employees.full_name', 'employees.employee_code', 'attendances.*')->whereBetween('date', [$dateFilter, $weekEnd]);

            } else {
                $dateFilter = date('Y-m', strtotime($dateFilter));
                $dataAttendance = self::leftJoin('attendances', 'employees.id', '=' ,'attendances.employee_id')
                                ->select('employees.full_name', 'employees.employee_code', 'attendances.*')->where('date','like', $dateFilter.'%');

            }
        } else {
            if ($currentTab === 'daily') {
                $dataAttendance = self::leftJoin('attendances', 'employees.id', '=' ,'attendances.employee_id')
                                ->select('employees.full_name', 'employees.employee_code', 'attendances.*');

            } else if ($currentTab === 'weekly') {
                $weekEnd = date('Y-m-d', strtotime(date('Y-m-d') . '+7 days'));
                $dateFilter = date('Y-m-d');
                $dataAttendance = self::leftJoin('attendances', 'employees.id', '=' ,'attendances.employee_id')
                                ->select('employees.full_name', 'employees.employee_code', 'attendances.*')->whereBetween('date', [$dateFilter, $weekEnd]);

            } else {
                $dateFilter = date('Y-m');
                $dataAttendance = self::leftJoin('attendances', 'employees.id', '=' ,'attendances.employee_id')
                                ->select('employees.full_name', 'employees.employee_code', 'attendances.*')->where('date','like', $dateFilter.'%');
                                
            }
            
        }
        if (isset($searchValue) && !empty($searchValue)) {
            $dataAttendance = $dataAttendance->where('full_name','like', '%'.$searchValue.'%')
            ->orWhere('employee_code','like', '%'.$searchValue.'%');
        }
        if (!empty($dataFilter)) {
            $dataAttendance = $dataAttendance->where('attendances.status', $dataFilter);
        }
        $dataAttendance = $dataAttendance->orderBy('date')->get();
        foreach ($dataAttendance as $data) {
            $data['first_checkin'] = !is_null($data['first_checkin']) ? date('H:i:s', strtotime($data['first_checkin'])) : '';
            $data['last_checkout'] = !is_null($data['last_checkout']) ? date('H:i:s', strtotime($data['last_checkout'])) : '';
        }
        return $dataAttendance;
    }

    public static function getCurrentEmployeeID ()
    {
        return self::where('user_id', Auth::user()->id)->value('id');
    }

    public static function getListEmployees()
    {
        return self::leftJoin('departments', 'employees.department_id', 'departments.id')
        ->leftJoin('positions', 'employees.position_id', 'positions.id')
        ->leftJoin('users', 'employees.user_id', 'users.id')
        ->select('employees.*', 'departments.department_name as department', 'positions.position_name as position' ,'users.username')
        ->get();
    }

    public static function deleteEmployeeUserID($userID)
    {
        return self::where('user_id', $userID)->update([
            'user_id'   => -1
        ]);
    }

    public static function getEmployeeByID($id)
    {
        return self::leftJoin('departments', 'employees.department_id', 'departments.id')
        ->leftJoin('positions', 'employees.position_id', 'positions.id')
        ->select('employees.*', 
        'departments.department_name as department', 
        'departments.id as department_id',
        'positions.position_name as position',
        'positions.id as position_id',
        )
        ->where('employees.id', $id)
        ->first();
    }


    public static function getListCalendarsByEmployeeID($dateFilter, $currentTab, $employeeID, $dataFilter)
    {
        if ($dateFilter) {
            if ($currentTab === 'daily') {
                $dateFilter = date('Y-m-d', strtotime($dateFilter));
                $dataAttendance = self::leftJoin('attendances', 'employees.id', '=' ,'attendances.employee_id')
                                ->select('employees.full_name', 'employees.employee_code', 'attendances.*')
                                ->where('date', $dateFilter);

            } else if ($currentTab === 'weekly') {
                $weekEnd = date('Y-m-d', strtotime($dateFilter . '+7 days'));
                $dateFilter = date('Y-m-d', strtotime($dateFilter));
                $dataAttendance = self::leftJoin('attendances', 'employees.id', '=' ,'attendances.employee_id')
                                ->select('employees.full_name', 'employees.employee_code', 'attendances.*')->whereBetween('date', [$dateFilter, $weekEnd]);

            } else {
                $dateFilter = date('Y-m', strtotime($dateFilter));
                $dataAttendance = self::leftJoin('attendances', 'employees.id', '=' ,'attendances.employee_id')
                                ->select('employees.full_name', 'employees.employee_code', 'attendances.*')->where('date','like', $dateFilter.'%');

            }
        } else {
            if ($currentTab === 'daily') {
                $dataAttendance = self::leftJoin('attendances', 'employees.id', '=' ,'attendances.employee_id')
                                ->select('employees.full_name', 'employees.employee_code', 'attendances.*');

            } else if ($currentTab === 'weekly') {
                $weekEnd = date('Y-m-d', strtotime(date('Y-m-d') . '+7 days'));
                $dateFilter = date('Y-m-d');
                $dataAttendance = self::leftJoin('attendances', 'employees.id', '=' ,'attendances.employee_id')
                                ->select('employees.full_name', 'employees.employee_code', 'attendances.*')->whereBetween('date', [$dateFilter, $weekEnd]);

            } else {
                $dateFilter = date('Y-m');
                $dataAttendance = self::leftJoin('attendances', 'employees.id', '=' ,'attendances.employee_id')
                                ->select('employees.full_name', 'employees.employee_code', 'attendances.*')->where('date','like', $dateFilter.'%');
                                
            }
            
        }
        $dataAttendance = $dataAttendance->where('employee_id', $employeeID);
        if (!empty($dataFilter)) {
            $dataAttendance = $dataAttendance->where('attendances.status', $dataFilter);
        }
        $dataAttendance = $dataAttendance->orderBy('date')->get();
        foreach ($dataAttendance as $data) {
            $data['first_checkin'] = !is_null($data['first_checkin']) ? date('H:i:s', strtotime($data['first_checkin'])) : '';
            $data['last_checkout'] = !is_null($data['last_checkout']) ? date('H:i:s', strtotime($data['last_checkout'])) : '';
        }
        return $dataAttendance;
    }
}

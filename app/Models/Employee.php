<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Termwind\Components\Raw;

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
            $dataAttendance = $dataAttendance->where(function($query) use ($searchValue) {
                $query->where('full_name', 'like', '%'.$searchValue.'%')
                    ->orWhere('employee_code', 'like', '%'.$searchValue.'%');
            });
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

    public static function getListEmployees($dataFilter)
    {
        $data = self::leftJoin('departments', 'employees.department_id', 'departments.id')
        ->leftJoin('positions', 'employees.position_id', 'positions.id')
        ->leftJoin('users', 'employees.user_id', 'users.id')
        ->select('employees.*', 'departments.department_name as department', 'positions.position_name as position' ,'users.username');
        if (isset($dataFilter) && !empty($dataFilter)) {
            $data = $data->where(function($query) use ($dataFilter) {
                $query->where('full_name', 'like', '%'.$dataFilter.'%')
                    ->orWhere('employee_code', 'like', '%'.$dataFilter.'%');
            });
        }
        $data = $data->get();
        return $data;
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

    public static function getReportDataAttendance($dateFilter, $searchValue)
    {
        $data = [];
        $reportList = self::leftJoin('attendances', 'employees.id', 'attendances.employee_id')
        ->select(
                'employees.full_name',
                'employees.employee_code',
                'attendances.working_hours',
                'attendances.status',
                DB::raw('DATE(attendances.date) as date'),
                DB::raw('SUM(working_hours) over (partition by employee_code, date_format(date, "%Y-%m")) as hour'),
        )->where('date', 'like', $dateFilter.'%')
        ->groupBy('employee_code', 'date');
        if (isset($searchValue)) {
            $reportList = $reportList->where(function($query) use ($searchValue) {
                $query->where('full_name', 'like', '%'.$searchValue.'%')
                    ->orWhere('employee_code', 'like', '%'.$searchValue.'%');
            });
        }
        $reportList = $reportList->orderBy('employee_code')->get();
        $reportList = collect($reportList)->toArray();
        // $dateInMonth = Employee::getDayInMonth($dateFilter);
        // $listFullEmployees = self::all()->pluck('full_name', 'employee_code')->toArray();
        // foreach($reportList as $report) {
        //     foreach ($dateInMonth as $date) {
        //         $data[$report['employee_code']][$date] = 0.0;
        //     }
        // }
        foreach($reportList as $report) {
            $data[$report['employee_code']]['full_name'] = $report['full_name'];
            $data[$report['employee_code']][$report['date']]['working_hours'] = $report['working_hours'];
            $data[$report['employee_code']]['total'] = $report['hour'];
            $data[$report['employee_code']][$report['date']]['status'] = $report['status'];
        }
        // $lackEmployee = array_diff_key($listFullEmployees, $data);
        // foreach ($lackEmployee as $code => $name) {
        //     $data[$code]['full_name'] = $name;
        //     foreach ($dateInMonth as $date) {
        //         $data[$code][$date] = 0.0;
        //     }
        // }
        return $data;
    }

    public static function getDayInMonth($day)
    {
        $month = date('m', strtotime($day));
        $year = date('Y', strtotime($day));
        $days_in_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $dates = array();
        for ($day = 1; $day <= $days_in_month; $day++) {
            $date = sprintf('%d-%02d-%02d', $year, $month, $day); // tạo chuỗi ngày theo định dạng yyyy-mm-dd
            $dates[] = $date; // thêm ngày vào mảng
        }
        return $dates;
    }

    public static function getReportDataOvertime($dateFilter, $searchValue) {
        $data = [];
        $reportList = self::leftJoin('attendances', 'employees.id', 'attendances.employee_id')
        ->select(
                'employees.full_name',
                'employees.employee_code',
                'attendances.overtime',
                'attendances.status',
                DB::raw('DATE(attendances.date) as date'),
                DB::raw('SUM(overtime) over (partition by employee_code, date_format(date, "%Y-%m")) as hour'),
        )->where('date', 'like', $dateFilter.'%')
        ->groupBy('employee_code', 'date');
        if (isset($searchValue)) {
            $reportList = $reportList->where(function($query) use ($searchValue) {
                $query->where('full_name', 'like', '%'.$searchValue.'%')
                    ->orWhere('employee_code', 'like', '%'.$searchValue.'%');
            });
        }
        $reportList = $reportList->orderBy('employee_code')->get();
        $reportList = collect($reportList)->toArray();

        foreach($reportList as $report) {
            $data[$report['employee_code']]['full_name'] = $report['full_name'];
            $data[$report['employee_code']][$report['date']]['working_hours'] = $report['overtime'];
            $data[$report['employee_code']]['total'] = $report['hour'];
            $data[$report['employee_code']][$report['date']]['status'] = $report['status'];
        }


        return $data;
    }


    public static function getReportDataTotal($dateFilter, $searchValue) {
        $data = [];
        $reportList = self::leftJoin('attendances', 'employees.id', 'attendances.employee_id')
        ->select(
                'employees.full_name',
                'employees.employee_code',
                'attendances.status',
                DB::raw('SUM(working_hours + overtime) as total_hours'),
                DB::raw('DATE(attendances.date) as date'),
                DB::raw('SUM(working_hours + overtime) over (partition by employee_code, date_format(date, "%Y-%m")) as hour'),
        )->where('date', 'like', $dateFilter.'%')
        ->groupBy('employee_code', 'date');
        if (isset($searchValue)) {
            $reportList = $reportList->where(function($query) use ($searchValue) {
                $query->where('full_name', 'like', '%'.$searchValue.'%')
                    ->orWhere('employee_code', 'like', '%'.$searchValue.'%');
            });
        }
        $reportList = $reportList->orderBy('employee_code')->get();
        $reportList = collect($reportList)->toArray();

        foreach($reportList as $report) {
            $data[$report['employee_code']]['full_name'] = $report['full_name'];
            $data[$report['employee_code']][$report['date']]['working_hours'] = $report['total_hours'];
            $data[$report['employee_code']]['total'] = $report['hour'];
            $data[$report['employee_code']][$report['date']]['status'] = $report['status'];
        }


        return $data;
    }

    public static function getCurrentEmployeeCode()
    {
        return self::where('user_id', Auth::user()->id)->value('employee_code');
    }

    public static function getReportDataAttendanceByID($dateFilter, $searchValue)
    {
        $code = self::getCurrentEmployeeCode();
        $data = [];
        $reportList = self::leftJoin('attendances', 'employees.id', 'attendances.employee_id')
        ->select(
                'employees.full_name',
                'employees.employee_code',
                'attendances.working_hours',
                'attendances.status',
                DB::raw('DATE(attendances.date) as date'),
                DB::raw('SUM(working_hours) over (partition by employee_code, date_format(date, "%Y-%m")) as hour'),
        )->where('date', 'like', $dateFilter.'%')->where('employee_code', $code)
        ->groupBy('employee_code', 'date');
        if (isset($searchValue)) {
            $reportList = $reportList->where(function($query) use ($searchValue) {
                $query->where('full_name', 'like', '%'.$searchValue.'%')
                    ->orWhere('employee_code', 'like', '%'.$searchValue.'%');
            });
        }
        $reportList = $reportList->orderBy('employee_code')->get();
        $reportList = collect($reportList)->toArray();
        
        foreach($reportList as $report) {
            $data[$report['employee_code']]['full_name'] = $report['full_name'];
            $data[$report['employee_code']][$report['date']]['working_hours'] = $report['working_hours'];
            $data[$report['employee_code']]['total'] = $report['hour'];
            $data[$report['employee_code']][$report['date']]['status'] = $report['status'];
        }
    
        return $data;
    }

    public static function getReportDataOvertimeByID($dateFilter, $searchValue) {
        $code = self::getCurrentEmployeeCode();
        $data = [];
        $reportList = self::leftJoin('attendances', 'employees.id', 'attendances.employee_id')
        ->select(
                'employees.full_name',
                'employees.employee_code',
                'attendances.overtime',
                'attendances.status',
                DB::raw('DATE(attendances.date) as date'),
                DB::raw('SUM(overtime) over (partition by employee_code, date_format(date, "%Y-%m")) as hour'),
        )->where('date', 'like', $dateFilter.'%')->where('employee_code', $code)
        ->groupBy('employee_code', 'date');
        if (isset($searchValue)) {
            $reportList = $reportList->where(function($query) use ($searchValue) {
                $query->where('full_name', 'like', '%'.$searchValue.'%')
                    ->orWhere('employee_code', 'like', '%'.$searchValue.'%');
            });
        }
        $reportList = $reportList->orderBy('employee_code')->get();
        $reportList = collect($reportList)->toArray();

        foreach($reportList as $report) {
            $data[$report['employee_code']]['full_name'] = $report['full_name'];
            $data[$report['employee_code']][$report['date']]['working_hours'] = $report['overtime'];
            $data[$report['employee_code']]['total'] = $report['hour'];
            $data[$report['employee_code']][$report['date']]['status'] = $report['status'];
        }


        return $data;
    }

    public static function getReportDataTotalByID($dateFilter, $searchValue) {
        $code = self::getCurrentEmployeeCode();
        $data = [];
        $reportList = self::leftJoin('attendances', 'employees.id', 'attendances.employee_id')
        ->select(
                'employees.full_name',
                'employees.employee_code',
                'attendances.status',
                DB::raw('SUM(working_hours + overtime) as total_hours'),
                DB::raw('DATE(attendances.date) as date'),
                DB::raw('SUM(working_hours + overtime) over (partition by employee_code, date_format(date, "%Y-%m")) as hour'),
        )->where('date', 'like', $dateFilter.'%')->where('employee_code', $code)
        ->groupBy('employee_code', 'date');
        if (isset($searchValue)) {
            $reportList = $reportList->where(function($query) use ($searchValue) {
                $query->where('full_name', 'like', '%'.$searchValue.'%')
                    ->orWhere('employee_code', 'like', '%'.$searchValue.'%');
            });
        }
        $reportList = $reportList->orderBy('employee_code')->get();
        $reportList = collect($reportList)->toArray();

        foreach($reportList as $report) {
            $data[$report['employee_code']]['full_name'] = $report['full_name'];
            $data[$report['employee_code']][$report['date']]['working_hours'] = $report['total_hours'];
            $data[$report['employee_code']]['total'] = $report['hour'];
            $data[$report['employee_code']][$report['date']]['status'] = $report['status'];
        }


        return $data;
    }
}

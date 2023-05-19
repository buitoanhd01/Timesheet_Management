<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'shifts';

    protected $fillable = [
        'employee_id',
        'shift_name',
        'shift_start_time',
        'shift_end_time',
        'shift_rest_time_start',
        'shift_rest_time_end',
        'time_start_overtime',
        'status'
    ];

    public static function getShiftAllEmployees($searchValue)
    {
        $dataShift = [];
        $dataShift = self::rightJoin('employees', function ($join) {
            $join->on('employees.id', '=', 'shifts.employee_id')
                 ->where('shifts.status', '=', 0);
        })->select('employee_code', 'full_name', 'shifts.*');

        if (isset($searchValue) && !empty($searchValue)) {
            $dataShift = $dataShift->where(function($query) use ($searchValue) {
                $query->where('full_name', 'like', '%'.$searchValue.'%')
                    ->orWhere('employee_code', 'like', '%'.$searchValue.'%');
            });
        }
        $dataShift = $dataShift->orderBy('employee_code')->get();
        foreach ($dataShift as $shift) {
            $shift['shift_name'] = (isset($shift['shift_name'])) ? $shift['shift_name'] : 'Default Shift';
            $shift['shift_start_time'] = (isset($shift['shift_start_time'])) ? $shift['shift_start_time'] : '08:30:00';
            $shift['shift_end_time'] = (isset($shift['shift_end_time'])) ? $shift['shift_end_time'] : '17:30:00';
            $shift['shift_rest_time_start'] = (isset($shift['shift_rest_time_start'])) ? $shift['shift_rest_time_start'] : '12:00:00';
            $shift['shift_rest_time_end'] = (isset($shift['shift_rest_time_end'])) ? $shift['shift_rest_time_end'] : '13:00:00';
            $shift['time_start_overtime'] = (isset($shift['time_start_overtime'])) ? $shift['time_start_overtime'] : '18:30:00';
        }

        return $dataShift;
    }

    public static function getShiftEmployeeByID($id)
    {
        $dataShift = [];
        $dataShift = self::rightJoin('employees', function ($join) {
            $join->on('employees.id', '=', 'shifts.employee_id')
                 ->where('shifts.status', '=', 0);
        })->select('employee_code', 'full_name', 'shifts.*')
        ->where('employee_id', $id);
        $dataShift = $dataShift->orderBy('employee_code')->first();
        $dataShift['shift_name'] = (isset($dataShift['shift_name'])) ? $dataShift['shift_name'] : 'Default Shift';
        $dataShift['shift_start_time'] = (isset($dataShift['shift_start_time'])) ? $dataShift['shift_start_time'] : '08:30:00';
        $dataShift['shift_end_time'] = (isset($dataShift['shift_end_time'])) ? $dataShift['shift_end_time'] : '17:30:00';
        $dataShift['shift_rest_time_start'] = (isset($dataShift['shift_rest_time_start'])) ? $dataShift['shift_rest_time_start'] : '12:00:00';
        $dataShift['shift_rest_time_end'] = (isset($dataShift['shift_rest_time_end'])) ? $dataShift['shift_rest_time_end'] : '13:00:00';
        $dataShift['time_start_overtime'] = (isset($dataShift['time_start_overtime'])) ? $dataShift['time_start_overtime'] : '18:30:00';

        return $dataShift;
    }
}

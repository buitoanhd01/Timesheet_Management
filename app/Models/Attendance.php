<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendance extends Model
{
    use HasFactory;

    const ARRIVAL_LATE = 1;
    const LEAVE_EARLY = 2;
    const BOTH = 3;
    const ONTIME = 0;
    const LEAVED = 4;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'attendances';

    protected $fillable = [
        'date',
        'employee_id',
        'first_checkin',
        'last_checkout',
        'working_hours',
        'overtime',
        'status',
        'note'
    ];


    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }



    public static function InsertOrUpdateAttendance($param)
    {
        $timeCheckIn = ($param['time_checkin'] != "null") ? date('Y-m-d H:i:s', strtotime($param['time_checkin'])) : "null";
        $timeCheckOut = ($param['time_checkout'] != "null") ? date('Y-m-d H:i:s', strtotime($param['time_checkout'])) : "null";
        $data = [];
        if ($timeCheckIn != "null") {
            $data = [
                'date'          => date('Y-m-d'),
                'first_checkin' => $timeCheckIn,
            ];
        }
        if($timeCheckOut != "null") {
            $data = [
                'date'          => date('Y-m-d'),
                'last_checkout' => $timeCheckOut,
            ];
        }
        $data['employee_id'] = Employee::getCurrentEmployeeID();
        $data['working_hours'] = self::getWorkingHours(date('Y-m-d'), $data);
        $data['overtime'] = self::getOvertime($data);
        $data['status'] = self::getStatus($data);
        return self::updateOrCreate(
            ['date' => $param['date'], 'employee_id' => $data['employee_id']],
            $data
        );
    }



    public static function getWorkingHours($date, $data) {
        $timeSchedule = Shift::getShiftEmployeeByID($data['employee_id']);
        $firstCheckIn = self::select('first_checkin')->where(['date'=> $date, 'employee_id' => $data['employee_id']])->value('first_checkin');
        if (isset($firstCheckIn) && isset($data['last_checkout'])) {
            if ($firstCheckIn != 'null' && $data['last_checkout'] != 'null') {
                $firstCheckIn = date('H:i:s', strtotime($firstCheckIn));
                $data['last_checkout'] = date('H:i:s', strtotime($data['last_checkout']));
                $checkInToTime = strtotime($firstCheckIn);
                $checkOutToTime = strtotime($data['last_checkout']);
                $lunchTimeStart = strtotime($timeSchedule['shift_rest_time_start']);
                $lunchTimeEnd = strtotime($timeSchedule['shift_rest_time_end']);
                if ($checkInToTime > $lunchTimeStart || $checkOutToTime < $lunchTimeEnd) {
                    $timeRest = 0;
                } else {
                    $timeRest = (60 * 60);
                }
                $workingHours =$checkOutToTime - $checkInToTime - $timeRest;
            } else {
                $workingHours = 0;
            }
        } else {
            $workingHours = 0;
        }
        return $workingHours / (60 * 60);
    }



    public static function getOverTime($data) {
        $timeSchedule = Shift::getShiftEmployeeByID($data['employee_id']);
        if (isset($data['last_checkout'])) {
            if ($data['last_checkout'] != 'null') {
                $data['last_checkout'] = date('H:i:s', strtotime($data['last_checkout']));
                $checkOutToTime = strtotime($data['last_checkout']);
                $overTimeStart = strtotime($timeSchedule['time_start_overtime']);
                if ($checkOutToTime >= $overTimeStart) {
                    $overTiming = $checkOutToTime - $overTimeStart;
                } else {
                    $overTiming = 0;
                }
            } else {
                $overTiming = 0;
            }
        } else {
            $overTiming = 0;
        }
        
        return $overTiming / (60 * 60);
    }



    public static function getStatus($data) {
        $timeSchedule = Shift::getShiftEmployeeByID($data['employee_id']);
        $timeArrivalLate = strtotime($timeSchedule['shift_start_time']);
        $timeLeaveEarly = strtotime($timeSchedule['shift_start_end']);
        $status = 0;
        if (isset($data['first_checkin']) && $data['first_checkin'] != 'null') {
            $data['first_checkin'] = date('H:i:s', strtotime($data['first_checkin']));
            $checkInToTime = strtotime($data['first_checkin']);
            if ($checkInToTime > $timeArrivalLate) {
                $status = self::ARRIVAL_LATE;
            }
        }
        if (isset($data['last_checkout']) && $data['last_checkout'] != 'null') {
            $data['last_checkout'] = date('H:i:s', strtotime($data['last_checkout']));
            $checkOutToTime = strtotime($data['last_checkout']);
            $statusTmp = self::select('status', 'first_checkin')->where(['date'=> $data['date'], 'employee_id' => $data['employee_id']])->first();
            $checkInToTime = strtotime($statusTmp['first_checkin']);
            if ($checkInToTime > $timeArrivalLate) {
                $status = self::ARRIVAL_LATE;
            }
            if ($checkOutToTime < $timeLeaveEarly) {
                $status = self::LEAVE_EARLY;
            }
            if ($checkInToTime > $timeArrivalLate && $checkOutToTime < $timeLeaveEarly) {
                $status = self::BOTH;
            }
        }
        return $status;
    }



    public static function getPersonalCheckInOutNow()
    {
        $data = self::select('first_checkin', 'last_checkout')->where([
            'date' => date('Y-m-d'),
            'employee_id' => Employee::getCurrentEmployeeID()
            ])->first();
        if (isset($data) && $data != 'null') {
            return $data;
        }
        $data['first_checkin'] = 'null';
        $data['last_checkout'] = 'null';
        return $data;
    }



    public static function compareAndGetMinuteStrTime($time1, $time2)
    {
        if ($time1 != 'null' && $time2 != 'null') {
            $time1 = strtotime($time1);
            $time2 = strtotime($time2);
            if (($time1 - $time2) / 60 < 0) {
                return round(1 - ($time1 - $time2) / 60);
            }
        }
        return 0;
    }

    public static function deleteAttendanceDataByEmployeeID($employee_id)
    {
        $data = self::where('employee_id', $employee_id);
        if (isset($data))
            $data->delete();
    }

    public static function getWorkingHoursByTime($firstCheckIn, $last_checkout, $employee_id) {
        $timeSchedule = Shift::getShiftEmployeeByID($employee_id);
        if (isset($firstCheckIn) && isset($last_checkout)) {
            if ($firstCheckIn != 'null' && $last_checkout != 'null') {
                $firstCheckIn = date('H:i:s', strtotime($firstCheckIn));
                $last_checkout = date('H:i:s', strtotime($last_checkout));
                $checkInToTime = strtotime($firstCheckIn);
                $checkOutToTime = strtotime($last_checkout);
                $lunchTimeStart = strtotime($timeSchedule['shift_rest_time_start']);
                $lunchTimeEnd = strtotime($timeSchedule['shift_rest_time_end']);
                $shiftEnd = strtotime($timeSchedule['shift_end_time']);
                // dd($checkOutToTime - $checkInToTime);
                if ($checkInToTime > $lunchTimeStart || $checkOutToTime < $lunchTimeEnd) {
                    $timeRest = 0;
                } else {
                    $timeRest = (60 * 60);
                }
                if ($checkOutToTime > $shiftEnd) {
                    $timeRest += 60*60;
                }
                $workingHours =$checkOutToTime - $checkInToTime - $timeRest;
            } else {
                $workingHours = 0;
            }
        } else {
            $workingHours = 0;
        }
        return $workingHours / (60 * 60);
    }



    public static function getOverTimeByTime($last_checkout, $employee_id) {
        $timeSchedule = Shift::getShiftEmployeeByID($employee_id);
        if (isset($last_checkout)) {
            if ($last_checkout != 'null') {
                $last_checkout = date('H:i:s', strtotime($last_checkout));
                $checkOutToTime = strtotime($last_checkout);
                $overTimeStart = strtotime($timeSchedule['time_start_overtime']);
                if ($checkOutToTime >= $overTimeStart) {
                    $overTiming = $checkOutToTime - $overTimeStart;
                } else {
                    $overTiming = 0;
                }
            } else {
                $overTiming = 0;
            }
        } else {
            $overTiming = 0;
        }
        
        return $overTiming / (60 * 60);
    }



    public static function getStatusByTime($firstCheckIn, $last_checkout, $employee_id, $date) {
        $timeSchedule = Shift::getShiftEmployeeByID($employee_id);
        $timeArrivalLate = strtotime($timeSchedule['shift_start_time']);
        $timeLeaveEarly = strtotime($timeSchedule['shift_start_end']);
        $status = 0;
        if (isset($firstCheckIn) && $firstCheckIn != 'null') {
            $firstCheckIn = date('H:i:s', strtotime($firstCheckIn));
            $checkInToTime = strtotime($firstCheckIn);
            if ($checkInToTime > $timeArrivalLate) {
                $status = self::ARRIVAL_LATE;
            }
        }
        if (isset($last_checkout) && $last_checkout != 'null') {
            $last_checkout = date('H:i:s', strtotime($last_checkout));
            $checkOutToTime = strtotime($last_checkout);
            $statusTmp = self::select('status', 'first_checkin')->where(['date'=> $date, 'employee_id' => $employee_id])->first();
            $checkInToTime = strtotime($statusTmp['first_checkin']);
            if ($checkInToTime > $timeArrivalLate) {
                $status = self::ARRIVAL_LATE;
            }
            if ($checkOutToTime < $timeLeaveEarly) {
                $status = self::LEAVE_EARLY;
            }
            if ($checkInToTime > $timeArrivalLate && $checkOutToTime < $timeLeaveEarly) {
                $status = self::BOTH;
            }
        }
        return $status;
    }
}


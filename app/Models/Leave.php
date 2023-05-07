<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Leave extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'leaves';

    protected $fillable = [
        'employee_id',
        'leave_date_start',
        'leave_date_end',
        'leave_type',
        'reason',
        'status',
        'time_sent_request',
        'time_response_request',
        'responded_by'
    ];

    // public function employees(): BelongsTo
    // {
    //     return $this->belongsTo(Employees::class);
    // }
    public static function getLeavesByEmployeeId($id, $dataFilter, $dateFilter)
    {
        if ($dataFilter != 'all') {
            $data = self::leftJoin('employees', 'employees.id', 'leaves.employee_id')
                ->where(['employee_id' => $id, 'leaves.status' => $dataFilter])
                ->where('time_sent_request', 'like', $dateFilter.'%')
                ->select('leaves.*');
        } else {
            $data = self::leftJoin('employees', 'employees.id', 'leaves.employee_id')
                ->where('employee_id', $id)
                ->where('time_sent_request', 'like', $dateFilter.'%')
                ->select('leaves.*');
        }
        $data = $data->get();
        foreach ($data as $d) {
            $d['leave_date_start'] = date('Y-m-d', strtotime($d['leave_date_start']));
            $d['leave_date_end'] = date('Y-m-d', strtotime($d['leave_date_end']));
        }
        return $data;
    }

    public static function getAllLeaveRequests($dataFilter, $dateFilter)
    {
        if ($dataFilter != 'all') {
            $data = self::leftJoin('employees', 'employees.id', 'leaves.employee_id')
                ->where(['leaves.status' => $dataFilter])
                ->where('time_sent_request', 'like', $dateFilter.'%')
                ->select('leaves.*', 'employee_code', 'full_name');
        } else {
            $data = self::leftJoin('employees', 'employees.id', 'leaves.employee_id')
                ->where('time_sent_request', 'like', $dateFilter.'%')
                ->select('leaves.*', 'employee_code', 'full_name');
        }
        $data = $data->get();
        foreach ($data as $d) {
            $d['leave_date_start'] = date('Y-m-d', strtotime($d['leave_date_start']));
            $d['leave_date_end'] = date('Y-m-d', strtotime($d['leave_date_end']));
        }
        return $data;
    }

    public static function updateStatusByID($id, $status)
    {
        $employee_code = Employee::getCurrentEmployeeCode();
        return self::where('id', $id)->update([
            'status' => $status,
            'time_response_request' => date('Y-m-d H:i:s'),
            'responded_by' => $employee_code
        ]);
    }
}

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
    public static function getLeavesByEmployeeId($id, $dataFilter)
    {
        if ($dataFilter != 'all') {
            $data = self::leftJoin('employees', 'employees.id', 'leaves.employee_id')
                ->where(['employee_id' => $id, 'leaves.status' => $dataFilter]);
        } else {
            $data = self::leftJoin('employees', 'employees.id', 'leaves.employee_id')
                ->where('employee_id', $id);
        }
        return $data;
    }
}

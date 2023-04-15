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
        'leave_date_start',
        'leave_date_end',
        'leave_type',
        'leave_reason',
        'status',
    ];

    public function employees(): BelongsTo
    {
        return $this->belongsTo(Employees::class);
    }
}

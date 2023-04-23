<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    use HasFactory;

    protected $table = 'salary';

    protected $fillable = [
        'employee_id',
        'month',
        'year',
        'overtime',
        'paid_leaves',
        'total_salary',
        'bonus',
        'basic_salary',
    ];
}

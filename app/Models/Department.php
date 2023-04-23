<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Department extends Model
{
    use HasFactory;

    protected $table = 'departments';

    protected $fillable = [
        'department_name',
        'department_description',
    ];

    public static function getListDepartments()
    {
        return self::leftJoin('employees', 'employees.department_id', 'departments.id')
        ->select('departments.id', 'departments.department_name', 'departments.department_description', 
        DB::raw('COUNT(employees.id) as num_employees'))
        ->groupBy('departments.id','departments.department_name','departments.department_description')
        ->get();
    }
}

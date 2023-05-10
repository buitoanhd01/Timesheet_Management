<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;

    protected $table = 'positions';

    protected $fillable = [
        'position_name',
        'position_description',
    ];

    public static function getListPositions()
    {
        return self::leftJoin('employees', 'employees.position_id', 'positions.id')
        ->select('positions.*', 'employees.full_name as name')
        ->get();
    }

    public static function getListPositionsAvailable()
    {
        return self::leftJoin('employees', 'employees.position_id', 'positions.id')
        ->select('positions.*')->whereNull('employees.position_id')
        ->get();
    }
}

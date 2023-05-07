<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'settings';

    protected $fillable = [

    ];

    public static function getDefaultPassword()
    {
        $data = self::first()->value('password_default');
        if (!isset($data))
        $data = '1234567890';
        return $data;
    }
}

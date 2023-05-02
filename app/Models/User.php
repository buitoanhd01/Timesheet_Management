<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'users';
    protected $fillable = [
        'username',
        'password',
        'role_id',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // public function employees()
    // {
    //     return $this->belongsTo(Employee::class);
    // }


    public static function getAllUsersActive($filter)
    {
        $data = self::with('roles')->leftJoin('employees', 'users.id', 'employees.user_id')
        ->where('users.status', '!=', 'deleted')
        ->select('full_name', 'users.*');
        if (isset($filter)) {
            $data=$data->where('full_name', 'like' , '%'.$filter.'%')
            ->orWhere('username', 'like', '%'.$filter.'%');
        }
        $data=$data->get();
        return $data;
    }
}

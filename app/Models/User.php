<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // We added this
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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // A user with the 'company' role has one company profile
    public function companyProfile()
    {
        return $this->hasOne(CompanyProfile::class);
    }

    // A user with the 'employee' role has one employee profile
    public function employeeProfile()
    {
        return $this->hasOne(EmployeeProfile::class);
    }

    // A user with the 'employee' role can have many job applications
    public function jobApplications()
    {
        return $this->hasMany(JobApplication::class);
    }
}

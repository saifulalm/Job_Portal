<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'major',
        'graduation_year',
        'skills',
        'resume_path',
    ];

    // An employee profile belongs to exactly one user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

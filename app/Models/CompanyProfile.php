<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'company_name',
        'website',
        'logo',
        'description',
    ];

    // A company profile belongs to exactly one user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // A company profile can have many jobs
    public function jobs()
    {
        return $this->hasMany(Job::class);
    }
}

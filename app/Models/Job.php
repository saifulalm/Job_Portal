<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_profile_id',
        'title',
        'description',
        'location',
        'job_type',
        'salary',
    ];

    // A job belongs to one company profile
    public function companyProfile()
    {
        return $this->belongsTo(CompanyProfile::class);
    }

    // A job can have many applications
    public function jobApplications()
    {
        return $this->hasMany(JobApplication::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Patient extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = ['id'];

    public function documents()
    {
        return $this->hasMany(PatientDocument::class, 'patient_id');
    }
}

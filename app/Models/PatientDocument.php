<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientDocument extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $appends = array('PatientDocumentLink');

    public function getPatientDocumentLinkAttribute()
    {
        if (!$this->name) {
            return url('img/admin/no-data.svg');
        } else {
            return url('/storage' . '/' . config('custom.upload.patients.documents') . '/' . $this->name);
        }
    }
}

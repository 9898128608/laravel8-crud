<?php

namespace App\Repositories\Patient;

use App\Models\Patient;
use App\Repositories\BaseRepository;


class PatientRepository extends BaseRepository
{
    protected $patientModel;
    public function __construct(Patient $patientModel)
    {
        parent::__construct($patientModel);
        $this->patientModel = $patientModel;
    }

    
}

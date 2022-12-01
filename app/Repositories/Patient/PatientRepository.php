<?php

namespace App\Repositories\Patient;

use App\Models\Patient as ModelsPatient;
use App\Repositories\BaseRepository;


class PatientRepository extends BaseRepository
{
    protected $patientModel;
    public function __construct(ModelsPatient $patientModel)
    {
        parent::__construct($patientModel);
        $this->patientModel = $patientModel;
    }

    
}

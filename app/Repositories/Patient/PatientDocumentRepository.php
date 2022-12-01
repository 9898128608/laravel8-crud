<?php

namespace App\Repositories\Patient;

use App\Models\PatientDocument;
use App\Repositories\BaseRepository;


class PatientDocumentRepository extends BaseRepository
{
    protected $patientDocumentModel;
    public function __construct(PatientDocument $patientDocumentModel)
    {
        parent::__construct($patientDocumentModel);
        $this->patientDocumentModel = $patientDocumentModel;
    }
}

<?php
return [
    'formats' => [
        'date' => 'd/m/Y',
        'date_time' => 'd/m/Y h:i A',
        'date_time_24' => 'd/m/Y H:i',
        'time' => 'h:i A',
        'date_js' => 'dd/mm/yyyy',
        'sort_date' => 'd M Y',
        'dateonly' => 'Y-m-d',
        'full_date_time' => 'd M Y h:i A'
    ],
    'upload' => [
        'disk' => env('STORAGE_DISK', 'public'),
        'patients' => [
            'documents' => 'patients/documents',
            'profile_picture' => 'patients/profile_picture'
        ]
    ]
];

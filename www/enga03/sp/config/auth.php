<?php
return [
    'guards' => [
        'coach'   => ['driver'=>'session', 'provider'=>'coaches'],
        'student' => ['driver'=>'session', 'provider'=>'students'],
    ],

    'providers' => [
        'coaches'  => ['driver'=>'eloquent', 'model'=>App\Models\Coach::class],
        'students' => ['driver'=>'eloquent', 'model'=>App\Models\Student::class],
    ]
];
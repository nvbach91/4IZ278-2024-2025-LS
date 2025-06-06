<?php
return [
    'guards' => [
        'coach'   => ['driver'=>'session', 'provider'=>'coaches'],
        'student' => ['driver'=>'session', 'provider'=>'students'],
        'admin'   => ['driver'=>'session', 'provider'=>'admins'],
    ],

    'providers' => [
        'coaches'  => ['driver'=>'eloquent', 'model'=>App\Models\Coach::class],
        'students' => ['driver'=>'eloquent', 'model'=>App\Models\Student::class],
        'admins'   => ['driver'=>'eloquent', 'model'=>App\Models\Admin::class],
    ]
];
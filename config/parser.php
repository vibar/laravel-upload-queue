<?php

return [

    'path' => storage_path('app/spreadsheets/'),

    'maxsize' => 5 * 1024, // in kB

    'mimes' => [
        'xlsx'
    ],

    'mimetypes' => [
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
    ],
];

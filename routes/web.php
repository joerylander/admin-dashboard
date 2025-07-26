<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
});

Route::get('/ninjas', function () {
    $ninjas = [
            ["name" => "mario",
            "skill" => 70,
            "id" => "1"
        ],
            ["name" => "luigi",
            "skill" => 45,
            "id" => "2"
            ]
    ];

    return view('ninjas.index', [
        "greeting" => "hellooo",
        "ninjas" => $ninjas
    ]);
});

Route::get("/ninjas/create", function() {
    return view("ninjas.create");
});

// Note: Wildcards routes need to be last as Laravel grabs the first match, going up to down
Route::get("/ninjas/{id}", function ($id) {
    return view("ninjas.show", ["id" => $id]);
});

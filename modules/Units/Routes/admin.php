<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'admin',
    'as' => 'units.',
    'namespace' => 'Modules\Units\Http\Controllers'
], function () {
    Route::prefix('units')->group(function() {
         Route::get('/', 'Main@index');
    });
});

<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'portal',
    'middleware' => 'portal',
    'namespace' => 'Modules\Units\Http\Controllers'
], function () {
    Route::resource('units', 'Main');
    // Route::get('invoices/{invoice}/units', 'Main@show')->name('portal.invoices.units.show');
    // Route::post('invoices/{invoice}/units/confirm', 'Main@confirm')->name('portal.invoices.units.confirm');
});

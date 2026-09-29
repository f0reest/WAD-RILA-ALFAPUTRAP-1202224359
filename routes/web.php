<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WorkshopContactController;
use App\Http\Controllers\WorkshopLocationController;
use App\Http\Controllers\WorkshopPartnerController;
use App\Http\Controllers\WorkshopServiceTypeController;
use App\Http\Controllers\WorkshopSubscriptionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }

    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/workshops', [WorkshopSubscriptionController::class, 'index'])->name('workshops.index');
    Route::get('/workshops/export/excel', [WorkshopSubscriptionController::class, 'exportExcel'])->name('workshops.export.excel');
    Route::get('/workshops/export/pdf', [WorkshopSubscriptionController::class, 'exportPdf'])->name('workshops.export.pdf');
    Route::post('/workshops/subscriptions', [WorkshopSubscriptionController::class, 'store'])->name('workshops.subscriptions.store');
    Route::put('/workshops/subscriptions/{subscription}', [WorkshopSubscriptionController::class, 'update'])->name('workshops.subscriptions.update');
    Route::delete('/workshops/subscriptions/{subscription}', [WorkshopSubscriptionController::class, 'destroy'])->name('workshops.subscriptions.destroy');

    Route::post('/workshops/partners', [WorkshopPartnerController::class, 'store'])->name('workshops.partners.store');
    Route::put('/workshops/partners/{partner}', [WorkshopPartnerController::class, 'update'])->name('workshops.partners.update');
    Route::delete('/workshops/partners/{partner}', [WorkshopPartnerController::class, 'destroy'])->name('workshops.partners.destroy');

    Route::post('/workshops/locations', [WorkshopLocationController::class, 'store'])->name('workshops.locations.store');
    Route::put('/workshops/locations/{location}', [WorkshopLocationController::class, 'update'])->name('workshops.locations.update');
    Route::delete('/workshops/locations/{location}', [WorkshopLocationController::class, 'destroy'])->name('workshops.locations.destroy');

    Route::post('/workshops/contacts', [WorkshopContactController::class, 'store'])->name('workshops.contacts.store');
    Route::put('/workshops/contacts/{contact}', [WorkshopContactController::class, 'update'])->name('workshops.contacts.update');
    Route::delete('/workshops/contacts/{contact}', [WorkshopContactController::class, 'destroy'])->name('workshops.contacts.destroy');

    Route::post('/workshops/service-types', [WorkshopServiceTypeController::class, 'store'])->name('workshops.service-types.store');
    Route::put('/workshops/service-types/{serviceType}', [WorkshopServiceTypeController::class, 'update'])->name('workshops.service-types.update');
    Route::delete('/workshops/service-types/{serviceType}', [WorkshopServiceTypeController::class, 'destroy'])->name('workshops.service-types.destroy');
});

require __DIR__.'/auth.php';

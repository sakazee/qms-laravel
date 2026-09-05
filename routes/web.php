<?php

use App\Http\Controllers\AnimalController;
use App\Http\Controllers\AnimalShareController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TemplateController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Language Switcher
Route::get('/language/{locale}', [LanguageController::class, 'switch'])->name('language.switch');

// Auth Routes
Auth::routes(['verify' => false]);

// Protected Routes
Route::middleware(['auth', 'set.locale', 'ensure.template'])->group(function () {

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Templates
    Route::get('templates/deselect', [TemplateController::class, 'deselect'])->name('templates.deselect');
    Route::resource('templates', TemplateController::class)->except(['show']);
    Route::get('templates/{template}/select', [TemplateController::class, 'select'])->name('templates.select');

    // Animals
    Route::resource('animals', AnimalController::class);

    // Partners
    Route::resource('partners', PartnerController::class);

    // Animal Shares
    Route::resource('shares', AnimalShareController::class);
    Route::get('api/animal/{animal}/info', [AnimalShareController::class, 'getAnimalInfo'])->name('api.animal.info');

    // Expenses
    Route::resource('expenses', ExpenseController::class);

    // Payments
    Route::resource('payments', PaymentController::class);

    // Reports
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('template-summary',        [ReportController::class, 'templateSummary'])->name('template-summary');
        Route::get('template-summary/pdf',    [ReportController::class, 'templateSummaryPdf'])->name('template-summary.pdf');
        Route::get('partner-summary',         [ReportController::class, 'partnerSummary'])->name('partner-summary');
        Route::get('partner-summary/pdf',     [ReportController::class, 'partnerSummaryPdf'])->name('partner-summary.pdf');
        Route::get('animal-summary',          [ReportController::class, 'animalSummary'])->name('animal-summary');
        Route::get('animal-summary/pdf',      [ReportController::class, 'animalSummaryPdf'])->name('animal-summary.pdf');
    });
});

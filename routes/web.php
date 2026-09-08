<?php

use App\Http\Controllers\Admin\ImpersonateController;
use App\Http\Controllers\Admin\ModeController;
use App\Http\Controllers\Admin\TemplateBrowserController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\AnimalController;
use App\Http\Controllers\AnimalShareController;
use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ExpenseHeadController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\UserPreferenceController;
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

    // Change Password
    Route::get('password/change', [ChangePasswordController::class, 'showForm'])->name('password.change');
    Route::post('password/change', [ChangePasswordController::class, 'update'])->name('password.change.update');

    // Templates
    Route::get('templates/deselect', [TemplateController::class, 'deselect'])->name('templates.deselect');
    Route::resource('templates', TemplateController::class)->except(['show']);
    Route::get('templates/{template}/select', [TemplateController::class, 'select'])->name('templates.select');
    Route::post('templates/{template}/make-default', [TemplateController::class, 'makeDefault'])->name('templates.make-default');

    // Expense Heads
    Route::resource('expense-heads', ExpenseHeadController::class)->except(['show']);

    // Animals
    Route::post('animals/bulk-destroy', [AnimalController::class, 'bulkDestroy'])->name('animals.bulk-destroy');
    Route::post('animals/{animal}/status', [AnimalController::class, 'toggleStatus'])->name('animals.toggle-status');
    Route::resource('animals', AnimalController::class);

    // Partners
    Route::post('partners/bulk-destroy', [PartnerController::class, 'bulkDestroy'])->name('partners.bulk-destroy');
    Route::resource('partners', PartnerController::class);

    // Animal Shares
    Route::resource('shares', AnimalShareController::class);
    Route::get('api/animal/{animal}/info', [AnimalShareController::class, 'getAnimalInfo'])->name('api.animal.info');

    // Expenses
    Route::post('expenses/bulk-destroy', [ExpenseController::class, 'bulkDestroy'])->name('expenses.bulk-destroy');
    Route::resource('expenses', ExpenseController::class);

    // Payments
    Route::post('payments/bulk-destroy', [PaymentController::class, 'bulkDestroy'])->name('payments.bulk-destroy');
    Route::resource('payments', PaymentController::class);

    // Sidebar preference
    Route::post('sidebar-mode', [UserPreferenceController::class, 'updateSidebarMode'])->name('sidebar-mode.update');

    // Reports
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('template-summary', [ReportController::class, 'templateSummary'])->name('template-summary');
        Route::get('template-summary/pdf', [ReportController::class, 'templateSummaryPdf'])->name('template-summary.pdf');
        Route::get('partner-summary', [ReportController::class, 'partnerSummary'])->name('partner-summary');
        Route::get('partner-summary/pdf', [ReportController::class, 'partnerSummaryPdf'])->name('partner-summary.pdf');
        Route::get('animal-summary', [ReportController::class, 'animalSummary'])->name('animal-summary');
        Route::get('animal-summary/pdf', [ReportController::class, 'animalSummaryPdf'])->name('animal-summary.pdf');
        Route::get('partner-due-summary', [ReportController::class, 'partnerDueSummary'])->name('partner-due-summary');
        Route::get('partner-due-summary/pdf', [ReportController::class, 'partnerDueSummaryPdf'])->name('partner-due-summary.pdf');
    });
});

// Super Admin Routes
Route::middleware(['auth', 'set.locale', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    // Mode switching (admin <-> user)
    Route::get('switch-to-admin', [ModeController::class, 'switchToAdmin'])->name('switch-to-admin');
    Route::get('switch-to-user', [ModeController::class, 'switchToUser'])->name('switch-to-user');

    // User management
    Route::get('users', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('users/create', [AdminUserController::class, 'create'])->name('users.create');
    Route::post('users', [AdminUserController::class, 'store'])->name('users.store');
    Route::get('users/{user}/edit', [AdminUserController::class, 'edit'])->name('users.edit');
    Route::put('users/{user}', [AdminUserController::class, 'update'])->name('users.update');
    Route::delete('users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');
    Route::post('users/{user}/restore', [AdminUserController::class, 'restore'])->name('users.restore')->withTrashed();
    Route::post('users/{user}/manage', [AdminUserController::class, 'manage'])->name('users.manage');
    Route::post('users/{user}/deactivate', [AdminUserController::class, 'deactivate'])->name('users.deactivate');
    Route::post('users/{user}/activate', [AdminUserController::class, 'activate'])->name('users.activate');

    // Impersonation
    Route::post('impersonate/stop', [ImpersonateController::class, 'stop'])->name('impersonate.stop');
    Route::post('impersonate/{user}', [ImpersonateController::class, 'start'])->name('impersonate');

    // Template browser
    Route::get('templates', [TemplateBrowserController::class, 'index'])->name('templates.index');
    Route::post('templates/{template}/select', [TemplateBrowserController::class, 'select'])->name('templates.select');
    Route::post('templates/{template}/restore', [TemplateBrowserController::class, 'restore'])->name('templates.restore')->withTrashed();
});

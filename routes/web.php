<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\OnboardingController;
use App\Http\Controllers\Auth\AuthUserController;


Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthUserController::class, 'showRegisterForm'])->name('register.form');
    Route::post('/register', [AuthUserController::class, 'register'])->name('register');

    Route::get('/login', [AuthUserController::class, 'showLoginForm'])->name('login.form');
    Route::post('/login', [AuthUserController::class, 'login'])->name('login');
});

Route::post('/logout', [AuthUserController::class, 'logout'])->middleware('auth')->name('logout');

// Onboarding routes - protected by auth middleware
Route::middleware(['auth'])->group(function () {
    // Check if user needs onboarding
    Route::get('/onboarding/check', [OnboardingController::class, 'checkOnboardingStatus'])->name('onboarding.check');
    
    // Onboarding wizard steps
    Route::get('/onboarding', [OnboardingController::class, 'welcome'])->name('onboarding.welcome');
    Route::get('/onboarding/step-1', [OnboardingController::class, 'stepOne'])->name('onboarding.step1');
    Route::post('/onboarding/step-1', [OnboardingController::class, 'storeStepOne'])->name('onboarding.store.step1');
    
    Route::get('/onboarding/step-2', [OnboardingController::class, 'stepTwo'])->name('onboarding.step2');
    Route::post('/onboarding/step-2', [OnboardingController::class, 'storeStepTwo'])->name('onboarding.store.step2');
    
    Route::get('/onboarding/step-3', [OnboardingController::class, 'stepThree'])->name('onboarding.step3');
    Route::post('/onboarding/step-3', [OnboardingController::class, 'storeStepThree'])->name('onboarding.store.step3');
    
    Route::get('/onboarding/complete', [OnboardingController::class, 'complete'])->name('onboarding.complete');
});




// Dashboard route (after onboarding completion)
Route::middleware(['auth', 'onboarding.completed'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\User\UserDashboardController::class, 'dashboard'])->name('dashboard');
});


Route::get('/', function () {
    return view('welcome');
});


Route::get('/admin-dashboard', function () {
    return view('admin.dashboard.dashboard');
});


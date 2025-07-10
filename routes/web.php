<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\OnboardingController;
use App\Http\Controllers\Auth\AuthUserController;
use App\Http\Controllers\Auth\AuthAdminController;


//Landing Page
Route::get('/', function () {
    return view('welcome');
});




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
Route::middleware(['auth', 'onboarding.completed', 'role:user'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\User\UserDashboardController::class, 'dashboard'])->name('dashboard');
});






Route::prefix('admin')->group(function () {
    Route::get('/login', [AuthAdminController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AuthAdminController::class, 'login']);
    Route::get('/register', [AuthAdminController::class, 'showRegisterForm'])->name('admin.register');
    Route::post('/register', [AuthAdminController::class, 'register']);
});

    Route::post('/admin/logout', [AuthAdminController::class, 'logout'])->name('admin.logout');

//Dashboard Contents
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin-dashboard', [App\Http\Controllers\Admin\AdminDashboardController::class, 'dashboard'])->name('admin.dashboard');
});

//Dashboard Contents
Route::get('/new-signups', [App\Http\Controllers\Admin\AdminUserManagementController::class, 'newUsers'])->name('admin.new-signups');
Route::get('/active-users', [App\Http\Controllers\Admin\AdminUserManagementController::class, 'activeUsers'])->name('admin.active-users');
Route::get('/total-workouts', [App\Http\Controllers\Admin\AdminUserManagementController::class, 'totalWorkoutsLogged'])->name('admin.total-workouts');



// Manage exercises
Route::get('/exercises', [App\Http\Controllers\Admin\AdminExerciseController::class, 'index'])->name('exercises.index');
Route::get('/exercises/create', [App\Http\Controllers\Admin\AdminExerciseController::class, 'create'])->name('exercises.create');
Route::post('/exercises', [App\Http\Controllers\Admin\AdminExerciseController::class, 'store'])->name('exercises.store');
Route::get('/exercises/{exercise}/edit', [App\Http\Controllers\Admin\AdminExerciseController::class, 'edit'])->name('exercises.edit');
Route::put('/exercises/{exercise}', [App\Http\Controllers\Admin\AdminExerciseController::class, 'update'])->name('exercises.update');
Route::delete('/exercises/{exercise}', [App\Http\Controllers\Admin\AdminExerciseController::class, 'destroy'])->name('exercises.destroy');

//Manage food items
Route::get('/food-items', [App\Http\Controllers\Admin\AdminFoodItemController::class, 'index'])->name('food_items.index');
Route::get('/food-items/create', [App\Http\Controllers\Admin\AdminFoodItemController::class, 'create'])->name('food_items.create');
Route::post('/food-items', [App\Http\Controllers\Admin\AdminFoodItemController::class, 'store'])->name('food_items.store');
Route::get('/food-items/{food_item}/edit', [App\Http\Controllers\Admin\AdminFoodItemController::class, 'edit'])->name('food_items.edit');
Route::put('/food-items/{food_item}', [App\Http\Controllers\Admin\AdminFoodItemController::class, 'update'])->name('food_items.update');
Route::delete('/food-items/{food_item}', [App\Http\Controllers\Admin\AdminFoodItemController::class, 'destroy'])->name('food_items.destroy');

//Manage workout templates
Route::get('/workout-templates', [App\Http\Controllers\Admin\AdminWorkoutTemplateController::class, 'index'])->name('workout_templates.index');
Route::get('/workout-templates/create', [App\Http\Controllers\Admin\AdminWorkoutTemplateController::class, 'create'])->name('workout_templates.create');
Route::post('/workout-templates', [App\Http\Controllers\Admin\AdminWorkoutTemplateController::class, 'store'])->name('workout_templates.store');
Route::get('/workout-templates/{workout_template}/edit', [App\Http\Controllers\Admin\AdminWorkoutTemplateController::class, 'edit'])->name('workout_templates.edit');
Route::put('/workout-templates/{workout_template}', [App\Http\Controllers\Admin\AdminWorkoutTemplateController::class, 'update'])->name('workout_templates.update');
Route::delete('/workout-templates/{workout_template}', [App\Http\Controllers\Admin\AdminWorkoutTemplateController::class, 'destroy'])->name('workout_templates.destroy');


//Manage workout templates exercises
Route::get('/workout-template-exercises', [App\Http\Controllers\Admin\AdminWorkoutTemplateExerciseController::class, 'index'])->name('workout-template-exercises.index');
Route::get('/workout-template-exercises/create', [App\Http\Controllers\Admin\AdminWorkoutTemplateExerciseController::class, 'create'])->name('workout-template-exercises.create');
Route::post('/workout-template-exercises', [App\Http\Controllers\Admin\AdminWorkoutTemplateExerciseController::class, 'store'])->name('workout-template-exercises.store');
Route::get('/workout-template-exercises/{workout_template_exercise}/edit', [App\Http\Controllers\Admin\AdminWorkoutTemplateExerciseController::class, 'edit'])->name('workout-template-exercises.edit');
Route::put('/workout-template-exercises/{workout_template_exercise}', [App\Http\Controllers\Admin\AdminWorkoutTemplateExerciseController::class, 'update'])->name('workout-template-exercises.update');
Route::delete('/workout-template-exercises/{workout_template_exercise}', [App\Http\Controllers\Admin\AdminWorkoutTemplateExerciseController::class, 'destroy'])->name('workout-template-exercises.destroy');


Route::get('/fitness-motivations', [App\Http\Controllers\Admin\AdminFitnessMotivationController::class, 'index'])->name('fitness-motivations.index');
Route::post('/fitness-motivations', [App\Http\Controllers\Admin\AdminFitnessMotivationController::class, 'store'])->name('fitness-motivations.store');
Route::put('/fitness-motivations/{fitnessMotivation}', [App\Http\Controllers\Admin\AdminFitnessMotivationController::class, 'update'])->name('fitness-motivations.update');
Route::delete('/fitness-motivations/{fitnessMotivation}', [App\Http\Controllers\Admin\AdminFitnessMotivationController::class, 'destroy'])->name('fitness-motivations.destroy');
Route::get('/fitness-motivations/create', [App\Http\Controllers\Admin\AdminFitnessMotivationController::class, 'create'])->name('fitness-motivations.create');
Route::get('/fitness-motivations/{fitnessMotivation}/edit', [App\Http\Controllers\Admin\AdminFitnessMotivationController::class, 'edit'])->name('fitness-motivations.edit');


Route::get('/fitness-facts', [App\Http\Controllers\Admin\AdminFitnessFactController::class, 'index'])->name('fitness-facts.index');
Route::get('/fitness-facts/create', [App\Http\Controllers\Admin\AdminFitnessFactController::class, 'create'])->name('fitness-facts.create');
Route::post('/fitness-facts', [App\Http\Controllers\Admin\AdminFitnessFactController::class, 'store'])->name('fitness-facts.store');
Route::get('/fitness-facts/{fitnessFact}/edit', [App\Http\Controllers\Admin\AdminFitnessFactController::class, 'edit'])->name('fitness-facts.edit');
Route::put('/fitness-facts/{fitnessFact}', [App\Http\Controllers\Admin\AdminFitnessFactController::class, 'update'])->name('fitness-facts.update');
Route::delete('/fitness-facts/{fitnessFact}', [App\Http\Controllers\Admin\AdminFitnessFactController::class, 'destroy'])->name('fitness-facts.destroy');


Route::prefix('users')->name('admin.users.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/', [App\Http\Controllers\Admin\AdminUserManagementController::class, 'index'])->name('index');
    Route::get('/{user}', [App\Http\Controllers\Admin\AdminUserManagementController::class, 'show'])->name('show');
    Route::get('/{user}/edit', [App\Http\Controllers\Admin\AdminUserManagementController::class, 'edit'])->name('edit');
    Route::put('/{user}', [App\Http\Controllers\Admin\AdminUserManagementController::class, 'update'])->name('update');
    Route::delete('/{user}', [App\Http\Controllers\Admin\AdminUserManagementController::class, 'destroy'])->name('destroy');
});

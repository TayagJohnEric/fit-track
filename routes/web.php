<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\OnboardingController;
use App\Http\Controllers\Auth\AuthUserController;
use App\Http\Controllers\Auth\AuthAdminController;



//Landing Page
Route::get('/', function () {
    return view('welcome');
});



//User Auth
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

// User Log Meal
Route::middleware('auth', 'role:user')->group(function () {
    // Nutrition Logging Routes
    Route::prefix('nutrition')->name('nutrition.')->group(function () {
        Route::get('/', [App\Http\Controllers\User\UserMealLogController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\User\UserMealLogController::class, 'create'])->name('create');
        Route::post('/store', [App\Http\Controllers\User\UserMealLogController::class, 'store'])->name('store');
        Route::delete('/entry/{entry}', [App\Http\Controllers\User\UserMealLogController::class, 'destroyEntry'])->name('entry.destroy');
        
        // Custom food routes
        Route::get('/custom-food/create', [App\Http\Controllers\User\UserMealLogController::class, 'createCustomFood'])->name('custom-food.create');
        Route::post('/custom-food/store', [App\Http\Controllers\User\UserMealLogController::class, 'storeCustomFood'])->name('custom-food.store');
        
        // AJAX routes
        Route::get('/search-food', [App\Http\Controllers\User\UserMealLogController::class, 'searchFoodItems'])->name('search-food');
    });
});

//User Workout 
Route::middleware('auth')->group(function () {
    // Today's workout
    Route::get('/workouts/today', [App\Http\Controllers\User\UserWorkoutController::class, 'todaysWorkout'])->name('workouts.today');
    
    // Exercise detail view
    Route::get('/workouts/{workoutScheduleId}/exercise/{exerciseId}', [App\Http\Controllers\User\UserWorkoutController::class, 'showExercise'])->name('workouts.exercise.show');
    
    // Complete workout
    Route::post('/workouts/{workoutScheduleId}/complete', [App\Http\Controllers\User\UserWorkoutController::class, 'completeWorkout'])->name('workouts.complete');
    
    // Skip workout
    Route::post('/workouts/{workoutScheduleId}/skip', [App\Http\Controllers\User\UserWorkoutController::class, 'skipWorkout'])->name('workouts.skip');

    // Workout history
    Route::get('/workouts/history', [App\Http\Controllers\User\UserWorkoutController::class, 'history'])->name('workouts.history');
});

// Meal Ideas Routes
    Route::prefix('meal-ideas')->middleware(['auth'])->name('meal-ideas.')->group(function () {
        Route::get('/', [App\Http\Controllers\User\UserMealIdeasController::class, 'index'])->name('index');
        Route::get('/details', [App\Http\Controllers\User\UserMealIdeasController::class, 'show'])->name('show');
        Route::get('/log-form', [App\Http\Controllers\User\UserMealIdeasController::class, 'showLogForm'])->name('log-form');
        Route::post('/log-meal', [App\Http\Controllers\User\UserMealIdeasController::class, 'logMeal'])->name('log-meal');
    });
    

    
// User Progress Routes - RESTful resource routes
Route::middleware(['auth'])->prefix('progress')->name('progress.')->group(function () {
    
    // Main progress dashboard
    Route::get('/', [App\Http\Controllers\User\UserProgressController::class, 'index'])->name('index');
    Route::get('/weight/history', [App\Http\Controllers\User\UserProgressController::class, 'weightHistory'])->name('weight-history');

    // Weight logging routes
    Route::get('/weight/create', [App\Http\Controllers\User\UserProgressController::class, 'create'])->name('create');
    Route::post('/weight', [App\Http\Controllers\User\UserProgressController::class, 'store'])->name('store');
    Route::get('/weight/{id}/edit', [App\Http\Controllers\User\UserProgressController::class, 'edit'])->name('edit');
    Route::put('/weight/{id}', [App\Http\Controllers\User\UserProgressController::class, 'update'])->name('update');
    Route::delete('/weight/{id}', [App\Http\Controllers\User\UserProgressController::class, 'destroy'])->name('destroy');
    
    // AJAX route for chart data updates
    Route::get('/chart-data', [App\Http\Controllers\User\UserProgressController::class, 'getChartData'])->name('chart-data');
    
});


// Profile routes 
Route::middleware(['auth'])->group(function () {
    
    // Profile management routes
    Route::get('/profile', [App\Http\Controllers\User\UserProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [App\Http\Controllers\User\UserProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [App\Http\Controllers\User\UserProfileController::class, 'update'])->name('profile.update');
    
    // Password change routes
    Route::get('/profile/change-password', [App\Http\Controllers\User\UserProfileController::class, 'showChangePasswordForm'])->name('profile.change-password');
    Route::put('/profile/change-password', [App\Http\Controllers\User\UserProfileController::class, 'updatePassword'])->name('profile.update-password');
});





Route::middleware(['auth'])->group(function () {
    
    // Main exercise listing page with search and filtering
    Route::get('/exercises-library', [App\Http\Controllers\User\UserExerciseController::class, 'index'])->name('exercises-library.index');
    
    // Individual exercise detail page
    Route::get('/exercises-library/{exercise}', [App\Http\Controllers\User\UserExerciseController::class, 'show'])->name('exercises-library.show');
    
    // AJAX Routes for dynamic functionality
    Route::prefix('api/exercises')->group(function () {
        
        // AJAX search endpoint for real-time filtering
        Route::get('/search', [App\Http\Controllers\User\UserExerciseController::class, 'search'])->name('exercises.search');
        
        // Get exercise details for modals/quick view
        Route::get('/{exercise}/details', [App\Http\Controllers\User\UserExerciseController::class, 'getDetails'])->name('exercises.details');
        
        // Filter exercises by muscle group
        Route::get('/muscle-group', [App\Http\Controllers\User\UserExerciseController::class, 'getByMuscleGroup'])->name('exercises.by-muscle-group');
        
    });
    
});



// Custom Food Management Routes
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('custom-foods', [App\Http\Controllers\User\UserCustomFoodItemController::class, 'index'])->name('custom-foods.index');
    Route::get('custom-foods/{custom_food}/edit', [App\Http\Controllers\User\UserCustomFoodItemController::class, 'edit'])->name('custom-foods.edit');
    Route::put('custom-foods/{custom_food}', [App\Http\Controllers\User\UserCustomFoodItemController::class, 'update'])->name('custom-foods.update');
    Route::delete('custom-foods/{custom_food}', [App\Http\Controllers\User\UserCustomFoodItemController::class, 'destroy'])->name('custom-foods.destroy');
});








//Admin Auth
Route::prefix('admin')->group(function () {
    Route::get('/login', [AuthAdminController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AuthAdminController::class, 'login']);
    Route::get('/register', [AuthAdminController::class, 'showRegisterForm'])->name('admin.register');
    Route::post('/register', [AuthAdminController::class, 'register']);
});

    Route::post('/admin/logout', [AuthAdminController::class, 'logout'])->name('admin.logout');

//Admin Dashboard
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin-dashboard', [App\Http\Controllers\Admin\AdminDashboardController::class, 'dashboard'])->name('admin.dashboard');
});

//Dashboard Cards Contents
Route::get('/new-signups', [App\Http\Controllers\Admin\AdminUserManagementController::class, 'newUsers'])->name('admin.new-signups');
Route::get('/active-users', [App\Http\Controllers\Admin\AdminUserManagementController::class, 'activeUsers'])->name('admin.active-users');
Route::get('/total-workouts', [App\Http\Controllers\Admin\AdminUserManagementController::class, 'totalWorkoutsLogged'])->name('admin.total-workouts');



// Manage exercises
Route::get('/exercises', [App\Http\Controllers\Admin\AdminExerciseController::class, 'index'])->name('exercises.index');
Route::post('/exercises', [App\Http\Controllers\Admin\AdminExerciseController::class, 'store'])->name('exercises.store');
Route::put('/exercises/{exercise}', [App\Http\Controllers\Admin\AdminExerciseController::class, 'update'])->name('exercises.update');
Route::delete('/exercises/{exercise}', [App\Http\Controllers\Admin\AdminExerciseController::class, 'destroy'])->name('exercises.destroy');

//Manage food items
Route::get('/food-items', [App\Http\Controllers\Admin\AdminFoodItemController::class, 'index'])->name('food_items.index');
Route::post('/food-items', [App\Http\Controllers\Admin\AdminFoodItemController::class, 'store'])->name('food_items.store');
Route::put('/food-items/{food_item}', [App\Http\Controllers\Admin\AdminFoodItemController::class, 'update'])->name('food_items.update');
Route::delete('/food-items/{food_item}', [App\Http\Controllers\Admin\AdminFoodItemController::class, 'destroy'])->name('food_items.destroy');

//Manage workout templates
Route::get('/workout-templates', [App\Http\Controllers\Admin\AdminWorkoutTemplateController::class, 'index'])->name('workout_templates.index');
Route::post('/workout-templates', [App\Http\Controllers\Admin\AdminWorkoutTemplateController::class, 'store'])->name('workout_templates.store');
Route::put('/workout-templates/{workout_template}', [App\Http\Controllers\Admin\AdminWorkoutTemplateController::class, 'update'])->name('workout_templates.update');
Route::delete('/workout-templates/{workout_template}', [App\Http\Controllers\Admin\AdminWorkoutTemplateController::class, 'destroy'])->name('workout_templates.destroy');


//Manage workout templates exercises
Route::get('/workout-template-exercises', [App\Http\Controllers\Admin\AdminWorkoutTemplateExerciseController::class, 'index'])->name('workout-template-exercises.index');
Route::get('/workout-template-exercises/create', [App\Http\Controllers\Admin\AdminWorkoutTemplateExerciseController::class, 'create'])->name('workout-template-exercises.create');
Route::post('/workout-template-exercises', [App\Http\Controllers\Admin\AdminWorkoutTemplateExerciseController::class, 'store'])->name('workout-template-exercises.store');
Route::get('/workout-template-exercises/{workout_template_exercise}/edit', [App\Http\Controllers\Admin\AdminWorkoutTemplateExerciseController::class, 'edit'])->name('workout-template-exercises.edit');
Route::put('/workout-template-exercises/{workout_template_exercise}', [App\Http\Controllers\Admin\AdminWorkoutTemplateExerciseController::class, 'update'])->name('workout-template-exercises.update');
Route::delete('/workout-template-exercises/{workout_template_exercise}', [App\Http\Controllers\Admin\AdminWorkoutTemplateExerciseController::class, 'destroy'])->name('workout-template-exercises.destroy');

//Manage Fitness motivation
Route::get('/fitness-motivations', [App\Http\Controllers\Admin\AdminFitnessMotivationController::class, 'index'])->name('fitness-motivations.index');
Route::post('/fitness-motivations', [App\Http\Controllers\Admin\AdminFitnessMotivationController::class, 'store'])->name('fitness-motivations.store');
Route::put('/fitness-motivations/{fitnessMotivation}', [App\Http\Controllers\Admin\AdminFitnessMotivationController::class, 'update'])->name('fitness-motivations.update');
Route::delete('/fitness-motivations/{fitnessMotivation}', [App\Http\Controllers\Admin\AdminFitnessMotivationController::class, 'destroy'])->name('fitness-motivations.destroy');

//Manage Fitness Facts
Route::get('/fitness-facts', [App\Http\Controllers\Admin\AdminFitnessFactController::class, 'index'])->name('fitness-facts.index');
Route::post('/fitness-facts', [App\Http\Controllers\Admin\AdminFitnessFactController::class, 'store'])->name('fitness-facts.store');
Route::put('/fitness-facts/{fitnessFact}', [App\Http\Controllers\Admin\AdminFitnessFactController::class, 'update'])->name('fitness-facts.update');
Route::delete('/fitness-facts/{fitnessFact}', [App\Http\Controllers\Admin\AdminFitnessFactController::class, 'destroy'])->name('fitness-facts.destroy');

//Manage Users
Route::prefix('users')->name('admin.users.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/', [App\Http\Controllers\Admin\AdminUserManagementController::class, 'index'])->name('index');
    Route::get('/{user}', [App\Http\Controllers\Admin\AdminUserManagementController::class, 'show'])->name('show');
    Route::get('/{user}/edit', [App\Http\Controllers\Admin\AdminUserManagementController::class, 'edit'])->name('edit');
    Route::put('/{user}', [App\Http\Controllers\Admin\AdminUserManagementController::class, 'update'])->name('update');
    Route::delete('/{user}', [App\Http\Controllers\Admin\AdminUserManagementController::class, 'destroy'])->name('destroy');
});

// Manage Allergy
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/allergies', [App\Http\Controllers\Admin\AdminAllergyController::class, 'index'])->name('allergies.index');
    Route::post('/allergies', [App\Http\Controllers\Admin\AdminAllergyController::class, 'store'])->name('allergies.store');
    Route::put('/allergies/{allergy}', [App\Http\Controllers\Admin\AdminAllergyController::class, 'update'])->name('allergies.update');
    Route::delete('/allergies/{allergy}', [App\Http\Controllers\Admin\AdminAllergyController::class, 'destroy'])->name('allergies.destroy');
});

    // Food Item Allergies Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/food-item-allergies', [App\Http\Controllers\Admin\AdminFoodItemAllergyController::class, 'index'])->name('food_item_allergies.index');
    Route::post('/food-item-allergies', [App\Http\Controllers\Admin\AdminFoodItemAllergyController::class, 'store'])->name('food_item_allergies.store');
    Route::put('/food-item-allergies/{foodItemAllergy}', [App\Http\Controllers\Admin\AdminFoodItemAllergyController::class, 'update'])->name('food_item_allergies.update');
    Route::delete('/food-item-allergies/{foodItemAllergy}', [App\Http\Controllers\Admin\AdminFoodItemAllergyController::class, 'destroy'])->name('food_item_allergies.destroy');
});
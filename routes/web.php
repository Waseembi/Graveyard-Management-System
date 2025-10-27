<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\User_RegistrationController;
use App\Http\Controllers\GraveSearchController;
use App\Http\Controllers\FamilyMemberController;
use App\Http\Controllers\AdminUserController;



Route::get('/', [AuthController::class, 'home'])->name('home');
Route::get('/about', function () {
    return view('about');
})->name('about');
Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/search', function () {
    return view('search');
})->name('search');


// Route::middleware(['auth'])->group(function () {
//     Route::get('/register-grave', [User_RegistrationController::class, 'create'])->name('registration.create');
//     Route::post('/register-grave', [User_RegistrationController::class, 'store'])->name('registration.store');
// });


Route::get('/search-grave', [GraveSearchController::class, 'index'])->name('grave.search');

// Route::get('/register-grave', [GraveRegistrationController::class, 'create'])->name('registration.create');
// Route::post('/register-grave', [GraveRegistrationController::class, 'store'])->name('registration.store');





// Route::get('/user/dashboard', [UserController::class, 'index'])->name('user.dashboard');

Route::middleware(['auth'])->group(function () {

    Route::get('/register-grave', [User_RegistrationController::class, 'create'])->name('registration.create');
    Route::post('/register-grave', [User_RegistrationController::class, 'store'])->name('registration.store');

    Route::get('/user/dashboard', [UserController::class, 'index'])->name('user.dashboard');

    Route::get('/user/register', [User_RegistrationController::class, 'ucreate'])->name('user.register.create');
    Route::post('/user/register', [User_RegistrationController::class, 'ustore'])->name('user.register.store');
    //Family
    Route::get('/family/register', [FamilyMemberController::class, 'create'])->name('family.create');
    Route::post('/family/register', [FamilyMemberController::class, 'store'])->name('family.store');

});

//admin 
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/users', [AdminUserController::class, 'index'])->name('admin.users');
    Route::get('/admin/users/{id}', [AdminUserController::class, 'show'])->name('admin.users.show');
    Route::get('/admin/users/{id}/edit', [AdminUserController::class, 'edit'])->name('admin.users.edit');
    Route::put('/admin/users/{id}', [AdminUserController::class, 'update'])->name('admin.users.update');
    Route::delete('/admin/users/{id}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');


    
   








Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

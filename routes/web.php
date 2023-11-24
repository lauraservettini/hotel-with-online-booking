<?php

use App\Http\Controllers\Backend\TeamController;
use App\Http\Controllers\Backend\BookareaController;
use App\Http\Controllers\Backend\RoomTypeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [UserController::class, 'home'])->name('home');

Route::get('/dashboard', function () {
    return view('frontend.dashboard.user_dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [UserController::class, 'userProfile'])->name('user.profile');
    Route::post('/profile/store', [UserController::class, 'updateProfile'])->name('user.profile.store');
    Route::get('/user/logout', [UserController::class, 'logout'])->name('user.logout');
    Route::get('/user/change/password', [UserController::class, 'changePassword'])->name('change.password');
    Route::post('/user/change/password', [UserController::class, 'updatePassword'])->name('update.password');
});

require __DIR__ . '/auth.php';

//Admin group middleware
Route::middleware('auth', 'roles:admin')->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');
    Route::get('/admin/profile', [AdminController::class, 'profile'])->name('admin.profile');
    Route::post('/admin/profile', [AdminController::class, 'updateProfile'])->name('admin.profile.store');
    Route::get('/admin/change/password', [AdminController::class, 'updatePassword'])->name('admin.change.password');
    Route::post('/admin/change/password', [AdminController::class, 'storePassword'])->name('admin.change.password.store');
});

Route::get('/admin/login', [AdminController::class, 'login'])->name('admin.login');

//Admin teams group middleware
Route::middleware('auth', 'roles:admin')->group(function () {

    // Team All Route Group
    Route::controller(TeamController::class)->group(function () {
        Route::get('/admin/all-team', 'allTeam')->name('all.team');
        Route::get('/admin/add-team', 'getAddTeam')->name('add.team');
        Route::post('/admin/add-team', 'postAddTeam')->name('post.add.team');
        Route::get('/admin/edit/{id}', 'getEdit')->name('edit.team');
        Route::post('/admin/edit/{id}', 'postEdit')->name('update.team');
        Route::get('/admin/delete/{id}', 'delete')->name('delete.team');
    });

    // Book Area All Route Group
    Route::controller(BookareaController::class)->group(function () {
        Route::get('/admin/update/bookarea', 'getUpdateBookarea')->name('update.bookarea');
        Route::post('/admin/update/bookarea', 'postUpdateBookarea')->name('store.bookarea');
    });

    // Room Type All Route Group
    Route::controller(RoomTypeController::class)->group(function () {
        Route::get('/admin/room-type/list', 'roomTypeList')->name('room.type.list');
        Route::get('/admin/room-type/add', 'addRoomType')->name('add.room.type');
        Route::post('/admin/room-type/add', 'postAddRoomType')->name('store.room.type');
    });
});

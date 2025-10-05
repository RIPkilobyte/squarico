<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OpportunitiesController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Laravel\Fortify\Http\Controllers\NewPasswordController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => 'auth'], function(){

    Route::get('/details', [UserController::class, 'details'])->name('details');
    Route::get('/details-success', [UserController::class, 'details'])->name('details.success');
    Route::post('/details', [UserController::class, 'detailsStore'])->name('details');

    Route::get('/opportunities', [OpportunitiesController::class, 'index'])->name('opportunities');

    Route::get('/investments', [UserController::class, 'investments'])->name('investments');

    Route::get('/investor-complete', [UserController::class, 'investorComplete'])->name('investor.complete');

    Route::get('/identity', [UserController::class, 'identity'])->name('identity');
    Route::get('/identity-wait', [UserController::class, 'identityWait'])->name('identity.wait');
    Route::get('/identity-change', [UserController::class, 'identityChange'])->name('identity.change');
    Route::post('/identity', [UserController::class, 'identityStore'])->name('identity');

    Route::get('/test', [UserController::class, 'test'])->name('test');
    Route::get('/test-process', [UserController::class, 'testProcess'])->name('test.process');
    Route::post('/test', [UserController::class, 'testStore'])->name('test');

    Route::get('/profile/password', [UserController::class, 'changePassword'])->name('profile.password');
    Route::post('/profile/password', [UserController::class, 'changePasswordStore'])->name('profile.password');

    Route::get('/profile/delete', [UserController::class, 'deleteProfile'])->name('profile.delete');
    Route::post('/profile/delete', [UserController::class, 'deleteProfileStore'])->name('profile.delete');

    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/user/view/{id}', [AdminController::class, 'user'])->name('user');
    Route::get('/api/users', [AdminController::class, 'usersDatatable'])->name('users.datatable');
    Route::get('/user/investments/complete/{id}', [AdminController::class, 'usersInvestmentComplete'])->name('users.investments.complete');
    Route::get('/user/investments/delete/{id}', [AdminController::class, 'usersInvestmentDelete'])->name('users.investments.delete');
    Route::get('/user/approve/{id}', [AdminController::class, 'userApprove'])->name('user.approve');
    Route::get('/user/attention/{id}', [AdminController::class, 'userAttention'])->name('user.attention');
    Route::get('/user/verify/{id}', [AdminController::class, 'userVerify'])->name('user.verify');
    Route::get('/user/delete/{id}', [AdminController::class, 'userDelete'])->name('user.delete');
    Route::post('/user/view/{id}', [AdminController::class, 'userStore'])->name('user');
    Route::post('/user/notes/{id}', [AdminController::class, 'userNotes'])->name('user.notes');
    Route::post('/user/project', [AdminController::class, 'userProject'])->name('user.project');
    Route::post('/user/investments', [AdminController::class, 'userProjectStore'])->name('user.investments');

    Route::get('/projects', [AdminController::class, 'projects'])->name('projects');
    Route::get('/project/view/{id}', [AdminController::class, 'project'])->name('project');
    Route::get('/project/delete/{id}', [AdminController::class, 'projectDelete'])->name('project.delete');
    Route::get('/api/projects', [AdminController::class, 'projectsDatatable'])->name('projects.datatable');
    Route::post('/project/view/{id}', [AdminController::class, 'projectStore'])->name('project');

    Route::get('/download/{id}', [UserController::class, 'downloadFile'])->name('download');
    Route::get('/delete/{id}', [UserController::class, 'deleteFile'])->name('delete');
    Route::post('/upload', [UserController::class, 'uploadFile'])->name('upload');

    Route::post('/upload', [UserController::class, 'uploadFile'])->name('upload');
});
Route::get('/kilobyte', [UserController::class, 'kilobyte'])->name('kilobyte');

Route::get('/', [AuthController::class, 'router'])->name('home');

Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'registerStore'])->name('register');

Route::get('/forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot-password');
Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])
                ->middleware(['guest:'.config('fortify.guard')])
                ->name('password.reset');
Route::post('/forgot-password', [AuthController::class, 'forgotPasswordStore'])->name('forgot-password');

Route::get('/investor', [AuthController::class, 'investorType'])->name('investor');
Route::get('/investor-description/{type}', [AuthController::class, 'investorTypeText'])->name('investor.description');
Route::post('/investor', [AuthController::class, 'investorTypeStore'])->name('investor');

Route::get('/complete', [AuthController::class, 'complete'])->name('register.complete');

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::get('/clear', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    Artisan::call('route:clear');

    return "All cache clear!";
});

<?php

use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CookieController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LocalizationController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
// use Laravel\Cashier\Http\Controllers\WebhookController;
// use GuzzleHttp\Middleware;
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

Route::get('/', function () {
    return view('welcome');
});

Route::resource('reset', PasswordResetLinkController::class);

// ------------------------------Routes of Roles, Users, & Permissions-----------------------------

Route::group(['Middleware' => ['role:super-admin|admin']], function(){

    Route::resource('permissions', PermissionController::class);
    Route::get('permissions/{permissionId}/delete', [PermissionController::class, 'destroy']);

    Route::resource('roles', RoleController::class);
    Route::get('roles/{roleId}/delete', [RoleController::class, 'destroy']);

    Route::get('roles/{roleId}/give-permissions', [RoleController::class, 'addPermissionsToRole']);
    Route::put('roles/{roleId}/give-permissions', [RoleController::class, 'updatePermissionsToRole']);

    Route::resource('users', UserController::class);
    Route::get('users/{userId}/delete', [UserController::class, 'destroy']);

});

// -----------------------------------------Dashboard----------------------------------------------

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');

// ------------------------------------------Profile-----------------------------------------------

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// ---------------------------------------Error Handling Route-------------------------------------

Route::get('/404', function () {
    return view('404');
});

//-----------------------------------------Payment Submission Routes-------------------------------

Route::post('single-charge', [HomeController::class, 'singleCharge'])->name('single.charge');
// Route::get('plans/create', [SubscriptionController::class, 'showPlanForm'])->name('plans.create');
// Route::post('plans/store', [SubscriptionController::class, 'savePlan'])->name('plans.store');


// Route::get('plans', [SubscriptionController::class, 'allPlans'])->name('plans.all');
// Route::get('plans/checkout/{planId}', [SubscriptionController::class, 'checkout'])->name('plans.checkout');
// Route::post('plans/process', [SubscriptionController::class, 'processPlan'])->name('plan.process');

// Route::get('subscriptions/all', [SubscriptionController::class, 'allSubscriptions'])->name('subscriptions.all');
// Route::get('subscriptions/cancel', [SubscriptionController::class, 'cancelSubscriptions'])->name('subscriptions.cancel');
// Route::get('subscriptions/resume', [SubscriptionController::class, 'resumeSubscriptions'])->name('subscriptions.resume');

// ----------------------------------------Testing Routes------------------------------------------

Route::get('/demo', function(){
    echo 'hello';
});

Route::get('/test', function(){
    echo 'Testing the route';
});

Route::get('/cookie/set',[CookieController:: class, 'setCookie']);
Route::get('/cookie/get',[CookieController:: class, 'getCookie']);

Route::get('/basic_response', function () {
    return 'Hello World';
});

Route::get('/header',function() {
    return response("Hello", 200)->header('Content-Type', 'text/html');
});

Route::get('/cookie',function() {
    return response("Hello", 200)->header('Content-Type', 'text/html')
       ->withcookie('name','Virat Gandhi');
});

Route::get('json',function() {
   return response()->json(['name' => 'Virat Gandhi', 'state' => 'Gujarat']);
});

Route::get('localization/{locale}',[LocalizationController::class, 'index']);

Route::get('session/get',   [SessionController::class, 'accessSessionData']);
Route::get('session/set',   [SessionController::class, 'storeSessionData']);
Route::get('session/remove',[SessionController::class, 'deleteSessionData']);





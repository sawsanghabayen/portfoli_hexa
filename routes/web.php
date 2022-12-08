<?php

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

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\HomeController;
// use App\Http\Controllers\InfoController;
use WEB\Admin\SettingController;

// use ExperienceController;
// use EducationController;
use App\Models\Cart;
use App\Models\Setting;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => [
        'localeSessionRedirect',
        'localizationRedirect',
        'localeViewPath'
    ]
], function () {

    Route::prefix('portfolio-project')->group(function () {
        // Route::post('/contact', [ContactController::class ,'store'])->name('contacts.store');
    Route::post('/message', [App\Http\Controllers\MessageController::class ,'store'])->name('messages.store');
        
        Route::get('/',[ HomeController::class,'index'])->name('app.index');
    });
Route::get('/cv',[ App\Http\Controllers\InfoController::class,'downloadCv'])->name('portfolio.cv');
    



   

    Route::get('forgot/password', 'Auth\ForgotPasswordController@forgotPasswordForm')->name('forgotPasswordForm');
    Route::post('sendResetLinkEmail', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('sendResetLinkEmail');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.new');
    Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');




    Route::get('/checkPayment/{order_id}', 'API\v1\CartController@checkPayment')->name('checkPayment');


    Route::group(['middleware' => ['auth']], function () {

    });


    Route::get('/sendMail', function (){


    });


    // Route::resource('/setting_copies', 'WEB\Admin\SettingCopyController');



    //ADMIN AUTH ///
    Route::group(['prefix' => 'admin'], function () {
        Route::get('/', function () {
            return route('/login');
        });


        Route::get('/login', 'AdminAuth\LoginController@showLoginForm')->name('admin.login.form');
        Route::post('/login', 'AdminAuth\LoginController@login')->name('admin.login');
        Route::get('/logout', 'AdminAuth\LoginController@logout')->name('admin.logout');
    });


    Route::group(['middleware' => ['web', 'admin'], 'prefix' => 'admin', 'as' => 'admin.',], function () {
        Route::get('/', function () {
            return redirect('/admin/home');
        });
        Route::post('/changeStatus/{model}', 'WEB\Admin\HomeController@changeStatus');

        Route::get('home', 'WEB\Admin\HomeController@index')->name('admin.home');

        Route::get('/admins/{id}/edit', 'WEB\Admin\AdminController@edit')->name('admins.edit');
        Route::patch('/admins/{id}', 'WEB\Admin\AdminController@update')->name('users.update');
        Route::get('/admins/{id}/edit_password', 'WEB\Admin\AdminController@edit_password')->name('admins.edit_password');
        Route::post('/admins/{id}/edit_password', 'WEB\Admin\AdminController@update_password')->name('admins.edit_password');


        Route::get('/admins', 'WEB\Admin\AdminController@index')->name('admins.all');
        Route::post('/admins/changeStatus', 'WEB\Admin\AdminController@changeStatus')->name('admin_changeStatus');
        Route::delete('admins/{id}', 'WEB\Admin\AdminController@destroy')->name('admins.destroy');
        Route::post('/admins', 'WEB\Admin\AdminController@store')->name('admins.store');
        Route::get('/admins/create', 'WEB\Admin\AdminController@create')->name('admins.create');
        Route::get('/editMyProfile', 'WEB\Admin\AdminController@editMyProfile')->name('admins.editMyProfile');
        Route::post('/updateProfile', 'WEB\Admin\AdminController@updateProfile')->name('admins.updateProfile');
        Route::get('/changeMyPassword', 'WEB\Admin\AdminController@changeMyPassword')->name('admins.changeMyPassword');
        Route::post('/updateMyPassword', 'WEB\Admin\AdminController@updateMyPassword')->name('admins.updateMyPassword');


        // Sawsan
        Route::get('/categories/{id}/meals', 'WEB\Admin\CategoryController@meals');
        Route::resource('/categories', 'WEB\Admin\CategoryController');

        Route::resource('settings', SettingController::class);
        Route::resource('educations', EducationController::class);
        Route::resource('experiences', ExperienceController::class);
        Route::resource('skills', SkillController::class);
        Route::resource('projects', ProjectController::class);
        Route::resource('infos', InfoController::class);
        Route::get('/messages', [App\Http\Controllers\MessageController::class ,'index'])->name('messages.index');
        Route::delete('/messages/{id}', [App\Http\Controllers\MessageController::class ,'destroy'])->name('messages.delete');
        Route::get('profile/personal', [AuthController::class, 'profilePersonalInformation'])->name('admin.profile.personal-information');
    
        Route::put('profile/personal', [AuthController::class, 'updateProfilePersonalInformation'])->name('admin.profile.update-personal-information');
        
        Route::get('profile/account', [AuthController::class, 'profileAccountInformatiion'])->name('admin.profile.account-information');
       






        Route::resource('/pages', 'WEB\Admin\PagesController');

        Route::resource('/roles', 'WEB\Admin\RolesController');
        Route::resource('/notifications', 'WEB\Admin\NotificationsController');

        Route::get('logs', 'WEB\Admin\LogController@index');


    });



 



});


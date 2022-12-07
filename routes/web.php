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

// use App\Http\Controllers\WEB\Admin\SettingController;









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
    

    // Route::get('settings', 'SettingController@index')->name('settings.index');

    // Route::resource('/setting_copies', 'WEB\SubAdmin\CategoryController');      
    // Route::resource('/categories', 'WEB\Admin\CategoryController');
    // Route::resource('/categories', 'WEB\SubAdmin\CategoryController');



    Route::get('/failPayment', function () { return view('website.fail');})->name('failPayment');
    Route::get('/successPayment', function () {
        return view('website.success');
    })->name('successPayment');
    Route::get('/payment', function () {
        return view('website.payment');
    })->name('payment');

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



        Route::get('/users', 'WEB\Admin\UsersController@index')->name('users.all');
        Route::post('/users', 'WEB\Admin\UsersController@store')->name('users.store');
        Route::get('/users/create', 'WEB\Admin\UsersController@create')->name('users.create');
        Route::delete('users/{id}', 'WEB\Admin\UsersController@destroy')->name('users.destroy');
        Route::get('/users/{id}/edit', 'WEB\Admin\UsersController@edit')->name('users.edit');
        Route::get('/users/{id}/show', 'WEB\Admin\UsersController@show')->name('users.show');
        Route::get('/users/{id}/orders', 'WEB\Admin\UsersController@orders')->name('users.orders');
        Route::get('/users/{id}/{order_id}/editOrder', 'WEB\Admin\UsersController@editOrder')->name('users.editOrder');
        Route::patch('/users/{id}', 'WEB\Admin\UsersController@update')->name('users.update');
        Route::get('/users/{id}/edit_password', 'WEB\Admin\UsersController@edit_password')->name('users.edit_password');
        Route::post('/users/{id}/edit_password', 'WEB\Admin\UsersController@update_password')->name('users.edit_password');
        Route::get('/exportUsers', 'WEB\Admin\UsersController@exportUsers');
        Route::get('/pdfUsers', 'WEB\Admin\UsersController@pdfUsers');



        Route::get('/providers/{id}/orders', 'WEB\Admin\ProvidersController@orders')->name('providers.orders');
        Route::get('/providers/{id}/{order_id}/editOrder', 'WEB\Admin\ProvidersController@editOrder')->name('users.editOrder');
        Route::get('/providers', 'WEB\Admin\ProvidersController@index')->name('providers.all');
        Route::post('/providers', 'WEB\Admin\ProvidersController@store')->name('providers.store');
        Route::get('/providers/create', 'WEB\Admin\ProvidersController@create')->name('providers.create');
        Route::delete('providers/{id}', 'WEB\Admin\ProvidersController@destroy')->name('providers.destroy');
        Route::get('/providers/{id}/edit', 'WEB\Admin\ProvidersController@edit')->name('providers.edit');
        Route::get('/providers/{id}/categories', 'WEB\Admin\ProvidersController@categories')->name('providers.categories');
        Route::get('/providers/{id}/meals', 'WEB\Admin\ProvidersController@meals')->name('providers.meals');
        Route::patch('/providers/{id}', 'WEB\Admin\ProvidersController@update')->name('providers.update');
        Route::get('/providers/{id}/edit_password', 'WEB\Admin\ProvidersController@edit_password')->name('providers.edit_password');
        Route::post('/providers/{id}/edit_password', 'WEB\Admin\ProvidersController@update_password')->name('providers.edit_password');
        Route::get('/exportProviders', 'WEB\Admin\ProvidersController@exportProviders');
        Route::get('/pdfProviders', 'WEB\Admin\ProvidersController@pdfProviders');
        Route::get('/providers/getCategories', 'WEB\Admin\ProvidersController@getCategories')->name('providers.getCategories');
        Route::get('/providers/{id}/businessHours', 'WEB\Admin\ProvidersController@businessHours')->name('providers.businessHours');
        Route::post('/providers/{id}/updateBusinessHours', 'WEB\Admin\ProvidersController@updateBusinessHours')->name('providers.updateBusinessHours');
















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
        // Route::get('/settings', 'WEB\Admin\SettingController@index');
        // Route::get('/settings/create', 'WEB\Admin\SettingController@create');
        // Route::post('/settings', 'WEB\Admin\SettingController@store');
        // Route::resource('/settings', 'WEB\Admin\SettingController');

        // Route::resource('/settings', 'WEB\Admin\SettingCopyController');



        Route::get('/report/meals', 'WEB\Admin\MealController@report')->name('mealsReport');
        Route::get('/export/excel/meals', 'WEB\Admin\MealController@exportExcel');
        Route::get('/MealsReportForAdmin/excel/meals', 'WEB\Admin\MealController@MealsReportForAdmin');
        Route::resource('/meals', 'WEB\Admin\MealController');
        Route::get('/meals/{id}/options', 'WEB\Admin\MealController@options');
        Route::get('/meals/{id}/createOption', 'WEB\Admin\MealController@createOption');
        Route::post('/meals/{id}/storeOption', 'WEB\Admin\MealController@storeOption');
        Route::get('/meals/{id}/editOption', 'WEB\Admin\MealController@editOption');
        Route::post('/meals/{id}/updateOption', 'WEB\Admin\MealController@updateOption');
        Route::delete('/meals/{id}/deleteOption', 'WEB\Admin\MealController@deleteOption');
        Route::delete('/meals/{id}/deleteOffer', 'WEB\Admin\MealController@deleteOffer');


        Route::resource('/option_values', 'WEB\Admin\OptionValueController');
        Route::resource('/promo_codes', 'WEB\Admin\PromoCodesController');


        Route::get('getNewOrdersCount/orders','WEB\Admin\OrderController@getNewOrdersCount');
        Route::get('invoice/orders/{id}','WEB\Admin\OrderController@invoice')->name('invoice');
        Route::get('refund/orders/{id}','WEB\Admin\OrderController@refund');
        Route::get('changeOrdersCount/orders','WEB\Admin\OrderController@changeOrdersCount');
        Route::get('/orders/changeStatus/{id}/{status}', 'WEB\Admin\OrderController@changeStatus')->name('changeOrderStatus');
        Route::get('/report/orders', 'WEB\Admin\OrderController@report')->name('ordersReport');
        Route::get('/pdfOrders', 'WEB\Admin\OrderController@pdfOrders');
        Route::get('/export/excel/orders', 'WEB\Admin\OrderController@OrdersExportForAdmin');
        Route::get('/OrdersReportForAdmin/excel/orders', 'WEB\Admin\OrderController@OrdersReportForAdmin');
        Route::resource('/orders', 'WEB\Admin\OrderController');


        Route::resource('/cuisines', 'WEB\Admin\CuisineController');

        Route::resource('/banners', 'WEB\Admin\BannerController');


        Route::get('/contacts', 'WEB\Admin\ContactController@index');
        Route::get('/contacts/{id}/show', 'WEB\Admin\ContactController@show');
        Route::patch('/contacts/{id}', 'WEB\Admin\ContactController@update');
        Route::get('/export/excel/contacts', 'WEB\Admin\ContactController@exportExcel');
        Route::get('/pdfContacts', 'WEB\Admin\ContactController@pdfContacts');


        Route::get('/join_requests', 'WEB\Admin\JoinRequestController@index');
        Route::get('/join_requests/{id}/show', 'WEB\Admin\JoinRequestController@show');
        Route::patch('/join_requests/{id}', 'WEB\Admin\JoinRequestController@update');
        Route::get('/export/excel/join_requests', 'WEB\Admin\JoinRequestController@exportExcel');
        Route::get('/pdfJoinRequests', 'WEB\Admin\JoinRequestController@pdfJoinRequests');


        // Route::get('settings', 'WEB\Admin\SettingController@index')->name('settings.index');
        // Route::get('settings', 'WEB\Admin\SettingController@create')->name('settings.create');
        // Route::post('settings', 'WEB\Admin\SettingController@update')->name('settings.update');




        Route::get('system_maintenance', 'WEB\Admin\SettingController@system_maintenance')->name('system.maintenance');
        Route::post('system_maintenance', 'WEB\Admin\SettingController@update_system_maintenance')->name('update.system.maintenance');


        Route::resource('/pages', 'WEB\Admin\PagesController');

        Route::resource('/roles', 'WEB\Admin\RolesController');
        Route::resource('/notifications', 'WEB\Admin\NotificationsController');

        Route::get('logs', 'WEB\Admin\LogController@index');


    });


    // Route::get('settings', 'WEB\Admin\SettingController@index')->name('settings.index');





    Route::group(['prefix' => 'provider'], function () {
        Route::get('/', function () {
            return route('/login');
        });
        Route::get('/login', 'SubAdminAuth\LoginController@showLoginForm')->name('subadmin.login.form');
        Route::post('/login', 'SubAdminAuth\LoginController@login')->name('subadmin.login');
        Route::get('/logout', 'SubAdminAuth\LoginController@logout')->name('subadmin.logout');

    });
    Route::group(['middleware' => ['web', 'subadmin'], 'prefix' => 'provider', 'as' => 'provider.',], function () {
        Route::get('/', function () {
            return redirect('/provider/home');
        });
        Route::post('/changeStatus/{model}', 'WEB\SubAdmin\HomeController@changeStatus');

        Route::get('home', 'WEB\SubAdmin\HomeController@index')->name('provider.home');


        Route::get('/editMyProfile', 'WEB\SubAdmin\SubAdminController@editMyProfile')->name('provider.editMyProfile');
        Route::post('/updateProfile', 'WEB\SubAdmin\SubAdminController@updateProfile')->name('provider.updateProfile');

        Route::get('/categories/{id}/meals', 'WEB\SubAdmin\CategoryController@meals');

        

        Route::get('/report/meals', 'WEB\SubAdmin\MealController@report')->name('mealsReport');
//        Route::get('/export/excel/meals', 'WEB\SubAdmin\MealController@exportExcel');
        Route::get('/MealsReportForProvider/excel/meals', 'WEB\SubAdmin\MealController@MealsReportForProvider');
        Route::resource('/meals', 'WEB\SubAdmin\MealController');
        Route::get('/meals/{id}/options', 'WEB\SubAdmin\MealController@options');
        Route::get('/meals/{id}/createOption', 'WEB\SubAdmin\MealController@createOption');
        Route::post('/meals/{id}/storeOption', 'WEB\SubAdmin\MealController@storeOption');
        Route::get('/meals/{id}/editOption', 'WEB\SubAdmin\MealController@editOption');
        Route::post('/meals/{id}/updateOption', 'WEB\SubAdmin\MealController@updateOption');
        Route::delete('/meals/{id}/deleteOption', 'WEB\SubAdmin\MealController@deleteOption');
        Route::delete('/meals/{id}/deleteOffer', 'WEB\SubAdmin\MealController@deleteOffer');

        Route::resource('/option_values', 'WEB\SubAdmin\OptionValueController');

        Route::get('getNewOrdersCount/orders','WEB\SubAdmin\OrderController@getNewOrdersCount');
        Route::get('invoice/orders/{id}','WEB\SubAdmin\OrderController@invoice')->name('invoice');
        Route::get('refund/orders/{id}','WEB\Admin\OrderController@refund');
        Route::get('changeOrdersCount/orders','WEB\SubAdmin\OrderController@changeOrdersCount');
        Route::get('/orders/changeStatus/{id}/{status}', 'WEB\SubAdmin\OrderController@changeStatus')->name('changeOrderStatus');
        Route::get('/report/orders', 'WEB\SubAdmin\OrderController@report')->name('ordersReport');
        Route::get('/pdfOrders', 'WEB\SubAdmin\OrderController@pdfOrders');
        Route::get('/OrdersExportForProvider/excel/orders', 'WEB\SubAdmin\OrderController@exportExcel');
        Route::get('/OrdersReportForProvider/excel/orders', 'WEB\SubAdmin\OrderController@OrdersReportForProvider');
        Route::resource('/orders', 'WEB\SubAdmin\OrderController');

        // Route::get('settings', 'WEB\SubAdmin\SettingController@index');
        // Route::post('settings', 'WEB\SubAdmin\SettingController@update');

    });



});


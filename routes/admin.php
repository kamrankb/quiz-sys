<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\UserController;
use App\Http\controllers\Auth\LoginController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\BrandSettingsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\QuizController;

Route::get('/admin', function () {
    return redirect()->route('login');
});


Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return redirect()->route('login');
    });
    //Home
    Route::controller(HomeController::class)->group(function () {
        Route::get('/dashboard', 'dashboard')->middleware('is_admin')->name('admin.dashboard');
        Route::get('/invoice', [HomeController::class, 'invoice_form']);
        Route::get('notification/send', 'sendOfferNotification');
        Route::post('notification/save/all', 'notification_store');
        Route::get('/notification/mark-all-read', [HomeController::class, 'markAllRead'])->name('mark-all-read');
    });

    //Login
    Route::controller(LoginController::class)->group(function () {
        Route::get('/logout', 'logout');
    });

    //DashBoard
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/dashboard/getPayments', 'monthEarning')->name('dashboard.getpayments');
        Route::get('/paymentlinks', 'filter_chart')->name('getpaymentlinkapi');
        Route::get('/paymentlinks/yearly', 'getpaymentlinkapiyearly')->name('getpaymentlinkapiyearly');
        Route::get('/payments/category/api', 'Payments_category')->name('Payments_category_api');
        Route::post('/Total/payments/api', 'monthly_payments')->name('dateRange_Monthly_payments');
        Route::post('/Total/orders', 'orders')->name('dateRange_Orders');
        Route::post('/average/price', 'average_price')->name('dateRange_Average_price');
        Route::any('/payments/latest/transaction', 'latest_transaction')->name('dateRange_Latest_transactioN');
        Route::post('/revenue', 'revenue')->name('dateRange_Revenue');
        Route::post('/DateRange/DonutCharts', 'dateRange_DonutCharts')->name('dateRange_DonutCharts_Apidata');
        Route::post('/DateRange/CategorySales', 'total_category_sales')->name('total_category_sales_Apidata');
        Route::post('/DateRange/SalesChart', 'dateRange_SalesChart')->name('dateRange_SalesChart_Apidata');
        Route::post('/DateRange/salesTargetChart', 'salesTargetChart')->name('salesTargetChart_Apidata');

    });

    // users
    Route::controller(UserController::class)->group(function () {
        Route::get('user/list', 'index')->name('user.list');
        Route::get('user/add', 'form')->name('user.add');
        Route::get('/user/profile', [UserController::class, 'userProfile_form']);
        Route::post('/user/profile/update', [UserController::class, 'userProfile_update'])->name('admin-user.profile-update');
        Route::get('user/edit/{id}', 'edit')->name('user.edit');
        Route::get('user/detail/{id?}', 'view')->name('user.detail.view');
        Route::post('user/remove', 'delete')->name('user.remove');
        Route::post('user/destroy', 'destroy')->name('user.destroy');
        Route::post('user/restore', 'restore')->name('user.restore');
        Route::post('user/update', 'update')->name('user.update');
        Route::post('/user/status/{id}', 'status')->name('user.status');
        Route::post('user/store', 'store')->name('user.store');
        Route::get('user/trash', 'trashed')->name('user.list.trashed');
        Route::get('/additional-permission/{id}', 'details')->name('admin-user.fetchdata');
        Route::post('/user/additionalpermission/{id}', 'permission_update')->name('admin-user.additionalpermission');
    });

    // categories
    Route::controller(CategoriesController::class)->group(function () {
        Route::get('/category/list', 'index')->name('categories.list');
        Route::get('/category/trash', 'trashed')->name('categories.list.trashed');
        Route::post('/category/detail/{isTrashed?}', 'view')->name('categories.detail.view');
        Route::get('/category/restore/{id}', 'restore')->name('categories.restore');
        Route::get('/category/add', 'form')->name('categories.add');
        Route::post('/category/save', 'store')->name('categories.save');
        Route::get('/category/edit/{id}', 'edit')->name('categories.edit');
        Route::post('/category/remove', 'delete')->name('categories.remove');
        Route::get('/category/view/', 'view')->name('categories.view');
        Route::post('/category/update', 'update')->name('categories.update');
        Route::post('/category/delete', 'destroy')->name('categories.delete');
        Route::post('/category/status/{id}', 'status')->name('categories.status');
        Route::get('/categories-api', 'CategoryApi');
    });

    // Quiz
    Route::controller(QuizController::class)->group(function () {
        Route::get('/category/list', 'index')->name('quiz.list');
        Route::get('/category/trash', 'trashed')->name('categories.list.trashed');
        Route::post('/category/detail/{isTrashed?}', 'view')->name('categories.detail.view');
        Route::get('/category/restore/{id}', 'restore')->name('categories.restore');
        Route::get('/category/add', 'form')->name('quiz.add');
        Route::post('/category/save', 'store')->name('categories.save');
        Route::get('/category/edit/{id}', 'edit')->name('categories.edit');
        Route::post('/category/remove', 'delete')->name('categories.remove');
        Route::get('/category/view/', 'view')->name('categories.view');
        Route::post('/category/update', 'update')->name('categories.update');
        Route::post('/category/delete', 'destroy')->name('categories.delete');
        Route::post('/category/status/{id}', 'status')->name('categories.status');
        Route::get('/categories-api', 'CategoryApi');
    });

    // roles
    Route::controller(RoleController::class)->group(function () {
        Route::get('/role/list', 'index')->name('role.list');
        Route::get('/role/trash', 'trashed')->name('role.list.trashed');
        Route::get('/role/add', 'form')->name('role.add');
        Route::post('/role/freshdata', 'edit')->name('role.edit');
        Route::post('/role/detail/{isTrashed?}', 'view')->name('role.detail.view');
        Route::post('/role/remove', 'delete')->name('role.remove');
        Route::get('/role/restore/{id}', 'restore')->name('role.restore');
        Route::post('/role/status/{id}', 'status')->name('role.status');
        Route::post('/role/store', 'store')->name('role.store');
        Route::post('/role/edit', 'update')->name('role.update');
        Route::post('/role/delete', 'destroy')->name('role.delete');
    });


    // permission
    Route::controller(PermissionController::class)->group(function () {

        Route::get('/permission/list', 'index')->name('permission.list');
        Route::get('/permission/trash', 'trashed')->name('permission.trashed');
        Route::get('/permission/add', 'form')->name('permission.add');
        Route::get('/permission/edit/{id}', 'edit')->name('permission.edit');
        Route::post('/permission/detail/{isTrashed?}', 'view')->name('permission.detail.view');
        Route::post('/permission/remove', 'delete')->name('permission.remove');
        Route::get('/permission/restore/{id}', 'restore')->name('permission.restore');
        Route::post('/permission/status/{id}', 'status')->name('permission.status');
        Route::post('/permission/store', 'store')->name('permission.store');
        Route::post('/permission/edit', 'update')->name('permission.update');
        Route::post('/permission/delete', 'destroy')->name('permission.delete');
    });

    // Notification
    Route::controller(NotificationController::class)->group(function () {
        Route::get('/notification/list', 'index')->name('admin-notification.main');
        Route::get('/notification/add', 'form')->name('admin-notification.add');
        Route::post('/notification/save', 'store')->name('admin-notification.save');
        Route::post('/notification/fresh', 'edit')->name('admin-notification.freshdata');
        Route::post('/notification/view', 'view')->name('admin-notification.view');
        Route::post('/notification/edit', 'update')->name('admin-notification.update');
        Route::post('/notification/delete', 'destroy')->name('admin-notification.delete');
    });

    // BrandSettings
    Route::controller(BrandSettingsController::class)->group(function () {
        Route::get('/brand-settings/general-setting', 'general_setting')->name('admin-brand-settings-general-setting');
        Route::get('/brand-settings/logos', 'form')->name('admin-brand-settings.logos');
        Route::post('/brand-settings/logos-save', 'store')->name('admin-brand-settings.logos-save');
        Route::post('/brand-settings/theme-save', 'themestore')->name('admin-brand-settings.theme-save');
        Route::get('/brand-settings/contact-information', 'contactinformationform')->name('admin-brand-settings-contact-information-form');
        Route::post('/brand-settings/contact-information-save', 'contactinformationstore')->name('admin-brand-settings.contact-information-save');;
    });
});
<?php

use Illuminate\Support\Facades\Route;



Route::group(['prefix' => 'admin','middleware'=>'Lang'], function () {

        Config::set('auth.defines', 'admin');
        /*====================Start Admin Auth System==================*/
        Route::get('login', 'AdminLoginController@showLoginForm')->name('admin.login');
        Route::post('login', 'AdminLoginController@login')->name('admin.login.submit');
        /*====================End Admin Auth System==================*/
        /*====================Admin Panel==================*/
        Route::group(['middleware' => 'admin:admin'], function () {
            Route::get('/home', 'AdminController@index')->name('admin.dashboard');
            /*================LogOut===========*/
            Route::get('logout', 'AdminLoginController@logout')->name('admin.logout');
            /*================Admin Home =========================*/
            Route::get('/home', 'AdminController@index')->name('admin.dashboard');
            /*================Admin Home =========================*/
            /*================Admin Setting control =========================*/
            Route::resource('settings','AdminSettingController');//setting
            Route::resource('sliders','AdminSlidersController');//sliders
            Route::delete('sliders/delete/bulk','AdminSlidersController@delete_all')->name('sliders.delete.bulk');
            Route::get('sliders/allSliders','AdminSlidersController@all_Sliders')->name('sliders.allSliders');


            /*================Admin Contact us control =========================*/
            Route::resource('contacts','AdminContactUsController');
//            //firbase Notification
            Route::resource('firebaseNotification','AdminFirebaseNotificationController');
//            /*================Admin Setting control =========================*/
//            /*================Admin Profile control =========================*/
              Route::resource('profile','AdminProfileController');
//            /*================Admin Admin control =========================*/
            Route::resource('admins','AdminAdminController');
            Route::delete('admins/delete/bulk','AdminAdminController@delete_all')->name('admins.delete.bulk');
          /*================Admin Admin control =========================*/

//       /*================Admin Users control =========================*/
            Route::resource('users','AdminUserController');
            Route::resource('usersPackages','AdminUserPackageController');
            Route::post('update_finished_at','AdminUserPackageController@UpdateFinishedAt');
            Route::delete('users/delete/bulk','AdminUserController@delete_all')->name('users.delete.bulk');
            Route::get('users/changeBlock/{id}','AdminUserController@changeBlock')
                ->name('users.changeBlock');

            /*================Admin  products =========================*/
            Route::resource('notifications','AdminNotifications');
            Route::get('notifications/makeRead/{id}','AdminNotifications@makeRead')->name('makeRead');
            Route::delete('notifications/delete/bulk','AdminNotifications@delete_all')->name('notifications.delete.bulk');
            Route::get('notificationsForLayout','AdminNotifications@notificationsForLayout')->name('notificationsForLayout');

            /*=============Roles and Permissions==============================*/
            Route::resource('permissions','AdminPermissionsController');
            Route::delete('permissions/delete/bulk','AdminPermissionsController@delete_all')->name('permissions.delete.bulk');

            Route::resource('adminPermissions','PermissionForAdminAddingController');
            Route::delete('adminPermissions/delete/bulk','PermissionForAdminAddingController@delete_all')->name('adminPermissions.delete.bulk');
            /*=============Roles and Permissions==============================*/

            /*==================== New Users =======================*/

            Route::resource('newUsers','CRUD\AdminNewUsersController');
            Route::delete('newUsers/delete/bulk','CRUD\AdminNewUsersController@delete_all')
                ->name('newUsers.delete.bulk');
            Route::get('newUsers/changeStatus/{id}','CRUD\AdminNewUsersController@changeStatus')
                ->name('newUsers.changeStatus');



        // ========================== Packages //////////////////////////
            Route::resource('packages','AdminPackagesController');
            Route::delete('packages/delete/bulk','AdminPackagesController@delete_all')
                ->name('packages.delete.bulk');



        });//end middleware admin
        /*====================End Admin Panel==================*/


});





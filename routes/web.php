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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'panel', 'middleware' => ['auth'] ], function (){
    Route::group(['prefix' => 'customers' ], function (){
        Route::group(['prefix' => 'list_data' ], function (){
            Route::get('work_schedule/{customer_id?}', 'CommonAccess\CustomersController@listWorkSchedules')->name('list.work.schedule');
            Route::get('schedules_worked/{customer_id?}', 'CommonAccess\CustomersController@listSchedulesWork')->name('list.schedule.work');
            Route::get('absence_permission/{customer_id?}', 'CommonAccess\CustomersController@listAbsence_permission')->name('list.absence.permission');
            Route::get('summary_hours/{customer_id?}', 'CommonAccess\CustomersController@listSummaryHours')->name('list.summary.hours');
        });

        Route::get('list', 'CommonAccess\CustomersController@listCustomers')->name('list.customers');
        Route::get('form/{customer_id?}', 'CommonAccess\CustomersController@formCustomers')->name('form.customers');
        Route::post('save', 'CommonAccess\CustomersController@saveCustomers')->name('save.customer');
        Route::get('profile/{customer_id?}', 'CommonAccess\CustomersController@profileCustomer')->name('profile.customers');

        Route::group(['prefix' => '{customer_id?}/schedules_worked' ], function (){
            Route::get('form/{schedule_id?}', 'CommonAccess\CustomersController@formScheduleWorked')->name('form.schedule.worked');
            Route::post('save/{schedule_id?}', 'CommonAccess\CustomersController@saveScheduleWorked')->name('save.schedule.worked');
        });

        Route::group(['prefix' => '{customer_id?}/work_schedule' ], function (){
            Route::get('form/{schedule_id?}', 'CommonAccess\CustomersController@formWorkSchedule')->name('form.work.schedule');
            Route::post('save/{schedule_id?}', 'CommonAccess\CustomersController@saveWorkSchedule')->name('save.work.schedule');
        });

        Route::group(['prefix' => '{customer_id?}/absence_permission' ], function (){
            Route::get('form/{absence?}', 'CommonAccess\CustomersController@formAbsencePermission')->name('form.absence.permission');
            Route::post('save/{absence?}', 'CommonAccess\CustomersController@saveAbsencePermission')->name('save.absence.permission');
        });
    });
});

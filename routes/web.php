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

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::get('grades', 'Grades\GradesController@index')->name('grade');

Route::get('account/details', 'Accounts\DetailsController@index')->name('accountDetails');

Route::get('/assessement', 'Assessement\AssessmentController@view')->name('selfassess');
Route::post('/assessement', 'Assessement\ProcessAssessment@save')->name('processAssessment');

Route::post('/reassess', 'Assessement\ProcessAssessment@reassess')->name('reassess');
Route::get('/assessement/printassessment', 'Assessement\AssessmentController@printAssessement')->name('printassessment');

//AJAX
Route::get('/planassessement/{plan}/{strand?}', 'Assessement\AjaxController@getPlanView');

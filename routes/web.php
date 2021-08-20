<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

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

Route::view('welcome', 'welcome')->name('welcome');

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/changePassword', [App\Http\Controllers\HomeController::class, 'changePassword'])->name('changePassword');
Route::post('/passwordChanged', [App\Http\Controllers\HomeController::class, 'passwordChanged'])->name('passwordChanged');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index']);
Route::view('patrol', 'patrol')->name('patrol');

/* Scan routes */
Route::get('/scanner', [App\Http\Controllers\ScannerController::class, 'index'])->name('scan');
Route::post('/scanner', [App\Http\Controllers\ScannerController::class, 'store'])->name('scanned');
Route::get('/clockin', [App\Http\Controllers\ScannerController::class, 'clockin'])->name('clockin');

/* Report routes for the guards*/
Route::get('/scanned_areas', [App\Http\Controllers\ScannerController::class, 'scanned_areas'])->name('scanned_areas');
Route::get('/reportIssue', [App\Http\Controllers\IssueController::class, 'create'])->name('reportIssue');
Route::post('/storeIssue', [App\Http\Controllers\IssueController::class, 'store'])->name('storeIssue');

/* Report routes for the admins*/
Route::get('shifts/export/', [App\Http\Controllers\ShiftController::class, 'export'])->name('shiftExport');
Route::get('/shifts', [App\Http\Controllers\ShiftController::class, 'index'])->name('shifts');
Route::get('/shifts/{id}', [App\Http\Controllers\ShiftController::class, 'info'])->name('shiftInfo');
Route::post('/shifts/search', [App\Http\Controllers\ShiftController::class, 'searchDate'])->name('shiftSearch');
Route::get('/shifts-all_scanned_areas', [App\Http\Controllers\ShiftController::class, 'all_scanned_areas'])->name('all_scanned_areas');
Route::get('/issues', [App\Http\Controllers\IssueController::class, 'index'])->name('all_issues');
Route::get('/issues/{id}', [App\Http\Controllers\IssueController::class, 'show'])->name('issueInfo');
Route::get('/clearIssue/{id}', [App\Http\Controllers\IssueController::class, 'clearIssue'])->name('clearIssue');
Route::get('/employees', [App\Http\Controllers\ShiftController::class, 'employees'])->name('employees');


/**Routes for admins to register users */
Route::get('/registerUser', [App\Http\Controllers\HomeController::class, 'registerUser'])->name('registerUser');
Route::post('/registerUser', [App\Http\Controllers\HomeController::class, 'confirmRegistration'])->name('registered');

/* Session Flushing Routes */
Route::get('/last_interactions', [App\Http\Controllers\ScannerController::class, 'last_interactions'])->name('last_interactions');
<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PositionsController;
use App\Http\Controllers\DepartementsController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\JadwalController;

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



Route::get('register', [UserController::class, 'register'])->name('register');
Route::post('register', [UserController::class, 'register_action'])->name('register.action');
Route::get('login', [UserController::class, 'login'])->name('login');
Route::post('login', [UserController::class, 'login_action'])->name('login.action');


Route::middleware('auth')->group(
    function (){
        Route::get('/', function () {
            return view('home', ['title' => 'Chart Ajax']);
        })->name('home');
        Route::get('password', [UserController::class, 'password'])->name('password');
        Route::post('password', [UserController::class, 'password_action'])->name('password.action');
        Route::get('logout', [UserController::class, 'logout'])->name('logout');

        //route positions
        Route::resource('positions', PositionsController::class);
        Route::get('position/export-excel', [PositionsController::class, 'exportExcel'])->name('positions.exportExcel');

        //route departments
        Route::resource('departements', DepartementsController::class);
        Route::get('departement/export-pdf', [DepartementsController::class, 'exportPdf'])->name('departements.export-Pdf');

        //route user
        Route::resource('user', UserController::class);
        Route::get('users/export-pdf', [UserController::class, 'exportPdf'])->name('users.export-Pdf');
        
        //route dokters
        Route::resource('karyawans', KaryawanController::class);
        Route::get('search/karyawan', [KaryawanController::class, 'autocomplete'])->name('search.karyawan');
        Route::resource('jadwals', JadwalController::class);

        //route chart
        Route::get('chart-line', [KaryawanController::class, 'chartLine'])->name('karyawans.chartLine');
        Route::get('chart-line-ajax', [KaryawanController::class, 'chartLineAjax'])->name('karyawans.chartLineAjax');
    });

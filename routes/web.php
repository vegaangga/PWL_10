<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\MahasiswaController;
use App\Models\Article;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('mahasiswa', MahasiswaController::class);

Route::get('/search',[MahasiswaController::class, 'cari']);

//praktikum 9 latihan
Route::get('nilai/{nim}',[MahasiswaController::class,'nilai']);

//Minggu 10 Praktikum 1
Route::resource('articles', ArticleController::class);

Route::get('/article/cetak_pdf',[ArticleController::class,'cetak_pdf']);

Route::get('mahasiswa/cetak_pdf/{nim}', [MahasiswaController::class, 'cetak_pdf'])->name('mahasiswa.cetak_pdf');
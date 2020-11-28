<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TournamentController;
use App\Http\Controllers\TournamentsController;
use App\Http\Controllers\CompetitionController;
use App\Http\Controllers\StandingsController;
use App\Http\Controllers\JumperController;


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


Route::get('tournament/{id_tournament}', [TournamentController::class, 'display'])->name('tournament');

Route::get('tournaments', [TournamentsController::class, 'display']);

Route::get('competition/{id_tournament}/{id_competition}', [CompetitionController::class, 'display'])->name('competition');

Route::get('standings/{id_tournament}/{id_competition}', [StandingsController::class, 'display'])->name('standings');;

Route::get('jumper/{name}/{id_tournament}', [JumperController::class, 'display']);
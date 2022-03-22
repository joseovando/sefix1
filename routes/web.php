<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\PresupuestoEjecutadoController;
use App\Http\Controllers\PresupuestoProgramadoController;
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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Auth::routes();

Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home')->middleware('auth');

Route::group(['middleware' => 'auth'], function () {
	Route::get('table-list', function () {
		return view('pages.table_list');
	})->name('table');

	Route::get('typography', function () {
		return view('pages.typography');
	})->name('typography');

	Route::get('icons', function () {
		return view('pages.icons');
	})->name('icons');

	Route::get('map', function () {
		return view('pages.map');
	})->name('map');

	Route::get('notifications', function () {
		return view('pages.notifications');
	})->name('notifications');

	Route::get('rtl-support', function () {
		return view('pages.language');
	})->name('language');

	Route::get('upgrade', function () {
		return view('pages.upgrade');
	})->name('upgrade');
});

Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);

	Route::resource('posts', 'App\Http\Controllers\PostController', ['except' => ['show']]);

	/* Route::resource('categorias', 'App\Http\Controllers\CategoriaController', ['except' => ['show']]); */
	Route::get('categorias/{id}/index', [CategoriaController::class, 'index'])->name('categorias.index');
	Route::get('categorias/create', [CategoriaController::class, 'create'])->name('categorias.create');
	Route::get('categorias/create_categoria', [CategoriaController::class, 'create_categoria'])->name('categorias.create_categoria');
	Route::get('categorias/tablero', [CategoriaController::class, 'tablero'])->name('categorias.tablero');
	Route::get('categorias/tablero_categoria', [CategoriaController::class, 'tablero_categoria'])->name('categorias.tablero_categoria');
	Route::post('categorias/store', [CategoriaController::class, 'store'])->name('categorias.store');
	Route::post('categorias/store_categoria', [CategoriaController::class, 'store_categoria'])->name('categorias.store_categoria');
	Route::get('categorias/{id}/edit', [CategoriaController::class, 'edit'])->name('categorias.edit');
	Route::get('categorias/{id}/edit_categoria', [CategoriaController::class, 'edit_categoria'])->name('categorias.edit_categoria');
	Route::put('categorias/update', [CategoriaController::class, 'update'])->name('categorias.update');
	Route::put('categorias/update_categoria', [CategoriaController::class, 'update_categoria'])->name('categorias.update_categoria');
	Route::get('categorias/{id}/delete', [CategoriaController::class, 'delete'])->name('categorias.delete');
	Route::get('categorias/{id}/delete_categoria', [CategoriaController::class, 'delete_categoria'])->name('categorias.delete_categoria');

	/* Route::resource('presupuestosprogramados', 'App\Http\Controllers\PresupuestoProgramadoController', ['except' => ['show']]); */
	Route::get('presupuestosprogramados/index', [PresupuestoProgramadoController::class, 'index'])->name('presupuestosprogramados.index');
	Route::get('presupuestosprogramados/{id}/{menu}/create', [PresupuestoProgramadoController::class, 'create'])->name('presupuestosprogramados.create');
	Route::post('presupuestosprogramados/store', [PresupuestoProgramadoController::class, 'store'])->name('presupuestosprogramados.store');
	Route::get('presupuestosprogramados/{id}/{menu}/edit', [PresupuestoProgramadoController::class, 'edit'])->name('presupuestosprogramados.edit');
	Route::put('presupuestosprogramados/update', [PresupuestoProgramadoController::class, 'update'])->name('presupuestosprogramados.update');
	Route::get('presupuestosprogramados/{id}/{menu}/delete', [PresupuestoProgramadoController::class, 'delete'])->name('presupuestosprogramados.delete');

	/* Route::resource('presupuestosejecutados', 'App\Http\Controllers\PresupuestoEjecutadoController', ['except' => ['show']]); */
	Route::get('presupuestosejecutados/index', [PresupuestoEjecutadoController::class, 'index'])->name('presupuestosejecutados.index');
	Route::get('presupuestosejecutados/{id}/create', [PresupuestoEjecutadoController::class, 'create'])->name('presupuestosejecutados.create');
	Route::post('presupuestosejecutados/store', [PresupuestoEjecutadoController::class, 'store'])->name('presupuestosejecutados.store');
	Route::get('presupuestosejecutados/{id}/{menu}/edit', [PresupuestoEjecutadoController::class, 'edit'])->name('presupuestosejecutados.edit');
	Route::put('presupuestosejecutados/update', [PresupuestoEjecutadoController::class, 'update'])->name('presupuestosejecutados.update');
	Route::get('presupuestosejecutados/{id}/{menu}/delete', [PresupuestoEjecutadoController::class, 'delete'])->name('presupuestosejecutados.delete');

	Route::resource('presupuestosporcategorias', 'App\Http\Controllers\PresupuestoPorCategoriaController', ['except' => ['show']]);

	Route::get('charts', ['as' => 'charts.ejemplo', 'uses' => 'App\Http\Controllers\ChartController@ejemplo']);
	Route::get('charts/pie', ['as' => 'charts.ejemplo_pie', 'uses' => 'App\Http\Controllers\ChartController@ejemplo_pie']);
	Route::get('charts/group_bar', ['as' => 'charts.ejemplo_group_bar', 'uses' => 'App\Http\Controllers\ChartController@ejemplo_group_bar']);
	Route::get('charts/gasto_categoria', ['as' => 'charts.gasto_categoria', 'uses' => 'App\Http\Controllers\ChartController@gasto_categoria']);
});

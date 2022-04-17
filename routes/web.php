<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\CuentaController;
use App\Http\Controllers\PresupuestoEjecutadoController;
use App\Http\Controllers\PresupuestoProgramadoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\RoleController;

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

	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);

	Route::resource('posts', 'App\Http\Controllers\PostController', ['except' => ['show']]);

	Route::resource('users', 'App\Http\Controllers\UserController', ['except' => ['show']]);

	Route::resource('permissions', 'App\Http\Controllers\PermissionController', ['except' => ['show']]);
	Route::get('permissions/{id}/delete', [PermissionController::class, 'delete'])->name('permissions.delete');

	Route::resource('roles', 'App\Http\Controllers\RoleController', ['except' => ['show']]);
	Route::get('roles/{id}/delete', [RoleController::class, 'delete'])->name('roles.delete');

	Route::get('reportes/{mes}/{ano}/index', [ReporteController::class, 'index'])->name('reportes.index');
	Route::get('reportes/{mes}/{ano}/{tipo}/categoria', [ReporteController::class, 'categoria'])->name('reportes.categoria');
	Route::get('reportes/tablero', [ReporteController::class, 'tablero'])->name('reportes.tablero');
	Route::get('reportes/{mes}/{ano}/{categoria}/subcategoria', [ReporteController::class, 'subcategoria'])->name('reportes.subcategoria');

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

	Route::get('presupuestosprogramados/index', [PresupuestoProgramadoController::class, 'index'])->name('presupuestosprogramados.index');
	Route::get('presupuestosprogramados/{id}/{menu}/{mes}/{ano}/{estado}/create', [PresupuestoProgramadoController::class, 'create'])->name('presupuestosprogramados.create');
	Route::post('presupuestosprogramados/store', [PresupuestoProgramadoController::class, 'store'])->name('presupuestosprogramados.store');
	Route::get('presupuestosprogramados/{id}/{menu}/edit', [PresupuestoProgramadoController::class, 'edit'])->name('presupuestosprogramados.edit');
	Route::put('presupuestosprogramados/update', [PresupuestoProgramadoController::class, 'update'])->name('presupuestosprogramados.update');
	Route::get('presupuestosprogramados/{id}/{menu}/delete', [PresupuestoProgramadoController::class, 'delete'])->name('presupuestosprogramados.delete');

	Route::get('presupuestosejecutados/index', [PresupuestoEjecutadoController::class, 'index'])->name('presupuestosejecutados.index');
	Route::get('presupuestosejecutados/{id}/{menu}/{date}/{estado}/create', [PresupuestoEjecutadoController::class, 'create'])->name('presupuestosejecutados.create');
	Route::post('presupuestosejecutados/store', [PresupuestoEjecutadoController::class, 'store'])->name('presupuestosejecutados.store');
	Route::get('presupuestosejecutados/{id}/{menu}/edit', [PresupuestoEjecutadoController::class, 'edit'])->name('presupuestosejecutados.edit');
	Route::put('presupuestosejecutados/update', [PresupuestoEjecutadoController::class, 'update'])->name('presupuestosejecutados.update');
	Route::get('presupuestosejecutados/{id}/{menu}/delete', [PresupuestoEjecutadoController::class, 'delete'])->name('presupuestosejecutados.delete');

	Route::get('cuentas/{id}/{mes}/{ano}/index', [CuentaController::class, 'index'])->name('cuentas.index');
	Route::post('cuentas/store', [CuentaController::class, 'store'])->name('cuentas.store');
	Route::get('cuentas/{id}/{mes}/{ano}/getVistaCuentas', 'App\Http\Controllers\CuentaController@getVistaCuentas')->name('cuentas.getVistaCuentas');
	Route::get('cuentas/{id}/edit', 'App\Http\Controllers\CuentaController@edit')->name('cuentas.edit');
	Route::get('cuentas/{id}/delete', 'App\Http\Controllers\CuentaController@delete')->name('cuentas.delete');
	Route::get('cuentas/{mes}/{ano}/reporte', [CuentaController::class, 'reporte'])->name('cuentas.reporte');

	Route::resource('presupuestosporcategorias', 'App\Http\Controllers\PresupuestoPorCategoriaController', ['except' => ['show']]);

	Route::get('charts', ['as' => 'charts.ejemplo', 'uses' => 'App\Http\Controllers\ChartController@ejemplo']);
	Route::get('charts/pie', ['as' => 'charts.ejemplo_pie', 'uses' => 'App\Http\Controllers\ChartController@ejemplo_pie']);
	Route::get('charts/group_bar', ['as' => 'charts.ejemplo_group_bar', 'uses' => 'App\Http\Controllers\ChartController@ejemplo_group_bar']);
	Route::get('charts/gasto_categoria', ['as' => 'charts.gasto_categoria', 'uses' => 'App\Http\Controllers\ChartController@gasto_categoria']);
});

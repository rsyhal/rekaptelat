<?php

use App\Http\Controllers\LatesController;
use App\Http\Controllers\RayonsController;
use App\Http\Controllers\RomblesController;
use App\Http\Controllers\StudentsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use function Ramsey\Uuid\v1;
    
// Route::redirect('/', '/user/create');

// Route::get('/', function () {
//     return view('login');
// })->name('login');

// Route::middleware('IsLogin')->group(function () {
//     Route::get('/logout', [UserController::class, 'logout'])->name('logout');
//     Route::get('/home', function () {
//         return view('home');
//     })->name('home');
// });

Route::post('/login', [UserController::class, 'loginAuth'])->name('login.auth');
Route::get('/logout', [UserController::class, 'logout'])->name('logout');

Route::get('/error-permission', function () {
    return view('errors.permission');
})->name('error.permission');

// Route::middleware(['IsLogin', 'IsAdmin'])->group(function () {
//     Route::get('/home', function () {
//         return view('pages.admin.home');
//     })->name('home.page');


    Route::prefix('/rombel')->name('rombel.')->group(function () {
        Route::get('/', [RomblesController::class, 'index'])->name('home');
        Route::get('/create', [RomblesController::class, 'create'])->name('create');
        Route::post('/store', [RomblesController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [RomblesController::class, 'edit'])->name('edit');
        Route::patch('/edit/{id}', [RomblesController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [RomblesController::class, 'destroy'])->name('delete');
    });

    Route::prefix('/rayon')->name('rayon.')->group(function () {
        Route::get('/', [RayonsController::class, 'index'])->name('home');
        Route::get('/create', [RayonsController::class, 'create'])->name('create');
        Route::post('/store', [RayonsController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [RayonsController::class, 'edit'])->name('edit');
        Route::patch('/edit/{id}', [RayonsController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [RayonsController::class, 'destroy'])->name('delete');
    });

    Route::prefix('/student')->name('student.')->group(function () {
        Route::get('/', [StudentsController::class, 'index'])->name('home');
        Route::get('/create', [StudentsController::class, 'create'])->name('create');
        Route::post('/store', [StudentsController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [StudentsController::class, 'edit'])->name('edit');
        Route::patch('/edit/{id}', [StudentsController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [StudentsController::class, 'destroy'])->name('delete');
    });

    Route::prefix('/user')->name('user.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('home');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/store', [UserController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [UserController::class, 'edit'])->name('edit');
        Route::patch('/edit/{id}', [UserController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [UserController::class, 'destroy'])->name('delete');
    });

    Route::prefix('/late')->name('late.')->group(function () {
        Route::get('/', [LatesController::class, 'index'])->name('home');
        Route::get('/show/{id}', [LatesController::class, 'show'])->name('show');
        Route::get('/rekap', [LatesController::class, 'rekap'])->name('rekap');
        Route::get('/create', [LatesController::class, 'create'])->name('create');
        Route::post('/store', [LatesController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [LatesController::class, 'edit'])->name('edit');
        Route::patch('/edit/{id}', [LatesController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [LatesController::class, 'destroy'])->name('delete');
        Route::get('/print/{id}', [LatesController::class, 'print'])->name('print');
        Route::get('/download/{id}', [LatesController::class, 'downloadPDF'])->name('download');
        Route::get('/export', [LatesController::class, 'exportExcel'])->name('export');
    });
// });

// Route::middleware(['IsLogin', 'IsPs'])->group(function () {
//     Route::prefix('/ps')->name('pemb.')->group(function () {
//         Route::get('/dashboard', function () {
//             return view('pages.pembimbing.home');
//         })->name('ps.home');
        
        Route::prefix('/late')->name('late.')->group(function () {
            Route::get('/', [LatesController::class, 'index'])->name('home');
            Route::get('/show/{id}', [LatesController::class, 'show'])->name('show');
            Route::get('/rekap', [LatesController::class, 'rekap'])->name('rekap');
            Route::get('/create', [LatesController::class, 'create'])->name('create');
            Route::post('/store', [LatesController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [LatesController::class, 'edit'])->name('edit');
            Route::patch('/edit/{id}', [LatesController::class, 'update'])->name('update');
            Route::delete('/delete/{id}', [LatesController::class, 'destroy'])->name('delete');
        });
//     });
// });

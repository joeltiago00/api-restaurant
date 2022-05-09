<?php

use App\Http\Controllers\{Auth\LoginController,
    CookerController,
    CostumerController,
    MenuController,
    RequestOrderController,
    TableController,
    UserController,
    WaiterController};
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('', function () {
    return response()->json(['message' => 'API ON!!!'], Response::HTTP_OK);
});

Route::post('login', [LoginController::class, 'login']);

Route::group(['prefix' => 'costumer'], function () {
    Route::post('', [CostumerController::class, 'store']);
});

Route::middleware(['auth'])->group(function () {
    Route::group(['prefix' => 'request-order'], function () {
        Route::get('index', [CookerController::class, 'index']);

    });

    //Waiter Routes
    Route::group(['prefix' => 'waiter', 'middleware' => 'waiter'], function () {
        Route::group(['prefix' => 'request-order'], function () {
            Route::get('get-request-orders', [WaiterController::class, 'getRequestOrdersByWaiter']);
            Route::get('create', [RequestOrderController::class, 'create']);
            Route::post('', [RequestOrderController::class, 'store']);
        });
    });

    //Cooker Routes
    Route::group(['prefix' => 'cooker', 'middleware' => 'cooker'], function () {
        Route::group(['prefix' => 'request-order'], function () {

            Route::group(['prefix' => '{requestOrder}'], function () {
                Route::get('set-cooker', [RequestOrderController::class, 'setCooker']);
                Route::get('start', [RequestOrderController::class, 'start']);
                Route::get('finish', [RequestOrderController::class, 'finish']);
            });
        });
    });

    //Admin Routes
    Route::middleware('admin')->group(function () {
        //User
        Route::group(['prefix' => 'user'], function () {
            Route::get('create', [UserController::class, 'create']);
            Route::post('', [UserController::class, 'store']);
        });

        //Menu
        Route::group(['prefix' => 'menu'], function () {
            Route::post('', [MenuController::class, 'store']);
            Route::get('', [MenuController::class, 'index']);

            Route::group(['prefix' => '{menu}'], function () {
                Route::patch('', [MenuController::class, 'update']);
                Route::get('', [MenuController::class, 'show']);
                Route::delete('', [MenuController::class, 'delete']);
            });
        });

        //Table
        Route::group(['prefix' => 'table'], function () {
            Route::post('', [TableController::class, 'store']);
            Route::get('', [TableController::class, 'index']);

            Route::group(['prefix' => '{table}'], function () {
                Route::patch('', [TableController::class, 'update']);
                Route::get('', [TableController::class, 'show']);
                Route::delete('', [TableController::class, 'delete']);
            });
        });

    });

});


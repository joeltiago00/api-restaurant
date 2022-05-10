<?php

use App\Http\Controllers\{Auth\LoginController,
    Auth\LogoutController,
    CookerController,
    CustomerController,
    MenuController,
    MenuItemController,
    RequestOrderController,
    TableController,
    UserController,
    WaiterController
};
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
    Route::post('', [CustomerController::class, 'store']);
});

Route::middleware(['auth'])->group(function () {
    Route::get('logout', [LogoutController::class, 'logout']);

//===============================================================================================

    //Customer Routes
    Route::group(['prefix' => 'customer'], function () {
        Route::get('', [CustomerController::class, 'index']);

        Route::group(['prefix' => '{customer}'], function () {
            Route::get('', [CustomerController::class, 'show']);

        });
    });

//===============================================================================================

    //Menu Routes
    Route::group(['prefix' => 'menu'], function () {
        Route::get('', [MenuController::class, 'index']);

        Route::group(['prefix' => '{menu}'], function () {
            Route::get('', [MenuController::class, 'show']);
        });
    });

//===============================================================================================

    //Request Order Routes
    Route::group(['prefix' => 'request-order'], function () {
        Route::get('index', [RequestOrderController::class, 'index']);
        Route::get('get-first-greater-less/{customer}', [RequestOrderController::class, 'getFirstGreaterLessByCustomer']);

        Route::group(['prefix' => '{requestOrder}'], function () {
            Route::get('', [RequestOrderController::class, 'show']);
        });
    });

//===============================================================================================

    //Waiter Routes
    Route::group(['prefix' => 'waiter', 'middleware' => 'waiter'], function () {
        Route::group(['prefix' => 'request-order'], function () {
            Route::get('', [WaiterController::class, 'getRequestOrdersByWaiter']);
            Route::get('create', [RequestOrderController::class, 'create']);
            Route::post('', [RequestOrderController::class, 'store']);
        });
    });

//===============================================================================================

    //Cooker Routes
    Route::group(['prefix' => 'cooker', 'middleware' => 'cooker'], function () {
        Route::group(['prefix' => 'request-order'], function () {
            Route::get('', [CookerController::class, 'getRequestOrdersByCooker']);

            Route::group(['prefix' => '{requestOrder}'], function () {
                Route::get('set-cooker', [RequestOrderController::class, 'setCooker']);
                Route::get('start', [RequestOrderController::class, 'start']);
                Route::get('finish', [RequestOrderController::class, 'finish']);
            });
        });
    });

//===============================================================================================


    //Table Routes
    Route::group(['prefix' => 'table'], function () {
        Route::get('', [TableController::class, 'index']);

        Route::group(['prefix' => '{table}'], function () {
            Route::get('', [TableController::class, 'show']);
        });
    });

//===============================================================================================

    /*
     * Admin Routes
     */

//===============================================================================================

    Route::group(['prefix' => 'admin'], function () {
        //User Routes
        Route::group(['prefix' => 'user'], function () {
            Route::get('create', [UserController::class, 'create']);
            Route::post('', [UserController::class, 'store']);
            Route::get('', [UserController::class, 'index']);

            Route::group(['prefix' => '{user}'], function () {
                Route::get('', [UserController::class, 'show']);
                Route::patch('', [UserController::class, 'update']);
                Route::delete('', [UserController::class, 'delete']);
            });
        });

//===============================================================================================

        //Customer Routes
        Route::group(['prefix', 'customer'], function () {
            Route::group(['prefix' => '{customer}'], function () {
                Route::patch('', [CustomerController::class, 'update']);
                Route::delete('', [CustomerController::class, 'delete']);
            });
        });

//===============================================================================================

        //RequestOrder Routes
        Route::group(['prefix' => 'request-order'], function () {
            Route::group(['prefix' => '{requestOrder}'], function () {
                Route::patch('', [RequestOrderController::class, 'update']);
                Route::delete('', [RequestOrderController::class, 'delete']);
            });
        });

//===============================================================================================

        //Menu Routes
        Route::group(['prefix' => 'menu'], function () {
            Route::post('', [MenuController::class, 'store']);

            Route::group(['prefix' => '{menu}'], function () {
                Route::patch('', [MenuController::class, 'update']);
                Route::delete('', [MenuController::class, 'delete']);
            });
        });

//===============================================================================================

        //Item Menu Routes
        Route::group(['prefix' => 'item-menu'], function () {
            Route::post('', [MenuItemController::class, 'store']);
            Route::get('i', [MenuItemController::class, 'index']);

            Route::group(['prefix' => '{menuItem}'], function () {
                Route::get('', [MenuItemController::class, 'show']);
                Route::patch('', [MenuItemController::class, 'update']);
                Route::delete('', [MenuItemController::class, 'delete']);
            });
        });

//===============================================================================================

        //Table Routes
        Route::group(['prefix' => 'table'], function () {
            Route::post('', [TableController::class, 'store']);

            Route::group(['prefix' => '{table}'], function () {
                Route::patch('', [TableController::class, 'update']);
                Route::delete('', [TableController::class, 'delete']);
            });
        });

    });

});


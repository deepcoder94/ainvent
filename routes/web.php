<?php

use App\Http\Controllers\BeatController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DistributorController;
use App\Http\Controllers\MeasurementController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\InventoryHistoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShipmentController;
use App\Http\Controllers\BulkUploadController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\GenerateInvoiceController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\InvoiceListController;
use App\Http\Controllers\InvoiceRequestController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PaymentHistoryController;

use App\Http\Controllers\ProfitController;
use App\Http\Controllers\ReturnController;
use App\Http\Controllers\SalesController;



Route::controller(DashboardController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/dashboard', 'index')->name('dashboard');    
});

Route::name('sales.')->group(function () {
    Route::controller(SalesController::class)->group(function () {
        Route::prefix('sales')->group(function () {
            Route::get('/list', 'list')->name('list');
            Route::get('/search', 'search')->name('search');
        });
    });
});

Route::name('profit.')->group(function () {
    Route::controller(ProfitController::class)->group(function () {
        Route::prefix('profit')->group(function () {
            Route::get('/list', 'list')->name('list');
            Route::get('/export', 'export')->name('export');
        });
    });
});

Route::name('measurement.')->group(function () {
    Route::controller(MeasurementController::class)->group(function () {
        Route::prefix('measurement')->group(function () {
            Route::post('/create', 'create')->name('create');
            Route::get('/view/{id}', 'view')->name('view');
            Route::post('/edit/{id}', 'update')->name('update');
            Route::post('/delete/{id}', 'delete')->name('delete');
        });    
    });
});    

Route::name('distributor.')->group(function () {
    Route::controller(DistributorController::class)->group(function () {
        Route::prefix('distributor')->group(function () {
            Route::get('/list', 'index')->name('index');
            Route::post('/update','update')->name('update');
        });
    });
});

Route::name('beats.')->group(function () {
    Route::controller(BeatController::class)->group(function () {
        Route::prefix('beats')->group(function () {
            Route::get('/list', 'list')->name('list');
            Route::post('/store', 'store')->name('store');
            Route::get('/view/{id}', 'view')->name('view');
            Route::post('/edit/{id}', 'edit')->name('edit');
            Route::post('/delete/{id}', 'delete')->name('delete');
            Route::get('/{id}/customers', 'customers')->name('customers');

        });    
    });    
});

Route::name('customer.')->group(function () {
    Route::controller(CustomerController::class)->group(function () {
        Route::prefix('customer')->group(function () {
            Route::get('/list', 'list')->name('list');
            Route::get('/view/{id}', 'view')->name('view');
            Route::post('/store', 'store')->name('store');
            Route::post('/edit/{id}', 'edit')->name('edit');
            Route::post('/delete/{id}', 'delete')->name('delete');
            Route::get('/search', 'search')->name('search');

        });    
    });
});

Route::name('product.')->group(function () {
    Route::controller(ProductController::class)->group(function () {
        Route::prefix('products')->group(function () {
            Route::get('/list', 'list')->name('list');
            Route::post('/store', 'store')->name('store');
            Route::get('/view/{id}', 'view')->name('view');
            Route::post('/delete/{id}', 'delete')->name('delete');
            Route::post('/edit/{id}', 'edit')->name('edit');

            Route::get('/{id}/measurements', 'measurements')->name('measurements');
            Route::get('/{id}/{typeId}/max_qty', 'max_qty')->name('max_qty');

        });    
    });
});

Route::name('inventory.')->group(function () {
    Route::controller(InventoryController::class)->group(function () {
        Route::prefix('inventory')->group(function () {
            Route::get('/list', 'list')->name('list');
            Route::post('/store', 'store')->name('store');
        });    
    });
    Route::controller(InventoryHistoryController::class)->group(function () {
        Route::prefix('inventory/history')->group(function () {
            Route::get('/list', 'list')->name('history.list');
            Route::get('/listWithPaginate', 'listWithPaginate')->name('history.listWithPaginate');
        });    
    });    
});

Route::name('shipment.')->group(function () {
    Route::controller(ShipmentController::class)->group(function () {
        Route::prefix('shipment')->group(function () {
            Route::get('/list', 'list')->name('list');
            Route::post('/store', 'store')->name('store');
        });    
    });    
});

Route::name('payment.')->group(function () {
    Route::controller(PaymentController::class)->group(function () {
        Route::prefix('payment')->group(function () {
            Route::get('/list', 'list')->name('list');
            Route::get('/view/{type}/{id}', 'view')->name('view');
            Route::post('/edit/{id}', 'edit')->name('edit');
        });    
    });    

    Route::controller(PaymentHistoryController::class)->group(function () {
        Route::prefix('payment/history')->group(function () {
            Route::get('/list', 'list')->name('history.list');
            Route::get('/view/{id}', 'view')->name('history.view');
            Route::get('/search/{id}', 'search')->name('history.search');

        });    
    });    
    
});

Route::name('return.')->group(function () {
    Route::controller(ReturnController::class)->group(function () {
        Route::prefix('return')->group(function () {
            Route::get('/list', 'list')->name('list');
            Route::get('/view/{id}/{index}', 'view')->name('view');
            Route::post('/store', 'store')->name('store');

        });    
    });    
    
});
            

Route::name('export.')->group(function () {
    Route::controller(ExportController::class)->group(function () {
        Route::prefix('export')->group(function () {
            Route::get('/product', 'products')->name('product');
            Route::get('/customer', 'customers')->name('customer');
            Route::get('/inventory', 'inventory')->name('inventory');
            Route::get('/csv/{file}', 'csv')->name('csv');
        });    
    });    
    
});

Route::name('import.')->group(function () {
    Route::controller(ImportController::class)->group(function () {
        Route::prefix('export')->group(function () {
            Route::post('/product', 'products')->name('product');
            Route::post('/customer', 'customers')->name('customer');
            Route::post('/inventory', 'inventory')->name('inventory');

        });    
    });    
    
});

Route::name('invoice.')->group(function () {
    Route::controller(InvoiceListController::class)->group(function () {
        Route::prefix('invoice/list')->group(function () {
            Route::get('/', 'list')->name('list');
            Route::post('/', 'print')->name('print');
            Route::get('/search', 'search')->name('search');
            Route::get('/view/{id}', 'view')->name('view');
            Route::get('/view/{id}/products/{index}', 'products')->name('products');

        });    
    });    
    Route::controller(GenerateInvoiceController::class)->group(function () {
        Route::prefix('invoice/create')->group(function () {
            Route::get('/', 'list')->name('create.list');
            Route::post('/', 'create')->name('create');
            Route::get('/{id}/single_product', 'single_product')->name('create.single_product');
        });    
    });     
    
    Route::controller(InvoiceRequestController::class)->group(function () {
        Route::prefix('invoice/request')->group(function () {
            Route::get('/list', 'list')->name('request.list');
            Route::get('/create', 'create')->name('request.create');
            Route::post('/store', 'store')->name('request.store');
            Route::get('/{id}/edit', 'edit')->name('request.edit');
            Route::post('/{id}/update', 'update')->name('request.update');
            Route::post('/delete/{id}', 'delete')->name('request.delete');
            Route::post('/approve', 'approve')->name('request.approve');

        });    
    });     
    
});




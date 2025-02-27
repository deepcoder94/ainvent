<?php

use App\Http\Controllers\BeatController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DistributorController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\InventoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ShipmentController;

// Route::get('/', [DashboardController::class,'index'])->name('dashboard');
Route::get('/dashboard', [DashboardController::class,'index'])->name('dashboard');

Route::resources([
    'distributor'=>DistributorController::class,
    'beats'=>BeatController::class,
    'customer'=>CustomerController::class,
    'products'=>ProductController::class,
    'inventory'=>InventoryController::class
]);

Route::post('/updateCompany',[DistributorController::class,'updateCompany'])->name('updateCompany');


Route::post('/updateBeatById/{id}', [BeatController::class,'updateBeatById'])->name('updateBeatById');
Route::post('/deleteBeatById/{id}', [BeatController::class,'deleteBeatById'])->name('deleteBeatById');

Route::post('/updateCustomerById/{id}', [CustomerController::class,'updateCustomerById'])->name('updateCustomerById');
Route::post('/deleteCustomerById/{id}', [CustomerController::class,'deleteCustomerById'])->name('deleteCustomerById');

Route::post('/updateProductById/{id}', [ProductController::class,'updateProductById'])->name('updateProductById');
Route::post('/deleteProductById/{id}', [ProductController::class,'deleteProductById'])->name('deleteProductById');

Route::post('/createMeasurement', [DistributorController::class,'createMeasurement'])->name('createMeasurement');
Route::post('/updateMeasurementById/{id}', [DistributorController::class,'updateMeasurementById'])->name('updateMeasurementById');
Route::post('/deleteMeasurementById/{id}', [DistributorController::class,'deleteMeasurementById'])->name('deleteMeasurementById');

Route::get('/invoice/generate',[InvoiceController::class,'index'])->name('invoiceGenerate');
Route::get('/invoice/list',[InvoiceController::class,'list'])->name('invoiceList');
Route::post('/invoice/create',[InvoiceController::class,'create'])->name('newInvoiceCreate');
Route::post('/invoice/loadpdf',[InvoiceController::class,'loadpdf'])->name('loadPdf');

Route::get('/searchCustomer',[CustomerController::class,'searchCustomer'])->name('customer.search');

Route::get('/inventoryHistory',[InventoryController::class,'inventoryHistory'])->name('inventoryHistory');
Route::get('/download-zip/{file}', [InvoiceController::class, 'downloadZip'])->name('downloadZip');

Route::post('/shipment/create',[ShipmentController::class, 'createShipment'])->name('createShipment');
Route::get('/shipment/list',[ShipmentController::class, 'shipmentList'])->name('shipmentList');

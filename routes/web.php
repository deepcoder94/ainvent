<?php

use App\Http\Controllers\BeatController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DistributorController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\InventoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShipmentController;
use App\Http\Controllers\BulkUploadController;
use App\Http\Controllers\GenerateInvoiceController;
use App\Http\Controllers\InvoiceListController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfitController;
use App\Http\Controllers\ReturnController;
use App\Http\Controllers\SalesController;

Route::get('/', [DashboardController::class,'index'])->name('index');
Route::get('/dashboard', [DashboardController::class,'index'])->name('dashboard');
Route::get('/sales/list', [SalesController::class,'salesList'])->name('salesList');
Route::get('/searchSales', [SalesController::class,'searchSales'])->name('searchSales');

Route::get('/profit/list', [ProfitController::class,'profitList'])->name('profitList');
Route::get('/profitexport', [ProfitController::class,'profitExport'])->name('profitExport');


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


Route::get('/searchCustomer',[CustomerController::class,'searchCustomer'])->name('customer.search');

Route::get('/inventoryHistory',[InventoryController::class,'inventoryHistory'])->name('inventoryHistory');
Route::get('/inventoryHistoryWithPaginate',[InventoryController::class,'inventoryHistoryWithPaginate'])->name('inventoryHistoryWithPaginate');


Route::post('/shipment/create',[ShipmentController::class, 'createShipment'])->name('createShipment');
Route::get('/shipment/list',[ShipmentController::class, 'shipmentList'])->name('shipmentList');

Route::get('/payments/list',[PaymentController::class, 'paymentsList'])->name('paymentsList');
Route::post('/paymentsUpdate/{id}',[PaymentController::class, 'paymentsUpdate'])->name('paymentsUpdate');

Route::post('/uploadCustomerCsv',[BulkUploadController::class,'uploadCustomerCsv'])->name('customer.upload');
Route::post('/uploadProductCsv',[BulkUploadController::class,'uploadProductCsv'])->name('product.upload');
Route::post('/uploadInventoryCsv',[BulkUploadController::class,'uploadInventoryCsv'])->name('inventory.upload');

Route::get('/generateProductCsv', [BulkUploadController::class, 'generateProductCsv'])->name('generate.product.csv');
Route::get('/downloadProductCsv/{file}', [BulkUploadController::class, 'downloadProductCsv'])->name('download.product.csv');

Route::get('/generateInventoryCsv', [BulkUploadController::class, 'generateInventoryCsv'])->name('generate.inventory.csv');

Route::get('/generateCustomerCsv', [BulkUploadController::class, 'generateCustomerCsv'])->name('generate.customer.csv');
Route::get('/downloadCustomerCsv/{file}',[BulkUploadController::class,'downloadCustomerCsv'])->name('download.customer.csv');

Route::get('/getPaymentsByBeat/{beatId}',[PaymentController::class,'getPaymentsByBeat'])->name('getPaymentsByBeat');
Route::get('/getPaymentsByInvoiceId/{invoiceId}',[PaymentController::class,'getPaymentsByInvoiceId'])->name('getPaymentsByInvoiceId');

Route::get('/return/form',[ReturnController::class,'showReturnForm'])->name('showReturnForm');
Route::get('/getProductsByInvoice/{id}/{index}',[ReturnController::class,'getInvoiceProducts'])->name('getInvoiceProducts');
Route::post('/submitReturn',[ReturnController::class,'submitReturn'])->name('submitReturn');


Route::get('/payment/history',[PaymentController::class,'paymentHistory'])->name('paymentHistory');
Route::get('/getSingleInvoicePaymentDetail/{id}',[PaymentController::class,'getSingleInvoicePaymentDetail'])->name('getSingleInvoicePaymentDetail');
Route::get('/searchPayHistory/{id}',[PaymentController::class,'searchPayHistory'])->name('searchPayHistory');

Route::get('/getHsnCodeByProduct/{id}',[ProductController::class,'getHsnCodeByProduct'])->name('getHsnCodeByProduct');


Route::get('/invoice/generatenew',[GenerateInvoiceController::class,'index'])->name('invoiceGenerateNew');
Route::post('/invoice/createnew',[GenerateInvoiceController::class,'create'])->name('newInvoiceCreate2');
Route::get('/getMeasurementsByProduct/{id}',[GenerateInvoiceController::class,'getMeasurementsByProduct'])->name('getMeasurementsByProduct');
Route::get('/loadSingleProduct/{id}',[GenerateInvoiceController::class,'loadSingleProduct'])->name('loadSingleProduct');
Route::get('/getCustomersByBeat/{id}',[GenerateInvoiceController::class,'getCustomersByBeat'])->name('getCustomersByBeat');
Route::get('/getMaxQtyByTypeAndProduct/{typeId}/{productId}',[GenerateInvoiceController::class,'getMaxQtyByTypeAndProduct'])->name('getMaxQtyByTypeAndProduct');

Route::post('/invoice/loadpdfnew',[InvoiceListController::class,'loadPdfNew'])->name('loadPdfNew');
Route::get('/invoice/list',[InvoiceListController::class,'list'])->name('invoiceList');
Route::get('/searchInvoice',[InvoiceListController::class,'searchInvoice'])->name('invoice.search');
Route::get('/invoiceView/{id}',[InvoiceListController::class,'invoiceView'])->name('invoiceView');
Route::get('/download-zip/{file}', [InvoiceListController::class, 'downloadZip'])->name('downloadZip');

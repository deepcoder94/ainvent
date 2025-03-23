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
use App\Http\Controllers\BulkUploadController;
use App\Http\Controllers\GstInvoiceController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReturnController;
use App\Models\Product;
use Illuminate\Http\Request;

Route::get('/', [DashboardController::class,'index'])->name('index');
Route::get('/dashboard', [DashboardController::class,'index'])->name('dashboard');
Route::get('/sales/list', [DashboardController::class,'salesList'])->name('salesList');
Route::get('/profit/list', [DashboardController::class,'profitList'])->name('profitList');

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
Route::get('/searchInvoice',[InvoiceController::class,'searchInvoice'])->name('invoice.search');


Route::get('/searchCustomer',[CustomerController::class,'searchCustomer'])->name('customer.search');

Route::get('/inventoryHistory',[InventoryController::class,'inventoryHistory'])->name('inventoryHistory');
Route::get('/inventoryHistoryWithPaginate',[InventoryController::class,'inventoryHistoryWithPaginate'])->name('inventoryHistoryWithPaginate');

Route::get('/download-zip/{file}', [InvoiceController::class, 'downloadZip'])->name('downloadZip');

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

Route::get('/loadSingleProduct/{id}',[InvoiceController::class,'loadSingleProduct'])->name('loadSingleProduct');

Route::get('/gst/form',[GstInvoiceController::class,'showGstInvoiceForm'])->name('showGstInvoiceForm');
Route::post('/generateGstInvoice',[GstInvoiceController::class,'generateGstInvoice'])->name('generateGstInvoice');
Route::get('/addGstProduct/{id}',function(Request $request,$id){
    $products = Product::get();
    return view('pages.generate-gst.add-single-product',compact('id','products'));
})->name('addGstProduct');

Route::get('/addGstInvoiceFormProduct/{id}',[GstInvoiceController::class,'addGstInvoiceFormProduct'])->name('addGstInvoiceFormProduct');

Route::get('/payment/history',[PaymentController::class,'paymentHistory'])->name('paymentHistory');
Route::get('/getSingleInvoicePaymentDetail/{id}',[PaymentController::class,'getSingleInvoicePaymentDetail'])->name('getSingleInvoicePaymentDetail');
Route::get('/searchPayHistory/{id}',[PaymentController::class,'searchPayHistory'])->name('searchPayHistory');

Route::get('/getHsnCodeByProduct/{id}',[ProductController::class,'getHsnCodeByProduct'])->name('getHsnCodeByProduct');

Route::get('/invoiceView/{id}',[InvoiceController::class,'invoiceView'])->name('invoiceView');

Route::get('/gstinvoice/list',[GstInvoiceController::class,'list'])->name('gstInvoiceList');

// // Daily Sales
// Route::get('/sales');

// // Profits
// Route::get('/profits');
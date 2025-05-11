<?php
namespace App\Http\Controllers;

use App\Models\Beat;
use App\Models\Customer;
use App\Models\Measurement;
use App\Models\Product;
use App\Models\Inventory;
use App\Models\InventoryHistory;

use App\Models\ProductMeasurement;

use Illuminate\Http\Request;

class ExportController extends Controller
{
    public function products(Request $request)
    {
        // Fetch products with their related measurements
        $products = Product::with('measurements')->get();

        // Generate the filename
        $filename = 'products-' . now()->timestamp . '.csv';

        // Define the path where the file will be stored
        $filePath = storage_path('app/' . $filename);

        // Open the file for writing
        $handle = fopen($filePath, 'w');

        // Add the CSV column headings (optional)
        fputcsv($handle, ['ID', 'Product Name','GST Rate', 'Product Rate', 'Is Active', 'Measurement Ids']);

        // Loop through the data and write each row to the CSV file
        foreach ($products as $product) {
            $measurements = $product->measurements;
            $measurement_ids = [];

            foreach ($measurements as $measurement) {
                $measurement_ids[] = $measurement->measurement_id;
            }

            // Convert measurement IDs into a comma-separated string
            $measurements = implode(',', $measurement_ids);

            // Write the product row to the CSV
            fputcsv($handle, [
                $product->id,
                $product->product_name,
                $product->gst_rate,                
                $product->product_rate,
                $product->is_active,
                $measurements
            ]);
        }

        // Close the file handle
        fclose($handle);

        // Return the file path so it can be used for the download
        return response()->json(['url_path'=> route('export.csv',['file'=>$filename])]);
    }
    
    public function customers(Request $request){
        // Fetch products with their related measurements
        $customers = Customer::with('beat')->get();

        // Generate the filename
        $filename = 'customers-' . now()->timestamp . '.csv';

        // Define the path where the file will be stored
        $filePath = storage_path('app/' . $filename);

        // Open the file for writing
        $handle = fopen($filePath, 'w');

        // Add the CSV column headings (optional)
        fputcsv($handle, ['ID', 'Beat Name', 'Customer Name', 'Customer Address', 'Customer GST', 'Customer Phone', 'Is Active']);

        // Loop through the data and write each row to the CSV file
        foreach ($customers as $customer) {
            // Write the product row to the CSV
            fputcsv($handle, [
                $customer->id,
                $customer->beat->beat_name,
                $customer->customer_name,
                $customer->customer_address,
                $customer->customer_gst,
                $customer->customer_phone,
                $customer->is_active,
            ]);
        }

        // Close the file handle
        fclose($handle);

        // Return the file path so it can be used for the download
        return response()->json(['url_path'=> route('export.csv',['file'=>$filename])]);
        
    }    

    public function inventory(){
        $inventory = Inventory::with('product')->get();
        // Generate the filename
        $filename = 'inventory-' . now()->timestamp . '.csv';

        // Define the path where the file will be stored
        $filePath = storage_path('app/' . $filename);

        // Open the file for writing
        $handle = fopen($filePath, 'w');

        // Add the CSV column headings (optional)
        fputcsv($handle, ['ID', 'Product Name', 'Buy Price', 'Quantity','Type']);

        // Loop through the data and write each row to the CSV file
        foreach ($inventory as $i) {
            // Write the product row to the CSV
            fputcsv($handle, [
                $i->id,
                $i->product->product_name,
                $i->buying_price,
                $i->total_stock,
                'Piece'
            ]);
        }

        // Close the file handle
        fclose($handle);

        // Return the file path so it can be used for the download
        return response()->json(['url_path'=> route('export.csv',['file'=>$filename])]);
        
    }    

    public function csv(Request $request,$file){
        $path = storage_path('app/' . $file);

        if (!file_exists($path)) {
            abort(404);
        }

        return response()->download($path)->deleteFileAfterSend(true);        
    }
}
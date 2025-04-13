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

class BulkUploadController extends Controller
{
    public function uploadCustomerCsv(Request $request)
    {
        // Validate the uploaded file
        $request->validate([
            'file_csv' => 'required|mimes:csv,txt|max:2048', // You can adjust file type and size
        ]);

        // Handle file upload
        if ($request->hasFile('file_csv')) {
            $file = $request->file('file_csv');

            // Process the CSV (example)
            $csvData = $this->parseCsv($file);
            foreach ($csvData as $csv) {
                // Use Laravel's Collection to transform the keys
                $newArray = collect($csv)
                    ->mapWithKeys(function ($value, $key) {
                        // Convert the key to lowercase and replace spaces with underscores
                        $newKey = strtolower(str_replace(' ', '_', $key));
                        return [$newKey => $value];
                    })
                    ->toArray();
                $beat = Beat::where('beat_name',$newArray['beat_name'])->get()->first();
                if(empty($beat)){
                    continue;
                }
                unset($newArray['beat_name']);
                $newArray['beat_id'] = $beat->id;
                Customer::upsert($newArray, ['id'], ['beat_id', 'customer_name', 'customer_address', 'customer_gst', 'customer_phone', 'is_active']);
            }

            return response()->json(['success' => 'File uploaded successfully!']);
        }

        return response()->json(['error' => 'No file uploaded.'], 400);
    }

    private function parseCsv($file)
    {
        $csvData  = [];
        $filePath = $file->getRealPath();
        $file     = fopen($filePath, 'r');

        // Assuming the first row contains headers
        $header = fgetcsv($file);

        while (($row = fgetcsv($file)) !== false) {
            $csvData[] = array_combine($header, $row); // Combine headers with data
        }

        fclose($file);

        return $csvData;
    }

    public function uploadProductCsv(Request $request){
      
        // Validate the uploaded file
        $request->validate([
            'file_csv' => 'required|mimes:csv,txt|max:2048', // You can adjust file type and size
        ]);

        // Handle file upload
        if ($request->hasFile('file_csv')) {
            $file = $request->file('file_csv');

            // Process the CSV (example)
            $csvData = $this->parseCsv($file);
            foreach ($csvData as $csv) {
                // Use Laravel's Collection to transform the keys
                $newArray = collect($csv)
                    ->mapWithKeys(function ($value, $key) {
                        // Convert the key to lowercase and replace spaces with underscores
                        $newKey = strtolower(str_replace(' ', '_', $key));
                        return [$newKey => $value];
                    })
                    ->toArray();
                $measurements = $newArray['measurement_ids'];
                unset($newArray['measurement_ids']);
                Product::upsert($newArray,['id'],['product_name','product_rate','is_active']);
                
                if(empty($measurements)){
                    continue;
                }
                $arr = explode(',', $measurements);
                
                foreach($arr as $a){
                    $measurementsArray = [
                        'product_id' => $newArray['id'],
                        'measurement_id'=>$a
                    ];
                    $ex = ProductMeasurement::where('product_id',$newArray['id'])->where('measurement_id',$a)->get()->first();
                    if(!empty($ex) || empty($measurementsArray)){
                        continue;
                    }
                    ProductMeasurement::upsert($measurementsArray,['product_id','measurement_id'],['product_id','measurement_id']);
                }
            }

            return response()->json(['success' => 'File uploaded successfully!']);
        }

        return response()->json(['error' => 'No file uploaded.'], 400);  
    }

    public function exportCustomerCsv(){

    }

    public function generateProductCsv(Request $request)
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
        return response()->json(['url_path'=> route('download.product.csv',['file'=>$filename])]);
    }

    public function downloadProductCsv(Request $request,$file)
    {
        $path = storage_path('app/' . $file);

        if (!file_exists($path)) {
            abort(404);
        }

        return response()->download($path)->deleteFileAfterSend(true);
    }    
    
    public function generateCustomerCsv(Request $request){
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
        return response()->json(['url_path'=> route('download.customer.csv',['file'=>$filename])]);
        
    }

    public function downloadCustomerCsv(Request $request,$file){
        $path = storage_path('app/' . $file);

        if (!file_exists($path)) {
            abort(404);
        }

        return response()->download($path)->deleteFileAfterSend(true);
    }

    public function uploadInventoryCsv(Request $request){
        // Validate the uploaded file
        $request->validate([
            'file_csv' => 'required|mimes:csv,txt|max:2048', // You can adjust file type and size
        ]);

        // Handle file upload
        if ($request->hasFile('file_csv')) {
            $file = $request->file('file_csv');

            // Process the CSV (example)
            $csvData = $this->parseCsv($file);
            foreach ($csvData as $csv) {
                // Use Laravel's Collection to transform the keys
                $newArray = collect($csv)
                    ->mapWithKeys(function ($value, $key) {
                        // Convert the key to lowercase and replace spaces with underscores
                        $newKey = strtolower(str_replace(' ', '_', $key));
                        return [$newKey => $value];
                    })
                    ->toArray();

                // Product 
                $productExist = Product::where('product_name',$newArray['product_name'])->get()->first();
                // Type
                
                $typeExist = Measurement::where('name',$newArray['type'])->get()->first();
                if(empty($productExist) || empty($typeExist)){
                    return response()->json(['error' => 'Invalid Product or Type'], 400);         
                }
                
                $qty = $newArray['quantity']*(int)$typeExist->quantity;

                $inventory = Inventory::where('product_id',$productExist->id)->get()->first();
                
                $inventory->buying_price = $newArray['buy_price'];
                $inventory->total_stock += $qty;
                $inventory->save();

                InventoryHistory::create([
                    'product_id' => (int)$productExist->id,
                    'measurement_id' => (int)$typeExist->id,
                    'stock_out_in'   => (int)$qty,
                    'stock_action'  => 'add',
                    'buying_price'  => $newArray['buy_price']
                ]);
            }

            return response()->json(['success' => 'File uploaded successfully!']);
        }

        return response()->json(['error' => 'No file uploaded.'], 400);         
    }

    public function generateInventoryCsv(){
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
        return response()->json(['url_path'=> route('download.customer.csv',['file'=>$filename])]);
        
    }
}

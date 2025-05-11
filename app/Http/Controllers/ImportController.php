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

class ImportController extends Controller
{
    public function customers(Request $request)
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
    public function products(Request $request){
      
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

    public function inventory(Request $request){
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
}
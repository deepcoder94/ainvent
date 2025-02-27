<?php
namespace App\Http\Controllers;

use App\Models\Beat;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::with('beat')->get();
        $beats     = Beat::get();
        return view('pages.customers.list', ['currentPage' => 'customers', 'customers' => $customers, 'beats' => $beats]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'beat_id'          => 'required',
                'customer_name'    => 'required|string|max:255',
                'customer_address' => 'required|string',
                'customer_phone' => 'required|string',
                'customer_gst'     => 'required|string',
                'is_active'        => 'required',
            ]);

            $beat = Customer::create([
                'beat_id'          => $request->beat_id,
                'customer_name'    => $request->customer_name,
                'customer_address' => $request->customer_address,
                'customer_gst'     => $request->customer_gst,
                'customer_phone'     => $request->customer_phone,
                'is_active'        => $request->is_active,
            ]);
            $success = true;
            $message = 'Customer saved successfully';

        } catch (\Exception $e) {
            $success = false;
            $message = $e->getMessage();
        }
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        //
    }

    public function updateCustomerById(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'beat_id'          => 'required',
                'customer_name'    => 'required|string|max:255',
                'customer_address' => 'required|string',
                'customer_gst'     => 'required|string',
                'customer_phone'     => 'required|string',
                'is_active'        => 'required',
            ]);
            $resource = Customer::findOrFail($id);

            $beat = $resource->update([
                'beat_id'          => $request->beat_id,
                'customer_name'    => $request->customer_name,
                'customer_address' => $request->customer_address,
                'customer_gst'     => $request->customer_gst,
                'customer_phone'     => $request->customer_phone,
                'is_active'        => $request->is_active,
            ]);
            $success = true;
            $message = 'Customer updated successfully';

        } catch (\Exception $e) {
            $success = false;
            $message = $e->getMessage();
        }
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }

    public function deleteCustomerById(Request $request, $id)
    {
        $beat = Customer::find($id);
        // If the resource doesn't exist, return an error response
        if (! $beat) {
            return response()->json([
                'message' => 'Resource not found.',
            ], 404);
        }

// Delete the resource
        $beat->delete();
        // Return a success response
        return response()->json([
            'message' => 'Resource deleted successfully.',
        ]);
    }

    public function searchCustomer(Request $request){

        $beatSearch =$request->input('beatSearch');
        $searchField =$request->input('searchField');
        
        $query = Customer::query();

        if(!empty($beatSearch)){
            $searchString = $request->input('beatSearch');
            $query->where('beat_id',$searchString);
        }
        if(!empty($searchField)){
            $query->where('customer_name','LIKE',"%{$searchField}%");
        }
        $cust = $query->get();

        return view('partials.customers.list',['customers'=>$cust]);
    }

}

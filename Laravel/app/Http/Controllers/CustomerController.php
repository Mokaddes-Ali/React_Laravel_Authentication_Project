<?php

namespace App\Http\Controllers;

use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::all();
        return CustomerResource::collection($customers);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email',
            'address' => 'nullable|string|max:255',
            'website' => 'nullable|url',
            'phone' => 'nullable|string|max:15',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif',
            'status' => 'nullable|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Handle image upload and get insert data
        $data = $this->getInsertData($request);

        // Create customer
        $customer = Customer::create($data);

        return new CustomerResource($customer);
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        return new CustomerResource($customer);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:customers,email,' . $customer->id,
            'address' => 'nullable|string|max:255',
            'website' => 'nullable|url',
            'phone' => 'nullable|string|max:15',
            // 'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif|dimensions:width=300,height=300|max:200',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif',
            'status' => 'nullable|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Handle image upload and get update data
        $data = $this->getInsertData($request, $customer);

        // Update customer
        $customer->update($data);

        return new CustomerResource($customer);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        // Delete the associated image if it exists
        if ($customer->image) {
            Storage::delete('public/customer_images/' . $customer->image);
        }

        $customer->delete();

        return response()->json([
            'success' => true,
            'message' => 'Customer deleted successfully'
        ], 200);
    }

    /**
     * Handle image upload and prepare data for insertion/update.
     */
    protected function getInsertData(Request $request, Customer $customer = null)
    {
        $data = $request->except('image');

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete the old image if updating
            if ($customer && $customer->image) {
                Storage::delete('public/customer_images/' . $customer->image);
            }

            // Generate a unique image name using timestamp and original file name
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName(); // e.g., 1698765432_image.jpg

            // Store the new image
            $image->storeAs('public/customer_images', $imageName);
            $data['image'] = $imageName;
        }

        return $data;
    }
}

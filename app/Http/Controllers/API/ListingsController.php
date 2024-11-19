<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Listings as Model;
use App\Traits\Uploadable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ListingsController extends Controller
{
    use Uploadable;

    public function getAll()
    {
        if (Auth::check()) {
            $users = Auth::id();
            $records = Model::where("user_id", $users)->get();
            $data = ['code' => 200, 'records' => $records];
            return response($data);
        }
        else{
            return response()->json([
                'message' => 'User not authenticated.'
            ], 401);    
        }
    }

    public function get($id)
    {
        $record = Model::findOrFail($id);
        $data = ['code' => 200, 'record' => $record];
        return response($data);
    }

    public function add(Request $request)
    {
        // Validate input data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:15',
            'unit_name' => 'required|string|max:255',
            'unit_type' => 'required|string|max:255',
            'unit_location' => 'required|string|max:255',
            'unit_price' => 'required|numeric|between:0,9999999.99',
        
            'images.*' => 'nullable|image',  // Allow images, if any, to be uploaded
        ]);
    
        // Determine user_id based on authentication status
        if (Auth::check()) {
            $validated['user_id'] = Auth::id();
            $validated['status'] = "Pending";
        } else {
            $validated['user_id'] = $request->input('user_id');
        }

        // Handle file uploads (if images are provided)
        if ($request->hasFile('images')) {
            $images = [];
            foreach ($request->file('images') as $image) {
                $images[] = $this->upload($image, 'uploads/listings/images');
            }
            $validated['images'] = json_encode($images);
        }
    
        // Fill the validated data into the model and save the record
        $property = Model::create($validated);
    
        // Return a success response
        return response()->json([
            'code' => 200,
            'message' => 'Property added successfully'
        ]);
    }
    


    public function delete($id)
    {
        $record = Model::findOrFail($id);
        $record->delete();
        return response(['code' => 200, 'msg' => 'Property deleted successfully']);
    }
}

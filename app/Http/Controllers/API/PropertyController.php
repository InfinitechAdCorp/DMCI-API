<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Traits\Uploadable;
use App\Models\Property as property;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PropertyController extends Controller
{
    use Uploadable;

    public function getAll()
    {
        $user = Auth::id();

        if ($user) {
            $records = property::where('user_id', $user)->get();
            $data = ['code' => 200, 'records' => $records];
            return response($data);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'User not authenticated.'
            ], 401);
        }
    }


    public function get($id)
    {
        $record = property::findOrFail($id);
        $data = ['code' => 200, 'record' => $record];
        return response($data);
    }

    public function add(Request $request)
    {
        try {
            // Validation
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'logo' => 'required',
                'description' => 'required|string',
                'slogan' => 'required|string|max:255',
                'location' => 'required|string|max:255',
                'min_price' => 'required|numeric|min:0',
                'max_price' => 'required|numeric|gte:min_price',
                'status' => 'required|string',
                'percent' => 'required|numeric|between:0,100',
                'images.*' => 'file',
            ]);
    
            // Log validated data
            Log::info('Validated data:', $validated);
    
            // Ensure user is authenticated
            $user = auth()->user();
            if (!$user) {
                return response()->json(['message' => 'User not authenticated'], 401);
            }
    
            // File upload processing
            if ($request->hasFile('logo')) {
                $validated['logo'] = $this->upload($request->file('logo'), 'uploads/properties/logos');
            }
    
            if ($request->hasFile('images')) {
                $images = [];
                foreach ($request->file('images') as $image) {
                    $images[] = $this->upload($image, 'uploads/properties/images');
                }
                $validated['images'] = json_encode($images);
            }
    
            $validated['user_id'] = $user->user_id;
    
            $property = Property::create($validated);
            
            return response()->json([
                'code' => 200,
                'message' => 'Property created successfully',
                'property' => $property,
            ]);
        } catch (\Exception $e) {
            Log::error('Error creating property:', ['error' => $e->getMessage()]);
            return response()->json([
                'code' => 500,
                'message' => 'Failed to create property',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    


    // public function update(Request $request, $id)
    // {
    //     $request->validate([
    //         'name' => 'required',
    //         'description' => 'required',
    //     ]);

    //     $record = property::find($id);
    //     $record->update($request->all());

    //     return response(['code' => 200]);
    // }

    public function delete($id)
    {
        // Check if the user is authenticated
        if (Auth::check()) {
            $user = Auth::id();
    
            $property = Property::where('id', $id)->where('user_id', $user)->first();
    
            if ($property) {
                $property->delete();
                return response()->json(['code' => 200, 'message' => 'Property deleted successfully']);
            } else {
                return response()->json(['code' => 404, 'message' => 'Property not found or not owned by user'], 404);
            }
        }
        return response()->json(['code' => 401, 'message' => 'Unauthorized'], 401);
    }
    
}

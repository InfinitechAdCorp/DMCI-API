<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Traits\Uploadable;
use App\Models\Property as Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PropertyController extends Controller
{
    use Uploadable;

    public function getAll()
    {
        $user = Auth::id();

        if ($user) {
            $records = Model::where('user_id', $user)->get();
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
        $record = Model::findOrFail($id);
        $data = ['code' => 200, 'record' => $record];
        return response($data);
    }

    public function add(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'logo' => 'required',
            'description' => 'required|string',
            'slogan' => 'required|string|max:255',
            'location'  => 'required|string|max:255',
            'min_price'  => 'required|numeric|min:0',
            'max_price'  => 'required|numeric|gte:min_price',
            'status'  => 'required|string',
            'percent' => 'required|numeric|between:0,100',
            'images.*' => 'required'  // Optional images upload
        ]);

        try {
            // Get the authenticated user
            $user = auth()->user();

            // Upload the logo
            if ($request->hasFile('logo')) {
                $validated['logo'] = $this->upload($validated['logo'], 'uploads/properties/logos');
            }

            // Handle additional images
            if ($request->hasFile('images')) {
                $images = [];
                foreach ($request->file('images') as $image) {
                    $images[] = $this->upload($image, 'uploads/properties/images');
                }
                $validated['images'] = json_encode($images); // Save as JSON if images column is a JSON type
            }

            // Set the authenticated user's ID
            $validated['user_id'] = $user->user_id;

            // Create a new property record
            $property = Model::create($validated);

            return response()->json([
                'code' => 200,
                'message' => 'Property created successfully'
            ])
                ->header('Access-Control-Allow-Origin', '*')
                ->header('Access-Control-Allow-Methods', 'POST, GET, OPTIONS, PUT, DELETE')
                ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization');
        } catch (\Exception $e) {
            return response()->json([
                'code' => 500,
                'message' => 'Failed to create property',
                'error' => $e->getMessage()
            ], 500)
                ->header('Access-Control-Allow-Origin', '*')
                ->header('Access-Control-Allow-Methods', 'POST, GET, OPTIONS, PUT, DELETE')
                ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization');
        }
    }


    // public function update(Request $request, $id)
    // {
    //     $request->validate([
    //         'name' => 'required',
    //         'description' => 'required',
    //     ]);

    //     $record = Model::find($id);
    //     $record->update($request->all());

    //     return response(['code' => 200]);
    // }

    public function delete($id)
    {
        $record = Model::findOrFail($id);
        $record->delete();
        return response(['code' => 200]);
    }
}

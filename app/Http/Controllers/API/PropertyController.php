<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Traits\Uploadable;
use App\Models\Property as property;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

class PropertyController extends Controller
{
    use Uploadable;

    public function getAll()
    {
        if (Auth::check()) {

            $user = Auth::user();

            // Initialize $records in case neither condition is met
            $records = [];

            // Check user type
            if ($user->user_type == "Agent") {
                $userID = $user->user_id;
                $records = Property::where('user_id', $userID)->get(); // Fetch properties for the agent
            } elseif ($user->user_type == "Admin") {
                $records = property::with(['user'])->get();
            } else {
                // If needed, return a response for unauthorized user type
                return response()->json([
                    'status' => 'error',
                    'message' => 'User type not authorized.'
                ], 403); // 403 Forbidden, as this user type isn't allowed
            }

            // Return the records with a success response
            $data = ['code' => 200, 'records' => $records];
            return response($data);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'User not authenticated.'
        ], 401);
    }

    public function getPropertyAgent($id)
    {
        $records = Property::where('user_id', $id)->get();

        if ($records->isNotEmpty()) {
            return response()->json([
                'status' => 'success',
                'record' => $records,
            ], 200);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'No properties found for the given user ID.',
        ], 404);
    }




    public function get($id)
    {
        $user = Auth::id();
        if ($user) {
            $record = property::where('user_id', $user)->where('id', $id)->first();
            $data = ['code' => 200, 'record' => $record];
            return response($data);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'User not authenticated.'
            ], 401);
        }
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

            // Ensure user is authenticated
            $user = auth()->user();
            if (!$user) {
                return response()->json(['message' => 'User not authenticated'], 401);
            }

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



    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required',
            'status' => 'required',
            'percent' => 'required',
            'location' => 'required',
            'min_price' => 'required',
            'max_price' => 'required',
            'slogan' => 'required',
            'description' => 'required',

        ]);

        $record = property::where('id', $id);
        $record->update($validated);
        $data = ['code' => 200];

        return response($data);
    }



    public function delete($id)
    {
        // Check if the user is authenticated
        if (Auth::check()) {
            // Get the authenticated user's ID
            $user = Auth::id();

            // Find the property by its ID and ensure it belongs to the authenticated user
            $property = Property::where('id', $id)->where('user_id', $user)->first();

            if ($property) {
                try {
                    // Handle the logo image deletion if it exists
                    if ($property->logo) {
                        // Assuming the logo column stores the relative path to the logo image
                        $logoPath = public_path('uploads/properties/logos/' . $property->logo);
                        if (File::exists($logoPath)) {
                            File::delete($logoPath);
                        }
                    }

                    // Handle the property images deletion if they exist
                    if ($property->images) {
                        $images = json_decode($property->images, true);
                        foreach ($images as $image) {
                            // Assuming each image is stored in 'uploads/properties/images/'
                            $imagePath = public_path('uploads/properties/images/' . $image);
                            if (File::exists($imagePath)) {
                                File::delete($imagePath);
                            }
                        }
                    }

                    // Delete the property record from the database
                    $property->delete();

                    // Return success response
                    return response()->json([
                        'code' => 200,
                        'message' => 'Property and its associated images deleted successfully'
                    ]);
                } catch (\Exception $e) {
                    // Handle any exceptions during deletion (e.g., file not found, database error)
                    return response()->json([
                        'code' => 500,
                        'message' => 'Error deleting property or images: ' . $e->getMessage()
                    ], 500);
                }
            } else {
                // Return 404 if the property is not found or does not belong to the user
                return response()->json([
                    'code' => 404,
                    'message' => 'Property not found or not owned by user'
                ], 404);
            }
        }

        // Return 401 if the user is not authenticated
        return response()->json([
            'code' => 401,
            'message' => 'Unauthorized'
        ], 401);
    }
}

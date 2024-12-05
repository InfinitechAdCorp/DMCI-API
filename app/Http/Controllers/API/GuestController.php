<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Listings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class GuestController extends Controller
{
    public function AddListings(Request $request)
    {
        // Validate request input
        $validated = $request->validate([
            'user_id' => 'required',
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'unit_name' => 'required',
            'unit_type' => 'required',
            'unit_location' => 'required',
            'status' => 'nullable',
            'unit_price' => 'required|numeric|between:0,9999999.99',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        // Handle image uploads
        $images = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                // Store the file in the S3 disk
                $path = $image->store('uploads/listings/images', 's3', 'public'); 
                
                // Get the public URL for the uploaded file
                $url = 'https://' . env('AWS_BUCKET') . '.s3.' . '.amazonaws.com/' . $path;

                // Add the URL to the images array
                $images[] = $url;
            }
        }

        // Add the images to the validated data as a JSON string
        $validated['images'] = json_encode($images);

        try {
            // Create the listing
            $property = Listings::create($validated);

            return response()->json([
                'code' => 200,
                'message' => 'Property added successfully',
                'data' => $property,
            ]);
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Failed to add property', [
                'error' => $e->getMessage(),
                'validated_data' => $validated,
            ]);

            return response()->json([
                'code' => 500,
                'message' => 'Failed to add property. Please try again.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}

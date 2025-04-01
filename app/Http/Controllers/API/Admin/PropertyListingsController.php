<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\PropertyListings as Model;

class PropertyListingsController extends Controller
{

    public $model = "PropertyListings";

    // Create New Properties
    public function create(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'property_name' => 'required',
            'property_location' => 'required',
            'property_price' => 'required',
            'property_type' => 'required',
            'property_size' => 'required|decimal:0,2',
            'property_bldg' => 'required',
            'property_level' => 'required|numeric|integer',
            'property_amenities' => 'required',
            'property_parking' => 'required',
            'property_images' => 'required',
            'property_description' => 'required',
        ]);

        $validated['property_featured'] = false;

        $key = 'property_images';
        if ($request[$key]) {
            $property_images = [];
            foreach ($request[$key] as $image) {
                array_push($property_images, $this->upload($property_images, "properties/images"));
            }
            $validated[$key] = json_encode($property_images);
        }

        $record = Model::create($validated);
        $code = 201;
        $response = [
            'message' => "Created $this->model",
            'record' => $record,
        ];
        return response()->json($response, $code);
    }
}

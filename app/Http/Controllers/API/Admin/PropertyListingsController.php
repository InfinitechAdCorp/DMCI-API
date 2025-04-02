<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\Uploadable;
use Laravel\Sanctum\PersonalAccessToken;
use App\Models\PropertyListings as Model;

class PropertyListingsController extends Controller
{
    use Uploadable;

    public $model = "PropertyListings";

    public function getAll(Request $request)
    {
        $user =  PersonalAccessToken::findToken($request->bearerToken())->tokenable;
        $relations = ['user'];
        if ($user->type == "Admin") {
            $records = Model::with($relations)->orderBy('created_at', 'desc')->get();
        } else if ($user->type == "Agent") {
            $records = Model::with($relations)->where('user_id', $user->id)->orderBy('status')->get();
        }
        $code = 200;
        $response = ['message' => "Fetched Properties", 'records' => $records];
        return response()->json($response, $code);
    }

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
            'images' => 'required',
            'property_description' => 'required',
        ]);

        $validated['property_featured'] = false;

        $key = 'images';
        if ($request[$key]) {
            $images = [];
            foreach ($request[$key] as $image) {
                array_push($images, $this->upload($image, "properties/images"));
            }
            $validated[$key] = json_encode($images);
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

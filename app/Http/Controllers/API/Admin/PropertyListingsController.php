<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\Uploadable;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Support\Facades\Storage;
use App\Models\PropertyListings as Model;

class PropertyListingsController extends Controller
{
    use Uploadable;

    public $model = "Property Listings";

    public function getAll(Request $request)
    {
        $user =  PersonalAccessToken::findToken($request->bearerToken())->tokenable;
        $relations = ['user', 'property.buildings', 'property.features'];
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
            'property_id' => 'required|exists:properties,id',
            'property_building' => 'required|max:255',
            'property_location' => 'required|max:255',
            'property_price' => 'required|decimal:0,2',
            'property_type' => 'required|max:255',
            'property_size' => 'required|decimal:0,2',
            'property_parking' => 'required|boolean',
            'property_description' => 'required',
            'property_level' => 'required|max:255',
            'property_amenities' => 'required',
            'images' => 'required',
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

        $relations = ['user', 'property.buildings', 'property.features'];
        $record = Model::with($relations)->where('id', $record->id)->first();

        $code = 201;
        $response = [
            'message' => "Created $this->model",
            'record' => $record,
        ];
        return response()->json($response, $code);
    }

    // Update

    public function update(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'property_id' => 'required|exists:properties,id',
            'property_location' => 'required|max:255',
            'property_price' => 'required|decimal:0,2',
            'property_type' => 'required|max:255',
            'property_size' => 'required|decimal:0,2',
            'property_parking' => 'required|boolean',
            'property_description' => 'required',
            'property_level' => 'required|max:255',
            'property_amenities' => 'required',
            'images' => 'required',
        ]);

        $record = Model::find($validated['id']);

        $validated['property_featured'] = false;

        $key = 'images';
        if ($request[$key]) {
            $images = json_decode($record[$key]);
            foreach ($images as $image) {
                Storage::disk('s3')->delete("properties/images/$image");
            }

            $images = [];
            foreach ($request[$key] as $image) {
                array_push($images, $this->upload($image, "properties/images"));
            }
            $validated[$key] = json_encode($images);
        }

        $record->update($validated);
        $code = 200;
        $response = ['message' => "Updated $this->model", 'record' => $record];
        return response()->json($response, $code);
    }

    // Delete Property

    public function delete($id)
    {
        $record = Model::find($id);
        if ($record) {
            Storage::disk('s3')->delete("properties/logos/$record->logo");

            $images = json_decode($record->images);
            foreach ($images as $image) {
                Storage::disk('s3')->delete("properties/images/$image");
            }

            $record->delete();
            $code = 200;
            $response = [
                'message' => "Deleted $this->model"
            ];
        } else {
            $code = 404;
            $response = ['message' => "$this->model Not Found"];
        }
        return response()->json($response, $code);
    }

    public function set(Request $request)
    {
        $user =  PersonalAccessToken::findToken($request->bearerToken())->tokenable;

        Model::where('user_id', $user->id)->update(['featured' => false]);

        $record = Model::find($request['id']);

        if ($record) {
            $record->update(['property_featured' => true]);
            $code = 200;
            $response = ['message' => "Set $this->model as Featured", 'record' => $record];
        }
        else {
            $code = 404;
            $response = ['message' => "Property Not Found", 'record' => $record];
        }

        return response()->json($response, $code);
    }
}

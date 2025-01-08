<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Traits\Uploadable;
use Laravel\Sanctum\PersonalAccessToken;

use App\Models\Property as Model;

class PropertyController extends Controller
{
    use Uploadable;

    public $model = "Property";

    public function getAll(Request $request)
    {
        if ($token = $request->bearerToken()) {
            $user =  PersonalAccessToken::findToken($token)->tokenable;

            if ($user) {
                $relations = ['user', 'plan', 'buildings', 'facilities', 'features', 'units'];
                if ($user->type == "Admin") {
                    $records = Model::with($relations)->get();
                } else if ($user->type == "Agent") {
                    $records = Model::with($relations)->where('user_id', $user->id)->get();
                }
                $code = 200;
                $response = ['message' => "Fetched Properties", 'records' => $records];
            } else {
                $code = 404;
                $response = ['message' => "User Not Found"];
            }
        } else {
            $code = 401;
            $response = ['message' => "User Not Authenticated"];
        }
        return response()->json($response, $code);
    }

    public function get($id)
    {
        $record = Model::with(['user', 'plan', 'buildings', 'facilities', 'features', 'units'])->where('id', $id)->first();
        if ($record) {
            $code = 200;
            $response = ['message' => "Fetched $this->model", 'record' => $record];
        } else {
            $code = 404;
            $response = ['message' => "$this->model Not Found"];
        }
        return response()->json($response, $code);
    }

    public function create(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'name' => 'required',
            'slogan' => 'required',
            'location' => 'required',
            'min_price' => 'required|decimal:0,2',
            'max_price' => 'required|decimal:0,2',
            'status' => 'required',
            'percent' => 'required|numeric|integer',
            'description' => 'required',
            'logo' => 'required',
            'images' => 'required',
        ]);

        $key = 'logo';
        if ($request->hasFile($key)) {
            $validated[$key] = $this->upload($request->file($key), "properties/logos");
        }

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

    public function update(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|exists:properties,id',
            'user_id' => 'required|exists:users,id',
            'name' => 'required',
            'slogan' => 'required',
            'location' => 'required',
            'min_price' => 'required|decimal:0,2',
            'max_price' => 'required|decimal:0,2',
            'status' => 'required',
            'percent' => 'required|numeric|integer',
            'description' => 'required',
            'logo' => 'nullable',
            'images' => 'nullable',
        ]);

        $record = Model::find($validated['id']);

        $key = 'logo';
        if ($request->hasFile($key)) {
            Storage::disk('s3')->delete("properties/logos/$record->logo");
            $validated[$key] = $this->upload($request->file($key), "properties/logos");
        }

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
}

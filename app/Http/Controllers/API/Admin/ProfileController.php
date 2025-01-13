<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Traits\Uploadable;
use Laravel\Sanctum\PersonalAccessToken;

use App\Models\Profile as Model;

class ProfileController extends Controller
{
    use Uploadable;

    public $model = "Profile";

    public function getAll(Request $request)
    {
        $user =  PersonalAccessToken::findToken($request->bearerToken())->tokenable;
        if ($user->type == "Admin") {
            $records = Model::with('user')->orderBy('updated_at', 'desc')->get();
            $response = ['message' => "Fetched $this->model" . "s", 'records' => $records];
        } else if ($user->type == "Agent") {
            $record = Model::with('user')->where('user_id', $user->id)->first();
            $response = ['message' => "Fetched $this->model", 'record' => $record];
        }
        $code = 200;
        return response()->json($response, $code);
    }

    public function get($id)
    {
        $record = Model::with('user')->where('id', $id)->first();
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
            'position' => 'required',
            'phone' => 'required',
            'facebook' => 'nullable|url',
            'instagram' => 'nullable|url',
            'telegram' => 'nullable',
            'viber' => 'nullable',
            'whatsapp' => 'nullable',
            'about' => 'required',
            'image' => 'required',
        ]);

        $key = 'image';
        if ($request->hasFile($key)) {
            $validated[$key] = $this->upload($request->file($key), "profiles");
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
            'id' => 'required|exists:profiles,id',
            'user_id' => 'required|exists:users,id',
            'position' => 'required',
            'phone' => 'required',
            'facebook' => 'nullable|url',
            'instagram' => 'nullable|url',
            'telegram' => 'nullable',
            'viber' => 'nullable',
            'whatsapp' => 'nullable',
            'about' => 'required',
            'image' => 'nullable',
        ]);

        $record = Model::find($validated['id']);

        $key = 'image';
        if ($request->hasFile($key)) {
            Storage::disk('s3')->delete("profiles/$record[$key]");
            $validated[$key] = $this->upload($request->file($key), "profiles");
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
            Storage::disk('s3')->delete("profiles/$record->image");
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

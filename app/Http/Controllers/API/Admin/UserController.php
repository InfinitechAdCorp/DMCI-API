<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;

use App\Models\User as Model;

class UserController extends Controller
{
    public $model = "User";

    public function getAll(Request $request)
    {
        if ($token = $request->bearerToken()) {
            $record =  PersonalAccessToken::findToken($token)->tokenable;
            if ($record) {
                $relations = ['certificates', 'images', 'testimonials', 'properties', 'appointments', 'listings'];
                if ($record->type == "Admin") {
                    $records = Model::with($relations)->get();
                    $code = 200;
                    $response = ['message' => "Fetched $this->model" . "s", 'records' => $records];
                } else if ($record->type == "Agent") {
                    $record = Model::with($relations)->where('id', $record->id)->first();
                    $code = 200;
                    $response = ['message' => "Fetched $this->model", 'record' => $record];
                }
            } else {
                $code = 404;
                $response = ['message' => "$this->model Not Found"];
            }
        } else {
            $code = 401;
            $response = ['message' => "$this->model Not Authenticated"];
        }
        return response()->json($response, $code);
    }

    public function get($id)
    {
        $relations = ['certificates', 'images', 'testimonials', 'properties', 'appointments', 'listings'];
        $record = Model::with($relations)->where('id', $id)->first();
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
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'type' => 'required'
        ]);

        $key = "password";
        $validated[$key] = Hash::make($validated[$key]);

        $record = Model::create($validated);
        $code = 201;
        $response = [
            'message' => "Created $this->model",
            'record' => $record,
        ];
        return response()->json($response, $code);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        $record = Model::where('email', $request->email)->first();

        if ($record && Hash::check($request->password, $record->password)) {
            $record->tokens()->delete();
            $token = $record->createToken($record->name . '-AuthToken')->plainTextToken;
            $code = 200;
            $response = [
                'message' => 'Login Successful',
                'record' => $record,
                'token' => $token,
            ];
        } else {
            $code = 401;
            $response = [
                'message' => 'Invalid Credentials',
            ];
        }
        return response()->json($response, $code);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        $code = 200;
        $response = ['message' => 'Logged Out Successfully'];
        return response()->json($response, $code);
    }
}

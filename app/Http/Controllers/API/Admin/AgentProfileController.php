<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Traits\Uploadable;
use App\Models\AgentProfile as Model;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class AgentProfileController extends Controller
{
    use Uploadable;
    
    public $model = "AgentProfile";

    public function getAll(Request $request)
    {
        if ($token = $request->bearerToken()) {
            $user = PersonalAccessToken::findToken($token)->tokenable;

            if ($user) {
                if ($user->type == "Admin") {
                    $records = Model::with('user')->get();
                } else if ($user->type == "Agent") {
                    $records = Model::with('user')->where('user_id', $user->id)->get();
                }
                $code = 200;
                $response = ['message' => "Fetched $this->model" . "s", 'records' => $records];
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
        $record = Model::find($id);
        if ($record) {
            $data = ['code' => 200, 'record' => $record];
        } else {
            $data = ['code' => 404, 'message' => 'Agent Profile Not Found'];
        }
        return response($data);
    }

    public function add(Request $request)
    {
        if (!$request->has('user_id')) {
            return response()->json(['message' => 'User ID is missing'], 400);
        }

        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'position' => 'required|string',
            'email' => 'required|email',
            'phone_number' => 'required|string',
            'facebook' => 'nullable|string',
            'instagram' => 'nullable|string',
            'telegram' => 'nullable|string',
            'viber' => 'nullable|string',
            'whatsapp' => 'nullable|string',
            'about_me' => 'nullable|string',
            'image' => 'required', 
        ]);

        $validatedData = $validated; 

        if ($request->hasFile('image')) {
            $validatedData['image'] = $this->upload($request->file('image'), 'agent_images'); 
        }

        $record = Model::create($validatedData);
        $code = 201;
        $response = ['message' => "Created $this->model", 'record' => $record];

        return response()->json($response, $code);
    }


    public function update(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|exists:agent_profiles,id',
            'user_id' => 'required|exists:users,id',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'position' => 'required|string',
            'email' => 'required|email',
            'phone_number' => 'required|string',
            'facebook' => 'nullable|string',
            'instagram' => 'nullable|string',
            'telegram' => 'nullable|string',
            'viber' => 'nullable|string',
            'whatsapp' => 'nullable|string',
            'about_me' => 'nullable|string',
            'image' => 'required'
        ]);

        $profile = Model::find($validated['id']);
        if ($request->hasFile('image')) {
            $validated['image'] = $this->upload($request->file('image'), 'agent_images'); 
        }

        $profile->update($validated);

        $data = ['code' => 200, 'message' => 'Agent Profile Updated'];

        return response()->json($data, 200);
    }

    public function delete($id)
    {
        $profile = Model::find($id);
        if ($profile) {
            $profile->delete();
            $data = ['code' => 200, 'message' => 'Agent Profile Deleted'];
        } else {
            $data = ['code' => 404, 'message' => 'Agent Profile Not Found'];
        }

        return response($data);
    }
}
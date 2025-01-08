<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Traits\Uploadable;
use App\Models\Certificate as Model;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class CertificateController extends Controller
{
    use Uploadable;
    public $model = "Certificate";

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
            $data = ['code' => 404, 'message' => 'Certificate Not Found'];
        }
        return response($data);
    }

    public function add(Request $request)
    {
        if (!$request->has('user_id')) {
            return response()->json(['message' => 'User ID is missing'], 400);
        }
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
            'description' => 'required|string|max:1000',
            'image' => 'required',
            'date' => 'required|date',  
        ]);

        $key = 'image';
        if ($request->hasFile($key)) {
            $validated[$key] = $this->upload($request->file($key), "certificates");
        }

        $record = Model::create($validated);
        $code = 201;
        $response = ['message' => "Created certificate", 'record' => $record];

        return response()->json($response, $code);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|exists:certificates,id',
            'user_id' => 'required|exists:users,id',

            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'date' => 'required|date',
        ]);

        $certificate = Model::find($validated['id']);

        if ($request->hasFile('image')) {
            $this->deleteUploadedFile($certificate->image);
            $validated['image'] = $this->upload($request->file('image'), 'certificates');
        }

        $certificate->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'image' => $validated['image'] ?? $certificate->image,
            'date' => $validated['date'],  
        ]);

        $data = ['code' => 200, 'message' => 'Certificate Updated'];

        return response()->json($data, 200);
    }

    public function delete($id)
    {
        $certificate = Model::find($id);
        if ($certificate) {
            $this->deleteUploadedFile($certificate->image);
            $certificate->delete();

            $data = ['code' => 200, 'message' => 'Certificate Deleted'];
        } else {
            $data = ['code' => 404, 'message' => 'Certificate Not Found'];
        }

        return response($data);
    }
}

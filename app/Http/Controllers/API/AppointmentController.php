<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\Uploadable;
use Laravel\Sanctum\PersonalAccessToken;

use App\Models\Appointment as Model;

class AppointmentController extends Controller
{
    use Uploadable;

    public $model = "Appointment";

    public function getAll(Request $request)
    {
        if ($token = $request->bearerToken()) {
            $user =  PersonalAccessToken::findToken($token)->tokenable;

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
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'date' => 'required|date',
            'time' => 'required',
            'type' => 'required',
            'properties' => 'required',
            'message' => 'required',
            'status' => 'required',
        ]);

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
            'id' => 'required|exists:appointments,id',
            'user_id' => 'required|exists:users,id',
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'date' => 'required|date',
            'time' => 'required',
            'type' => 'required',
            'properties' => 'required',
            'message' => 'required',
            'status' => 'required',
        ]);

        $record = Model::find($validated['id']);
        $record->update($validated);
        $code = 200;
        $response = ['message' => "Updated $this->model", 'record' => $record];
        return response()->json($response, $code);
    }

    public function delete($id)
    {
        $record = Model::find($id);
        if ($record) {
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

    public function changeStatus(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|exists:appointments,id',
            'status' => 'required',
        ]);

        $record = Model::find($validated['id']);
        $record->update($validated);
        $code = 200;
        $response = ['message' => "Updated Status"];
        return response()->json($response, $code);
    }
}

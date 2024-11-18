<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment as Model;

class AppointmentController extends Controller
{
    public function getAll()
    {
        $records = Model::all();
        $data = ['code' => 200, 'records' => $records];
        return response($data);
    }

    public function get($id)
    {
        $record = Model::findOrFail($id);
        $data = ['code' => 200, 'record' => $record];
        return response($data);
    }

    public function add(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required',
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
            'type' => 'required',
            'properties' => 'required',
            'message' => 'required',
            'status' => 'required',
        ]);

        Model::create($validated);
        $data = ['code' => 200];

        return response($data);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|exists:appointments,id',
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
            'type' => 'required',
            'properties' => 'required',
            'message' => 'required',
            'status' => 'required',
        ]);

        $record = Model::find($validated["id"]);
        $record->update($validated);
        $data = ['code' => 200];

        return response($data);
    }

    public function delete($id)
    {
        $record = Model::findOrFail($id);
        $record->delete();
        return response(['code' => 200]);
    }
}

<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment as Model;
use Illuminate\Support\Facades\Log;

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
        // Validate the request data
        $validated = $request->validate([
            'user_id' => 'required',
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'date' => 'required|date',
            'time' => 'required',
            'type' => 'required',
            'properties' => 'required',
            'message' => 'nullable',  // Allow null for message
            'status' => 'nullable',   // Allow null for status
        ]);
        

        try {
            // Attempt to create the record in the database
            $record = Model::create($validated);

            // Prepare response data
            $data = [
                'code' => 200,
                'message' => 'Record created successfully.',
                'data' => $record // Return the created record data for clarity
            ];

            // Log the success
            Log::info('Record created successfully', ['data' => $data]);

            return response()->json($data);
        } catch (\Exception $e) {
            // Handle any errors that occur during the creation
            $data = [
                'code' => 500,
                'message' => 'Failed to create the record.',
                'error' => $e->getMessage()
            ];

            // Log the error for debugging
            Log::error('Failed to create record', ['error' => $e->getMessage()]);

            return response()->json($data, 500);
        }
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

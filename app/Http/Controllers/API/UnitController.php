<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Unit as Model;

class UnitController extends Controller
{
    public $model = "Unit";

    public function getAll()
    {
        $records = Model::with('property')->get();
        $code = 200;
        $response = ['message' => "Fetched $this->model" . "s", 'records' => $records];
        return response()->json($response, $code);
    }

    public function get($id)
    {
        $record = Model::with('property')->where('id',$id)->get();
        if ($record) {
            $code = 200;
            $response = ['message' => "Fetched $this->model", 'record' => $record];
        }
        else {
            $code = 404;
            $response = ['message' => "$this->model Not Found"];
        }
        return response()->json($response, $code);
    }

    public function create(Request $request)
    {
        $validated = $request->validate([
            'property_id' => 'required|exists:properties,id',
            'type' => 'required',
            'area' => 'required|decimal:0,2',
            'price' => 'required',
            'status' => 'required',
        ]);

        $record = Model::create($validated);
        $code = 201;
        $response = ['message' => "Created $this->model", 'record' => $record];
        return response()->json($response, $code);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|exists:units,id',
            'property_id' => 'required|exists:properties,id',
            'type' => 'required',
            'area' => 'required|decimal:0,2',
            'price' => 'required',
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
            $response = ['message' => "Deleted $this->model"];
        }
        else {
            $code = 404;
            $response = ['message' => "$this->model Not Found"];
        }
        return response($response, $code);
    }
}

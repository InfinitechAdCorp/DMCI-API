<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Unit as Model;

class UnitController extends Controller
{

    public function getAll()
    {
        $records = Model::with("property")->get();
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
            'property_id' => 'required|exists:properties,id',
            'type' => 'required',
            'area' => 'required|decimal:0,2',
            'price' => 'required',
            'status' => 'required',
        ]);

        Model::create($validated);
        $data = ['code' => 200];

        return response($data);
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

<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Feature as Model;

class FeatureController extends Controller
{

    public function getAll()
    {
        $records = Model::all();
        $data = ['records' => $records];
        return response($data);
    }

    public function get($id)
    {
        $record = Model::find($id);
        $data = ['record' => $record];
        return response($data);
    }

    public function add(Request $request)
    {
        $request->validate([
            'property_id' => 'required',
            'name' => 'required',
        ]);
        Model::create($request->all());
        return response(['code' => 200]);
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'property_id' => 'required',
            'name' => 'required',
        ]);

        $record = Model::find($id);
        $record->update($request->all());

        return response(['code' => 200]);
    }

    public function delete($id)
    {
        Model::find($id)->delete();
        return response(['code' => 200]);
    }
}

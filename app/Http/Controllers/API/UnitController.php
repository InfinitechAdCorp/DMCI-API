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
        $records = Model::with("property")->get();
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
            'type' => 'required',
            'area' => 'required',
            'price' => 'required',
            'status' => 'required',
        ]);
        Model::create($request->all());
        return response(['code' => 200, 'message' => "Added $this->model"]);
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'property_id' => 'required',
            'type' => 'required',
            'area' => 'required',
            'price' => 'required',
            'status' => 'required',
        ]);

        $record = Model::find($id);
        $record->update($request->all());

        return response(['code' => 200, 'message' => "Updated $this->model"]);
    }

    public function delete($id)
    {
        Model::find($id)->delete();
        return response(['code' => 200, 'message' => "Deleted $this->model"]);
    }
}

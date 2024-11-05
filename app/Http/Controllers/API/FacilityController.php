<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Facility as Model;

class FacilityController extends Controller
{
    public $model = "Facility";

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
            'image' => 'required|file',
        ]);

        $keys = [
            'property_id',
            'name',
        ];

        foreach ($keys as $key) {
            $new[$key] = $request->$key;
        }

        if ($file = $request->file("image")) {
            $name = mt_rand() . '.'.$file->clientExtension();
            $file->move('uploads/properties/facilities', $name);
            $new["image"] = $name;
        }

        Model::create($new);
        return response(['code' => 200, 'message' => "Added $this->model"]);
    }
    
    // public function update(Request $request, $id)
    // {
    //     $request->validate([
    //         'name' => 'required',
    //         'description' => 'required',
    //     ]);

    //     $record = Model::find($id);
    //     $record->update($request->all());

    //     return response(['code' => 200, 'message' => "Updated $this->model"]);
    // }

    public function delete($id)
    {
        Model::find($id)->delete();
        return response(['code' => 200, 'message' => "Deleted $this->model"]);
    }
}

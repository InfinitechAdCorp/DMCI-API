<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Property as Model;

class PropertyController extends Controller
{
    public $model = "Property";

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
            'category_id' => 'required',
            'name' => 'required',
            'logo' => 'required|file',
            'description' => 'required',
            'slogan' => 'required',
            'location'  => 'required',
            'min_price'  => 'required',
            'max_price'  => 'required',
            'status'  => 'required',
            'percent' => 'required',
        ]);

        $keys = [
            'category_id',
            'name',
            'description',
            'slogan',
            'location',
            'min_price',
            'max_price',
            'status',
            'percent'
        ];

        foreach ($keys as $key) {
            $new[$key] = $request->$key;
        }

        if ($file = $request->file("logo")) {
            $name = mt_rand() . '.'.$file->clientExtension();
            $file->move('uploads/properties/logos', $name);
            $new["logo"] = $name;
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

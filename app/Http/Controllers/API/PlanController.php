<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\Uploadable;

use App\Models\Plan as Model;

class PlanController extends Controller
{
    use Uploadable;

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
            'area' => 'required',
            'theme' => 'required',
            'image' => 'required|file',
        ]);

        $keys = [
            'property_id',
            'area',
            'theme',
            'image',
        ];

        foreach ($keys as $key) {
            if ($key == 'logo') {
                $new[$key] = $this->upload($request->file($key), 'uploads/properties/plans');
            }
            else {
                $new[$key] = $request->$key;
            }
        }

        Model::create($new);
        return response(['code' => 200]);
    }

    // public function update(Request $request, $id)
    // {
    //     $request->validate([
    //         'name' => 'required',
    //         'description' => 'required',
    //     ]);

    //     $record = Model::find($id);
    //     $record->update($request->all());

    //     return response(['code' => 200]);
    // }

    public function delete($id)
    {
        Model::find($id)->delete();
        return response(['code' => 200]);
    }
}

<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Career as Model;

class CareerController extends Controller
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
            'referrer' => 'required',
            'sub_agent' => 'required',
            'broker' => 'required',
            'partner' => 'required',
            'position' => 'required',
            'image' => 'required|file',
        ]);

        $keys = [
            'referrer',
            'sub_agent',
            'broker',
            'partner',
            'position',
        ];

        foreach ($keys as $key) {
            $new[$key] = $request->$key;
        }

        if ($file = $request->file("image")) {
            $name = mt_rand() . '.'.$file->clientExtension();
            $file->move('uploads/careers/images', $name);
            $new["image"] = $name;
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

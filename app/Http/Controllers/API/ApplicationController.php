<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Application as Model;

class ApplicationController extends Controller
{
    public function getAll()
    {
        $records = Model::with("career")->get();
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
            'career_id' => 'required',
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'resume'  => 'required|file',
        ]);

        $keys = [
            'career_id',
            'name',
            'email',
            'phone',
            'address',
        ];

        foreach ($keys as $key) {
            $new[$key] = $request->$key;
        }

        if ($file = $request->file("resume")) {
            $name = mt_rand() . '.'.$file->clientExtension();
            $file->move('uploads/careers/applications', $name);
            $new["resume"] = $name;
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

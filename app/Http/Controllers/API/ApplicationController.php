<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\Uploadable;
use App\Models\Application as Model;

class ApplicationController extends Controller
{
    use Uploadable;

    public function getAll()
    {
        $records = Model::with("career")->get();
        $data = ['records' => $records];
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
            'resume',
        ];

        foreach ($keys as $key) {
            if ($key == 'resume') {
                $new[$key] = $this->upload($validated[$key], 'uploads/careers/applications');
            } else {
                $new[$key] = $validated[$key];
            }
        }

        Model::create($new);
        $data = ['code' => 200];

        return response($data);
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
        $record = Model::findOrFail($id);
        $record->delete();
        return response(['code' => 200]);
    }
}

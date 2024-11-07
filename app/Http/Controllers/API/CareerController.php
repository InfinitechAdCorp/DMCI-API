<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\Uploadable;
use App\Models\Career as Model;

class CareerController extends Controller
{
    use Uploadable;

    public function getAll()
    {
        $records = Model::all();
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
            'image',
        ];

        foreach ($keys as $key) {
            if ($key == 'image') {
                $new[$key] = $this->upload($validated[$key], 'uploads/careers/images');
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

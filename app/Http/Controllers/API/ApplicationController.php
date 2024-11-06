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
        $record = Model::find($id);

        if ($record) {
            $data = ['code' => 200, 'record' => $record];
        }
        else {
            $data = ['code' => 404];
        }

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
            'resume',
        ];

        foreach ($keys as $key) {
            if ($key == 'resume') {
                $new[$key] = $this->upload($request->file($key), 'uploads/careers/applications');
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
        $record = Model::find($id);

        if ($record) {
            $record->delete();
            $code = 200;
        }
        else {
            $code = 404;
        }

        return response(['code' => $code]);
    }
}

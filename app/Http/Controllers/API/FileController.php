<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\File as Model;

class FileController extends Controller
{
    public function getAll()
    {
        $records = Model::with('folder')->get();
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
            'folder_id' => 'required',
            'name' => 'required',
            'links' => 'required',
        ]);
        Model::create($request->all());
        return response(['code' => 200]);
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'folder_id' => 'required',
            'name' => 'required',
            'links' => 'required',
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

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
        $record = Model::findOrFail($id);
        $data = ['code' => 200, 'record' => $record];
        return response($data);
    }

    public function add(Request $request)
    {
        $validated = $request->validate([
            'folder_id' => 'required',
            'name' => 'required',
            'links' => 'required',
        ]);

        Model::create($validated);
        $data = ['code' => 200];

        return response($data);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|exists:files,id',
            'folder_id' => 'required',
            'name' => 'required',
            'links' => 'required',
        ]);

        $record = Model::find($validated['id']);
        $record->update($validated);
        $data = ['code' => 200];

        return response($data);
    }

    public function delete($id)
    {
        $record = Model::findOrFail($id);
        $record->delete();
        return response(['code' => 200]);
    }
}

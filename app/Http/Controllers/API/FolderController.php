<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Folder as Model;

class FolderController extends Controller
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
        $validated = $request->validate( [
           'name' => 'required',
        ]);

        Model::create($validated);
        $data = ['code' => 200];

        return response($data);
    }
    
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
           'name' => 'required',
        ]);

        $record = Model::find($id);
        $record->update($validated);
        $data = ['code' => 200];

        return response($data);
    }

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

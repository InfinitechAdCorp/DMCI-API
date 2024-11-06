<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
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

        if ($record) {
            $data = ['code' => 200, 'record' => $record];
        } else {
            $data = ['code' => 404];
        }

        return response($data);
    }

    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'folder_id' => 'required',
            'name' => 'required',
            'links' => 'required',
        ]);

        if ($validator->passes()) {
            Model::create($validator->validated());
            $data = ['code' => 200];
        } else {
            $data = ['code' => 422, 'errors' => $validator->errors()];
        }

        return response($data);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'folder_id' => 'required',
            'name' => 'required',
            'links' => 'required',
        ]);

        if ($validator->passes()) {
            $record = Model::find($id);
            $record->update($validator->validated());
            $data = ['code' => 200];
        } else {
            $data = ['code' => 422, 'errors' => $validator->errors()];
        }

        return response($data);
    }

    public function delete($id)
    {
        $record = Model::find($id);

        if ($record) {
            $record->delete();
            $code = 200;
        } else {
            $code = 404;
        }

        return response(['code' => $code]);
    }
}

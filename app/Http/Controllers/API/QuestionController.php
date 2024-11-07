<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Question as Model;

class QuestionController extends Controller
{

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
            'question' => 'required',
            'answer' => 'required',
            'status' => 'required',
        ]);

        Model::create($validated);
        $data = ['code' => 200];

        return response($data);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'question' => 'required',
            'answer' => 'required',
            'status' => 'required',
        ]);

        $record = Model::find($id);
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

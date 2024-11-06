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
            'question' => 'required',
            'answer' => 'required',
            'status' => 'required',
        ]);
        Model::create($request->all());
        return response(['code' => 200]);
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'question' => 'required',
            'answer' => 'required',
            'status' => 'required',
        ]);

        $record = Model::find($id);
        $record->update($request->all());

        return response(['code' => 200]);
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

<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\Uploadable;
use App\Models\Article as Model;

class ArticleController extends Controller
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
        $validated = $request->validate([
            'headline' => 'required',
            'content' => 'required',
            'date' => 'required',
            'image' => 'required|file',
        ]);

        $keys = [
            'headline',
            'content',
            'date',
            'image',
        ];

        foreach ($keys as $key) {
            if ($key == 'image') {
                $new[$key] = $this->upload($validated[$key], 'uploads/articles');
            }
            else {
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

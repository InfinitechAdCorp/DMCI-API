<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\Uploadable;
use Validator;
use App\Models\Property as Model;

class PropertyController extends Controller
{
    use Uploadable;

    public function getAll()
    {
        $records = Model::with("category")->get();
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
        $validator = Validator::make($request->all(), [
            'category_id' => 'required',
            'name' => 'required',
            'logo' => 'required|file',
            'description' => 'required',
            'slogan' => 'required',
            'location'  => 'required',
            'min_price'  => 'required',
            'max_price'  => 'required',
            'status'  => 'required',
            'percent' => 'required',
        ]);

        if ($validator->passes()) {
            $validated = $validator->validated();

            $keys = [
                'category_id',
                'name',
                'logo',
                'description',
                'slogan',
                'location',
                'min_price',
                'max_price',
                'status',
                'percent',
            ];
    
            foreach ($keys as $key) {
                if ($key == 'logo') {
                    $new[$key] = $this->upload($validated[$key], 'uploads/properties/logos');
                }
                else {
                    $new[$key] = $validated[$key];
                }
            }

            Model::create($new);
            $data = ['code' => 200];
        } else {
            $data = ['code' => 422, 'errors' => $validator->errors()];
        }

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

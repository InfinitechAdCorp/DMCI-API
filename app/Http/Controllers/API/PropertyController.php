<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Traits\Uploadable;
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
        $record = Model::findOrFail($id);
        $data = ['code' => 200, 'record' => $record];
        return response($data);
    }

    public function add(Request $request)
    {
        $validated = $request->validate( [
            'category_id' => 'required|exists:categories,id',
            'name' => 'required',
            'logo' => 'required|image|max:2048',
            'description' => 'required',
            'slogan' => 'required',
            'location'  => 'required',
            'min_price'  => 'required|decimal:0,2',
            'max_price'  => 'required|decimal:0,2',
            'status'  => 'required',
            'percent' => 'required|numeric',
        ]);

        $key = 'logo';
        $validated[$key] = $this->upload($validated[$key], 'uploads/properties/logos');

        Model::create($validated);
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

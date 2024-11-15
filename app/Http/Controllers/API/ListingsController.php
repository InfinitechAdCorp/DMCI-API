<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Listings as Model;
use App\Traits\Uploadable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ListingsController extends Controller
{
    use Uploadable;

    public function getAll()
    {
        if (Auth::check()) {
            $users = Auth::id();
            $records = Model::where("user_id", $users)->get();
            $data = ['code' => 200, 'records' => $records];
            return response($data);
        }
        else{
            return response()->json([
                'message' => 'User not authenticated.'
            ], 401);    
        }
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
            'user_id' => 'required',
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:15',
            'unit_name' => 'required|string|max:255',
            'unit_type' => 'required|string|max:255',
            'unit_location' => 'required|string|max:255',
            'unit_price' => 'required|numeric|between:0,9999999.99',
            'status' => 'required|string',
            'images[]' => 'nullable'
        ]);


        $record = new Model();

        if ($request->hasFile('images')) {
            $mediaFiles = [];
            foreach ($request->file('images') as $file) {
                $filename = time() . '_' . $file->getClientOriginalName(); // Avoid filename conflicts
                $file->move(public_path('/upload/properties'), $filename);
                $mediaFiles[] = $filename;
            }
            $record->images = json_encode($mediaFiles);
        }

        $record->fill($validated);
        $record->save();



        return response()->json([
            'code' => 200,
            'message' => 'Property added successfully'
        ]);
    }



    public function delete($id)
    {
        $record = Model::findOrFail($id);
        $record->delete();
        return response(['code' => 200, 'msg' => 'Property deleted successfully']);
    }
}

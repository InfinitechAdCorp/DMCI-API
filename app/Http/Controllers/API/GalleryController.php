<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Traits\Uploadable;

class GalleryController extends Controller
{
    use Uploadable;

    public function getAll()
    {
        $records = Gallery::all();
        return response(['code' => 200, 'records' => $records]);
    }

    public function get($id)
    {
        $record = Gallery::find($id);
        if ($record) {
            return response(['code' => 200, 'record' => $record]);
        }

        return response(['code' => 404, 'message' => 'Gallery item not found'], 404);
    }

    public function add(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $key = 'image';
        if ($request->hasFile($key)) {
            $validated[$key] = $this->upload($request->file($key), 'galleries');
        }

        $record = Gallery::create([
            'name' => $validated['name'],
            'image' => $validated['image'],
        ]);

        return response()->json([
            'message' => 'Gallery item created successfully.',
            'record' => $record,
        ], 201);
    }

    public function delete($id)
    {
        $record = Gallery::find($id);

        if (!$record) {
            return response(['code' => 404, 'message' => 'Gallery item not found'], 404);
        }

        if (Storage::disk('public')->exists($record->image)) {
            Storage::disk('public')->delete($record->image);
        }

        $record->delete();
        return response(['code' => 200, 'message' => 'Gallery item deleted successfully']);
    }
}

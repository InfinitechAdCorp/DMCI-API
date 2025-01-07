<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Traits\Uploadable;
use App\Models\Certificate as Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CertificateController extends Controller
{
    use Uploadable;

    public function getAll()
    {
        $certificates = Model::all();
        $data = ['code' => 200, 'records' => $certificates];
        return response($data);
    }

    public function get($id)
    {
        $certificate = Model::find($id);
        if ($certificate) {
            $data = ['code' => 200, 'record' => $certificate];
        } else {
            $data = ['code' => 404, 'message' => 'Certificate Not Found'];
        }
        return response($data);
    }

    public function add(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'image' => 'required',
            'date' => 'required|date',  // Added date validation
        ]);

        $key = 'image';
        if ($request->hasFile($key)) {
            $validated[$key] = $this->upload($request->file($key), "certificates");
        }

        $record = Model::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'image' => $validated['image'],
            'date' => $validated['date'],  
        ]);

        $code = 201;
        $response = ['message' => "Created certificate", 'record' => $record];

        return response()->json($response, $code);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|exists:certificates,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'date' => 'required|date',
        ]);

        $certificate = Model::find($validated['id']);

        if ($request->hasFile('image')) {
            $this->deleteUploadedFile($certificate->image);
            $validated['image'] = $this->upload($request->file('image'), 'certificates');
        }

        $certificate->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'image' => $validated['image'] ?? $certificate->image,
            'date' => $validated['date'],  
        ]);

        $data = ['code' => 200, 'message' => 'Certificate Updated'];

        return response()->json($data, 200);
    }

    public function delete($id)
    {
        $certificate = Model::find($id);
        if ($certificate) {
            $this->deleteUploadedFile($certificate->image);
            $certificate->delete();

            $data = ['code' => 200, 'message' => 'Certificate Deleted'];
        } else {
            $data = ['code' => 404, 'message' => 'Certificate Not Found'];
        }

        return response($data);
    }
}

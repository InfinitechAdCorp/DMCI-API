<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Traits\Uploadable;

use App\Models\Application as Model;
use App\Models\Career as Parent;

class ApplicationController extends Controller
{
    use Uploadable;

    public $model = "Application";

    public function getAll()
    {
        $records = Model::with('career')->orderBy('updated_at', 'desc')->get();
        $code = 200;
        $response = ['message' => "Fetched $this->model" . "s", 'records' => $records];
        return response()->json($response, $code);
    }

    public function get($id)
    {
        $record = Model::with('career')->where('id', $id)->first();
        if ($record) {
            $code = 200;
            $response = ['message' => "Fetched $this->model", 'record' => $record];
        } else {
            $code = 404;
            $response = ['message' => "$this->model Not Found"];
        }
        return response()->json($response, $code);
    }

    public function create(Request $request)
    {
        $validated = $request->validate([
            'career_id' => 'required|exists:careers,id',
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'address' => 'required',
            'resume' => 'required',
        ]);

        $parent = Parent::with('applications')->where('id', $validated['career_id'])->first();
        $availableSlots = $parent->slots - count($parent['applications']);

        if ($availableSlots <= 0) {
            $code = 204;
            $response = ['message' => "Out Of Slots"];
        } else {
            $key = 'resume';
            if ($request->hasFile($key)) {
                $validated[$key] = $this->upload($request->file($key), "careers/applications");
            }
            
            $record = Model::create($validated);
            $code = 201;
            $response = ['message' => "Created $this->model", 'record' => $record];
        }

        return response()->json($response, $code);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|exists:applications,id',
            'career_id' => 'required|exists:careers,id',
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'address' => 'required',
            'resume' => 'required',
        ]);

        $parent = Parent::with('applications')->where('id', $validated['career_id'])->first();
        $availableSlots = $parent->slots - count($parent['applications']);

        if ($availableSlots <= 0) {
            $code = 204;
            $response = ['message' => "Out Of Slots"];
        } else {
            $record = Model::find($validated['id']);

            $key = 'resume';
            if ($request->hasFile($key)) {
                Storage::disk('s3')->delete("careers/applications/$record[$key]");
                $validated[$key] = $this->upload($request->file($key), "careers/applications");
            }

            $record->update($validated);
            $code = 200;
            $response = ['message' => "Updated $this->model", 'record' => $record];
        }

        return response()->json($response, $code);
    }

    public function delete($id)
    {
        $record = Model::find($id);
        if ($record) {
            Storage::disk('s3')->delete("careers/applications/$record->resume");
            $record->delete();
            $code = 200;
            $response = ['message' => "Deleted $this->model"];
        } else {
            $code = 404;
            $response = ['message' => "$this->model Not Found"];
        }
        return response($response, $code);
    }
}

<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Mail\ContactMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function contact(Request $request)
    {
        $validated = $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email',
            'number' => 'required',
            'property_name' => 'required',
            'unit_type' => 'required',
            'property_location' => 'required',
            'message' => 'nullable', // Optional
        ]);

        if ($validated) {
            // Send the email
            Mail::to('giolo.evora@gmail.com')->send(new ContactMail($validated));

            $data = ['code' => 200, 'message' => 'Email sent successfully!'];
            return response()->json($data);
        } else {
            $data = ['msg' => "Validation failed."];
            return response()->json($data, 422);
        }
    }
}

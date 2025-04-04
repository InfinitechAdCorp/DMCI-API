<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

use App\Models\Property;
use App\Models\Appointment;
use App\Models\Inquiry;
use App\Models\Application;


class DashboardController extends Controller
{
    public function getCounts(Request $request)
    {
        $user =  PersonalAccessToken::findToken($request->bearerToken())->tokenable;

        $properties = Property::get()->count();
        $inquiries = Inquiry::get()->count();
        $viewings = Appointment::get()->count();
        $applications = Application::get()->count();

        $records = [
            'properties' => $properties,
            'inquiries' => $inquiries,
            'viewings' => $viewings,
            'applications' => $applications,
        ];
        $code = 200;
        $response = ['message' => "Fetched Counts", 'records' => $records];
        return response()->json($response, $code);
    }
}

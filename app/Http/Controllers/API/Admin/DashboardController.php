<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

use App\Models\Property;
use App\Models\Listing;
use App\Models\Appointment;
use App\Models\Inquiry;
use App\Models\Application;
use App\Models\Plan;
use App\Models\Question;
use App\Models\Article;
use App\Models\Testimonial;
use App\Models\Video;
use App\Models\Contract;
use App\Models\Career;

class DashboardController extends Controller
{
    public function getCounts($request)
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

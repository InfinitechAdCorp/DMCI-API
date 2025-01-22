<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Property;
use App\Models\Listing;
use App\Models\Appointment;
use App\Models\Inquiry;
use App\Models\Application;
use App\Models\Plan;
use App\Models\Question;
use App\Models\Article;
use App\Models\Testimonial;

class DashboardController extends Controller
{
    public function getCounts()
    {
        $properties = Property::get()->count();
        $rfoProperties = Property::where('status', 'Ready For Occupancy')->get()->count();
        $underConstructionProperties = Property::where('status', 'Under Construction')->get()->count();
        $newProperties = Property::where('status', 'New')->get()->count();
        $listings = Listing::get()->count();
        $inquiries = Inquiry::get()->count();
        $viewings = Appointment::get()->count();
        $applications = Application::get()->count();
        $plans = Plan::get()->count();
        $questions = Question::get()->count();
        $articles = Article::get()->count();
        $testimonials = Testimonial::get()->count();

        $records = [
            'properties' => $properties,
            'rfoProperties' => $rfoProperties,
            'underConstructionProperties' => $underConstructionProperties,
            'newProperties' => $newProperties,
            'listings' => $listings,
            'inquiries' => $inquiries,
            'viewings' => $viewings,
            'applications' => $applications,
            'plans' => $plans,
            'questions' => $questions,
            'articles' => $articles,
            'testimonials' => $testimonials,
        ];
        $code = 200;
        $response = ['message' => "Fetched Counts", 'records' => $records];
        return response()->json($response, $code);
    }
}

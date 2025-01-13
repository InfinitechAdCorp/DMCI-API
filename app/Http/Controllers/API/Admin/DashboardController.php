<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Property;
use App\Models\Listing;
use App\Models\Inquiry;
use App\Models\Appointment;


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
        $propertyInquiries = 0;

        $records = [
            'properties' => $properties,
            'rfoProperties' => $rfoProperties,
            'underConstructionProperties' => $underConstructionProperties,
            'newProperties' => $newProperties,
            'listings' => $listings,
            'inquiries' => $inquiries,
            'viewings' => $viewings,
            'propertyInquiries' => $propertyInquiries,
        ];
        $code = 200;
        $response = ['message' => "Fetched Counts", 'records' => $records];
        return response()->json($response, $code);
    }
}

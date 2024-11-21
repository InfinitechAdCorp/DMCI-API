<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Listings;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function countProperties()
    {
        if (Auth::check()) {
            $user = Auth::user();

            if ($user->user_type === 'Admin') {
                $record = Property::count();
                $recordConstruction = Property::where('status', "Under Construction")->count();
                $recordRFO = Property::where('status', "Ready For Occupancy")->count();
                $recordNew = Property::where('status', "New")->count();

                $record_listings = Listings::count();
                $record_appointments = Appointment::count();
                $record_viewing = Appointment::where('type', "Property Viewing")->count();
                $record_inquiry = Appointment::where('type', "Property Inquiry")->count();
            } 

            elseif($user->user_type === 'Agent'){
                $userId = Auth::id();
                $record = Property::where('user_id', $userId)->count();
                $recordConstruction = Property::where('user_id', $userId)->where('status', "Under Construction")->count();
                $recordRFO = Property::where('user_id', $userId)->where('status', "Ready For Occupancy")->count();
                $recordNew = Property::where('user_id', $userId)->where('status', "New")->count();

                $record_listings = Listings::where('user_id', $userId)->count();
                $record_appointments = Appointment::where('user_id', $userId)->count();
                $record_viewing = Appointment::where('user_id', $userId)->where('type', "Property Viewing")->count();
                $record_inquiry = Appointment::where('user_id', $userId)->where('type', "Property Inquiry")->count();
            }
            else {
                return response(['message', 'You Dont have permission to access this site!']);
            }

            $records = [
                'properties' => $record,
                'available' => $recordRFO,
                'construction' => $recordConstruction,
                'new' => $recordNew,
                'listings' => $record_listings,
                'inquiries' => $record_appointments,
                'viewing_count' => $record_viewing,
                'inquiry_count' => $record_inquiry,
            ];

            return response(['code' => 200, 'record' => $records]);
        }

        return response(['code' => 401, 'message' => 'Unauthorized'], 401);
    }
}

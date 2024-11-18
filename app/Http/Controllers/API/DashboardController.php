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
    public function countProperties(){
        $user = Auth::id();
        $record = Property::where('user_id', $user)->count();
        $recordConstruction = Property::where('user_id', $user)->where('status',"Under Construction")->count();
        $recordRFO = Property::where('user_id', $user)->where('status',"Ready For Occupancy")->count();
        $recordNew = Property::where('user_id', $user)->where('status',"New")->count();

        $record_listings = Listings::where('user_id', $user)->count();
        $record_appointments = Appointment::where('user_id', $user)->count();   
        $record_viewing = Appointment::where('user_id', $user)->where('type', "Property Viewing")->count();
        $record_inquiry = Appointment::where('user_id', $user)->where('type', "Property Inquiry")->count();
    
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
    
    
}

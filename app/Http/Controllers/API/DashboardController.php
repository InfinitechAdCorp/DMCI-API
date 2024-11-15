<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
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
    
        $records = [
            'properties' => $record,
            'available' => $recordRFO,
            'construction' => $recordConstruction,
            'new' => $recordNew,
        ];
        return response(['code' => 200, 'record' => $records]);
    }
    
    
}

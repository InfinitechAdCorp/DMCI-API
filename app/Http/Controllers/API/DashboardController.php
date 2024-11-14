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
        $recordAvailable = Listings::where('status', 'Available')->count();
    
        $records = [
            'properties' => $record,
            'available' => $recordAvailable,
            'construction' => $recordConstruction,
        ];
        return response(['code' => 200, 'record' => $records]);
    }
    
    
}

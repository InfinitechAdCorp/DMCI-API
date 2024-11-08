<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Listings;
use App\Models\Property;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function countProperties(){
        $record = Property::count();
        $recordAvailable = Listings::where('status', 'Available')->count();
    
        $records = [
            'properties' => $record,
            'available' => $recordAvailable,
        ];
        return response(['code' => 200, 'record' => $records]);
    }
    
    
}

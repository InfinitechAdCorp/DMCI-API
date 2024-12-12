<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\Request;

class PropertyFinder extends Controller
{
    public function getPropertyFinder(Request $request, $id)
    {

        $location = $request->query('location');
        $min_price = $request->query('minPrice');
        $max_price = $request->query('maxPrice');
        $unit_type = $request->query('unitType');

        $query = Property::where('user_id', $id);

        if (!empty($location) && !empty($min_price) && !empty($max_price) && !empty($unit_type)) {
            $query->where('location', 'LIKE', '%' . $location . '%')
                ->where('min_price', '>=', $min_price)
                ->where('max_price', '<=', $max_price)
                ->whereHas('units', function($query) use ($unit_type) {
                    $query->where('type', $unit_type);
                });
        }
        // Fetch records
        $records = $query->get();

        // Return the response
        return response()->json([
            'status' => 'success',
            'record' => $records,
        ], 200);
    }
}

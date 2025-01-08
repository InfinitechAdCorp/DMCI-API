<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Property;

class UserSideController extends Controller
{
    public function propertiesGetAll(Request $request)
    {
        if ($user_id = $request->bearerToken()) {
            $relations = ['user', 'plan', 'buildings', 'facilities', 'features', 'units'];
            $records = Property::with($relations)->where('user_id', $user_id)->get();
            $code = 200;
            $response = ['message' => "Fetched Properties", 'records' => $records];
        } else {
            $code = 401;
            $response = ['message' => "User Not Authenticated"];
        }
        return response()->json($response, $code);
    }

    public function propertiesGet(Request $request)
    {
        if ($user_id = $request->bearerToken()) {
            $relations = ['user', 'plan', 'buildings', 'facilities', 'features', 'units'];
            $where = [['id', $request->id], ['user_id', $user_id]];

            $record = Property::with($relations)->where($where)->first();
            if ($record) {
                $code = 200;
                $response = ['message' => "Fetched Property", 'record' => $record];
            } else {
                $code = 404;
                $response = ['message' => "Property Not Found"];
            }
        } else {
            $code = 401;
            $response = ['message' => "User Not Authenticated"];
        }
        return response()->json($response, $code);
    }
}

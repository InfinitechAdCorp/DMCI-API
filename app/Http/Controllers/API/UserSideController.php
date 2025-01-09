<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\Uploadable;

use App\Models\User;
use App\Models\Property;
use App\Models\Article;
use App\Models\Career;
use App\Models\Listing;

class UserSideController extends Controller
{
    use Uploadable;

    public function getUser(Request $request)
    {
        $user_id = $request->header('user_id');
        if (User::find($user_id)) {
            $relations = ['profile', 'certificates', 'images', 'testimonials', 'properties', 'appointments', 'listings'];
            $record = User::with($relations)->where('id', $user_id)->first();
            $code = 200;
            $response = ['message' => "Fetched User", 'record' => $record];
        } else {
            $code = 401;
            $response = ['message' => "User Not Authenticated"];
        }
        return response()->json($response, $code);
    }

    public function propertiesGetAll(Request $request)
    {
        $user_id = $request->header('user_id');
        if (User::find($user_id)) {
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
        $user_id = $request->header('user_id');
        if (User::find($user_id)) {
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

    public function articlesGetAll(Request $request)
    {
        $user_id = $request->header('user_id');
        if (User::find($user_id)) {
            $records = Article::all();
            $code = 200;
            $response = ['message' => "Fetched Articles", 'records' => $records];
        } else {
            $code = 401;
            $response = ['message' => "User Not Authenticated"];
        }
        return response()->json($response, $code);
    }

    public function articlesGet(Request $request)
    {
        $user_id = $request->header('user_id');
        if (User::find($user_id)) {
            $record = Article::find($request->id);
            if ($record) {
                $code = 200;
                $response = ['message' => "Fetched Article", 'record' => $record];
            } else {
                $code = 404;
                $response = ['message' => "Article Not Found"];
            }
        } else {
            $code = 401;
            $response = ['message' => "User Not Authenticated"];
        }
        return response()->json($response, $code);
    }

    public function careersGetAll(Request $request)
    {
        $user_id = $request->header('user_id');
        if (User::find($user_id)) {
            $records = Career::with('applications')->get();
            $code = 200;
            $response = ['message' => "Fetched Careers", 'records' => $records];
        } else {
            $code = 401;
            $response = ['message' => "User Not Authenticated"];
        }
        return response()->json($response, $code);
    }

    public function careersGet(Request $request)
    {
        $user_id = $request->header('user_id');
        if (User::find($user_id)) {
            $record = Career::with('applications')->where('id', $request->id)->first();
            if ($record) {
                $code = 200;
                $response = ['message' => "Fetched Career", 'record' => $record];
            } else {
                $code = 404;
                $response = ['message' => "Career Not Found"];
            }
        } else {
            $code = 401;
            $response = ['message' => "User Not Authenticated"];
        }
        return response()->json($response, $code);
    }

    public function submitProperty(Request $request)
    {
        $user_id = $request->header('user_id');
        if (User::find($user_id)) {
            $validated = $request->validate([
                'user_id' => 'required|exists:users,id',
                'name' => 'required',
                'email' => 'required|email',
                'phone' => 'required',
                'unit_name' => 'required',
                'unit_type' => 'required',
                'unit_location' => 'required',
                'unit_price' => 'required|decimal:0,2',
                'status' => 'required',
                'images' => 'required',
            ]);

            $key = 'images';
            if ($request[$key]) {
                $images = [];
                foreach ($request[$key] as $image) {
                    array_push($images, $this->upload($image, "listings"));
                }
                $validated[$key] = json_encode($images);
            }

            $record = Listing::create($validated);
            $code = 201;
            $response = [
                'message' => "Submitted Property Details",
                'record' => $record,
            ];
        } else {
            $code = 401;
            $response = ['message' => "User Not Authenticated"];
        }
        return response()->json($response, $code);
    }
}

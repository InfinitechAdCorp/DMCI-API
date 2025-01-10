<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\Uploadable;
use Sentiment\Analyzer;

use App\Models\User;
use App\Models\Property;
use App\Models\Listing;
use App\Models\Article;
use App\Models\Career;
use App\Models\Appointment;
use App\Models\Application;
use App\Models\Subscriber;
use App\Models\Inquiry;
use App\Models\Testimonial;

class UserSideController extends Controller
{
    use Uploadable;

    public function getUser(Request $request)
    {
        $user_id = $request->header('user-id');
        $relations = ['profile', 'certificates', 'images', 'testimonials', 'properties', 'appointments', 'listings'];
        $record = User::with($relations)->where('id', $user_id)->first();
        $code = 200;
        $response = ['message' => "Fetched User", 'record' => $record];
        return response()->json($response, $code);
    }

    public function propertiesGetAll(Request $request)
    {
        $user_id = $request->header('user-id');
        $relations = ['user', 'plan', 'buildings', 'facilities', 'features', 'units'];
        $records = Property::with($relations)->where('user_id', $user_id)->get();
        $code = 200;
        $response = ['message' => "Fetched Properties", 'records' => $records];
        return response()->json($response, $code);
    }

    public function propertiesGet(Request $request)
    {
        $user_id = $request->header('user-id');
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
        return response()->json($response, $code);
    }

    public function listingsGetAll(Request $request)
    {
        $user_id = $request->header('user-id');
        $where = [['user_id', $user_id], ['status', '!=', 'Pending']];
        $records = Listing::with('user')->where($where)->get();
        $code = 200;
        $response = ['message' => "Fetched Listings", 'records' => $records];
        return response()->json($response, $code);
    }

    public function listingsGet(Request $request)
    {
        $user_id = $request->header('user-id');
        $where = [['id', $request->id], ['user_id', $user_id], ['status', '!=', 'Pending']];
        $record = Listing::with('user')->where($where)->first();
        if ($record) {
            $code = 200;
            $response = ['message' => "Fetched Listing", 'record' => $record];
        } else {
            $code = 404;
            $response = ['message' => "Listing Not Found"];
        }
        return response()->json($response, $code);
    }

    public function articlesGetAll()
    {
        $records = Article::all();
        $code = 200;
        $response = ['message' => "Fetched Articles", 'records' => $records];
        return response()->json($response, $code);
    }

    public function articlesGet(Request $request)
    {
        $record = Article::find($request->id);
        if ($record) {
            $code = 200;
            $response = ['message' => "Fetched Article", 'record' => $record];
        } else {
            $code = 404;
            $response = ['message' => "Article Not Found"];
        }
        return response()->json($response, $code);
    }

    public function careersGetAll()
    {
        $records = Career::with('applications')->get();
        $code = 200;
        $response = ['message' => "Fetched Careers", 'records' => $records];
        return response()->json($response, $code);
    }

    public function careersGet(Request $request)
    {
        $record = Career::with('applications')->where('id', $request->id)->first();
        if ($record) {
            $code = 200;
            $response = ['message' => "Fetched Career", 'record' => $record];
        } else {
            $code = 404;
            $response = ['message' => "Career Not Found"];
        }
        return response()->json($response, $code);
    }

    public function testimonialsGetAll(Request $request)
    {
        $user_id = $request->header('user-id');
        $records = [];
        $analyzer = new Analyzer();

        $where = [['user_id', $user_id]];
        $testimonials = Testimonial::with('user')->where($where)->get();
        foreach ($testimonials as $testimonial) {
            $sentiment = $analyzer->getSentiment($testimonial->message);
            if ($sentiment['compound'] > 0.5) {
                array_push($records, $testimonial);
            }
        }

        $code = 200;
        $response = ['message' => "Fetched Testimonials", 'records' => $records];
        return response()->json($response, $code);
    }

    public function testimonialsGet(Request $request)
    {
        $user_id = $request->header('user-id');
        $where = [['id', $request->id], ['user_id', $user_id]];
        $record = Testimonial::with('user')->where($where)->first();
        if ($record) {
            $code = 200;
            $response = ['message' => "Fetched Testimonial", 'record' => $record];
        } else {
            $code = 404;
            $response = ['message' => "Testimonial Not Found"];
        }
        return response()->json($response, $code);
    }

    public function filterProperties(Request $request) {
        $user_id = $request->header('user-id');

        $where = [['user_id', $user_id]];

        $location = $request->query('location');
        if ($location) {
            array_push($where, ['location', 'LIKE', "%$location%"]);
        }

        $min_price = $request->query('min_price');
        if ($min_price) {
            array_push($where, ['min_price', '>=', $min_price]);
        }

        $max_price = $request->query('max_price');
        if ($max_price) {
            array_push($where, ['max_price', '<=', $max_price]);
        }

        $relations = ['user', 'plan', 'buildings', 'facilities', 'features', 'units'];
        $records = Property::with($relations)->where($where);

        $unit_type = $request->query('unit_type');
        if ($unit_type) {
            $records->whereHas('units', function($result) use ($unit_type) {
                 $result->where('type', $unit_type);
            });
        }

        $records = $records->get();
        $code = 200;
        $response = ['message' => "Filtered Properties", 'records' => $records];
        return response()->json($response, $code);
    }

    public function submitProperty(Request $request)
    {
        $user_id = $request->header('user-id');

        $validated = $request->validate([
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

        $validated['user_id'] = $user_id;

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
        return response()->json($response, $code);
    }

    public function requestViewing(Request $request)
    {
        $user_id = $request->header('user-id');

        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'date' => 'required|date',
            'time' => 'required',
            'type' => 'required',
            'properties' => 'required',
            'message' => 'required',
            'status' => 'required',
        ]);

        $validated['user_id'] = $user_id;

        $record = Appointment::create($validated);
        $code = 201;
        $response = [
            'message' => "Submitted Viewing Request",
            'record' => $record,
        ];
        return response()->json($response, $code);
    }

    public function submitApplication(Request $request)
    {
        $validated = $request->validate([
            'career_id' => 'required|exists:careers,id',
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'address' => 'required',
            'resume' => 'required',
        ]);

        $key = 'resume';
        if ($request->hasFile($key)) {
            $validated[$key] = $this->upload($request->file($key), "careers/applications");
        }

        $record = Application::create($validated);
        $code = 201;
        $response = ['message' => "Submitted Application", 'record' => $record];
        return response()->json($response, $code);
    }

    public function subscribe(Request $request)
    {
        $user_id = $request->header('user-id');
        
        $validated = $request->validate([
            'email' => 'required|email',
        ]);

        $validated['user_id'] = $user_id;

        $record = Subscriber::create($validated);
        $code = 201;
        $response = [
            'message' => "Subscribed To Newsletter",
            'record' => $record,
        ];
        return response()->json($response, $code);
    }

    public function submitInquiry(Request $request)
    {
        $user_id = $request->header('user-id');

        $validated = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'property_name' => 'required',
            'property_location' => 'required',
            'unit_type' => 'required',
            'message' => 'required',
        ]);

        $validated['user_id'] = $user_id;

        $record = Inquiry::create($validated);
        $code = 201;
        $response = [
            'message' => "Submitted Inquiry",
            'record' => $record,
        ];
        return response()->json($response, $code);
    }

    public function submitTestimonial(Request $request)
    {
        $user_id = $request->header('user-id');

        $validated = $request->validate([
            'name' => 'required',
            'message' => 'required',
        ]);

        $validated['user_id'] = $user_id;

        $record = Testimonial::create($validated);
        $code = 201;
        $response = [
            'message' => "Submitted Testimonial",
            'record' => $record,
        ];
        return response()->json($response, $code);
    }
}

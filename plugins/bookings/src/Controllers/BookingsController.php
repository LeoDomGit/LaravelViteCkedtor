<?php

namespace Leo\Bookings\Controllers;

use Carbon\Carbon;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Leo\Bookings\Models\Bookings;
use Leo\Customers\Models\Customers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Events\PushBooking;

class BookingController extends Controller
{
    // List all bookings
    public function index()
    {
        $bookings = Bookings::with(['user', 'customer', 'service'])->get();
        return Inertia::render('Bookings/Index', ['bookings' => $bookings]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'time' => 'required|date_format:Y-m-d H:i:s',
            'id_service' => 'required|exists:services,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['check' => false, 'msg' => $validator->errors()->first()]);
        }
        $customer = Customers::where('email', $request->email)->first();
        if ($customer) {
            $id_customer = $customer->id;
        } else {
            $data['name'] = $request->name;
            $data['email'] = $request->email;
            $data['password'] = Hash::make($request->password);
            $id_customer = Customers::insertGetId($data);
        }

        $booking = Bookings::create([
            'id_user' => $request->user()->id ?? null,
            'id_customer' => $id_customer,
            'id_service' => $request->id_service,
            'time' => $request->time,
            'end_time' => Carbon::parse($request->time)->addHour(),
        ]);
        $bookings=Bookings::with(['user', 'customer', 'service'])->where('status',0)->orderBy('id','desc')->get();
        broadcast(new PushBooking($bookings));
        return response()->json(['check'=>true],200);
    }

    public function show($id)
    {
        $booking = Bookings::with(['user', 'customer', 'service'])->findOrFail($id);
        return response()->json($booking);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'time' => 'sometimes|required|date_format:Y-m-d H:i:s',
            'id_service' => 'sometimes|required|exists:services,id',
        ]);
        $booking = Bookings::findOrFail($id);
        if ($request->has('time')) {
            $booking->time = $request->time;
            $booking->end_time = Carbon::parse($request->time)->addHour();
        }
        if ($request->has('id_service')) {
            $booking->id_service = $request->id_service;
        }
        if($request->has('status')){
            $data['status']=$request->status;
            $data['id_user']=$request->id_user;
            $data['updated_at']=now();
            Bookings::where('id',$id)->update($data);

        }else{
            $booking->save();
        }
        $bookings=Bookings::with(['customer','user','service'])->where('status',0)
        ->get();
        $this->bookings = $bookings->map(function ($booking) {
            return [
                'id' => $booking->id,
                'phone' => $booking->customer->phone,
                'customer_name' => $booking->customer->name,
                'customer_email' => $booking->customer->email,
                'service_id' => $booking->id_service,
                'service_name'=>$booking->service->name,
                'service_slug'=>$booking->service->slug,
                'service_discount'=>$booking->service->price,
                'service_price'=>$booking->service->compare_price,
                'time' => $booking->time,
                'end_time' => $booking->end_time,
                'status' => $booking->status,
            ];
        });
        return response()->json(['check'=>true,'bookings'=>$bookings]);
    }


    public function destroy($id)
    {
        $booking = Bookings::findOrFail($id);
        $booking->delete();

        return response()->json(null, 204);
    }

    public function api_home(Request $request){
        $bookings = Bookings::with(['customer', 'user', 'service'])->where('status', 0)->get();

    $bookings = $bookings->map(function ($booking) {
        return [
            'id' => $booking->id,
            'id_user' => $booking->id_user,
            'phone' => $booking->customer->phone,
            'customer_name' => $booking->customer->name,
            'customer_email' => $booking->customer->email,
            'service_id' => $booking->id_service,
            'service_name' => $booking->service->name,
            'service_slug' => $booking->service->slug,
            'service_discount' => $booking->service->price,
            'service_price' => $booking->service->compare_price,
            'time' => $booking->time,
            'end_time' => $booking->end_time,
            'status' => $booking->status,
        ];
    });
        return response()->json($bookings);
    }
}

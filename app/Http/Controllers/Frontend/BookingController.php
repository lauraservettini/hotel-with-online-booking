<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Room;
use App\Models\RoomBookedDate;
use App\Models\Booking;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class BookingController extends Controller
{
    public function checkout()
    {
        if (Session::has('book_date')) {
            $bookingData = Session::get('book_date');
            $room = Room::find($bookingData['room_id']);

            $startDate = Carbon::parse($bookingData['check_in']);
            $endDate = Carbon::parse($bookingData['check_out']);

            $nights = $startDate->diffInDays($endDate);

            return view('frontend.booking.checkout', compact('room', 'nights', 'bookingData'));
        } else {
            $notification = array(
                'message' => "Nothing to checkout!",
                'alert-type' => 'error'
            );

            return view('/')->with($notification);
        }
    }

    public function storeUserBooking(Request $request)
    {
        //Validation
        $request->validate([
            "check_in" => "required",
            "check_out" => "required",
            "person" => "required",
            "numberOfRooms" => "required"
        ]);

        // Verifica se numberOfRooms <= available_room
        if ($request->numberOfRooms > $request->available_room) {
            $notification = array(
                'message' => "There's only {{ $request->available_room}} room left!",
                'alert-type' => 'error'
            );

            return redirect()->back()->with($notification);
        }

        // Verifica se Person <= room_capacity
        if ($request->person > ($request->room_capacity * $request->numberOfRooms)) {
            $notification = array(
                'message' => "Max {{ ($request->room_capacity * $request->numberOfRooms) }} persons for the selected rooms!",
                'alert-type' => 'error'
            );

            return redirect()->back()->with($notification);
        }

        Session::forget('book_date');

        $data = array();
        $data['numberOfRooms'] = $request->numberOfRooms;
        $data['available_room'] = $request->available_room;
        $data['person'] = $request->person;
        $data['check_in'] = date('Y-m-d', strtotime($request->check_in));
        $data['check_out'] = date('Y-m-d', strtotime($request->check_out));
        $data['room_id'] = $request->room_id;

        Session::put('book_date', $data);

        return redirect()->route('checkout');
    }
}

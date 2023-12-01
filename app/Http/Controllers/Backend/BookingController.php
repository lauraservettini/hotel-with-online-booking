<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Models\Room;
use App\Models\RoomBookedDate;
use App\Models\Booking;
use App\Models\RoomBookingList;
use App\Models\RoomNumber;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class BookingController extends Controller
{
    public function bookingList()
    {
        $allBookings = Booking::orderby('id', 'desc')->get();

        return view('backend.booking.booking_list', compact('allBookings'));
    }

    public function editBooking(int $id)
    {
        $booking = Booking::with('room')->find($id);
        return view('backend.booking.edit_booking', compact('booking'));
    }

    public function updateBookingStatus(Request $request, int $id)
    {
        $booking = Booking::find($id);
        $booking->status = $request->status;
        $booking->payment_status = $request->payment_status;
        $booking->save();

        $notification = array(
            'message' => "Status and Payment Status Updated Successfully!",
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function updateBookingDate(Request $request, int $id)
    {
        if ($request->number_of_rooms > $request->available_room) {
            $notification = array(
                'message' => "Rooms Selected Are More Then Rooms Available!",
                'alert-type' => 'error'
            );

            return redirect()->back()->with($notification);
        }

        $booking = Booking::find($id);

        $booking->number_of_rooms = $request->number_of_rooms;
        $booking->check_in = date('Y-m-d', strtotime($request->check_in));
        $booking->check_out = date('Y-m-d', strtotime($request->check_out));

        // Calcola il periodo
        $startDate = Carbon::parse($booking->check_in);
        $endDate = Carbon::parse($booking->check_out);
        $nights = $endDate->diffInDays($startDate);

        $booking->total_night = $nights;

        $booking->save();

        // cancella i vecchi dati da RoomBookedDate table
        $oldBookDates = RoomBookedDate::where('booking_id', $id)->delete();

        // salva i dati nella RoomBookedDate
        $lastDate = Carbon::create($endDate)->subDay();
        $dayPeriod = CarbonPeriod::create($startDate, $lastDate);

        foreach ($dayPeriod as $period) {
            $bookedDates = new RoomBookedDate();
            $bookedDates->booking_id = $id;
            $bookedDates->room_id = $booking->room_id;
            $bookedDates->book_date = date('Y-m-d', strtotime($period));
            $bookedDates->save();
        }

        Session::forget('book_date');

        $notification = array(
            'message' => "Booking Updated Successfully!",
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }
}

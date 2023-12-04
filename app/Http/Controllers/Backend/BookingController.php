<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\RoomBookedDate;
use App\Models\Booking;
use App\Models\RoomBookingList;
use App\Models\RoomNumber;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Barryvdh\DomPDF\Facade\Pdf;

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

        // cancella i vecchi dati da RoomBookingList table
        RoomBookingList::where('booking_id', $id)->delete();
        // cancella i vecchi dati da RoomBookedDate table
        RoomBookedDate::where('booking_id', $id)->delete();

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

    public function assignRoom(int $bookingId)
    {
        // cerca i dati di booking
        $booking = Booking::find($bookingId);

        $bookedDates = RoomBookedDate::where('booking_id', $bookingId)->pluck('book_date')->toArray();

        $checkDateBookingIds = RoomBookedDate::whereIn('book_date', $bookedDates)
            ->where('room_id', $booking->room_id)->distinct()->pluck('booking_id')->toArray();

        $bookingIds = Booking::whereIn('id', $checkDateBookingIds)->pluck('id')->toArray();

        // cerca i numeri di stanza già assegnati
        $assignRoomIds = RoomBookingList::whereIn('booking_id', $bookingIds)
            ->pluck('room_number_id')->toArray();

        if (!empty($assignRoomIds) && $assignRoomIds !== null) {
            // cerca i numeri delle stanze attive relative al ripo di camera che non sono già stati assegnati
            $roomNumbers = RoomNumber::where('room_id', $booking->room_id)
                ->whereNotIn('id', $assignRoomIds)->where('status', 'Active')->get();
        } else {
            $roomNumbers = RoomNumber::where('room_id', $booking->room_id)->where('status', 'Active')->get();
        }

        return view('backend.booking.assignRoom', compact('booking', 'roomNumbers'));
    }

    public function assignRoomStore(int $bookingId, int $roomNumberId)
    {
        // cerca i dati di booking
        $booking = Booking::find($bookingId);

        // verifica se la stanza è già assegnata
        $checkAvailability = RoomBookingList::where('booking_id', $bookingId)->count();

        if ($checkAvailability < $booking->number_of_rooms) {
            $assignData = new RoomBookingList();
            $assignData->booking_id = $bookingId;
            $assignData->room_id = $booking->room_id;
            $assignData->room_number_id = $roomNumberId;

            $assignData->save();
            $notification = array(
                'message' => "Room Assigned!",
                'alert-type' => 'success'
            );
        } else {
            $notification = array(
                'message' => "Room Already Assigned!",
                'alert-type' => 'error'
            );
        }

        return redirect()->back()->with($notification);
    }

    public function deleteAssignRoom(int $roomBookingListId)
    {
        RoomBookingList::find($roomBookingListId)->delete();

        $notification = array(
            'message' => "Room Unassigned Successfully!",
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function downloadInvoice(int $id)
    {
        $booking = Booking::with('room')->find($id);

        $pdf = Pdf::loadView('backend.booking.booking_invoice', compact('booking'))
            ->setPaper('a4')->setOption([
                'tempDir' => public_path(),
                'chroot' => public_path(),
            ]);
        return $pdf->download('invoice-booking-' . $booking->code . '.pdf');
    }
}

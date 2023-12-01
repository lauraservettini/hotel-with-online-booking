<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\RoomBookedDate;
use App\Models\Booking;
use App\Models\Facility;
use App\Models\MultiImage;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class FrontendRoomController extends Controller
{
    public function roomList()
    {
        $rooms = Room::latest()->get();

        return view('frontend.rooms.all_rooms', compact('rooms'));
    }

    public function roomDetails(int $id)
    {
        $room = Room::find($id);
        $multiImages = MultiImage::where('room_id', $id)->get()->toArray();
        $facilities = Facility::where('room_id', $id)->get()->toArray();

        $otherRooms = Room::where('id', '!=', $id)->orderby('id', 'DESC')->get()->toArray();

        return view('frontend.rooms.room_details', compact('room', 'multiImages', 'facilities', 'otherRooms'));
    }

    public function bookingSearch(Request $request)
    {
        // salva i dati nella sessione
        $request->flash();

        if ($request->check_in == $request->check_out) {
            // invia notifica
            $notification = array(
                'message' => 'Select different check-in and check-out dates!',
                'alert-type' => 'error'
            );

            return redirect()->back()->with($notification);
        }

        $startDate = date('Y-m-d', strtotime($request->check_in));
        $endDate = date('Y-m-d', strtotime($request->check_in));

        // estrai il giorno dalla data finale
        $allDate = Carbon::create($endDate)->subDay();

        // estrai i giorni dal check-in al check-out
        $dayPeriod = CarbonPeriod::create($startDate, $allDate);

        $dateArray = [];

        foreach ($dayPeriod as $day) {
            array_push($dateArray, date('Y-m-d', strtotime($day)));
        }

        // SELECT DISTINCT booking_id FROM room_booked_dates
        $checkDateBookingIds = RoomBookedDate::whereIn('book_date', $dateArray)->distinct()->pluck('booking_id')->toArray();

        $rooms = Room::withCount('roomNumbers')->where('status', '1')->get()->toArray();

        return view('frontend.rooms.search_room', compact('rooms', 'checkDateBookingIds'));
    }

    public function bookingSearchDetails(Request $request, int $id)
    {
        $request->flash();

        $room = Room::withCount('roomNumbers')->find($id);
        $multiImages = MultiImage::where('room_id', $id)->get()->toArray();
        $facilities = Facility::where('room_id', $id)->get()->toArray();

        $otherRooms = Room::where('id', '!=', $id)->orderby('id', 'DESC')->get()->toArray();

        return view('frontend.rooms.search_room_details', compact('room', 'multiImages', 'facilities', 'otherRooms'));
    }

    public function checkRoomsAvailability(Request $request)
    {
        // salva i dati nella sessione
        $request->flash();


        if ($request->check_in == $request->check_out) {
            // invia notifica
            $notification = array(
                'message' => 'Select different check-in and check-out dates!',
                'alert-type' => 'error'
            );

            return redirect()->back()->with($notification);
        }

        $startDate = date('Y-m-d', strtotime($request->check_in));
        $endDate = date('Y-m-d', strtotime($request->check_out));

        // estrai il giorno dalla data finale
        $allDate = Carbon::create($endDate)->subDay();

        // estrai i giorni dal check-in al check-out
        $dayPeriod = CarbonPeriod::create($startDate, $allDate);

        $dateArray = [];

        foreach ($dayPeriod as $day) {
            array_push($dateArray, date('Y-m-d', strtotime($day)));
        }

        // SELECT DISTINCT booking_id FROM room_booked_dates
        $checkDateBookingIds = RoomBookedDate::whereIn('book_date', $dateArray)->distinct()->pluck('booking_id')->toArray();

        $rooms = Room::withCount('roomNumbers')->find($request->room_id);

        // Verifica se ci sono booking per il tipo di stanza, altrimenti assegna 0 a totalBookRooms
        if (!empty($checkDateBookingIds) && $checkDateBookingIds !== null) {
            $bookings = Booking::withCount('assignRooms')->whereIn('id', $checkDateBookingIds)->where('room_id', $request->room_id)->get()->toArray();
            $totalBookRooms = array_sum(array_column($bookings, 'assign_rooms_count'));
        } else {
            $totalBookRooms = 0;
        }

        $avg_room = @$rooms['room_numbers_count'] - $totalBookRooms;

        $endDate = Carbon::parse($request->check_out);
        $startDate = Carbon::parse($request->check_in);

        // Calcola il periodo
        $nights = $endDate->diffInDays($startDate);

        return response()->json([
            'available_room' => $avg_room,
            'total_nights' => $nights
        ]);
    }
}

<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\RoomBookedDate;
use App\Models\Booking;
use App\Models\RoomBookingList;
use App\Models\RoomNumber;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class RoomListController extends Controller
{
    public function roomList()
    {
        $roomNumberList = RoomNumber::with(['roomType', 'lastBooking.booking:id,check_in,check_out,status,code,name,phone'])->orderBy('roomtype_id', 'asc')
            ->leftJoin('room_types', 'room_types.id', 'room_numbers.roomtype_id', 'roomtype_id')
            ->leftJoin('room_booking_lists', 'room_booking_lists.room_number_id', 'room_numbers.id')
            ->leftJoin('bookings', 'bookings.id', 'room_booking_lists.booking_id')
            ->select(
                'room_numbers.*',
                'room_numbers.id as id',
                'room_types.name',
                'bookings.id as booking_id',
                'bookings.check_in as check_in',
                'bookings.check_out as check_out',
                'bookings.name as customer_name',
                'bookings.phone as customer_phone',
                'bookings.status as booking_status',
                'bookings.code as booking_no'
            )
            ->orderBy('room_types.id', 'asc')
            ->orderBy('bookings.id', 'desc')
            ->get();

        return view('backend.rooms.rooms.room_list', compact('roomNumberList'));
    }

    public function addRoomList()
    {
        $roomTypes = RoomType::all();

        return view('backend.rooms.rooms.add_room_list', compact('roomTypes'));
    }

    public function storeRoomList(Request $request)
    {
        if ($request->available_room > $request->number_of_rooms) {
            $request->flash();

            $notification = array(
                'message' => "There's not enough room available!",
                'alert-type' => 'error'
            );

            return redirect()->back()->with($notification);
        }

        $room = Room::find($request['room_id']);

        if ($request->number_of_person > ($room->capacity * $request->number_of_rooms)) {
            $request->flash();

            $notification = array(
                'message' => "You exceeded max number of guests!",
                'alert-type' => 'error'
            );

            return redirect()->back()->with($notification);
        }
        // $bookingData = Session::get('book_date');

        $startDate = Carbon::parse($request['check_in']);
        $endDate = Carbon::parse($request['check_out']);

        $total_night = $startDate->diffInDays($endDate);
        $subtotal = $room->price * $total_night * $request['number_of_rooms'];
        $discount = $subtotal / 100 * $room->discount;
        $total_price = $subtotal - $discount;

        $code = rand(000000000, 999999999);

        // salva in $dataToSave i dati da inserire nel database
        $dataToSave = new Booking();
        $dataToSave->room_id = $request->room_id;
        $dataToSave->user_id = Auth::user()->id;

        $dataToSave->check_in = date('Y-m-d', strtotime($request->check_in));
        $dataToSave->check_out = date('Y-m-d', strtotime($request->check_out));
        $dataToSave->person = $request->number_of_person;
        $dataToSave->number_of_rooms = $request->number_of_rooms;
        $dataToSave->total_night = $total_night;
        $dataToSave->actual_price = $room->price;
        $dataToSave->subtotal = $subtotal;
        $dataToSave->discount = $discount;
        $dataToSave->total_price = $total_price;

        $dataToSave->payment_method = 'COD';
        $dataToSave->payment_status = 0;
        $dataToSave->transaction_id = "";

        $dataToSave->name = $request->name;
        $dataToSave->phone = $request->phone;
        $dataToSave->email = $request->email;
        $dataToSave->address = $request->address;
        $dataToSave->zip_code = $request->zip_code;
        $dataToSave->country = $request->country;
        $dataToSave->state = $request->state;

        $dataToSave->code = $code;
        $dataToSave->status = 0;
        $dataToSave->save();

        // salva i dati nella RoomBookedDate
        $startDate = date('Y-m-d', strtotime($request->check_in));
        $endDate = date('Y-m-d', strtotime($request->check_out));
        $lastDate = Carbon::create($endDate)->subDay();
        $dayPeriod = CarbonPeriod::create($startDate, $lastDate);

        foreach ($dayPeriod as $period) {
            $bookedDates = new RoomBookedDate();
            $bookedDates->booking_id = $dataToSave->id;
            $bookedDates->room_id = $request->room_id;
            $bookedDates->book_date = date('Y-m-d', strtotime($period));
            $bookedDates->save();
        }

        $dataToSave->save();

        foreach ($bookedDates as $bookedDate) {
            $bookedDate->save();
        }

        $notification = array(
            'message' => "Booking Inserted Successfully!",
            'alert-type' => 'success'
        );

        return redirect()->route('view.room.list')->with($notification);
    }
}

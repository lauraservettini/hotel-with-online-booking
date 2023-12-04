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

        return view('backend.rooms.room_list', compact('roomNumberList'));
    }
}

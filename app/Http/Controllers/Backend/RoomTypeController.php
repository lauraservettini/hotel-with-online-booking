<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RoomType;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;

class RoomTypeController extends Controller
{
    public function roomTypeList()
    {
        $rooms = RoomType::orderBy('id', 'desc')->get();
        return view(
            'backend.rooms.room_type.room_type_list',
            compact('rooms')
        );
    }

    public function addRoomType()
    {
        return view('backend.rooms.room_type.new_room_type');
    }

    public function postAddRoomType(Request $request)
    {
        //Validation
        $request->validate([
            'name' => "required"
        ]);

        RoomType::inseRt([
            'name' => $request->name,
            'created_at' => Carbon::now()
        ]);

        // invia notifica
        $notification = array(
            'message' => 'Room Type Added Successfully',
            'alert-type' => 'success'
        );


        return redirect()->route('room.type.list')->with($notification);
    }
}

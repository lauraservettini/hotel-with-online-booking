<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\RoomNumber;
use App\Models\Facility;
use App\Models\MultiImage;
use Intervention\Image\Facades\Image;

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
}

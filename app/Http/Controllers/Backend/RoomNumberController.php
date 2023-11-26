<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RoomNumber;

class RoomNumberController extends Controller
{
    public function storeRoomNo(int $id, Request $request)
    {
        $roomNo = new RoomNumber();
        $roomNo->room_id = $id;
        $roomNo->roomtype_id = $request->roomtype_id;
        $roomNo->room_no = $request->room_no;
        $roomNo->status = $request->status;

        $roomNo->save();

        // invia notifica
        $notification = array(
            'message' => 'Room Number Added Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function editRoomNo(int $id)
    {
        $roomNo = RoomNumber::find($id);

        return view('backend.rooms.room_no.edit_room_no', compact('roomNo'));
    }

    public function updateRoomNo(int $id, Request $request)
    {
        $roomNo = RoomNumber::find($id);

        // Update roomNo con i valori del form
        $roomNo->room_no = $request->room_no;
        $roomNo->status = $request->status;

        $roomNo->save();

        // invia notifica
        $notification = array(
            'message' => 'Room Number Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('room.type.list')->with($notification);
    }

    public function deleteRoomNo(int $id)
    {
        RoomNumber::find($id)->delete();

        // invia notifica
        $notification = array(
            'message' => 'Room Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('room.type.list')->with($notification);
    }
}

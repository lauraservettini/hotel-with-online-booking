<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\RoomNumber;
use App\Models\Facility;
use App\Models\MultiImage;
use Intervention\Image\Facades\Image;


class RoomController extends Controller
{
    public function editRoom(int $id)
    {
        $room = Room::find($id);
        $basic_facility = Facility::where('room_id', $id)->get()->toArray();
        $multi_images = MultiImage::where('room_id', $id)->get()->toArray();

        $allRoomNo = RoomNumber::where('room_id', $id)->get()->toArray();

        return view(
            'backend.rooms.rooms.edit_room',
            compact('room', 'basic_facility', 'multi_images', 'allRoomNo')
        );
    }

    public function updateRoom(int $id, Request $request)
    {
        $room = Room::find($id);

        $room->roomtype_id = $room->roomtype_id;
        $room->total_adult = $request->total_adult;
        $room->total_child = $request->total_child;
        $room->room_capacity = $request->room_capacity;
        $room->price = $request->price;
        $room->discount = $request->discount;
        $room->size = $request->size;
        $room->short_descr = $request->short_descr;
        $room->description = $request->description;
        $room->view = $request->view;
        $room->bed_style = $request->bed_style;
        $room->status = 1;

        // Update single Image
        if ($request->file('image')) {
            // Crea il nome per l'immagine
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();

            $oldImage = $room->image;

            // resize image
            Image::make($image)->resize(550, 850)->save('upload/room_images/' . $name_gen);
            $save_url = 'upload/room_images/' . $name_gen;
            $room->image = $name_gen;

            // aggiorna i dati nel database con l'immagine
            $room->save();

            // cancella la vecchia immagine da upload/admin_images
            @unlink(public_path('upload/room_images/' . $oldImage));

            // invia notifica
        } else {
            // salva i dati nel database
            $room->save();
        }

        // Update Facility Table
        if ($request->facility_name === NULL) {
            $notification = array(
                'message' => 'Sorry! Not Any basic facility selected!',
                'alert-type' => 'error'
            );
        } else {
            Facility::where('room_id', $id)->delete();
            $facilities = Count($request->facility_name);

            for ($i = 0; $i < $facilities; $i++) {
                $fcount = new Facility();
                $fcount->room_id = $room->id;
                $fcount->facility_name = $request->facility_name[$i];
                $fcount->save();
            }
        }

        // Update Muti Image Table
        if ($room->save()) {
            $files = $request->multi_image;
            if (!empty($files)) {
                // salva i file in Multi Images
                foreach ($files as $file) {
                    $imgName = date('YmdHi') . $file->getClientOriginalName();
                    $file->move('upload/room_images/multi_img', $imgName);

                    $images = new MultiImage();
                    $images->room_id = $id;
                    $images->multi_image = $imgName;
                    $images->save();
                }

                // invia notifica
                $notification = array(
                    'message' => 'Room Updated Successfully',
                    'alert-type' => 'success'
                );

                return redirect()->back()->with($notification);
            } else {
                // invia notifica
                $notification = array(
                    'message' => 'Room Updated Successfully',
                    'alert-type' => 'success'
                );

                return redirect()->back()->with($notification);
            }
        }
        return redirect()->back();
    }

    public function multiImageDelete(int $id)
    {
        $toDeleteData = MultiImage::where('id', $id)->first();

        if (!empty($toDeleteData->multi_image) && $toDeleteData->multi_image) {
            $imagePath = public_path('upload/room_images/multi_img/' . $toDeleteData->multi_image);

            // Verifica se il file esiste e lo cancella
            if (file_exists($imagePath)) {
                unlink($imagePath);
                echo 'Image Unlinked Successfully';
            } else {
                echo 'Image does not exist';
            }

            // Cancella il file nel database
            MultiImage::where('id', $id)->delete();
        }

        // invia notifica
        $notification = array(
            'message' => 'Multi Image Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function deleteRoom($id, Request $request)
    {
        $room = Room::find($id);

        $roomMultiImages = MultiImage::where('room_id', $id)->get()->toArray();

        if (!empty($room->image) && $room->image) {
            $imagePath = public_path('upload/room_images/' . $room->image);
        }

        // Verifica se esiste l'immagine singola e la cancella
        if (!empty($imagePath) && file_exists($imagePath)) {
            unlink($imagePath);
        }

        // Verifica se esistono le immagini e lo cancella
        if (!empty($roomMultiImages)) {

            foreach ($roomMultiImages as $roomMultiImage) {
                $roomMultiImagePath = public_path('upload/room_images/multi_img/' . $roomMultiImage['multi_image']);

                // cancella la vecchia immagine da upload/admin_images
                if (!empty($roomMultiImagePath) && file_exists($roomMultiImagePath)) {
                    unlink($roomMultiImagePath);
                }
            }
        }

        // Cancella il RoomType, la room, le room number, le Facility e le multiImages nel database
        RoomType::where('id', $room->roomtype_id)->delete();
        RoomNumber::where('room_id', $id)->delete();
        Facility::where('room_id', $id)->delete();
        MultiImage::where('room_id', $id)->delete();
        $room->delete();

        // invia notifica
        $notification = array(
            'message' => 'Room Type Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }
}

<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;

class GalleryController extends Controller
{
    public function gallery()
    {
        $galleries = Gallery::latest()->get();

        return view('backend.gallery.all_gallery', compact('galleries'));
    }

    public function addGallery()
    {
        return view('backend.gallery.add_gallery');
    }

    public function storeGallery(Request $request)
    {
        //Validation
        $request->validate([
            "photo_name" => "required"
        ]);

        $files = $request->photo_name;

        if (!empty($files)) {
            // salva i file in Multi Images
            foreach ($files as $image) {
                // Crea il nome per l'immagine
                $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();

                // resize image
                Image::make($image)->resize(550, 550)->save('upload/gallery/multi_img/' . $name_gen);
                $save_url = 'upload/gallery/multi_img/' . $name_gen;

                $images = new Gallery();
                $images->photo_name = $save_url;
                $images->save();
            }

            // invia notifica
            $notification = array(
                'message' => 'Gallery Inserted Successfully',
                'alert-type' => 'success'
            );
        } else {
            // invia notifica
            $notification = array(
                'message' => 'Gallery Not Inserted!',
                'alert-type' => 'error'
            );
        }


        return redirect()->route('gallery')->with($notification);
    }

    public function editGallery(int $id)
    {
        $gallery = Gallery::find($id);

        return view('backend.gallery.update_gallery', compact('gallery'));
    }

    public function updateGallery(Request $request, int $id)
    {
        //Validation
        $request->validate([
            "photo_name" => "required"
        ]);

        $gallery = Gallery::findOrFail($id);

        if (!empty($gallery)) {

            $image = $request->file('photo_name');

            if (!empty($image)) {
                // Crea il nome per l'immagine
                $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();

                $oldImage = $gallery->photo_name;

                // resize image
                Image::make($image)->resize(550, 550)->save('upload/gallery/multi_img/' . $name_gen);
                $save_url = 'upload/gallery/multi_img/' . $name_gen;

                $gallery->update([
                    'photo_name' => $save_url
                ]);

                unlink($oldImage);

                // invia notifica
                $notification = array(
                    'message' => 'Gallery Updated Successfully',
                    'alert-type' => 'success'
                );
            } else {
                // invia notifica
                $notification = array(
                    'message' => 'Gallery Not Updated!',
                    'alert-type' => 'error'
                );
            }
        } else {
            // invia notifica
            $notification = array(
                'message' => 'Gallery Not Updated!',
                'alert-type' => 'error'
            );
        }


        return redirect()->route('gallery')->with($notification);
    }

    public function deleteGallery(int $id)
    {
        $toDeleteData = Gallery::where('id', $id)->first();

        if (!empty($toDeleteData->photo_name) && $toDeleteData->photo_name) {
            $imagePath = public_path($toDeleteData->photo_name);

            // Verifica se il file esiste e lo cancella
            if (file_exists($imagePath)) {
                unlink($imagePath);
                echo 'Image Unlinked Successfully';
            } else {
                echo 'Image does not exist';
            }

            // Cancella il file nel database
            $toDeleteData->delete();
        }

        // invia notifica
        $notification = array(
            'message' => 'Gallery Photo Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function deleteSelectedGallery(Request $request)
    {
        $selectedItems = $request->selectedItem;

        if (empty($selectedItems)) {
            //invia notifica
            $notification = array(
                'message' => 'You Have Not Selected Any Photo!',
                'alert-type' => 'error'
            );
        } else {
            foreach ($selectedItems as $selectedItem) {
                $gallery = Gallery::findOrFail($selectedItem);

                $oldImage = $gallery->photo_name;

                unlink($oldImage);

                $gallery->delete();
            }

            // invia notifica
            $notification = array(
                'message' => 'Gallery Photo Selected Deleted Successfully',
                'alert-type' => 'success'
            );
        }

        return redirect()->back()->with($notification);
    }
}

<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BookArea;
use Intervention\Image\Facades\Image;


class BookareaController extends Controller
{
    public function getUpdateBookarea()
    {
        $book = BookArea::find(1);
        return view(
            'backend.bookarea.update_bookarea',
            compact('book')
        );
    }

    public function postUpdateBookarea(Request $request)
    {
        //Validation
        $request->validate([
            'short_title' => "required",
            "main_title" => "required",
            "short_descr" => "required",
            'link_url' => "required"
        ]);

        $book_id = $request->id;

        if ($request->file('image')) {
            // Crea il nome per l'immagine
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();

            $book = BookArea::findOrFail($book_id);
            $oldImage = $book->image;


            // resize image
            Image::make($image)->resize(1000, 1000)->save('upload/bookarea_images/' . $name_gen);
            $save_url = 'upload//bookarea_images/' . $name_gen;

            // aggiorna i dati nel database con l'immagine
            $book->update([
                'short_title' => $request->short_title,
                'main_title' => $request->main_title,
                'short_descr' => $request->short_descr,
                'link_url' => $request->link_url,
                'image' => $save_url
            ]);

            // cancella la vecchia immagine da upload/admin_images
            @unlink(public_path($oldImage));

            // invia notifica
            $notification = array(
                'message' => 'Book Area Updated With Image Successfully',
                'alert-type' => 'success'
            );
        } else {
            // salva i dati nel database
            BookArea::findOrFail($book_id)->update([
                'short_title' => $request->short_title,
                'main_title' => $request->main_title,
                'short_descr' => $request->short_descr,
                'link_url' => $request->link_url
            ]);
            // invia notifica
            $notification = array(
                'message' => 'Book Area Without Image Successfully',
                'alert-type' => 'success'
            );
        }

        return redirect()->back()->with($notification);
    }
}

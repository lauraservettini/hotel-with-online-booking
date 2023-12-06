<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Testimonial;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;

class TestimonialController extends Controller
{
    public function testimonials()
    {
        $testimonials = Testimonial::latest()->get();

        return view('backend.testimonials.all_testimonials', compact('testimonials'));
    }

    public function addTestimonial()
    {
        return view('backend.testimonials.add_testimonial');
    }

    public function storeTestimonial(request $request)
    {
        //Validation
        $request->validate([
            "name" => "required",
            "city" => "required",
            "message" => "required",
            "image" => "required"
        ]);

        $image = $request->file('image');
        if ($image) {
            // Crea il nome per l'immagine
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();

            // resize image
            Image::make($image)->resize(550, 550)->save('upload/testimonials/' . $name_gen);
            $save_url = 'upload/testimonials/' . $name_gen;

            // salva i dati nel database con l'immagine
            Testimonial::insert([
                'name' => $request->name,
                'city' => $request->city,
                'image' => $save_url,
                'message' => $request->message,
                'created_at' => Carbon::now()
            ]);
        } else {
            // salva i dati nel database senza immagine
            Testimonial::insert([
                'name' => $request->name,
                'city' => $request->city,
                'message' => $request->message,
                'created_at' => Carbon::now()
            ]);
        }

        // invia notifica
        $notification = array(
            'message' => 'Testimonial Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('testimonials')->with($notification);
    }

    public function updateTestimonial(int $id)
    {
        $testimonial = Testimonial::find($id);

        return view('backend.testimonials.update_testimonial', compact('testimonial'));
    }

    public function storeUpdateTestimonial(Request $request, int $id)
    {
        //Validation
        $request->validate([
            "name" => "required",
            "city" => "required",
            "message" => "required",
            "image" => "required"
        ]);

        $testimonial = Testimonial::findOrFail($id);

        $image = $request->file('image');
        if ($image) {
            $oldImage = $testimonial->image;
            // Crea il nome per l'immagine
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();

            // resize image
            Image::make($image)->resize(550, 550)->save('upload/testimonials/' . $name_gen);
            $save_url = 'upload/testimonials/' . $name_gen;


            // salva i dati nel database con l'immagine
            $testimonial->update([
                'name' => $request->name,
                'city' => $request->city,
                'image' => $save_url,
                'message' => $request->message,
                'created_at' => Carbon::now()
            ]);

            // Cancella la vecchia immagine
            unlink($oldImage);
        } else {
            // salva i dati nel database senza immagine
            $testimonial->update([
                'name' => $request->name,
                'city' => $request->city,
                'message' => $request->message,
                'created_at' => Carbon::now()
            ]);
        }

        // invia notifica
        $notification = array(
            'message' => 'Testimonial Updateded Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('testimonials')->with($notification);
    }

    public function deleteTestimonial(int $id)
    {
        $testimonial = Testimonial::findOrFail($id);

        // Cancella l'immagine prima di cancellare il record nel database
        unlink($testimonial->image);

        $testimonial->delete();

        // invia notifica
        $notification = array(
            'message' => 'Testimonial Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('testimonials')->with($notification);
    }
}

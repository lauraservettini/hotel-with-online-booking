<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\SiteSettings;
use Carbon\Carbon;

class ContactController extends Controller
{
    public function contact()
    {
        $settings = SiteSettings::find(1);

        return view('frontend.contact.contact_us', compact('settings'));
    }

    public function storeContact(Request $request)
    {
        //Validation
        $request->validate([
            "name" => "required",
            "email" => "required",
            "phone" => "required",
            "subject" => "required",
            "message" => "required"
        ]);

        Contact::insert([
            "name" => $request->name,
            "email" => $request->email,
            "phone" => $request->phone,
            "subject" => $request->subject,
            "message" => $request->message,
            "created_at" => Carbon::now()
        ]);

        // invia notifica
        $notification = array(
            'message' => 'Contact Message Send Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function adminContact()
    {
        $contacts = Contact::latest()->get();

        return view('backend.contact.all_contact', compact('contacts'));
    }
}

<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SmtpSettings;
use App\Models\SiteSettings;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;

class SettingsController extends Controller
{
    public function smtpSettings()
    {
        $smtp = SmtpSettings::find(1);
        return view('backend.settings.smtp_update', compact('smtp'));
    }

    public function updateSmtp(Request $request)
    {
        //Validation
        $request->validate([
            "mailer" => "required",
            "host" => "required",
            "port" => "required",
            "username" => "required",
            "password" => "required",
            "encryption" => "required",
            "from_address" => "required"
        ]);


        if (!empty($request->id) && $request->id != "") {
            $smtp = SmtpSettings::find($request->id);

            $smtp->update([
                "mailer" => $request->mailer,
                "host" => $request->host,
                "port" => $request->port,
                "username" => $request->username,
                "password" => $request->password,
                "encryption" => $request->encryption,
                "from_address" => $request->from_address
            ]);
        } else {
            $smtp = new SmtpSettings();

            $smtp->id = 1;
            $smtp->mailer = $request->mailer;
            $smtp->host = $request->host;
            $smtp->port = $request->port;
            $smtp->username = $request->username;
            $smtp->password = $request->password;
            $smtp->encryption = $request->encryption;
            $smtp->from_address = $request->from_address;
            $smtp->save();
        }

        $notification = array(
            'message' => "Smtp Updated Successfully",
            'alert-type' => 'success'
        );

        return redirect()->route('admin.dashboard')->with($notification);
    }

    public function siteSettings()
    {
        $site = SiteSettings::find(1);
        return view('backend.settings.site_settings_update', compact('site'));
    }

    public function updateSiteSettings(Request $request)
    {
        //Validation
        $request->validate([
            "phone" => "required",
            "email" => "required",
            "address" => "required",
            "copyright" => "required",
            "logo" => "required",
            "facebook" => "required",
            "twitter" => "required"
        ]);

        $site = SiteSettings::find(1);

        if (!empty($site)) {
            $image = $request->file('logo');
            if ($image) {
                // Crea il nome per l'immagine
                $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
                $oldImage = $site->logo;
                // resize image
                Image::make($image)->resize(110, 44)->save('upload/settings/' . $name_gen);
                $save_url = 'upload/settings/' . $name_gen;

                // salva i dati nel database con l'immagine
                $site->update([
                    'phone' => $request->phone,
                    'email' => $request->email,
                    'address' => $request->address,
                    'logo' => $save_url,
                    'facebook' => $request->facebook,
                    'twitter' => $request->twitter,
                    'copyright' => $request->copyright
                ]);

                unlink($oldImage);
            } else {
                // salva i dati nel database senza immagine
                $site->update([
                    'phone' => $request->phone,
                    'email' => $request->email,
                    'address' => $request->address,
                    'facebook' => $request->facebook,
                    'twitter' => $request->twitter,
                    'copyright' => $request->copyright
                ]);
            }

            // invia notifica
            $notification = array(
                'message' => 'Settings Updated Successfully',
                'alert-type' => 'success'
            );
        } else {

            $image = $request->file('logo');
            if ($image) {
                // Crea il nome per l'immagine
                $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();

                // resize image
                Image::make($image)->resize(110, 44)->save('upload/settings/' . $name_gen);
                $save_url = 'upload/settings/' . $name_gen;

                // salva i dati nel database con l'immagine
                SiteSettings::insert([
                    'phone' => $request->phone,
                    'email' => $request->email,
                    'address' => $request->address,
                    'logo' => $save_url,
                    'facebook' => $request->facebook,
                    'twitter' => $request->twitter,
                    'copyright' => $request->copyright,
                    'created_at' => Carbon::now()
                ]);
            } else {
                // salva i dati nel database senza immagine
                SiteSettings::insert([
                    'phone' => $request->phone,
                    'email' => $request->email,
                    'address' => $request->address,
                    'facebook' => $request->facebook,
                    'twitter' => $request->twitter,
                    'copyright' => $request->copyright,
                    'created_at' => Carbon::now()
                ]);
            }

            // invia notifica
            $notification = array(
                'message' => 'Settings Inserted Successfully',
                'alert-type' => 'success'
            );
        }

        return redirect()->back()->with($notification);
    }
}

<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Facility;
use App\Models\SmtpSettings;

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
}

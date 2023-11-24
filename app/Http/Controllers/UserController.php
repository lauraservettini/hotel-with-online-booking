<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
    public function home()
    {
        return view('frontend.index');
    }

    public function userProfile()
    {
        $id = Auth::user()->id;

        $profileData = User::find($id);
        return view('frontend.dashboard.edit_profile', compact('profileData'));
    }

    public function updateProfile(Request $request)
    {
        // id user autenticato
        $id = Auth::user()->id;
        $data = User::find($id);
        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address;

        //verifica se il file è caricato
        if ($request->file('photo')) {
            $file = $request->file('photo');

            // cancella la vecchia immagine da upload/admin_images
            @unlink(public_path('upload/user_images/' . $data->photo));

            $filename = date('YmdHi') . $file->getClientOriginalName();
            $file->move(public_path('upload/user_images'), $filename);
            $data['photo'] = $filename;
        }

        //salva le modifiche nel database
        $data->save();

        // invia notifica
        $notification = array(
            'message' => 'User Profile Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        // invia notifica
        $notification = array(
            'message' => 'User Logout Successfully',
            'alert-type' => 'success'
        );

        return redirect('/login')->with($notification);
    }

    public function changePassword()
    {
        return view('frontend.dashboard.user_change_password');
    }

    public function updatePassword(Request $request)
    {
        //Validation
        $request->validate([
            "old_password" => "required",
            "password" => "required|confirmed",
            "password_confirmation" => "required"
        ]);

        // verifica se la vecchia password corrisponde
        if (!Hash::check($request->old_password, Auth::user()->password)) {
            $notification = array(
                'message' => 'Old password does not match',
                'alert-type' => 'error'
            );

            return redirect()->back()->with($notification);
        }

        //Update password

        User::whereId(Auth::user()->id)->update([
            "password" => Hash::make($request->password)
        ]);

        // invia notifica
        $notification = array(
            'message' => 'Password Changed Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }
}

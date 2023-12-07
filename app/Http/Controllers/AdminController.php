<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Booking;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard()
    {
        $bookings = Booking::latest()->get();

        $pendings = Booking::where('status', '0')->get();
        $complete = Booking::where('status', '1')->get();

        $totalPriceSum = Booking::sum('total_price');

        $today = Carbon::now()->todateString();
        $todayPriceSum = Booking::whereDate('created_at', $today)->sum('total_price');

        $allBookings = Booking::orderBy('id', 'desc')->limit(10)->get();

        return view("admin.index", compact('bookings', 'pendings', 'complete', 'totalPriceSum', 'allBookings', 'todayPriceSum'));
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/admin/login');
    }

    public function login()
    {
        return view('admin.admin_login');
    }

    public function profile()
    {
        $id = Auth::user()->id;

        $profileData = User::find($id);
        return view('admin.admin_profile', compact('profileData'));
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
            @unlink(public_path('upload/admin_images/' . $data->photo));

            $filename = date('YmdHi') . $file->getClientOriginalName();
            $file->move(public_path('upload/admin_images'), $filename);
            $data['photo'] = $filename;
        }

        //salva le modifiche nel database
        $data->save();

        // invia notifica
        $notification = array(
            'message' => 'Admin Profile Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function updatePassword()
    {
        $id = Auth::user()->id;

        $profileData = User::find($id);
        return view('admin.admin_change_password', compact('profileData'));
    }

    public function storePassword(Request $request)
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

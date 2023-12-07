<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Booking;
use Barryvdh\DomPDF\Facade\Pdf;

class UserDashboardController extends Controller
{
    public function userBooking()
    {
        $id = Auth::user()->id;

        $bookings = Booking::where('user_id', $id)->orderBy('id', 'desc')->get();

        return view('frontend.dashboard.user_booking', compact('bookings'));
    }

    public function userInvoice(int $id)
    {
        $booking = Booking::with('room')->find($id);

        $pdf = Pdf::loadView('backend.booking.booking_invoice', compact('booking'))
            ->setPaper('a4')->setOption([
                'tempDir' => public_path(),
                'chroot' => public_path(),
            ]);
        return $pdf->download('invoice-booking-' . $booking->code . '.pdf');
    }
}

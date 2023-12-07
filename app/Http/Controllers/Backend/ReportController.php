<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Booking;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class ReportController extends Controller
{
    public function bookingReport()
    {
        return view('backend.report.booking_report');
    }

    public function searchBooking(Request $request)
    {
        $startDate = date('Y-m-d', strtotime($request->start_date));

        $endDate = date('Y-m-d', strtotime($request->end_date));

        $bookings = Booking::where('check_in', '>=', $startDate)->where('check_out', '<=', $endDate)->get();

        return view('backend.report.booking_search', compact('bookings', 'startDate', 'endDate'));
    }
}

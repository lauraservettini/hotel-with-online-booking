<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Models\Room;
use App\Models\RoomBookedDate;
use App\Models\Booking;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Stripe\Stripe;
use Stripe\StripeClient;
use Stripe\Charge;

class BookingController extends Controller
{
    public function checkout()
    {
        if (Session::has('book_date')) {
            $bookingData = Session::get('book_date');
            $room = Room::find($bookingData['room_id']);

            $startDate = Carbon::parse($bookingData['check_in']);
            $endDate = Carbon::parse($bookingData['check_out']);

            $nights = $startDate->diffInDays($endDate);

            return view('frontend.booking.checkout', compact('room', 'nights', 'bookingData'));
        } else {
            $notification = array(
                'message' => "Nothing to checkout!",
                'alert-type' => 'error'
            );

            return redirect()->route('home')->with($notification);
        }
    }

    public function storeUserBooking(Request $request)
    {
        //Validation
        $request->validate([
            "check_in" => "required",
            "check_out" => "required",
            "person" => "required",
            "numberOfRooms" => "required"
        ]);

        // Verifica se numberOfRooms <= available_room
        if ($request->numberOfRooms > $request->available_room) {
            $notification = array(
                'message' => "There's only {{ $request->available_room}} room left!",
                'alert-type' => 'error'
            );

            return redirect()->back()->with($notification);
        }

        // Verifica se Person <= room_capacity
        if ($request->person > ($request->room_capacity * $request->numberOfRooms)) {
            $notification = array(
                'message' => "Max {{ ($request->room_capacity * $request->numberOfRooms) }} persons for the selected rooms!",
                'alert-type' => 'error'
            );

            return redirect()->back()->with($notification);
        }

        Session::forget('book_date');

        $data = array();
        $data['numberOfRooms'] = $request->numberOfRooms;
        $data['available_room'] = $request->available_room;
        $data['person'] = $request->person;
        $data['check_in'] = date('Y-m-d', strtotime($request->check_in));
        $data['check_out'] = date('Y-m-d', strtotime($request->check_out));
        $data['room_id'] = $request->room_id;

        Session::put('book_date', $data);

        return redirect()->route('checkout');
    }

    public function storeCheckout(Request $request)
    {
        //Validation
        $this->validate($request, [
            "name" => "required",
            "phone" => "required",
            "email" => "required",
            "country" => "required",
            "address" => "required",
            "zip_code" => "required",
            "state" => "required",
            "payment_method" => "required"
        ]);

        $bookingData = Session::get('book_date');
        $room = Room::find($bookingData['room_id']);

        $startDate = Carbon::parse($bookingData['check_in']);
        $endDate = Carbon::parse($bookingData['check_out']);

        $total_night = $startDate->diffInDays($endDate);
        $subtotal = $room->price * $total_night * $bookingData['numberOfRooms'];
        $discount = $subtotal / 100 * $room->discount;
        $total_price = $subtotal - $discount;

        $code = rand(000000000, 999999999);

        // salva in $dataToSave i dati da inserire nel database
        $dataToSave = new Booking();
        $dataToSave->room_id = $bookingData['room_id'];
        $dataToSave->user_id = Auth::user()->id;

        $dataToSave->check_in = date('Y-m-d', strtotime($bookingData['check_in']));
        $dataToSave->check_out = date('Y-m-d', strtotime($bookingData['check_out']));
        $dataToSave->person = $bookingData['person'];
        $dataToSave->number_of_rooms = $bookingData['numberOfRooms'];
        $dataToSave->total_night = $total_night;
        $dataToSave->actual_price = $room->price;
        $dataToSave->subtotal = $subtotal;
        $dataToSave->discount = $discount;
        $dataToSave->total_price = $total_price;

        $dataToSave->payment_method = $request->payment_method;
        $dataToSave->payment_status = 0;
        $dataToSave->transaction_id = "";

        $dataToSave->name = $request->name;
        $dataToSave->phone = $request->phone;
        $dataToSave->email = $request->email;
        $dataToSave->address = $request->address;
        $dataToSave->zip_code = $request->zip_code;
        $dataToSave->country = $request->country;
        $dataToSave->state = $request->state;

        $dataToSave->code = $code;
        $dataToSave->status = 0;
        $dataToSave->save();

        // salva i dati nella RoomBookedDate
        $startDate = date('Y-m-d', strtotime($bookingData['check_in']));
        $endDate = date('Y-m-d', strtotime($bookingData['check_out']));
        $lastDate = Carbon::create($endDate)->subDay();
        $dayPeriod = CarbonPeriod::create($startDate, $lastDate);

        foreach ($dayPeriod as $period) {
            $bookedDates = new RoomBookedDate();
            $bookedDates->booking_id = $dataToSave->id;
            $bookedDates->room_id = $bookingData['room_id'];
            $bookedDates->book_date = date('Y-m-d', strtotime($period));
            $bookedDates->save();
        }

        if ($request->payment_method == 'Stripe') {
            var_dump(env('STRIPE_SECRET'));

            Stripe::setApiKey(env('STRIPE_SECRET'));
            header('Content-Type: application/json');

            $success = route('stripe.pay');
            $cancel = route('order.failded');

            $name = "Payment for Booking N." . $code;
            $totalPriceRound = (int) $total_price * 100;

            var_dump($totalPriceRound);

            $checkout_session = \Stripe\Checkout\Session::create([
                'line_items'  => [
                    [
                        'price_data' => [
                            'currency'     => 'eur',
                            'product_data' => [
                                'name' => $name,
                            ],
                            'unit_amount'  => $totalPriceRound,
                        ],
                        'quantity'   => 1
                    ],
                ],
                'mode'        => 'payment',
                'success_url' => $success,
                'cancel_url' => $cancel,
            ]);


            header("HTTP/1.1 303 See Other");
            header("Location: " . $checkout_session->url);

            Session::put('checkout_session', $checkout_session);


            exit();
        }

        $dataToSave->save();

        foreach ($bookedDates as $bookedDate) {
            $bookedDate->save();
        }

        Session::forget('book_date');

        $notification = array(
            'message' => "Order Completed Successfully!",
            'alert-type' => 'success'
        );

        return redirect()->route('home')->with($notification);
    }

    public function stripePay()
    {
        $notification = array(
            'message' => "Order Completed Successfully!",
            'alert-type' => 'success'
        );

        return redirect()->route('home')->with($notification);
    }

    public function orderFailed()
    {
        $notification = array(
            'message' => "The Payment Were Cancelled!!",
            'alert-type' => 'error'
        );

        return redirect()->route('home')->with($notification);
    }
}

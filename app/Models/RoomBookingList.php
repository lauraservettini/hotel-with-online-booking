<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\RoomNumber;
use App\Models\Booking;

class RoomBookingList extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function roomNumber()
    {
        return $this->belongsTo(RoomNumber::class, 'room_number_id', 'id');
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id', 'id');
    }
}

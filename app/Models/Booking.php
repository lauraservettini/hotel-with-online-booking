<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\RoomBookingList;

class Booking extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function assignRooms()
    {
        return $this->hasMany(RoomBookingList::class, 'booking_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\RoomType;
use App\Models\RoomBookingList;

class RoomNumber extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function roomType()
    {
        return $this->belongsTo(RoomType::class, 'room_type_id');
    }

    public function lastBooking()
    {
        return $this->hasOne(RoomBookingList::class, 'room_number_id', 'id')->latest();
    }
}

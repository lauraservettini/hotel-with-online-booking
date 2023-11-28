<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\RoomType;
use App\Models\RoomNumber;

class Room extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function roomType()
    {
        return $this->belongsTo(RoomType::class, 'roomtype_id', 'id');
    }

    public function roomNumbers()
    {
        return $this->hasMany(RoomNumber::class, 'room_id')->where('status', 'active');
    }
}

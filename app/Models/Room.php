<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\RoomType;

class Room extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function roomType()
    {
        return $this->belongsTo(RoomType::class, 'roomtype_id', 'id');
    }
}

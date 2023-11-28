@extends('frontend.main_master')

@section('master')

<!-- Inner Banner -->
<div class="inner-banner inner-bg9">
    <div class="container">
        <div class="inner-title">
            <ul>
                <li>
                    <a href="index.html">Home</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>Booking</li>
            </ul>
            <h3>Rooms</h3>
        </div>
    </div>
</div>
<!-- Inner Banner End -->

<!-- Room Area -->
<div class="room-area pt-100 pb-70">
    <div class="container">
        <div class="section-title text-center">
            <span class="sp-color">ROOM LIST</span>
            <h2>Our Rooms & Rates</h2>
        </div>
        <div class="row pt-45">
            @php
                $items = [];
            @endphp

            @foreach($rooms as $room)

                @php
                    $bookings = App\Models\Booking::withCount('assignRooms')->whereIn('id', $checkDateBookingIds)->where('room_id', $room['id'])->get()->toArray();

                    $totalBookRooms = array_sum(array_column($bookings, 'assign_rooms_count'));
                
                    $avgRoom = $room['room_numbers_count'] - $totalBookRooms;
                @endphp

                @if($avgRoom > 0 && old('person') <= $room['total_adult'])

                    <div class="col-lg-4 col-md-6">
                        <div class="room-card">
                            <a href="{{  route('search.room.details', $room['id']
                                . '?check_in=' . old('check_in')
                                . '&check_out=' . old('check_out') 
                                . '&person=' . old('person') )
                                }}">
                                <img src="{{ asset('upload/room_images/' . $room['image']) }}" alt="Images" height="300px" width="300pz" >
                            </a>
                            <div class="content">
                                <h3><a href="{{  route('search.room.details', $room['id']
                                . '?check_in=' . old('check_in')
                                . '&check_out=' . old('check_out') 
                                . '&person=' . old('person') )
                                }}">{{ App\Models\Room::find($room['id'])['roomtype']['name'] }}</a></h3>
                                <ul>
                                    <li class="text-color">€ {{ $room['price'] }}</li>
                                    <li class="text-color">Per Night</li>
                                </ul>
                                <div class="rating text-color">
                                    <i class='bx bxs-star'></i>
                                    <i class='bx bxs-star'></i>
                                    <i class='bx bxs-star'></i>
                                    <i class='bx bxs-star'></i>
                                    <i class='bx bxs-star-half'></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    @php
                        array_push($items, $room['id']);
                    @endphp
                
                @endif

            @endforeach

            @if(empty($items) || !$items)
                <p class="text-center text-danger">Sorry, there's no available rooms for the selected period!</p>
            @endif
            <div class="col-lg-12 col-md-12">
                <div class="pagination-area">
                    <a href="#" class="prev page-numbers">
                        <i class='bx bx-chevrons-left'></i>
                    </a>

                    <span class="page-numbers current" aria-current="page">1</span>
                    <a href="#" class="page-numbers">2</a>
                    <a href="#" class="page-numbers">3</a>
                    
                    <a href="#" class="next page-numbers">
                        <i class='bx bx-chevrons-right'></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Room Area End -->

@endsection
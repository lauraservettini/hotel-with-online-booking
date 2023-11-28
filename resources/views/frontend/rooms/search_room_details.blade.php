@extends('frontend.main_master')

@section('master')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<!-- Inner Banner -->
<div class="inner-banner inner-bg9">
    <div class="container">
        <div class="inner-title">
            <ul>
                <li>
                    <a href="index.html">Home</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>Search Room Details</li>
            </ul>
            <h3>{{ $room['roomtype']['name'] }}</h3>
        </div>
    </div>
</div>
<!-- Inner Banner End -->

<!-- Room Details Area End -->
<div class="room-details-area pt-100 pb-70">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <div class="room-details-side">
                    <div class="side-bar-form">
                        <h3>Booking Sheet </h3>
                        <form action="{{ route('user.booking.store', $room->id) }}" method="POST" id="bk_form">
                            @csrf
                            <input type="hidden" name="room_id" id="room_id" value="{{ $room->id }}">

                            <div class="row align-items-center">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Check in</label>
                                        <div class="input-group">
                                            <input name="check_in" id="check_in" type="text" class="form-control dt-picker" value="{{ old('check_in') ? date('Y-m-d', strtotime(old('check_in'))) : "" }}" required autocomplete="off" @error('check_in') is-invalid @enderror />
                                            <span class="input-group-addon"></span>
                                        </div>
                                        <i class='bx bxs-calendar'></i>
                                    </div>
                                    @error('check_in')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Check Out</label>
                                        <div class="input-group">
                                            <input name="check_out" id="check_out" type="text" class="form-control dt-picker" value="{{ old('check_out') ? date('Y-m-d', strtotime(old('check_out'))) : "" }}" required autocomplete="off" @error('check_out') is-invalid @enderror />
                                            <span class="input-group-addon"></span>
                                        </div>
                                        <i class='bx bxs-calendar'></i>
                                    </div>
                                    @error('check_out')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Numbers of Persons</label>
                                        <select class="form-control" id="numberOfPerson" name="person" @error('numberOfPerson') is-invalid @enderror />
                                        @for($i = 1 ; $i <= $room->room_capacity; $i++)
                                            <option value="0{{ $i }}" {{ old('person') == $i ? "selected" : ""  }}>0{{ $i }}</option>
                                        @endfor
                                        </select>	
                                    </div>
                                    @error('numberOfPerson')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <input type="hidden" name="room_capacity" value="{{ $room->room_capacity }}">
                                <input type="hidden" id="total_adult" value="{{ $room->total_adult }}">
                                <input type="hidden" id="room_price" value="{{ $room->price }}">
                                <input type="hidden" id="discount_p" value="{{ $room->discount }}">

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Numbers of Rooms</label>
                                        <select class="form-control" id="numberOfRooms" name="numberOfRooms" @error('numberOfRooms') is-invalid @enderror />
                                        @for($i = 1 ; $i <= $room['room_numbers_count'] ; $i++)
                                            <option value="0{{ $i }}">0{{ $i }}</option>
                                        @endfor
                                        </select>	
                                        @error('numberOfRooms')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <input type="hidden" name="available_room" id="available_room">
                                    <p class="available_room"></p>
                                </div>
    
                                <div class="col-lg-12">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td><p>Subtotal</p></td>
                                                <td class="text-end"><span class="t_subtotal">0</span> €</td>
                                            </tr>
                                            <tr>
                                                <td><p>Discount</p></td>
                                                <td class="text-end"><span class="t_discount">0</span>%</td>
                                            </tr>
                                            <tr>
                                                <td><p>Total</p></td>
                                                <td class="text-end"><span class="t_g_total">0</span> €</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="col-lg-12 col-md-12">
                                    <button type="submit" class="default-btn btn-bg-three border-radius-5">
                                        Book Now
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="room-details-article">
                    <div class="room-details-slider owl-carousel owl-theme">
                        @foreach($multiImages as $image)
                        <div class="room-details-item">
                            <img src="{{ asset('upload/room_images/multi_img/' . $image['multi_image']) }}" alt="Images">
                        </div>
                        @endforeach
                    </div>
                    <div class="room-details-title">
                        <h2>{{  $room['roomtype']['name'] }}</h2>
                        <ul>
                            <li>
                               <b> Basic : €{{ $room->price }}/Night/Room</b>
                            </li> 
                        </ul>
                    </div>
                    <div class="room-details-content">
                        <p>{!!  $room->description !!}</p>
                        <div class="side-bar-plan">
                            <h3>Basic Plan Facilities</h3>
                            <ul>
                                @foreach($facilities as $facility)
                                <li><a>{{ $facility['facility_name'] }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="row"> 
                            <div class="col-lg-6">
                                <div class="services-bar-widget">
                                    <h3 class="title">Room Details</h3>
                                    <div class="side-bar-list">
                                        <ul>
                                            <li>
                                                <a> <b>Capacity : </b> {{  $room->room_capacity }} Person <i class='bx bxs-cloud-download'></i></a>
                                            </li>
                                            <li>
                                                <a> <b>Size : </b> {{  $room->size }}m2 <i class='bx bxs-cloud-download'></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="services-bar-widget">
                                    <h3 class="title">Room Details</h3>
                                    <div class="side-bar-list">
                                        <ul>
                                            <li>
                                                <a> <b>View : </b> {{  $room->view }} <i class='bx bxs-cloud-download'></i></a>
                                            </li>
                                            <li>
                                                <a> <b>Bad Style : </b> {{  $room->bed_style }} <i class='bx bxs-cloud-download'></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div> 
                            </div> 
                        </div>
                    </div>
                    <div class="room-details-review">
                        <h2>Clients Review and Retting's</h2>
                        <div class="review-ratting">
                            <h3>Your retting: </h3>
                            <i class='bx bx-star'></i>
                            <i class='bx bx-star'></i>
                            <i class='bx bx-star'></i>
                            <i class='bx bx-star'></i>
                            <i class='bx bx-star'></i>
                        </div>
                        <form >
                            <div class="row">
                                <div class="col-lg-12 col-md-12">
                                    <div class="form-group">
                                        <textarea name="message" class="form-control"  cols="30" rows="8" required data-error="Write your message" placeholder="Write your review here.... "></textarea>
                                    </div>
                                </div>

                                <div class="col-lg-12 col-md-12">
                                    <button type="submit" class="default-btn btn-bg-three">
                                        Submit Review
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Room Details Area End -->

<!-- Room Details Other -->
<div class="room-details-other pb-70">
    <div class="container">
        <div class="room-details-text">
            <h2>Other Rooms</h2>
        </div>

        <div class="row ">
            @foreach($otherRooms as $otherRoom)
            <div class="col-lg-6">
                <div class="room-card-two">
                    <div class="row align-items-center">
                        <div class="col-lg-5 col-md-4 p-0">
                            <div class="room-card-img">
                                <a href="{{  route('room.details', $otherRoom['id']) }}">
                                    <img src="{{ asset('upload/room_images/' . $otherRoom['image']) }}" alt="Images">
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-7 col-md-8 p-0">
                            <div class="room-card-content">
                                 <h3>
                                     <a href="{{  route('room.details', $otherRoom['id']) }}">{{ App\Models\Room::find($otherRoom['id'])['roomtype']['name'] }}</a>
                                </h3>
                                <span>{{ $otherRoom['price'] }} / Per Night </span>
                                <div class="rating">
                                    <i class='bx bxs-star'></i>
                                    <i class='bx bxs-star'></i>
                                    <i class='bx bxs-star'></i>
                                    <i class='bx bxs-star'></i>
                                    <i class='bx bxs-star'></i>
                                </div>
                                <p>>{{ $otherRoom['short_descr'] }}</p>
                                <ul>
                                    <li><i class='bx bx-user'></i> >{{ $otherRoom['room_capacity'] }} Person</li>
                                    <li><i class='bx bx-expand'></i> >{{ $otherRoom['size'] }}m2 </li>
                                </ul>

                                <ul>
                                    <li><i class='bx bx-show-alt'></i>>{{ $otherRoom['view'] }}</li>
                                    <li><i class='bx bxs-hotel'></i> >{{ $otherRoom['bed_style'] }}</li>
                                </ul>
                                
                                <a href="{{ route('room.details', $otherRoom['id']) }}" class="book-more-btn">
                                    Book Now
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
<!-- Room Details Other End -->

<script>
    $(document).ready(function () {
       var check_in = $("#check_in").val();
       var check_out = $("#check_out").val();
       var room_id = $("#room_id").val();
       if (check_in != '' && check_out != ''){
          getAvaility(check_in, check_out, room_id);
       }


       $("#check_out").on('change', function () {
          var check_out = $(this).val();
          var check_in = $("#check_in").val();

          if(check_in != '' && check_out != ''){
             getAvaility(check_in, check_out, room_id);
          }
       });

       $("#check_in").on('change', function () {
          var check_in = $(this).val();
          var check_out = $("#check_out").val();

          if(check_in != '' && check_out != ''){
             getAvaility(check_in, check_out, room_id);
          }
       });

       $("#numberOfRooms").on('change', function () {
          var check_out = $("#check_out").val();
          var check_in = $("#check_in").val();

          if(check_in != '' && check_out != ''){
             getAvaility(check_in, check_out, room_id);
          }
       });


    });



     function getAvaility(check_in, check_out, room_id) {
        $.ajax({
          url: "/booking/check-room-availability",
          data: {
            room_id:room_id,
            check_in:check_in, 
            check_out:check_out},
          success: function(data){
             $(".available_room").html('Availability : <span class="text-success">'+data['available_room']+' Rooms</span>');
             $("#available_room").val(data['available_room']);
             price_calculate(data['total_nights']);
          },
          error: function(stato){
            alert("Qualcosa è andato storto");
          }
       }); 
    }

    function price_calculate(total_nights){
       var room_price = $("#room_price").val();
       var discount_p = $("#discount_p").val();
       var select_room = $("#numberOfRooms").val();

       var sub_total = room_price * total_nights * parseInt(select_room);

       var discount_price = (parseInt(discount_p)/100)*sub_total;

       $(".t_subtotal").text(sub_total);
       $(".t_discount").text(discount_price);
       $(".t_g_total").text(sub_total-discount_price);

    }

    $("#bk_form").on('submit', function () {
       var avg_room = $("#available_room").val();
       var select_room = $("#numberOfRooms").val();
       if (parseInt(select_room) >  avg_room){
          alert('Sorry, you select maximum number of room');
          return false;
       }
       var number_person = $("#numberOfPerson").val();
       var total_adult = $("#total_adult").val();
       if(parseInt(number_person) > parseInt(total_adult)){
          alert('Sorry, you select maximum number of person');
          return false;
       }

    })
 </script>


@endsection
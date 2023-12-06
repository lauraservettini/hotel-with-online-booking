@extends('admin.admin_dashboard')

@section('admin')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Rooms</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Add Room List</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->
    <div class="container">
        <div class="main-body">
            <div class="row">
                <div>
                    <div class="card">
                        <div class="card-body p-4">
                            <form action="{{ route('store.room.list') }}" method="post" class="row g-3">
                                @csrf
                                <div class="col-xl-4">
                                    <label for="roomtype_id" class="form-label">Room Type</label>
                                    <select id="roomtype_id" name="room_id" class="form-select">
                                        <option selected>Select Room Type</option>
                                        @foreach( $roomTypes as $roomType)
                                        <option value="{{ $roomType->room->id }}" {{ collect(old('roomtype_id'))->contains($roomType->id)  ? 'selected' : '' }}> {{ $roomType->name   }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6  col-xl-4">
                                    <label for="check_in" class="form-label">Check in</label>
                                    <input type="date" name="check_in" class="form-control" id="check_in">
                                </div>
                                <div class="col-md-6  col-xl-4">
                                    <label for="check_out" class="form-label">Check out</label>
                                    <input type="date" name="check_out" class="form-control" id="check_out" >
                                </div>
                                <div class="col-md-4">
                                    <label for="numberOfRooms" class="form-label">Rooms</label>
                                    <input type="number" name="number_of_rooms" class="form-control" id="numberOfRooms">

                                    <div class="col-md-12 mt-2 mb-2">
                                        <input type="hidden" name="available_room" id="available_room">
                                        <p class="available_room"></p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="person" class="form-label">Guests</label>
                                    <input type="text" name="number_of_person" class="form-control" id="person">
                                </div>

                                <h3 class="mt-3 text-center">Customer Information</h3>

                                <div class="col-md-6 col-xl-4">
                                    <label for="username" class="form-label">Name</label>
                                    <input type="text" name="name" class="form-control" id="username" value="{{ old('name') }}">
                                </div>

                                <div class="col-md-6 col-xl-4">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control" id="email" value="{{ old('email') }}">
                                </div>

                                <div class="col-md-6 col-xl-4">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input type="email" name="phone" class="form-control" id="phone" value="{{ old('phone') }}">
                                </div>

                                <div class="col-md-6 col-xl-4">
                                    <label for="country" class="form-label">Country</label>
                                    <input type="text" name="country" class="form-control" id="country" value="{{ old('country') }}">
                                </div>

                                <div class="col-md-6 col-xl-4">
                                    <label for="state" class="form-label">State</label>
                                    <input type="text" name="state" class="form-control" id="state" value="{{ old('state') }}">
                                </div>

                                <div class="col-md-6 col-xl-4">
                                    <label for="zip_code" class="form-label">Zip Code</label>
                                    <input type="text" name="zip_code" class="form-control" id="zip_code" value="{{ old('zip_code') }}">
                                </div>
                    
                                <div class="col-md-12">
                                    <label for="address" class="form-label">Address</label>
                                    <textarea name="address" class="form-control" id="address" rows="3">{{ old('address') }}</textarea>
                                </div>

                                <div class="col-md-12">
                                    <div class="d-md-flex d-grid align-items-center gap-3">
                                        <button type="submit" class="btn btn-primary px-4">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
					</div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
       var check_in = $("#check_in").val();
       var check_out = $("#check_out").val();
       var room_id = $("#roomtype_id").val();

       $('#roomtype_id').on('change', function () {
          $('#check_in').val('');
          $('#check_out').val('');
          $('.available_room').text('');
          $('#available_room').val('');
          room_id = $(this).val();
       });
      
       if (check_in != '' && check_out != '' && room_id != ''){
          getAvaility(check_in, check_out, room_id);
       }


       $("#check_out").on('change', function () {
          var check_out = $(this).val();
          var check_in = $("#check_in").val();

          if(check_in != '' && check_out != '' && room_id != ''){
             getAvaility(check_in, check_out, room_id);
          }
       });

       $("#check_in").on('change', function () {
          var check_in = $(this).val();
          var check_out = $("#check_out").val();

          if(check_in != '' && check_out != '' && room_id != ''){
             getAvaility(check_in, check_out, room_id);
          }
       });
    });




     function getAvaility(check_in, check_out, room_id) {
        var startDate = new Date(check_in);
        var endDate = new Date(check_out);

        if(startDate >= endDate) {
            alert('Invalid check-in and check-out dates');
            $('#check_out').val('');
            return false;
        }

        $.ajax({
          url: "/booking/check-room-availability",
          data: {
            room_id:room_id,
            check_in:check_in, 
            check_out:check_out},
          success: function(data){
             $(".available_room").html('Availability : <span class="text-success">'+data['available_room']+' Rooms</span>');
             $("#available_room").val(data['available_room']);
          },
          error: function(stato){
            alert("Something went wrong");
          }
       }); 
    }

</script>

@endsection
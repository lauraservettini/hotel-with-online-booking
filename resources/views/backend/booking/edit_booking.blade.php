@extends('admin.admin_dashboard')

@section('admin')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Booking</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Update Booking</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->
    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-5">
        <div class="col">
            <div class="card radius-10 border-start border-0 border-3 border-info">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary">Booking N.</p>
                            <h6 class="my-1 text-info">{{ $booking->code }}</h6>
                        </div>
                        <div class="widgets-icons-2 rounded-circle bg-gradient-blues text-white ms-auto"><i class='bx bxs-cart'></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card radius-10 border-start border-0 border-3 border-danger">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                        <p class="mb-0 text-secondary">Booking Date</p>
                        <h6 class="my-1 text-danger">{{ \Carbon\Carbon::parse($booking->created_at)->format('d/m/Y') }}</h6>
                    </div>
                    <div class="widgets-icons-2 rounded-circle bg-gradient-burning text-white ms-auto"><i class='bx bxs-wallet'></i>
                    </div>
                </div>
            </div>
            </div>
        </div>
        <div class="col">
            <div class="card radius-10 border-start border-0 border-3 border-success">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                        <p class="mb-0 text-secondary">Payment method</p>
                        <h6 class="my-1 text-success">{{ $booking->payment_method }}</h6>
                    </div>
                    <div class="widgets-icons-2 rounded-circle bg-gradient-ohhappiness text-white ms-auto"><i class='bx bxs-bar-chart-alt-2' ></i>
                    </div>
                </div>
            </div>
            </div>
        </div>
        <div class="col">
            <div class="card radius-10 border-start border-0 border-3 border-warning">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                        <p class="mb-0 text-secondary">Payment Status</p>
                        <h6 class="my-1 text-warning">
                                @if($booking->payment_status == 1) 
                                    <span class="text-success">Complete</span>
                                @else
                                    <span class="text-warning">Pending</span>  
                                @endif
                        </h6>
                    </div>
                    <div class="widgets-icons-2 rounded-circle bg-gradient-orange text-white ms-auto"><i class='bx bxs-group'></i>
                    </div>
                </div>
            </div>
            </div>
        </div> 
        <div class="col">
            <div class="card radius-10 border-start border-0 border-3 border-warning">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                        <p class="mb-0 text-secondary">Order Status</p>
                        <h6 class="my-1 text-warning">
                                @if($booking->status == 1) 
                                    <span class="text-success">Complete</span>
                                @else
                                    <span class="text-warning">Pending</span>  
                                @endif
                        </h6>
                    </div>
                    <div class="widgets-icons-2 rounded-circle bg-gradient-orange text-white ms-auto"><i class='bx bxs-group'></i>
                    </div>
                </div>
            </div>
            </div>
        </div> 
    </div><!--end row-->

    <div class="row">
       <div class="col-12 col-xl-8">
          <div class="card radius-10 w-100">
              <div class="card-body">
                <!-- Table -->
                <div class="table-responsive">
                    <table class="table align-middle mb-2">
                        <thead class="table-light">
                            <tr>
                                <th>Room Type</th>
                                <th>Total Room</th>
                                <th>Price</th>
                                <th>Check-In/Out Date</th>
                                <th>Total Days</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $booking['room']['roomType']['name'] }}</td>
                                <td>{{ $booking->number_of_rooms }}</td>
                                <td>€ {{ $booking->actual_price }}</td>
                                <td><span class="badge bg-primary">{{ $booking->check_in }}</span> / </br> <span class="badge bg-warning text-dark"> {{ $booking->check_out  }} </span></td>
                                <td>{{ $booking->total_night }}</td>
                                <td>€ {{ $booking->total_price }}</td>
                            </tr>
                        <tbody>

                    </table>
                    <div class="col-md-6 mb-3 " style="float: right">
                        <style> 
                            .test_table td { text-align: right; }
                        </style>
                        <table class="table test_table" style="float: right" border="none">
                           
                            <tr>
                                <th>Subtotal</th>
                                <td>{{ $booking->subtotal }}</td>
                            </tr>
                            <tr>
                                <th>Discount</th>
                                <td>{{ $booking->discount  }}</td>
                            </tr>
                            <tr>
                                <th>Total</th>
                                <td>{{ $booking->total_price  }}</td>
                            </tr>
                           

                        </table>
                    </div>
                    <div class="mb-3" style="clear:both;"></div>
                    <div class="mb-4">
                        <a href="javascript::void(0)" class="btn btn-primary assign_room">Assign Room</a>
                    </div>
                </div>
                <!-- Table End -->

                <!-- Form -->
                <form action="{{ route('update.booking.status', $booking->id) }}" method="POST">
                    @csrf

                    <div class="row" >
                        <div class="col-md-6 mb-3">
                            <label for="status" class="form-label">Payment Status</label>
                                <select id="payment_status" name="payment_status" class="form-select" >
                                    <option selected="">Select status...</option>
                                    <option value="1" {{$booking->payment_status == '1'?'selected':''}}>Complete</option>
                                    <option value="0" {{$booking->payment_status == '0'?'selected':''}}>Pending</option>
                                </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="status" class="form-label">Booking Status</label>
                                <select id="status" name="status" class="form-select" >
                                    <option selected="">Select status...</option>
                                    <option value="1" {{$booking->status == '1'?'selected':''}}>Complete</option>
                                    <option value="0" {{$booking->status == '0'?'selected':''}}>Pending</option>
                                </select>
                        </div>
                        <div class="col-md-12 mb-3">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </div>
                </form>
                <!-- Form End -->

              </div>
          </div>
       </div>
       <div class="col-12 col-xl-4">
           <div class="card radius-10 w-100">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <div>
                            <h6 class="mb-0">Manage Room adn Date</h6>
                        </div>
                        
                    </div>
                </div>
                <div class="card-body">
                        <!-- Form -->
                    <form action="{{ route('update.booking.date', $booking->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="available_room" class="form-control" value="{{ $booking->number_of_rooms }}">
                        <input type="hidden" name="room_id" id="room_id" class="form-control" value="{{ $booking->room_id }}">
                        <div class="row" >
                            <div class="col-md-12 mb-2">
                                <label for="check_in" class="form-label">Check In</label>
                                <input type="date" name="check_in" id="check_in" class="form-control" 
                                value="{{ $booking->check_in }}" required/>
                            </div>
                            <div class="col-md-12 mb-2">
                                <label for="check_out" class="form-label">Check Out</label>
                                <input type="date" name="check_out" id="check_out" class="form-control" 
                                value="{{ $booking->check_out }}" required/>
                            </div>
                            <div class="col-md-12 mb-2">
                                <label for="numberOfRooms" class="form-label">Room</label>
                                <input type="number" name="number_of_rooms" id="numberOfRooms" class="form-control" 
                                value="{{ $booking->number_of_rooms }}" required/>
                            </div>
                            <div class="col-md-12 mb-2">
                                <input type="hidden" name="available_room" id="available_room">
                                <p class="available_room"></p>
                            </div>
                            <div class="col-md-12 mb-2">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </div>
                    </form>
                    <!-- Form End -->
                </div>
               
           </div>
           <div class="card radius-10 w-100">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <div>
                            <h6 class="mb-0">Customer</h6>
                        </div>
                        
                    </div>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center mb-2">Name: <span class="badge bg-primary rounded-pill">{{ $booking['user']['name'] }}<span></li>
                        <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center mb-2">Email: <span class="badge bg-danger rounded-pill">{{ $booking['user']['email'] }}<span></label>
                        <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center mb-2">Phone: <span class="badge bg-info rounded-pill">{{ $booking->phone }}<span></li>
                        <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center mb-2">Country: <span class="badge bg-success rounded-pill">{{ $booking->country }}<span></li>
                        <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center mb-2">State: <span class="badge bg-danger rounded-pill">{{ $booking->state }}<span></li>
                        <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center mb-2">Zip Code: <span class="badge bg-info rounded-pill">{{ $booking->zip_code }}<span></li>
                        <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center mb-2">Address: <span class="badge bg-primary rounded-pill">{{ $booking->address }}<span></li>
                    </ul>
                </div>
               
           </div>
       </div>
    </div><!--end row-->

</div>

<!-- Modal -->
    <div class="modal fade myModal" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Room</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body"></div>
            </div>
        </div>
    </div>
<!-- Modal End -->
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

</script>

@endsection
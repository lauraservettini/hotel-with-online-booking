@extends('admin.admin_dashboard')

@section('admin')

<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
         
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Booking</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <div class="btn-group">
                @if(Auth::user()->can('booking.add'))
                <a href="{{ route('add.team')}}" class="btn btn-primary px-5">Add Booking </a>
                @endif
                
            </div>
        </div>
    </div>
    <!--end breadcrumb-->
    
    <h6 class="mb-0 text-uppercase">Bookings</h6>
    <hr/>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="example" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>Serial N.</th>
                            <th>Booking code</th>
                            <th>Booking Date</th>
                            <th>Customer</th>
                            <th>Room</th>
                            <th>Check in/out</th>
                            <th>Total Rooms</th>
                            <th>Guests</th>
                            <th>Payment</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($allBookings as $key => $booking)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td><a href="{{ route('edit.booking', $booking->id) }}" class="btn btn-info px-3 radius-30">{{ $booking->code }}<a></td>
                            <td>{{ $booking->created_at }}</td>
                            <td>{{ $booking['user']['name'] }}</td>
                            <td>{{ $booking['room']['roomType']['name'] }}</td>
                            <td><span class="badge bg-primary">{{ $booking->check_in }}</span> / </br> <span class="badge bg-warning text-dark"> {{ $booking->check_out  }} </span></td>
                            <td>{{ $booking->number_of_rooms }}</td>
                            <td>{{ $booking->person }}</td>
                            <td
                                @if($booking->payment_status == 1) 
                                    <span class="text-success">Complete</span>
                                @else
                                    <span class="text-warning">Pending</span>  
                                @endif
                            </td>
                            <td>
                                @if($booking->status == 1) 
                                    <span class="text-success">Active</span>
                                @else
                                    <span class="text-warning">Pending</span>  
                                @endif
                            </td>

                            <td>
                                @if(Auth::user()->can('booking.add'))
                                <a href="" id="delete" class="btn btn-danger px-3 radius-30">Delete</a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
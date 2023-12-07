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
                    <li class="breadcrumb-item active" aria-current="page">Report</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <div class="btn-group">
                <a href="{{ route('booking.report')}}" class="btn btn-primary px-5">Search By Date</a>
                
            </div>
        </div>
    </div>
    <!--end breadcrumb-->

    <h6 class="mb-0 text-uppercase">All Bookings From <span class="badge bg-primary">{{ $startDate }}</span> to <span class="badge bg-warning">{{ $endDate }}</span></h6>
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
                            <th>Email</th>
                            <th>Check in/out</th>
                            <th>Payment Method</th>
                            <th>Total Price</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bookings as $key => $booking)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td><a href="{{ route('edit.booking', $booking->id) }}" class="btn btn-info px-3 radius-30">{{ $booking->code }}<a></td>
                            <td>{{ $booking->created_at }}</td>
                            <td>{{ $booking->name }}</td>
                            <td><span class="badge bg-success">{{ $booking->email }}</span></td>
                            <td><span class="badge bg-danger">{{ $booking->check_in }}</span> / </br> <span class="badge bg-warning text-dark"> {{ $booking->check_out  }} </span></td>
                            <td
                                @if($booking->payment_method == 'COD') 
                                    <span class="text-success">Cash On Delivery</span>
                                @else
                                    <span class="text-success">Stripe</span>  
                                @endif
                            </td>
                            <td>{{ $booking->total_price }}</td>
                            <td>
                                <a href="{{ route('download.invoice', $booking->id) }}" class="btn btn-warning px-3 rounded"><i class="lni lni-download"></i>Download Invoice</a>
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
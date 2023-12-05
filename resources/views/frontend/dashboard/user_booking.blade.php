@extends('frontend.main_master')

@section('master')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

        <!-- Inner Banner -->
        <div class="inner-banner inner-bg6">
            <div class="container">
                <div class="inner-title">
                    <ul>
                        <li>
                            <a href="index.html">Home</a>
                        </li>
                        <li><i class='bx bx-chevron-right'></i></li>
                        <li>User Dashboard </li>
                    </ul>
                    <h3>User Bookings</h3>
                </div>
            </div>
        </div>
        <!-- Inner Banner End -->

        <!-- Service Details Area -->
        <div class="service-details-area pt-100 pb-70">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3">
                        @include('frontend.dashboard.user_sidebar')
                    </div>
        
                    <div class="col-lg-9">
                        <div class="service-article">
                            <section class="checkout-area pb-70">
                                <div class="container">
                                    <form action="{{ route('update.password') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                
                                        <div class="card-body">
                                            
                                            <div class="col-sm-3">
                                                <h3 class="mb-0">User Bookings</h3>
                                            </div>
                                            
                                            <div class="row mb-3">
                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">B. No</th>
                                                            <th scope="col">B. Date</th>
                                                            <th scope="col">Customer</th>
                                                            <th scope="col">Room</th>
                                                            <th scope="col">Check In/Out</th>
                                                            <th scope="col">Total Rooms</th>
                                                            <th scope="col">Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($bookings as $booking)
                                                        <tr>
                                                            <td>
                                                                @if($booking->status == 1)
                                                                <a href="{{ route('user.invoice', $booking->id) }}" > 
                                                                <span class="badge bg-success">
                                                                @endif
                                                                {{ $booking->code }}
                                                                @if($booking->status == 1)
                                                                </span>
                                                                </a>
                                                                @endif
                                                                </td>
                                                            <td>{{ $booking->created_at->format('d/m/Y') }}</td>
                                                            <td>{{ $booking['user']['name'] }}</td>
                                                            <td>{{ $booking['room']['roomType']['name'] }}</td>
                                                            <td><span class="badge bg-primary">{{ $booking->check_in }} </span></br>
                                                             <span class="badge bg-warning">{{ $booking->check_out }}</span></td>
                                                            <td>{{ $booking->number_of_rooms }}</td>
                                                            <td>
                                                                @if($booking->status == 1)
                                                                    <span class="badge bg-success">Complete</span>
                                                                @else
                                                                    <span class="badge bg-info text-dark">Pending</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Service Details Area End-->

@endsection
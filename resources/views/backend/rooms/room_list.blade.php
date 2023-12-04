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
                    <li class="breadcrumb-item active" aria-current="page">Rooms</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <div class="btn-group">
                <a href="" class="btn btn-primary px-5">Add Booking </a>
                
            </div>
        </div>
    </div>
    <!--end breadcrumb-->
    <h6 class="mb-0 text-uppercase">All Team</h6>
    <hr/>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="example" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>Serial N.</th>
                            <th>Room Type</th>
                            <th>Room Number</th>
                            <th>B. Status</th>
                            <th>In/Out Date</th>
                            <th>Customer</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($roomNumberList as $key =>$roomNumber)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $roomNumber->name }}</td>
                            <td>{{ $roomNumber->room_no }}</td>
                            <td>
                            @if ($roomNumber->booking_id != "")
                                @if ($roomNumber->booking_status == 1)
                                    <span class="badge bg-danger">Booked</span>
                                @else
                                    <span class="badge bg-warning">Pending</span>
                                @endif
                            @else
                                <span class="badge bg-success">Available</span>
                            @endif
                            </td>
                            <td>
                            @if ($roomNumber->booking_id != "")
                                <span class="badge rounded-pill bg-secondary">{{ date('d-m-Y', strtotime($roomNumber->check_in)) }}</span>
                                to
                                <span class="badge rounded-pill bg-secondary">{{ date('d-m-Y', strtotime($roomNumber->check_out)) }}</span>
                            @endif
                            </td>
                            <td>
                             @if ($roomNumber->booking_id != "")
                                {{ $roomNumber->booking_no }}
                             @endif
                            </td>
                            <td>
                            @if ($roomNumber->booking_id != "")
                                {{ $roomNumber->customer_name }}
                             @endif
                            </td>
                            <td>
                            @if ($roomNumber->status == "Active")
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-danger">Inactive</span>
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
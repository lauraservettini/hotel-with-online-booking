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
                    <li class="breadcrumb-item active" aria-current="page">Testimonials</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <div class="btn-group">
                <a href="{{ route('add.testimonial')}}" class="btn btn-primary px-5">Add Testimonials </a>
                
            </div>
        </div>
    </div>
    <!--end breadcrumb-->

    <h6 class="mb-0 text-uppercase">All Testimonials</h6>
    <hr/>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="example" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>Serial N.</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>City</th>
                            <th>Message</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($testimonials as $key => $testimonial)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td><img src="{{asset($testimonial->image) }}" alt="{{ $testimonial->name }}" style="width:40px; height:40px"></td>
                            <td>{{ $testimonial->name }}</td>
                            <td>{{ $testimonial->city }}</td>
                            <td>{{ $testimonial->message }}</td>
                            <td>
                                <a href="{{ route('update.testimonial', $testimonial->id)}}" class="btn btn-warning px-3 radius-30">Edit</a>
                                <a href="{{ route('delete.testimonial', $testimonial->id)}}" id="delete" class="btn btn-danger px-3 radius-30">Delete</a>
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
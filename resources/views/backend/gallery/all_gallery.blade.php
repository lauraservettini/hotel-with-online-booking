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
                    <li class="breadcrumb-item active" aria-current="page">Gallery</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <div class="btn-group">
                <a href="{{ route('add.gallery')}}" class="btn btn-primary px-5">Add Gallery</a>
                
            </div>
        </div>
    </div>
    <!--end breadcrumb-->

    <h6 class="mb-0 text-uppercase">All Gallery</h6>
    <hr/>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <form action="{{ route('delete.selected.gallery') }}" method="post">
                    @csrf
                    
                    <table class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th width="50px">Select</th>
                                <th width="50px">Serial N.</th>
                                <th>Image</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($galleries as $key => $gallery)
                            <tr>
                                <td>
                                    <input type="checkbox" name="selectedItem[]" value="{{ $gallery->id }}" >
                                    </td>
                                <td>{{ $key + 1 }}</td>
                                <td><img src="{{ asset($gallery->photo_name) }}" alt="gallery image" style="width:40px; height:40px"></td>
                                <td>
                                    <a href="{{ route('edit.gallery', $gallery->id) }}" class="btn btn-warning px-3 radius-30">Edit</a>
                                    <a href="{{ route('delete.gallery', $gallery->id) }}" id="delete" class="btn btn-danger px-3 radius-30">Delete</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <button type="submit" class="btn btn-danger">Delete Selected</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
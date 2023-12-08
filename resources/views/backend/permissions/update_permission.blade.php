@extends('admin.admin_dashboard')

@section('admin')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Permissions</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Update Permission</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->
    <div class="container">
        <div class="main-body">
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <form action="{{ route('update.permission', $permission->id ) }}" method="POST">
                            @csrf
    
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Permission Name</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="text" name="name" class="form-control" value="{{ $permission->name }}" @error('name') is-invalid @enderror>
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Permission Group</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <select class="form-select mb-3" name="group_name" aria-label="Default select example" @error('group_name') is-invalid @enderror>
                                            <option selected="">Select Group </option>
                                            <option value="Team" {{ $permission->group_name == 'Team' ? 'selected' : '' }}>Team </option>
                                            <option value="Book Area" {{ $permission->group_name == 'Book Area' ? 'selected' : '' }}>Book Area</option>
                                            <option value="Manage Room" {{ $permission->group_name == 'Manage Room' ? 'selected' : '' }}>Manage Room</option>
                                            <option value="Booking" {{ $permission->group_name == 'Booking' ? 'selected' : '' }}>Booking</option>
                                            <option value="RoomList" {{ $permission->group_name == 'RoomList' ? 'selected' : '' }}>RoomList</option>
                                            <option value="Setting" {{ $permission->group_name == 'Setting' ? 'selected' : '' }}>Setting</option>
                                            <option value="Tesimonial" {{ $permission->group_name == 'Tesimonial' ? 'selected' : '' }}>Tesimonial</option>
                                            <option value="Blog" {{ $permission->group_name == 'Blog' ? 'selected' : '' }}>Blog</option>
                                            <option value="Manage Comment" {{ $permission->group_name == 'Manage Comment' ? 'selected' : '' }}>Manage Comment</option>
                                            <option value="Booking Report" {{ $permission->group_name == 'Booking Report' ? 'selected' : '' }}>Booking Report </option>
                                            <option value="Hotel Gallery" {{ $permission->group_name == 'Hotel Gallery' ? 'selected' : '' }}>Hotel Gallery </option>
                                            <option value="Contact Message" {{ $permission->group_name == 'Contact Message' ? 'selected' : '' }}>Contact Message </option>
                                            <option value="Role and Permission" {{ $permission->group_name == 'Role and Permission' ? 'selected' : '' }}>Role and Permission </option>
                                        </select>
                                        @error('group_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-3"></div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="submit" class="btn btn-primary px-4" value="Save Changes" />
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
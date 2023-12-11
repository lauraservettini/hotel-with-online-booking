@extends('admin.admin_dashboard')

@section('admin')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

 <style>
    .form-check-label{
        text-transform: capitalize;
    }
 </style>

<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Roles</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Update Roles Permission</li>
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
                        <form action="{{ route('update.roles.permission', $role->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
    
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Roles Name</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <h3>{{ $role->name }}</h3>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class=" text-secondary">
                                        <input class="form-check-input" id="CheckDefaultmain" type="checkbox">
                                        <label class="form-check-label" for="CheckDefaultmain">All Permissions</label>
                                        
                                    </div>
                                    <hr>

                                @foreach ($permissionGroups as $group) 
                                    <div class="row"> 
                                        <div class="col-3">
                                            @php
                                                $permissions = App\Models\User::getPermissionByGroupName($group->group_name);
                                                $checked = App\Models\User::roleHasGroupPermissions($role,$permissions);
                                            @endphp

                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="checkDefault" {{ $checked ? 'checked' : '' }}>
                                                <label class="form-check-label" for="checkDefault"> {{ $group->group_name }} </label>
                                            </div>

                                        </div>

                                        <div class="col-9">
                                            @foreach ($permissions as $permission) 
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="permission[]" id="checkDefault{{ $permission->id  }}" value="{{ $permission->name }}"
                                                {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}>

                                                <label class="form-check-label" for="checkDefault{{ $permission->id }}">{{ $permission->name }} </label>
                                            </div>
                                            @endforeach
                                            <hr>
                                        </div>

                                    </div>
                                @endforeach
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

<script>
    $('#CheckDefaultmain').click(function(){
        if ($(this).is(':checked')) {
           $('input[ type= checkbox]').prop('checked',true); 
        }else{
            $('input[ type= checkbox]').prop('checked',false); 
        }
    });
 </script>

@endsection
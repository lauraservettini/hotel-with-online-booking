@extends('admin.admin_dashboard')

@section('admin')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Settings</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Site Settings</li>
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
                    <form action="{{ route('update.site.settings') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="card-body">
                                <input type="hidden" name="id" class="form-control" value="{{ (!empty($site->id)) ? $site->id : '' }}">
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <h6 class="mb-0">Phone</h6>
                                </div>
                                <div class="col-md-9 text-secondary">
                                    <input type="text" name="phone" class="form-control" value="{{ (!empty($site->phone)) ? $site->phone : '' }}" @error('phone') is-invalid @enderror />
                                    @error('phone')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <h6 class="mb-0">Email</h6>
                                </div>
                                <div class="col-md-9 text-secondary">
                                    <input type="text" name="email" class="form-control" value="{{ (!empty($site->email)) ? $site->email : '' }}" @error('email') is-invalid @enderror />
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <h6 class="mb-0">Facebook</h6>
                                </div>
                                <div class="col-md-9 text-secondary">
                                    <input type="text" name="facebook" class="form-control" value="{{ (!empty($site->facebook)) ? $site->facebook : '' }}" @error('facebook') is-invalid @enderror />
                                    @error('facebook')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <h6 class="mb-0">Twitter</h6>
                                </div>
                                <div class="col-md-9 text-secondary">
                                    <input type="text" name="twitter" class="form-control" value="{{ (!empty($site->twitter)) ? $site->twitter : '' }}" @error('twitter') is-invalid @enderror />
                                    @error('twitter')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <h6 class="mb-0">Address</h6>
                                </div>
                                <div class="col-md-9 text-secondary">
                                    <input type="text" name="address" class="form-control" value="{{ (!empty($site->address)) ? $site->address : '' }}" @error('address') is-invalid @enderror />
                                    @error('address')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <h6 class="mb-0">Copyright</h6>
                                </div>
                                <div class="col-md-9 text-secondary">
                                    <input type="text" name="copyright" class="form-control" value="{{ (!empty($site->copyright)) ? $site->copyright : '' }}" @error('copyright') is-invalid @enderror />
                                    @error('copyright')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <h6 class="mb-0">Logo</h6>
                                </div>
                                <div class="col-md-9 text-secondary">
                                    <input type="file" id="image" name="logo" class="form-control" @error('logo') is-invalid @enderror />
                                    @error('logo')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <img id='showImage' src="{{ (!empty($site->logo)) ? asset($site->logo) : url('upload/no_image.jpg') }}" alt="" style="width:100px; height:100px;">
                                </div>
                            </div>
                           
                            <div class="row">
                                <div class="col-md-3"></div>
                                <div class="col-md-9 text-secondary">
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

<script type="text/javascript">
    $(document).ready(function(){
        $('#image').change(function(e){
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#showImage').attr('src', e.target.result);
            }
            reader.readAsDataURL(e.target.files['0']);
        });
    });
</script>

@endsection
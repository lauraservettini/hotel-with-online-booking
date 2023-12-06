 @extends('admin.admin_dashboard')

@section('admin')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Blog</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Update Blog Post</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->
    <div class="container">
        <div class="main-body">
            <div class="row">
                <div>
                    <div class="card">
                        <div class="card-body p-4">
                            <form action="{{ route('update.blog.post', $post->id) }}" method="post" enctype="multipart/form-data" class="row g-3">
                                @csrf
                                <div class="col-xl-6">
                                    <label for="blogCategory" class="form-label">Blog Category</label>
                                    <select id="blogCategory" name="category_id" class="form-select">
                                         <option selected>Select Category</option>
                                        @foreach($categories as $category)
                                        <option value="{{ $category->id}}" {{ ($post->category_id == $category->id) ? 'selected' : '' }} > {{ $category->category_name  }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-xl-6">
                                    <label for="postTitle" class="form-label">Post Title</label>
                                    <input type="text" name="post_title" class="form-control" value="{{ $post->post_title }}" id="postTitle" @error('post_title') is-invalid @enderror />
                                        @error('post_title')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                </div>
                                <div >
                                    <label for="shortDescr" class="form-label">Short Description</label>
                                    <textarea name="short_descr" class="form-control" id="shortDescr" rows="3" @error('post_title') is-invalid @enderror >{{ $post->short_descr }}</textarea>
                                        @error('short_descr')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="myeditorinstance" class="form-label">Description</label>
                                    <textarea name="long_descr" class="form-control" id="myeditorinstance" rows="3" @error('post_title') is-invalid @enderror >{!! $post->long_descr !!}</textarea>
                                        @error('long_descr')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                </div>
                                <div class="row mb-3 col-xl-9">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Photo</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="file" name="post_image" class="form-control" id="image" @error('post_image') is-invalid @enderror />
                                        @error('post_image')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0"></h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <img id="showImage" src="{{ $post->post_image ? url($post->post_image) : url('upload/no_image.jpg') }}" alt="Admin" class="rounded-circle p-1 bg-primary" width="80">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="d-md-flex d-grid align-items-center gap-3">
                                        <button type="submit" class="btn btn-primary px-4">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
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
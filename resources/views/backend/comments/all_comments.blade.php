@extends('admin.admin_dashboard')
@section('admin')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<style>
    .large-checkbox {
        transform: scale(1.5);
    }
</style>

<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
         
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Comments</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <div class="btn-group">
                
            </div>
        </div>
    </div>
    <!--end breadcrumb-->

    <h6 class="mb-0 text-uppercase">All Comments</h6>
    <hr/>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="example" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>Serial N.</th>
                            <th>User Name</th>
                            <th>Post Name</th>
                            <th>Message</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($comments as $key => $comment)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $comment->user->name }}</td>
                            <td>{{ Str::limit($comment->post->post_title, 20) }}</td>
                            <td>{{ Str::limit($comment->message, 40) }}</td>
                            <td>
                                <div class="form-check form-check-danger form-switch">
                                    <input class="form-check-input status-toggle large-checkbox" type="checkbox" 
                                    role="switch" id="flexSwitchCheckDanger" data-comment-id="{{ $comment->id}}"  {{ $comment->status ? 'checked' : '' }}>
                                    <label class="form-check-label" for="flexSwitchCheckDanger"></label>
							  </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $('.status-toggle').on('change', function(){
            var commentId = $(this).data('comment-id');

            // Send an ajax request to update status 
            $.ajax({
                url: "{{ route('update.comment.status') }}",
                method: "POST",
                data: {
                    comment_id: commentId,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response){
                    toastr.success(response.message);
                },
                error: function(){
                }
            }); 
        });
    });
</script>

@endsection
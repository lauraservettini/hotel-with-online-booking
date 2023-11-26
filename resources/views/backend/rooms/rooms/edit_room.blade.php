@extends('admin.admin_dashboard')

@section('admin')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Room</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Update Room</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->
    <div class="container">
        <div class="main-body">
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <ul class="nav nav-tabs nav-primary" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" data-bs-toggle="tab" href="#manageRoom" role="tab" aria-selected="true">
                                    <div class="d-flex align-items-center">
                                        <div class="tab-icon"><i class="bx bx-home font-18 me-1"></i>
                                        </div>
                                        <div class="tab-title">Manage Room</div>
                                    </div>
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" data-bs-toggle="tab" href="#roomNumber" role="tab" aria-selected="false">
                                    <div class="d-flex align-items-center">
                                        <div class="tab-icon"><i class="bx bx-user-pin font-18 me-1"></i>
                                        </div>
                                        <div class="tab-title">Room Number</div>
                                    </div>
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content py-3">
                            <div class="tab-pane fade show active" id="manageRoom" role="tabpanel">
                                <div class="card">
                                    <div class="card-body p-4">
                                        <h5 class="mb-4">Update Room</h5>
                                        <form class="row g-3" action="{{ route('update.room', $room->id) }}" method="POST"enctype="multipart/form-data">
                                            @csrf

                                            <div class="col-md-4">
                                                <label for="roomtype_id" class="form-label">Room Type Name</label>
                                                <input type="text" name="roomtype_id" class="form-control" id="roomtype_id" value="{{ $room['roomType']['name'] }}">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="total_adult" class="form-label">Total Adult</label>
                                                <input type="number" name="total_adult" class="form-control" id="total_adult" value="{{ $room->total_adult }}">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="total_child" class="form-label">Total Children</label>
                                                <input type="number" name="total_child" class="form-control" id="total_child" value="{{ $room->total_child }}">
                                            </div>
                                            <div class="col-md-5 p-2 bg-light rounded">
                                                <label for="image" class="form-label">Main Image</label>
                                                <input type="file" name="image" class="form-control mb-2" id="image">
                                                <img id="showImage" src="{{ (!empty($room->image)) ? url('upload/room_images/' . $room->image) : url('upload/no_image.jpg'); }}" alt="Team" class="rounded bg-primary" width="60" height="50px">
                                            </div>
                                            <div class="col-0 col-md-1">
                                            </div>
                                            <div class="col-md-6 p-2 bg-light rounded">
                                                <label for="multi_image" class="form-label">Gallery Image</label>
                                                <input type="file" name="multi_image[]" class="form-control mb-2" id="multi_image" multiple accept="image/jpeg, image/jpg, image/png, image/gif">
                                                
                                                @foreach($multi_images as $image)
                                                    <img src="{{ !empty($image['multi_image']) ? url('upload/room_images/multi_img/' . $image['multi_image']) : url('upload/no_image.jpg') }}" alt="Team" class="rounded bg-primary mb-1" width="60" height="50px">
                                                    <a href="{{  route('multi.images.delete', $image['id']) }}"><i class="lni lni-close me-2"></i></a>
                                                @endforeach

                                                <div class="row" id="preview_img"></div>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="input5price" class="form-label">Price</label>
                                                <input type="number" name="price" class="form-control" id="price" value="{{ $room->price }}">
                                            </div>
                                            <div class="col-md-3">
                                                <label for="discount" class="form-label">Discount (%)</label>
                                                <input type="number" name="discount" class="form-control" id="discount" value="{{ $room->discount }}">
                                            </div>
                                            <div class="col-md-3">
                                                <label for="size" class="form-label">Size</label>
                                                <input type="number" name="size" class="form-control" id="size" value="{{ $room->size }}">
                                            </div>
                                            <div class="col-md-3">
                                                <label for="room_capacity" class="form-label">Room Capacity</label>
                                                <input type="number" name="room_capacity" class="form-control" id="room_capacity" value="{{ $room->room_capacity }}">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="view" class="form-label">Room View</label>
                                                <select id="view" name="view" class="form-select">
                                                    <option selected="">Choose...</option>
                                                    <option value="Sea View" {{$room->view == 'Sea View'?'selected':''}}>Sea View</option>
                                                    <option value="Hill View" {{$room->view == 'Hill View'?'selected':''}}>Hill View</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="bed_style" class="form-label">Bed Style</label>
                                                <select id="bed_style" name="bed_style" class="form-select">
                                                    <option selected="">Choose...</option>
                                                    <option value="Queen Bed" {{$room->bed_style == 'Queen Bed'?'selected':''}}>Queen Bed<option>
                                                    <option value="Twin Bed" {{$room->bed_style == 'Twin Bed'?'selected':''}}>Twin Bed</option>
                                                    <option value="King Bed" {{$room->bed_style == 'King Bed'?'selected':''}}>King Bed</option>
                                                </select>
                                            </div>
                                            
                                            <div class="col-md-12">
                                                <label for="short_descr" class="form-label">Short Description</label>
                                                <textarea class="form-control" name="short_descr" id="short_descr" rows="3">{!! $room->short_descr !!}</textarea>
                                            </div>
                                            <div class="col-md-12">
                                                <label for="myeditorinstance" class="form-label">Description</label>
                                                <textarea class="form-control" name="description" id="myeditorinstance" rows="3">{!! $room->description !!}</textarea>
                                            </div>

                                            <div class="row mt-2">
                                                <div class="col-md-12 mb-3">
                                                   @forelse ($basic_facility as $item)
                                                        <div class="basic_facility_section_remove" id="basic_facility_section_remove">
                                                            <div class="row add_item">
                                                                <div class="col-md-8">
                                                                    <label for="facility_name" class="form-label"> Room Facilities </label>
                                                                    <select name="facility_name[]" id="facility_name" class="form-control">
                                                                        <option value="">Select Facility</option>

                                                                        <option value="Complimentary Breakfast" {{$item['facility_name'] == 'Complimentary Breakfast'?'selected':''}}>Complimentary Breakfast</option>

                                                                        <option value="32/42 inch LED TV"  {{$item['facility_name'] == 'Complimentary Breakfast'?'selected':''}}> 32/42 inch LED TV</option>
                                                                    
                                                                        <option value="Smoke alarms"  {{$item['facility_name'] == 'Smoke alarms'?'selected':''}}>Smoke alarms</option>
                                                                    
                                                                        <option value="Minibar" {{$item['facility_name'] == 'Complimentary Breakfast'?'selected':''}}> Minibar</option>
                                                                    
                                                                        <option value="Work Desk"  {{$item['facility_name'] == 'Work Desk'?'selected':''}}>Work Desk</option>
                                                                    
                                                                        <option value="Free Wi-Fi" {{$item['facility_name'] == 'Free Wi-Fi'?'selected':''}}>Free Wi-Fi</option>
                                                                    
                                                                        <option value="Safety box" {{$item['facility_name'] == 'Safety box'?'selected':''}} >Safety box</option>
                                                                    
                                                                        <option value="Rain Shower" {{$item['facility_name'] == 'Rain Shower'?'selected':''}} >Rain Shower</option>
                                                                    
                                                                        <option value="Slippers" {{$item['facility_name'] == 'Slippers'?'selected':''}} >Slippers</option>
                                                                    
                                                                        <option value="Hair dryer" {{$item['facility_name'] == 'Hair dryer'?'selected':''}} >Hair dryer</option>
                                                                    
                                                                        <option value="Wake-up service"  {{$item['facility_name'] == 'Wake-up service'?'selected':''}}>Wake-up service</option>
                                                                    
                                                                        <option value="Laundry & Dry Cleaning" {{$item['facility_name'] == 'Laundry & Dry Cleaning'?'selected':''}} >Laundry & Dry Cleaning</option>
                                                                        
                                                                        <option value="Electronic door lock"  {{$item['facility_name'] == 'Electronic door lock'?'selected':''}}>Electronic door lock</option> 
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group" style="padding-top: 30px;">
                                                                        <a class="btn btn-success addeventmore"><i class="lni lni-circle-plus"></i></a>
                                                                        <span class="btn btn-danger btn-sm removeeventmore"><i class="lni lni-circle-minus"></i></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                               
                                                    @empty
                                               
                                                        <div class="basic_facility_section_remove" id="basic_facility_section_remove">
                                                            <div class="row add_item">
                                                                <div class="col-md-6">
                                                                    <label for="basic_facility_name" class="form-label">Room Facilities </label>
                                                                    <select name="facility_name[]" id="basic_facility_name" class="form-control">
                                                                        <option value="">Select Facility</option>
                                                                        <option value="Complimentary Breakfast">Complimentary Breakfast</option>
                                                                        <option value="32/42 inch LED TV" > 32/42 inch LED TV</option>
                                                                        <option value="Smoke alarms" >Smoke alarms</option>
                                                                        <option value="Minibar"> Minibar</option>
                                                                        <option value="Work Desk" >Work Desk</option>
                                                                        <option value="Free Wi-Fi">Free Wi-Fi</option>
                                                                        <option value="Safety box" >Safety box</option>
                                                                        <option value="Rain Shower" >Rain Shower</option>
                                                                        <option value="Slippers" >Slippers</option>
                                                                        <option value="Hair dryer" >Hair dryer</option>
                                                                        <option value="Wake-up service" >Wake-up service</option>
                                                                        <option value="Laundry & Dry Cleaning" >Laundry & Dry Cleaning</option>
                                                                        <option value="Electronic door lock" >Electronic door lock</option> 
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group" style="padding-top: 30px;">
                                                                        <a class="btn btn-success addeventmore"><i class="lni lni-circle-plus"></i></a>
                                                            
                                                                        <span class="btn btn-danger removeeventmore"><i class="lni lni-circle-minus"></i></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                               
                                                    @endforelse
                                               
                                                    </div> 
                                                </div>
                                                <br>
                                            <div class="col-md-12">
                                                <div class="d-md-flex d-grid align-items-center justify-content-center gap-3">
                                                    <button type="submit" class="btn btn-primary px-4">Save Changes</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="roomNumber" role="tabpanel">
                                <div class="card">
                                    <div class="card-body">
                                        <a class="card-title btn btn-primary float-right" onclick="addRoomNo()" id="addRoomNo">
                                            <i class="lni lni-plus">Add New</i>
                                        </a>
                                        <div class="roomnoHide mb-3" id="roomnoHide">
                                            <form action="{{ route('store.room.no', $room->id )}}" method="POST">
                                                @csrf
                                                <div class="row">

                                                    <input type="hidden" name="roomtype_id" value="{{ $room->roomtype_id }}"">

                                                    <div class="col-md-4">
                                                        <label for="room_no" class="form-label">Room Number</label>
                                                        <input type="number" name="room_no" class="form-control" id="room_no" placeholder="Room Number"/>

                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="status" class="form-label">Status</label>
                                                        <select id="status" name="status" class="form-select" >
                                                            <option selected="">Select status...</option>
                                                            <option value="Active" {{$room->view == 'Active'?'selected':''}}>Active</option>
                                                            <option value="Inactive" {{$room->view == 'Inactive'?'selected':''}}>Inactive</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <button type="submit" class="btn btn-success px-4"style="margin-top:28px;" >Save Changes</button>
                                                    </div>
                                                </div>
                                            </form>

                                        </div>
                                        <table class="table mb-0 table-striped" id="roomview">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Room Number</th>
                                                    <th scope="col">Status</th>
                                                    <th scope="col">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($allRoomNo as $RoomNo)
                                                <tr>
                                                    <td>{{ $RoomNo['room_no'] }}</td>
                                                    <td>{{ $RoomNo['status'] }}</td>
                                                    <td>
                                                        <a href="{{ route('edit.room.no', $RoomNo['id'])}}" class="btn btn-warning px-3 radius-30">Edit</a>
                                                        <a href="{{ route('delete.room.no', $RoomNo['id'])}}" id="delete" class="btn btn-danger px-3 radius-30">Delete</a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
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

<!-- Show MultiImage -->
<script>
    $(document).ready(function(){
     $('#multi_image').on('change', function(){ //on file input change
        if (window.File && window.FileReader && window.FileList && window.Blob) //check File API supported browser
        {
            var data = $(this)[0].files; //this file data
             
            $.each(data, function(index, file){ //loop though each file
                if(/(\.|\/)(gif|jpe?g|png)$/i.test(file.type)){ //check supported file type
                    var fRead = new FileReader(); //new filereader
                    fRead.onload = (function(file){ //trigger function on successful read
                    return function(e) {
                        var img = $('<img/>').addClass('thumb').attr('src', e.target.result) .width(80)
                    .height(50); //create image element 
                        $('#preview_img').append(img); //append image to output element
                    };
                    })(file);
                    fRead.readAsDataURL(file); //URL representing the file's data.
                }
            });
             
        }else{
            alert("Your browser doesn't support File API!"); //if File API is absent
        }
     });
    });
 </script>

 <!-- Start of add Basic Plan Facilities -->
<div style="visibility: hidden">
    <div class="whole_extra_item_add" id="whole_extra_item_add">
       <div class="basic_facility_section_remove" id="basic_facility_section_remove">
            <div class="row">
            <div class="form-group col-md-6">
                <label for="basic_facility_name">Room Facilities</label>
                <select name="facility_name[]" id="basic_facility_name" class="form-control">
                    <option value="">Select Facility</option>
                    <option value="Complimentary Breakfast">Complimentary Breakfast</option>
                    <option value="32/42 inch LED TV" > 32/42 inch LED TV</option>
                    <option value="Smoke alarms" >Smoke alarms</option>
                    <option value="Minibar"> Minibar</option>
                    <option value="Work Desk" >Work Desk</option>
                    <option value="Free Wi-Fi">Free Wi-Fi</option>
                    <option value="Safety box" >Safety box</option>
                    <option value="Rain Shower" >Rain Shower</option>
                    <option value="Slippers" >Slippers</option>
                    <option value="Hair dryer" >Hair dryer</option>
                    <option value="Wake-up service" >Wake-up service</option>
                    <option value="Laundry & Dry Cleaning" >Laundry & Dry Cleaning</option>
                    <option value="Electronic door lock" >Electronic door lock</option> 
                </select>
            </div>
            <div class="form-group col-md-6" style="padding-top: 20px">
                <span class="btn btn-success addeventmore"><i class="lni lni-circle-plus"></i></span>
                <span class="btn btn-danger removeeventmore"><i class="lni lni-circle-minus"></i></span>
            </div>
            </div>
       </div>
    </div>
 </div>
 
 <script type="text/javascript">
    $(document).ready(function(){
       var counter = 0;
       $(document).on("click",".addeventmore",function(){
             var whole_extra_item_add = $("#whole_extra_item_add").html();
             $(this).closest(".add_item").append(whole_extra_item_add);
             counter++;
       });
       $(document).on("click",".removeeventmore",function(event){
             $(this).closest("#basic_facility_section_remove").remove();
             counter -= 1
       });
    });
 </script>
 <!-- End of Basic Plan Facilities -->

 <!-- Start Room Number Add -->
<script>
    $('#roomnoHide').hide();
    $('#roomview').show();

    function addRoomNo() {
        $('#roomnoHide').show();
        $('#roomview').hide();
        $('#addRoomNo').hide();
    }

</script>
 <!-- Start Room Number Add  End-->
@endsection
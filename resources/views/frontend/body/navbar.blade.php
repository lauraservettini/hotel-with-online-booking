@php
    $setting = App\Models\SiteSettings::find(1);
@endphp

<div class="navbar-area">
    <!-- Menu For Mobile Device -->
    <div class="mobile-nav">
        <a href="{{ route('home') }}" class="logo">
            <img src="{{ !empty($setting->logo) ? asset($setting->logo) : url('upload/no_image.jpg') }}" class="logo-one" alt="Logo" >
            <img src="{{ !empty($setting->logo) ? asset($setting->logo) : url('upload/no_image.jpg') }}" class="logo-two" alt="Logo">
        </a>
    </div>

    <!-- Menu For Desktop Device -->
    <div class="main-nav">
        <div class="container">
            <nav class="navbar navbar-expand-md navbar-light ">
                <a class="navbar-brand" href="route('home')">
                    <img src="{{ !empty($setting->logo) ? asset($setting->logo) : url('upload/no_image.jpg') }}" class="logo-one" alt="Logo">
                    <img src="{{ !empty($setting->logo) ? asset($setting->logo) : url('upload/no_image.jpg') }}" class="logo-two" alt="Logo">
                </a>

                <div class="collapse navbar-collapse mean-menu" id="navbarSupportedContent">
                    <ul class="navbar-nav m-auto">
                        <li class="nav-item">
                            <a href="{{ route('home') }}" class="nav-link active">
                                Home
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('show.gallery') }}" class="nav-link">
                                Gallery
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('blog.list') }}" class="nav-link">
                                Blog
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('froom.all') }}" class="nav-link">
                                All Rooms
                                <i class='bx bx-chevron-down'></i>
                            </a>
                            @php
                                $rooms = App\Models\Room::latest()->get();
                            @endphp
                            <ul class="dropdown-menu">
                                @foreach($rooms as $room)
                                <li class="nav-item">
                                    <a href="{{  route('room.details', $room->id) }}" class="nav-link">
                                        {{ $room['roomtype']['name'] }} 
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('contact') }}" class="nav-link">
                                Contact
                            </a>
                        </li>

                        <li class="nav-item-btn">
                            <a href="{{ route('home') }}" class="default-btn btn-bg-one border-radius-5">Book Now</a>
                        </li>
                    </ul>

                    <div class="nav-btn">
                        <a href="{{ route('home') }}" class="default-btn btn-bg-one border-radius-5">Book Now</a>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</div>
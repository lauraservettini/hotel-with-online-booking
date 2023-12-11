 <!--sidebar wrapper -->
<div class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        <div>
            <img src="{{ asset('backend/assets/images/logo-icon.png') }}" class="logo-icon" alt="logo icon">
        </div>
        <div>
            <h4 class="logo-text">Easy</h4>
        </div>
        <div class="toggle-icon ms-auto"><i class='bx bx-arrow-back'></i>
        </div>
     </div>
    <!--navigation-->
    <ul class="metismenu" id="menu">
        <li>
            <a href="{{ route('admin.dashboard') }}">
                <div class="parent-icon"><i class='bx bx-home-alt'></i>
                </div>
                <div class="menu-title">Dashboard</div>
            </a>
        </li>
        @if(Auth::user()->can('team.menu'))
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bx bx-category"></i>
                </div>
                <div class="menu-title">Manage Team</div>
            </a>
            <ul>
                @if(Auth::user()->can('team.all'))
                <li> <a href="{{ route('all.team')}}"><i class='bx bx-radio-circle'></i>All Team</a>
                </li>
                @endif
                @if(Auth::user()->can('team.add'))
                <li> <a href="{{ route('add.team')}}"><i class='bx bx-radio-circle'></i>Add Team</a>
                </li>
                @endif
            </ul>
        </li>
        @endif
        @if(Auth::user()->can('bookarea.menu'))
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bx bx-category"></i>
                </div>
                <div class="menu-title">Manage Book Area</div>
            </a>
            <ul>
                @if(Auth::user()->can('update.bookarea'))
                <li> <a href="{{ route('update.bookarea')}}"><i class='bx bx-radio-circle'></i>Update BookArea</a>
                </li>
                @endif
            </ul>
        </li>
        @endif
        @if(Auth::user()->can('room.type.menu'))
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bx bx-category"></i>
                </div>
                <div class="menu-title">Manage Room Type</div>
            </a>
            <ul>
                @if(Auth::user()->can('room.type'))
                <li> <a href="{{ route('room.type.list')}}"><i class='bx bx-radio-circle'></i>Room Type</a>
                </li>
                @endif
            </ul>
        </li>
        @endif
        <li class="menu-label">Booking Manage</li>
        @if(Auth::user()->can('booking.menu'))
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class='bx bx-cart'></i>
                </div>
                <div class="menu-title">Booking</div>
            </a>
            <ul>
                @if(Auth::user()->can('booking.list'))
                <li> <a href="{{ route('booking.list')}}"><i class='bx bx-radio-circle'></i>Booking List</a>
                </li>
                @endif
                @if(Auth::user()->can('booking.add'))
                <li> <a href="{{ route('add.room.list') }}"><i class='bx bx-radio-circle'></i>Add Booking</a>
                </li>
                @endif
            </ul>
        </li>
        @endif
        @if(Auth::user()->can('room.list.menu'))
        <li>
            <a class="has-arrow" href="javascript:;">
                <div class="parent-icon"><i class='bx bx-bookmark-heart'></i>
                </div>
                <div class="menu-title">Manage Room List</div>
            </a>
            <ul>
                @if(Auth::user()->can('room.list'))
                <li> <a href="{{ route('view.room.list')}}"><i class='bx bx-radio-circle'></i>Room List</a>
                </li>
                @endif
            </ul>
        </li>
        @endif
        @if(Auth::user()->can('setting.menu'))
        
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bx bx-support"></i>
                </div>
                <div class="menu-title">Settings</div>
            </a>
            <ul>
                <li> <a href="{{ route('smtp.settings') }}"><i class='bx bx-radio-circle'></i>SMTP Settings</a>
                </li>
                <li> <a href="{{ route('site.settings') }}"><i class='bx bx-radio-circle'></i>Site Settings</a>
                </li>
            </ul>
        </li>
        @endif
        @if(Auth::user()->can('testimonial.menu'))
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bx bx-support"></i>
                </div>
                <div class="menu-title">Testimonials</div>
            </a>
            <ul>
                @if(Auth::user()->can('testimonial.all'))
                <li> <a href="{{ route('testimonials') }}"><i class='bx bx-radio-circle'></i>All Testimonials</a>
                </li>
                @endif
                @if(Auth::user()->can('testimonial.add'))
                <li> <a href="{{ route('add.testimonial') }}"><i class='bx bx-radio-circle'></i>Add Testimonial</a>
                </li>
                @endif
            </ul>
        </li>
        @endif

        @if(Auth::user()->can('blog.menu'))
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bx bx-support"></i>
                </div>
                <div class="menu-title">Blog</div>
            </a>
            <ul>
                @if(Auth::user()->can('blog.category'))
                <li> <a href="{{ route('blog.category') }}"><i class='bx bx-radio-circle'></i>Blog Category</a>
                </li>
                @endif
                @if(Auth::user()->can('blog.post.list'))
                <li> <a href="{{ route('blog.posts') }}"><i class='bx bx-radio-circle'></i>Blog Posts</a>
                </li>
                @endif
            </ul>
        </li>
        @endif

        @if(Auth::user()->can('comment.menu'))
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bx bx-support"></i>
                </div>
                <div class="menu-title">Manage Comments</div>
            </a>
            <ul>
                <li> <a href="{{ route('comments') }}"><i class='bx bx-radio-circle'></i>All Comments</a>
                </li>
            </ul>
        </li>
        @endif
        @if(Auth::user()->can('booking.menu'))
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bx bx-support"></i>
                </div>
                <div class="menu-title">Report</div>
            </a>
            <ul>
                @if(Auth::user()->can('booking.list'))
                <li> <a href="{{ route('booking.report') }}"><i class='bx bx-radio-circle'></i>Booking Report</a>
                </li>
                @endif
            </ul>
        </li>
        @endif
        @if(Auth::user()->can('gallery.menu'))
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bx bx-support"></i>
                </div>
                <div class="menu-title">Gallery</div>
            </a>
            <ul>
                <li> <a href="{{ route('gallery') }}"><i class='bx bx-radio-circle'></i>All Gallery</a>
                </li>
            </ul>
        </li>
        @endif
        @if(Auth::user()->can('contact.message.menu'))
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bx bx-support"></i>
                </div>
                <div class="menu-title">Contact Message</div>
            </a>
            <ul>
                <li> <a href="{{ route('admin.contact') }}"><i class='bx bx-radio-circle'></i>All Contact Message</a>
                </li>
            </ul>
        </li>
        @endif
        @if(Auth::user()->can('role.permission.menu'))
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bx bx-support"></i>
                </div>
                <div class="menu-title">Role & Permissions</div>
            </a>
            <ul>
                <li> <a href="{{ route('permissions') }}"><i class='bx bx-radio-circle'></i>All Permissions</a>
                </li>
                <li> <a href="{{ route('roles') }}"><i class='bx bx-radio-circle'></i>All Roles</a>
                </li>
                <li> <a href="{{ route('add.roles.permission') }}"><i class='bx bx-radio-circle'></i>Add Role In Permission</a>
                </li>
                <li> <a href="{{ route('roles.permission') }}"><i class='bx bx-radio-circle'></i>All Role In Permission</a>
                </li>
            </ul>
        </li>
        @endif
        @if(Auth::user()->can('role.permission.menu'))
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bx bx-support"></i>
                </div>
                <div class="menu-title">Manage Admin User</div>
            </a>
            <ul>
                <li> <a href="{{ route('admin') }}"><i class='bx bx-radio-circle'></i>All Admin</a>
                </li>
                <li> <a href="{{ route('add.admin') }}"><i class='bx bx-radio-circle'></i>Add Admin</a>
                </li>
            </ul>
        </li>
        @endif
    </ul>
    <!--end navigation-->
</div>
<!--end sidebar wrapper -->
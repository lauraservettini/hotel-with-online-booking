<?php

use App\Http\Controllers\Backend\TeamController;
use App\Http\Controllers\Backend\BookareaController;
use App\Http\Controllers\Backend\RoomTypeController;
use App\Http\Controllers\Backend\RoomController;
use App\Http\Controllers\Backend\RoomNumberController;
use App\Http\Controllers\Backend\BookingController as BookContr;
use App\Http\Controllers\Backend\SettingsController;
use App\Http\Controllers\Backend\RoomListController;
use App\Http\Controllers\Backend\TestimonialController;
use App\Http\Controllers\Backend\BlogController;
use App\Http\Controllers\Backend\CommentController;
use App\Http\Controllers\Backend\ReportController;
use App\Http\Controllers\Backend\GalleryController;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\Frontend\FrontendRoomController;
use App\Http\Controllers\Frontend\BookingController;
use App\Http\Controllers\Frontend\UserDashboardController;
use App\Http\Controllers\Frontend\BlogController as BlogContr;
use App\Http\Controllers\Frontend\GalleryController as GalleryContr;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [UserController::class, 'home'])->name('home');

Route::get('/dashboard', function () {
    return view('frontend.dashboard.user_dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Auth routes
    Route::get('/dashboard/profile', [UserController::class, 'userProfile'])->name('user.profile');
    Route::post('/dashboard/profile/store', [UserController::class, 'updateProfile'])->name('user.profile.store');
    Route::get('/dashboard/user/logout', [UserController::class, 'logout'])->name('user.logout');
    Route::get('/dashboard/user/change/password', [UserController::class, 'changePassword'])->name('change.password');
    Route::post('/dashboard/user/change/password', [UserController::class, 'updatePassword'])->name('update.password');

    // Booking All Route Group
    Route::controller(BookingController::class)->group(function () {
        Route::get('/booking/checkout', 'checkout')->name('checkout');
        Route::post('/booking/store', 'storeUserBooking')->name('user.booking.store');
        Route::post('/booking/checkout/pay', 'storeCheckout')->name('checkout.store');
        Route::match(['get', 'post'], '/stripePay', [BookingController::class, 'stripePay'])->name('stripe.pay');
        Route::match(['get', 'post'], '/orderFailed', [BookingController::class, 'orderFailed'])->name('order.failed');
    });

    // User Dashboard All Route Group
    Route::controller(UserDashboardController::class)->group(function () {
        Route::get('/dashboard/booking', 'userBooking')->name('user.booking');
        Route::get('/dashboard/booking/{id}/invoice', 'userInvoice')->name('user.invoice');
    });
});

require __DIR__ . '/auth.php';

Route::get('/admin/login', [AdminController::class, 'login'])->name('admin.login');

//Admin teams group middleware
Route::middleware('auth', 'roles:admin')->group(function () {

    //Admin group middleware
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');
    Route::get('/admin/profile', [AdminController::class, 'profile'])->name('admin.profile');
    Route::post('/admin/profile', [AdminController::class, 'updateProfile'])->name('admin.profile.store');
    Route::get('/admin/change/password', [AdminController::class, 'updatePassword'])->name('admin.change.password');
    Route::post('/admin/change/password', [AdminController::class, 'storePassword'])->name('admin.change.password.store');
    Route::get('/admin/admin', [AdminController::class, 'admin'])->name('admin')->middleware('permission:role.permission.menu');
    Route::get('/admin/admin/add', [AdminController::class, 'addAdmin'])->name('add.admin')->middleware('permission:role.permission.menu');
    Route::post('/admin/admin/add', [AdminController::class, 'storeAdmin'])->name('post.add.admin')->middleware('permission:role.permission.menu');
    Route::get('/admin/admin/update/{id}', [AdminController::class, 'editAdmin'])->name('edit.admin')->middleware('permission:role.permission.menu');
    Route::post('/admin/admin/update/{id}', [AdminController::class, 'updateAdmin'])->name('update.admin')->middleware('permission:role.permission.menu');
    Route::get('/admin/admin/delete/{id}', [AdminController::class, 'deleteAdmin'])->name('delete.admin')->middleware('permission:role.permission.menu');

    // Team All Route Group
    Route::controller(TeamController::class)->group(function () {
        Route::get('/admin/all-team', 'allTeam')->name('all.team')->middleware('permission:team.all');
        Route::get('/admin/add-team', 'getAddTeam')->name('add.team')->middleware('permission:team.aadd');
        Route::post('/admin/add-team', 'postAddTeam')->name('post.add.team')->middleware('permission:team.add');
        Route::get('/admin/edit/{id}', 'getEdit')->name('edit.team')->middleware('permission:team.edit');
        Route::post('/admin/edit/{id}', 'postEdit')->name('update.team')->middleware('permission:team.edit');
        Route::get('/admin/delete/{id}', 'delete')->name('delete.team')->middleware('permission:team.delete');
    });

    // Book Area All Route Group
    Route::controller(BookareaController::class)->group(function () {
        Route::get('/admin/update/bookarea', 'getUpdateBookarea')->name('update.bookarea')->middleware('permission:update.bookarea');
        Route::post('/admin/update/bookarea', 'postUpdateBookarea')->name('store.bookarea')->middleware('permission:update.bookarea');
    });

    // Room Type All Route Group
    Route::controller(RoomTypeController::class)->group(function () {
        Route::get('/admin/room-type/list', 'roomTypeList')->name('room.type.list')->middleware('permission:room.type');
        Route::get('/admin/room-type/add', 'addRoomType')->name('add.room.type')->middleware('permission:room.type');
        Route::post('/admin/room-type/add', 'postAddRoomType')->name('store.room.type')->middleware('permission:room.type');
    });

    // Room All Route Group
    Route::controller(RoomController::class)->group(function () {
        Route::get('/admin/room/update/{id}', 'editRoom')->name('edit.room')->middleware('permission:room.list');
        Route::post('/admin/room/update/{id}', 'updateRoom')->name('update.room')->middleware('permission:room.list');
        Route::get('/admin/room/delete/{id}', 'deleteRoom')->name('delete.room')->middleware('permission:room.list');
        Route::get('/admin/room/delete/image/{id}', 'multiImageDelete')->name('multi.images.delete')->middleware('permission:room.list');
    });

    // Room Number All Route Group
    Route::controller(RoomNumberController::class)->group(function () {
        Route::post('/admin/room/number/{id}', 'storeRoomNo')->name('store.room.no')->middleware('permission:room.list');
        Route::get('/admin/room/number/update/{id}', 'editRoomNo')->name('edit.room.no')->middleware('permission:room.list');
        Route::post('/admin/room/number/update/{id}', 'updateRoomNo')->name('update.room.no')->middleware('permission:room.list');
        Route::get('/admin/room/number/delete/{id}', 'deleteRoomNo')->name('delete.room.no')->middleware('permission:room.type')->middleware('permission:room.list');
    });

    // Booking All Route Group
    Route::controller(BookContr::class)->group(function () {
        Route::get('/admin/booking/list', 'bookingList')->name('booking.list')->middleware('permission:booking.list');
        Route::get('/admin/booking/{id}', 'editBooking')->name('edit.booking')->middleware('permission:booking.add');
        Route::post('/admin/booking/status/{id}', 'updateBookingStatus')->name('update.booking.status')->middleware('permission:booking.add');
        Route::post('/admin/booking/date/{id}', 'updateBookingDate')->name('update.booking.date')->middleware('permission:booking.add');
        Route::get('/admin/download/{id}/download-invoice', 'downloadInvoice')->name('download.invoice')->middleware('permission:booking.add');

        // Notification All Route Group
        Route::post('/admin/mark-notification-as-read/{id}', 'markNotificationAsRead');


        // Assign Room All Route Group
        Route::get('/admin/booking/assignRoom/{id}', 'assignRoom')->name('assign.room')->middleware('permission:booking.add');
        Route::get('/admin/booking/assignRoom/delete/{id}', 'deleteAssignRoom')->name('delete.assign.room')->middleware('permission:booking.add');
        Route::get('/admin/booking/assignRoom/store/{booking_id}/{room_id}', 'assignRoomStore')->name('assign.room.store')->middleware('permission:booking.add');
    });

    // Room List All Route Group 
    Route::controller(RoomListController::class)->group(function () {
        Route::get('/admin/room-list', 'roomList')->name('view.room.list')->middleware('permission:room.list');
        Route::get('/admin/room-list/add', 'addRoomList')->name('add.room.list')->middleware('permission:room.list');
        Route::post('/admin/room-list/add', 'storeRoomList')->name('store.room.list')->middleware('permission:room.list');
    });

    // Settings All Route Group 
    Route::controller(SettingsController::class)->group(function () {
        Route::get('/admin/smtp-settings', 'smtpSettings')->name('smtp.settings')->middleware('permission:setting');
        Route::post('/admin/smtp-settings/update', 'updateSmtp')->name('update.smtp')->middleware('permission:setting');
        Route::get('/admin/site-settings', 'siteSettings')->name('site.settings')->middleware('permission:setting');
        Route::post('/admin/site-settings/update', 'updateSiteSettings')->name('update.site.settings')->middleware('permission:setting');
    });

    // Testimonials All Route Group 
    Route::controller(TestimonialController::class)->group(function () {
        Route::get('/admin/testimonials', 'testimonials')->name('testimonials')->middleware('permission:testimonial.all');
        Route::get('/admin/testimonials/add', 'addTestimonial')->name('add.testimonial')->middleware('permission:testimonial.add');
        Route::post('/admin/testimonials/add', 'storeTestimonial')->name('post.add.testimonial')->middleware('permission:testimonial.add');
        Route::get('/admin/testimonials/update/{id}', 'updateTestimonial')->name('update.testimonial')->middleware('permission:testimonial.edit');
        Route::post('/admin/testimonials/update/{id}', 'storeUpdateTestimonial')->name('store.update.testimonial')->middleware('permission:testimonial.edit');
        Route::get('/admin/testimonials/delete/{id}', 'deleteTestimonial')->name('delete.testimonial')->middleware('permission:testimonial.delete');
    });

    // Blog All Route Group 
    Route::controller(BlogController::class)->group(function () {
        Route::get('/admin/blog/category', 'blogCategory')->name('blog.category')->middleware('permission:blog.category');
        Route::post('/admin/blog/category/add', 'addBlogCategory')->name('add.blog.category')->middleware('permission:blog.category');
        Route::post('/admin/blog/category/update/{id}', 'updateBlogCategory')->name('update.blog.category')->middleware('permission:blog.category');
        Route::get('/admin/blog/category/delete/{id}', 'deleteBlogCategory')->name('delete.blog.category')->middleware('permission:blog.category');
        Route::get('/admin/blog/posts', 'blogPosts')->name('blog.posts')->middleware('permission:blog.post.list');
        Route::get('/admin/blog/posts/add', 'addBlogPost')->name('add.blog.post')->middleware('permission:blog.post.list');
        Route::post('/admin/blog/posts/add', 'storeBlogPost')->name('store.blog.post')->middleware('permission:blog.post.list');
        Route::get('/admin/blog/posts/update/{id}', 'editBlogPost')->name('edit.blog.post')->middleware('permission:blog.post.list');
        Route::post('/admin/blog/posts/update/{id}', 'updateBlogPost')->name('update.blog.post')->middleware('permission:blog.post.list');
        Route::get('/admin/blog/posts/delete/{id}', 'deleteBlogPost')->name('delete.blog.post')->middleware('permission:blog.post.list');
    });

    // Backend CommentController All Route Group
    Route::controller(CommentController::class)->group(function () {
        Route::get('/admin/comments/all', 'comments')->name('comments')->middleware('permission:comment.menu');
        Route::post('/admin/comments/update', 'updateStatus')->name('update.comment.status')->middleware('permission:comment.menu');
    });

    // Backend ReportController All Route Group
    Route::controller(ReportController::class)->group(function () {
        Route::get('/admin/report/booking', 'bookingReport')->name('booking.report')->middleware('permission:booking.menu');
        Route::post('/admin/report/booking/search', 'searchBooking')->name('search.booking.by.date')->middleware('permission:booking.menu');
    });

    // Backend GalleryController All Route Group
    Route::controller(GalleryController::class)->group(function () {
        Route::get('/admin/gallery', 'gallery')->name('gallery')->middleware('permission:gallery.menu');
        Route::get('/admin/gallery/add', 'addGallery')->name('add.gallery')->middleware('permission:gallery.menu');
        Route::post('/admin/gallery/add', 'storeGallery')->name('post.add.gallery')->middleware('permission:gallery.menu');
        Route::get('/admin/gallery/update/{id}', 'editGallery')->name('edit.gallery')->middleware('permission:gallery.menu');
        Route::post('/admin/gallery/update/{id}', 'updateGallery')->name('update.gallery')->middleware('permission:gallery.menu');
        Route::get('/admin/gallery/delete/{id}', 'deleteGallery')->name('delete.gallery')->middleware('permission:gallery.menu');
        Route::post('/admin/gallery/delete-selected', 'deleteSelectedGallery')->name('delete.selected.gallery')->middleware('permission:gallery.menu');
    });

    // Backend ContactController All Route Group
    Route::controller(ContactController::class)->group(function () {
        Route::get('/admin/contact', 'adminContact')->name('admin.contact')->middleware('permission:contact.message.menu');
    });

    // Backend RoleController All Route Group
    Route::controller(RoleController::class)->group(function () {
        // Permissions All Route
        Route::get('/admin/permissions', 'permissions')->name('permissions')->middleware('permission:role.permission.menu');
        Route::get('/admin/permissions/add', 'addPermission')->name('add.permission')->middleware('permission:role.permission.menu');
        Route::post('/admin/permissions/add', 'storePermission')->name('post.add.permission')->middleware('permission:role.permission.menu');
        Route::get('/admin/permissions/update/{id}', 'editPermission')->name('edit.permission')->middleware('permission:role.permission.menu');
        Route::post('/admin/permissions/update/{id}', 'updatePermission')->name('update.permission')->middleware('permission:role.permission.menu');
        Route::get('/admin/permissions/delete/{id}', 'deletePermission')->name('delete.permission')->middleware('permission:role.permission.menu');
        Route::get('/admin/permissions/import', 'importPermission')->name('import.permission')->middleware('permission:role.permission.menu');
        Route::post('/admin/permissions/import', 'storeImportPermission')->name('post.import.permission')->middleware('permission:role.permission.menu');
        Route::get('/admin/permissions/export', 'exportPermission')->name('export.permission')->middleware('permission:role.permission.menu');
        Route::get('/admin/permissions/download', 'downloadPermission')->name('download.permission')->middleware('permission:role.permission.menu');

        // Roles All Route
        Route::get('/admin/roles', 'roles')->name('roles')->middleware('permission:role.permission.menu');
        Route::get('/admin/roles/add', 'addRole')->name('add.role')->middleware('permission:role.permission.menu');
        Route::post('/admin/roles/add', 'storeRole')->name('post.add.role')->middleware('permission:role.permission.menu');
        Route::get('/admin/roles/update/{id}', 'editRole')->name('edit.role')->middleware('permission:role.permission.menu');
        Route::post('/admin/roles/update/{id}', 'updateRole')->name('update.role')->middleware('permission:role.permission.menu');
        Route::get('/admin/roles/delete/{id}', 'deleteRole')->name('delete.role')->middleware('permission:role.permission.menu');
        Route::get('/admin/roles/permissions/add', 'addRolesPermission')->name('add.roles.permission')->middleware('permission:role.permission.menu');
        Route::post('/admin/roles/permissions/add', 'storeRolePermissions')->name('store.roles.permission')->middleware('permission:role.permission.menu');
        Route::get('/admin/roles//permissions', 'rolesPermission')->name('roles.permission')->middleware('permission:role.permission.menu');
        Route::get('/admin/roles/permissions/update/{id}', 'adminRolesPermission')->name('admin.roles.permission')->middleware('permission:role.permission.menu');
        Route::post('/admin/roles/permissions/update/{id}', 'updateRolePermissions')->name('update.roles.permission')->middleware('permission:role.permission.menu');
        Route::get('/admin/roles/permissions/delete/{id}', 'deleteRolePermissions')->name('delete.role.permissions')->middleware('permission:role.permission.menu');
    });
});

// Frontend All Route Group
Route::controller(FrontendRoomController::class)->group(function () {
    Route::get('/rooms', 'roomList')->name('froom.all');
    Route::get('/rooms/{id}', 'roomDetails')->name('room.details');
    Route::get('/booking/search', 'bookingSearch')->name('booking.search');
    Route::get('/booking/search/{id}', 'bookingSearchDetails')->name('search.room.details');
    Route::get('/booking/check-room-availability', 'checkRoomsAvailability')->name('check.room.availability');
});

// Frontend BlogController All Route Group
Route::controller(BlogContr::class)->group(function () {
    Route::get('/blog/details/{id}/{post_slug}', 'detailsBlogPost')->name('blog.post.details');
    Route::get('/blog/category/list/{id}', 'categoryBlogPost')->name('blog.post.category');
    Route::get('/blog/list', 'listBlogPost')->name('blog.list');
});

// Frontend CommentController All Route Group
Route::controller(CommentController::class)->group(function () {
    Route::post('/blog/comment/add', 'addComment')->name('add.comment');
});

// Frontend GalleryController All Route Group
Route::controller(GalleryContr::class)->group(function () {
    Route::get('/gallery/show', 'showGallery')->name('show.gallery');
});

// Frontend ContactController All Route Group
Route::controller(ContactController::class)->group(function () {
    Route::get('/contact', 'contact')->name('contact');
    Route::post('/contact/store', 'storeContact')->name('store.contact');
});

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

    // Team All Route Group
    Route::controller(TeamController::class)->group(function () {
        Route::get('/admin/all-team', 'allTeam')->name('all.team');
        Route::get('/admin/add-team', 'getAddTeam')->name('add.team');
        Route::post('/admin/add-team', 'postAddTeam')->name('post.add.team');
        Route::get('/admin/edit/{id}', 'getEdit')->name('edit.team');
        Route::post('/admin/edit/{id}', 'postEdit')->name('update.team');
        Route::get('/admin/delete/{id}', 'delete')->name('delete.team');
    });

    // Book Area All Route Group
    Route::controller(BookareaController::class)->group(function () {
        Route::get('/admin/update/bookarea', 'getUpdateBookarea')->name('update.bookarea');
        Route::post('/admin/update/bookarea', 'postUpdateBookarea')->name('store.bookarea');
    });

    // Room Type All Route Group
    Route::controller(RoomTypeController::class)->group(function () {
        Route::get('/admin/room-type/list', 'roomTypeList')->name('room.type.list');
        Route::get('/admin/room-type/add', 'addRoomType')->name('add.room.type');
        Route::post('/admin/room-type/add', 'postAddRoomType')->name('store.room.type');
    });

    // Room All Route Group
    Route::controller(RoomController::class)->group(function () {
        Route::get('/admin/room/update/{id}', 'editRoom')->name('edit.room');
        Route::post('/admin/room/update/{id}', 'updateRoom')->name('update.room');
        Route::get('/admin/room/delete/{id}', 'deleteRoom')->name('delete.room');
        Route::get('/admin/room/delete/image/{id}', 'multiImageDelete')->name('multi.images.delete');
    });

    // Room Number All Route Group
    Route::controller(RoomNumberController::class)->group(function () {
        Route::post('/admin/room/number/{id}', 'storeRoomNo')->name('store.room.no');
        Route::get('/admin/room/number/update/{id}', 'editRoomNo')->name('edit.room.no');
        Route::post('/admin/room/number/update/{id}', 'updateRoomNo')->name('update.room.no');
        Route::get('/admin/room/number/delete/{id}', 'deleteRoomNo')->name('delete.room.no');
    });

    // Booking All Route Group
    Route::controller(BookContr::class)->group(function () {
        Route::get('/admin/booking/list', 'bookingList')->name('booking.list');
        Route::get('/admin/booking/{id}', 'editBooking')->name('edit.booking');
        Route::post('/admin/booking/status/{id}', 'updateBookingStatus')->name('update.booking.status');
        Route::post('/admin/booking/date/{id}', 'updateBookingDate')->name('update.booking.date');
        Route::get('/admin/download/{id}/download-invoice', 'downloadInvoice')->name('download.invoice');

        // Notification All Route Group
        Route::post('/admin/mark-notification-as-read/{id}', 'markNotificationAsRead');


        // Assign Room All Route Group
        Route::get('/admin/booking/assignRoom/{id}', 'assignRoom')->name('assign.room');
        Route::get('/admin/booking/assignRoom/delete/{id}', 'deleteAssignRoom')->name('delete.assign.room');
        Route::get('/admin/booking/assignRoom/store/{booking_id}/{room_id}', 'assignRoomStore')->name('assign.room.store');
    });

    // Room List All Route Group 
    Route::controller(RoomListController::class)->group(function () {
        Route::get('/admin/room-list', 'roomList')->name('view.room.list');
        Route::get('/admin/room-list/add', 'addRoomList')->name('add.room.list');
        Route::post('/admin/room-list/add', 'storeRoomList')->name('store.room.list');
    });

    // Settings All Route Group 
    Route::controller(SettingsController::class)->group(function () {
        Route::get('/admin/smtp-settings', 'smtpSettings')->name('smtp.settings');
        Route::post('/admin/smtp-settings/update', 'updateSmtp')->name('update.smtp');
        Route::get('/admin/site-settings', 'siteSettings')->name('site.settings');
        Route::post('/admin/site-settings/update', 'updateSiteSettings')->name('update.site.settings');
    });

    // Testimonials All Route Group 
    Route::controller(TestimonialController::class)->group(function () {
        Route::get('/admin/testimonials', 'testimonials')->name('testimonials');
        Route::get('/admin/testimonials/add', 'addTestimonial')->name('add.testimonial');
        Route::post('/admin/testimonials/add', 'storeTestimonial')->name('post.add.testimonial');
        Route::get('/admin/testimonials/update/{id}', 'updateTestimonial')->name('update.testimonial');
        Route::post('/admin/testimonials/update/{id}', 'storeUpdateTestimonial')->name('store.update.testimonial');
        Route::get('/admin/testimonials/delete/{id}', 'deleteTestimonial')->name('delete.testimonial');
    });

    // Blog All Route Group 
    Route::controller(BlogController::class)->group(function () {
        Route::get('/admin/blog/category', 'blogCategory')->name('blog.category');
        Route::post('/admin/blog/category/add', 'addBlogCategory')->name('add.blog.category');
        Route::post('/admin/blog/category/update/{id}', 'updateBlogCategory')->name('update.blog.category');
        Route::get('/admin/blog/category/delete/{id}', 'deleteBlogCategory')->name('delete.blog.category');
        Route::get('/admin/blog/posts', 'blogPosts')->name('blog.posts');
        Route::get('/admin/blog/posts/add', 'addBlogPost')->name('add.blog.post');
        Route::post('/admin/blog/posts/add', 'storeBlogPost')->name('store.blog.post');
        Route::get('/admin/blog/posts/update/{id}', 'editBlogPost')->name('edit.blog.post');
        Route::post('/admin/blog/posts/update/{id}', 'updateBlogPost')->name('update.blog.post');
        Route::get('/admin/blog/posts/delete/{id}', 'deleteBlogPost')->name('delete.blog.post');
    });

    // Backend CommentController All Route Group
    Route::controller(CommentController::class)->group(function () {
        Route::get('/admin/comments/all', 'comments')->name('comments');
        Route::post('/admin/comments/update', 'updateStatus')->name('update.comment.status');
    });

    // Backend ReportController All Route Group
    Route::controller(ReportController::class)->group(function () {
        Route::get('/admin/report/booking', 'bookingReport')->name('booking.report');
        Route::post('/admin/report/booking/search', 'searchBooking')->name('search.booking.by.date');
    });

    // Backend GalleryController All Route Group
    Route::controller(GalleryController::class)->group(function () {
        Route::get('/admin/gallery', 'gallery')->name('gallery');
        Route::get('/admin/gallery/add', 'addGallery')->name('add.gallery');
        Route::post('/admin/gallery/add', 'storeGallery')->name('post.add.gallery');
        Route::get('/admin/gallery/update/{id}', 'editGallery')->name('edit.gallery');
        Route::post('/admin/gallery/update/{id}', 'updateGallery')->name('update.gallery');
        Route::get('/admin/gallery/delete/{id}', 'deleteGallery')->name('delete.gallery');
        Route::post('/admin/gallery/delete-selected', 'deleteSelectedGallery')->name('delete.selected.gallery');
    });

    // Backend ContactController All Route Group
    Route::controller(ContactController::class)->group(function () {
        Route::get('/admin/contact', 'adminContact')->name('admin.contact');
    });

    // Backend RoleController All Route Group
    Route::controller(RoleController::class)->group(function () {
        Route::get('/admin/permissions', 'permissions')->name('permissions');
        Route::get('/admin/permissions/add', 'addPermission')->name('add.permission');
        Route::post('/admin/permissions/add', 'storePermission')->name('post.add.permission');
        Route::get('/admin/permissions/update/{id}', 'editPermission')->name('edit.permission');
        Route::post('/admin/permissions/update/{id}', 'updatePermission')->name('update.permission');
        Route::get('/admin/permissions/delete/{id}', 'deletePermission')->name('delete.permission');
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

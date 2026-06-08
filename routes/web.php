<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\HouseController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PriceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\InstallmentController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\PaymentController;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\LocationController;
use App\Http\Controllers\Admin\HouseController as AdminHouseController;
use App\Http\Controllers\Admin\TenantController;
use App\Http\Controllers\Admin\ComplaintController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\InstallmentRequestController;
use App\Http\Controllers\Admin\NotificationController as AdminNotificationController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\InstallmentReceiptController;
use App\Http\Controllers\Admin\UtilityController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\Admin\PaymentReportController;
use App\Http\Controllers\Admin\BalanceReportController;
use App\Http\Controllers\Admin\UserController;

use App\Models\Tenant;

/*
|--------------------------------------------------------------------------
| ADMIN AUTH
|--------------------------------------------------------------------------
*/

Route::get('/admin/login', function () {
    return view('admin.login');
})->name('admin.login');

Route::post('/admin/login', [AdminController::class, 'login'])
    ->name('admin.login.post');

Route::get('/admin/logout', [AdminController::class, 'logout'])
    ->name('admin.logout');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
});

/*
|--------------------------------------------------------------------------
| ADMIN - CATEGORIES
|--------------------------------------------------------------------------
*/

Route::get('/admin/categories', [CategoryController::class, 'index'])
    ->name('admin.categories');

Route::post('/admin/categories/save', [CategoryController::class, 'save'])
    ->name('admin.categories.save');

Route::post('/admin/categories/delete/{id}', [CategoryController::class, 'delete'])
    ->name('admin.categories.delete');

/*
|--------------------------------------------------------------------------
| ADMIN - LOCATIONS
|--------------------------------------------------------------------------
*/

Route::get('/admin/locations', [LocationController::class, 'index'])
    ->name('admin.locations');

Route::post('/admin/locations/save', [LocationController::class, 'save'])
    ->name('admin.locations.save');

Route::post('/admin/locations/delete/{id}', [LocationController::class, 'delete'])
    ->name('admin.locations.delete');

/*
|--------------------------------------------------------------------------
| ADMIN - HOUSES
|--------------------------------------------------------------------------
*/

Route::get('/admin/houses', [AdminHouseController::class, 'index'])
    ->name('admin.houses');

Route::get('/admin/houses/manage/{id?}', [AdminHouseController::class, 'manage'])
    ->name('admin.houses.manage');

Route::post('/admin/houses/save', [AdminHouseController::class, 'save'])
    ->name('admin.houses.save');

Route::post('/admin/houses/delete/{id}', [AdminHouseController::class, 'delete'])
    ->name('admin.houses.delete');

Route::post('/admin/houses/delete-image/{id}', [AdminHouseController::class, 'deleteImage'])
    ->name('admin.houses.delete-image');

/*
|--------------------------------------------------------------------------
| ADMIN - TENANTS
|--------------------------------------------------------------------------
*/

Route::get('/admin/tenants', [TenantController::class, 'index'])
    ->name('admin.tenants');

Route::get('/admin/tenants/manage/{id?}', [TenantController::class, 'manage'])
    ->name('admin.tenants.manage');

Route::post('/admin/tenants/save', [TenantController::class, 'save'])
    ->name('admin.tenants.save');

Route::post('/admin/tenants/delete/{id}', [TenantController::class, 'delete'])
    ->name('admin.tenants.delete');

Route::get('/admin/tenants/print-contract/{id}', [TenantController::class, 'printContract'])
    ->name('admin.tenants.print-contract');

Route::get('/admin/tenants/payment-history/{id}', [TenantController::class, 'paymentHistory'])
    ->name('admin.tenants.payment-history');

/*
|--------------------------------------------------------------------------
| ADMIN - COMPLAINTS
|--------------------------------------------------------------------------
*/

Route::get('/admin/complaints', [ComplaintController::class, 'index'])
    ->name('admin.complaints');

Route::get('/admin/complaints/manage/{id?}', [ComplaintController::class, 'manage'])
    ->name('admin.complaints.manage');

Route::post('/admin/complaints/save', [ComplaintController::class, 'save'])
    ->name('admin.complaints.save');

Route::post('/admin/complaints/delete/{id}', [ComplaintController::class, 'delete'])
    ->name('admin.complaints.delete');

/*
|--------------------------------------------------------------------------
| ADMIN - BOOKINGS
|--------------------------------------------------------------------------
*/

Route::get('/admin/bookings', [BookingController::class, 'index'])
    ->name('admin.bookings');

Route::post('/admin/bookings/update-status', [BookingController::class, 'updateStatus'])
    ->name('admin.bookings.update-status');

Route::post('/admin/bookings/delete/{id}', [BookingController::class, 'delete'])
    ->name('admin.bookings.delete');

/*
|--------------------------------------------------------------------------
| ADMIN - INSTALLMENT REQUESTS
|--------------------------------------------------------------------------
*/

Route::get('/admin/installment-requests', [InstallmentRequestController::class, 'index'])
    ->name('admin.installments');

Route::get('/admin/installment-requests/view/{id}', [InstallmentRequestController::class, 'view'])
    ->name('admin.installments.view');

Route::post('/admin/installments/update-status', [InstallmentRequestController::class, 'updateStatus'])
    ->name('admin.installments.update-status');

Route::post('/admin/installment-requests/delete/{id}', [InstallmentRequestController::class, 'delete'])
    ->name('admin.installments.delete');

/*
|--------------------------------------------------------------------------
| ADMIN - INSTALLMENT RECEIPTS
|--------------------------------------------------------------------------
*/

Route::get('/admin/installment-receipts', [InstallmentReceiptController::class, 'index'])
    ->name('admin.installment_receipts');

Route::post('/admin/installment-receipts/update-status', [InstallmentReceiptController::class, 'updateStatus'])
    ->name('admin.installment_receipts.update');

Route::post('/admin/installment-receipts/delete/{id}', [InstallmentReceiptController::class, 'delete'])
    ->name('admin.installment_receipts.delete');

/*
|--------------------------------------------------------------------------
| ADMIN - NOTIFICATIONS
|--------------------------------------------------------------------------
*/

Route::get('/admin/notifications', [AdminNotificationController::class, 'index'])
    ->name('admin.notifications');

Route::get('/admin/notifications/manage/{id?}', [AdminNotificationController::class, 'manage'])
    ->name('admin.notifications.manage');

Route::post('/admin/notifications/save', [AdminNotificationController::class, 'save'])
    ->name('admin.notifications.save');

Route::post('/admin/notifications/delete/{id}', [AdminNotificationController::class, 'delete'])
    ->name('admin.notifications.delete');

/*
|--------------------------------------------------------------------------
| ADMIN - REVIEWS
|--------------------------------------------------------------------------
*/

Route::get('/admin/reviews', [ReviewController::class, 'index'])
    ->name('admin.reviews');

Route::get('/admin/reviews/manage/{id}', [ReviewController::class, 'manage'])
    ->name('admin.reviews.manage');

Route::post('/admin/reviews/save', [ReviewController::class, 'save'])
    ->name('admin.reviews.save');

Route::post('/admin/reviews/delete/{id}', [ReviewController::class, 'delete'])
    ->name('admin.reviews.delete');

/*
|--------------------------------------------------------------------------
| ADMIN - MESSAGES
|--------------------------------------------------------------------------
*/

Route::get('/admin/messages', [MessageController::class, 'index'])
    ->name('admin.messages');

Route::post('/admin/messages/delete/{id}', [MessageController::class, 'delete'])
    ->name('admin.messages.delete');

/*
|--------------------------------------------------------------------------
| ADMIN - PAYMENTS
|--------------------------------------------------------------------------
*/

Route::get('/admin/payments', [AdminPaymentController::class, 'index'])
    ->name('admin.payments');

Route::get('/admin/payments/manage/{id?}', [AdminPaymentController::class, 'manage'])
    ->name('admin.payments.manage');

Route::post('/admin/payments/save', [AdminPaymentController::class, 'save'])
    ->name('admin.payments.save');

Route::post('/admin/payments/delete/{id}', [AdminPaymentController::class, 'delete'])
    ->name('admin.payments.delete');

Route::get('/admin/payments/view/{id}', [PaymentController::class, 'view'])
    ->name('admin.payments.view');

/*
|--------------------------------------------------------------------------
| ADMIN - UTILITIES
|--------------------------------------------------------------------------
*/

Route::get('/admin/utilities', [UtilityController::class, 'index'])
    ->name('admin.utilities');

Route::get('/admin/utilities/manage/{id?}', [UtilityController::class, 'manage'])
    ->name('admin.utilities.manage');

Route::post('/admin/utilities/save', [UtilityController::class, 'save'])
    ->name('admin.utilities.save');

Route::post('/admin/utilities/delete/{id}', [UtilityController::class, 'delete'])
    ->name('admin.utilities.delete');

/*
|--------------------------------------------------------------------------
| ADMIN - REPORTS
|--------------------------------------------------------------------------
*/

Route::view('/admin/reports', 'admin.reports.index')
    ->name('admin.reports');

Route::get('/admin/payment-report', [PaymentReportController::class, 'index'])
    ->name('admin.payment_report');

Route::get('/admin/balance-report', [BalanceReportController::class, 'index'])
    ->name('admin.balance_report');

/*
|--------------------------------------------------------------------------
| ADMIN - USERS
|--------------------------------------------------------------------------
*/

Route::get('/admin/users', [UserController::class, 'index'])
    ->name('admin.users');

Route::get('/admin/users/manage/{id?}', [UserController::class, 'manage'])
    ->name('admin.users.manage');

Route::post('/admin/users/save', [UserController::class, 'save'])
    ->name('admin.users.save');

Route::post('/admin/users/delete/{id}', [UserController::class, 'delete'])
    ->name('admin.users.delete');

/*
|--------------------------------------------------------------------------
| PAYMENT / VNPAY
|--------------------------------------------------------------------------
*/

Route::get('/mock_vnpay', [PaymentController::class, 'mockVnpay'])
    ->name('mock.vnpay');

Route::get('/vnpay_return', [PaymentController::class, 'vnpayReturn'])
    ->name('vnpay.return');

/*
|--------------------------------------------------------------------------
| CHAT
|--------------------------------------------------------------------------
*/

Route::post('/chat/edit/{id}', [ChatController::class, 'edit'])
    ->name('chat.edit');

Route::post('/chat/ai', [ChatController::class, 'aiReply'])
    ->name('chat.ai');

Route::get('/chat/load', [ChatController::class, 'load'])
    ->name('chat.load');

Route::post('/chat/send', [ChatController::class, 'send'])
    ->name('chat.send');

/*
|--------------------------------------------------------------------------
| CUSTOMER INSTALLMENT
|--------------------------------------------------------------------------
*/

Route::get('/installment', [InstallmentController::class, 'index'])
    ->name('installment.index');

Route::post('/installment/store', [InstallmentController::class, 'store'])
    ->name('installment.store');

Route::get('/installment/detail/{id}', [InstallmentController::class, 'detail'])
    ->name('installment.detail');

Route::get('/installment_payment', function () {
    return redirect()->route('installment.detail', request('req_id'));
});

/*
|--------------------------------------------------------------------------
| CUSTOMER PAGES
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])
    ->name('home');

Route::get('/notifications', [NotificationController::class, 'index'])
    ->name('notifications.index');

Route::get('/profile', [ProfileController::class, 'index'])
    ->name('profile');

Route::post('/profile/update', [ProfileController::class, 'update'])
    ->name('profile.update');

Route::post('/complaint/store', [ProfileController::class, 'storeComplaint'])
    ->name('complaint.store');

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'postLogin']);

Route::post('/login/google', [AuthController::class, 'loginGoogle']);

Route::get('/signup', [AuthController::class, 'showSignup'])
    ->name('signup');

Route::post('/signup', [AuthController::class, 'postSignup']);

Route::get('/logout', [AuthController::class, 'logout'])
    ->name('logout');

/*
|--------------------------------------------------------------------------
| CONTACT
|--------------------------------------------------------------------------
*/

Route::get('/contact', [ContactController::class, 'index'])
    ->name('contact');

Route::post('/contact/submit', [ContactController::class, 'submit'])
    ->name('contact.submit');

/*
|--------------------------------------------------------------------------
| ROOMS
|--------------------------------------------------------------------------
*/

Route::get('/rooms', [HouseController::class, 'index'])
    ->name('rooms.index');

Route::get('/view/{id}', [HouseController::class, 'show'])
    ->name('rooms.view');

/*
|--------------------------------------------------------------------------
| PREDICT PRICE
|--------------------------------------------------------------------------
*/

Route::get('/predict_price', [PriceController::class, 'index'])
    ->name('predict_price');
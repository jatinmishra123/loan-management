<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ForgotPasswordController;
use App\Http\Controllers\Admin\GoldItemController;
use App\Http\Controllers\Admin\SubcategoryController;
use App\Http\Controllers\Admin\WebsiteBannerController;
use App\Http\Controllers\Admin\SecondGoldItemController;
use App\Http\Controllers\Admin\WebsiteSettingsController;
use App\Http\Controllers\Admin\SlotMasterController;
use App\Http\Controllers\Admin\SlotBookingController;
use App\Http\Controllers\Admin\SecondAppraisalController;
use App\Http\Controllers\Admin\GoldPriceController;
use App\Http\Controllers\Admin\ManageAdminController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\BranchController;
use App\Http\Controllers\Admin\BankController;
use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\Admin\AgentSMSController;
use App\Http\Controllers\Admin\AgentController;
use App\Http\Controllers\Admin\AppraisalController;

use Illuminate\Support\Facades\Route;

// Redirect base URL
Route::get('/', fn() => redirect()->route('admin.login'));

// =============================================
// 🔐 ADMIN ROUTES
// =============================================
Route::prefix('admin')->name('admin.')->group(function () {

    // =============================
    // Guest Routes
    // =============================
    Route::middleware('guest:admin')->group(function () {
        Route::get('login', [AdminController::class, 'showLoginForm'])->name('login');
        Route::post('login', [AdminController::class, 'login']);

        Route::get('forgot-password', [ForgotPasswordController::class, 'showForgotForm'])->name('forgot-password');
        Route::post('send-otp', [ForgotPasswordController::class, 'sendOTP'])->name('send-otp');
        Route::get('verify-otp', [ForgotPasswordController::class, 'showVerifyOTP'])->name('verify-otp');
        Route::post('verify-otp', [ForgotPasswordController::class, 'verifyOTP'])->name('verify-otp');
        Route::get('reset-password', [ForgotPasswordController::class, 'showResetForm'])->name('reset-password');
        Route::post('reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('reset-password');
    });

    // =============================
    // Authenticated Admin Routes
    // =============================
    Route::middleware('admin')->group(function () {

        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::post('logout', [AdminController::class, 'logout'])->name('logout');


    // Slot Booking Module ✔ CORRECT
    Route::resource('slot-bookings', SlotBookingController::class);
        // Invoices
        Route::resource('invoices', InvoiceController::class);
        Route::get('invoices/{id}/download', [InvoiceController::class, 'downloadPDF'])->name('invoices.download');

        // Gold Items
        Route::resource('gold_items', GoldItemController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);

        // Customers
        Route::resource('customers', CustomerController::class);
        Route::post('customers/{customer}/toggle-status', [CustomerController::class, 'toggleStatus'])->name('customers.toggle-status');
        Route::get('branches-by-bank/{bankId}', [CustomerController::class, 'getBranchesByBank'])->name('branches.by-bank');

        // Agents
        Route::resource('agent', AgentController::class);
        Route::get('agent/{id}/certificate', [AgentController::class, 'certificate'])->name('agent.certificate');

        // Subcategories
        Route::resource('subcategories', SubcategoryController::class);
        Route::post('subcategories/{subcategory}/toggle-status', [SubcategoryController::class, 'toggleStatus'])->name('subcategories.toggle-status');

        // My Profile
        Route::get('profile', [ManageAdminController::class, 'myProfile'])->name('profile');
        Route::put('profile', [ManageAdminController::class, 'updateMyProfile'])->name('profile.update');

        // Contacts
        Route::resource('contacts', ContactController::class)->except(['create', 'store']);
        Route::post('contacts/{contact}/update-status', [ContactController::class, 'updateStatus'])->name('contacts.update-status');

        // Banks & Branches
        Route::resource('bank', BankController::class);
        Route::resource('branch', BranchController::class);

        // Change Credentials
        Route::get('change-credentials', fn() => view('admin.change-credentials.index'))->name('change-credentials');
        Route::put('change-credentials', fn() => redirect()->back()->with('success', 'Password updated successfully!'))->name('change-credentials.update');

        // First Appraisal
        Route::get('appraisal', [AppraisalController::class, 'index'])->name('appraisal.index');
        Route::get('appraisal/data/{customer}/{type}', [AppraisalController::class, 'getData'])->name('appraisal.data');
        Route::get('appraisal/pdf/{customer}/{type}', [AppraisalController::class, 'downloadPdf'])->name('appraisal.pdf');

        // Second Appraisal
        Route::resource('second-appraisal', SecondAppraisalController::class)->except(['destroy']);
        Route::get('second-appraisal/{id}/download', [SecondAppraisalController::class, 'downloadPdf'])->name('second-appraisal.download');
Route::get('appraisal/download-again/{id}', 
    [AppraisalController::class, 'downloadAgain']
)->name('appraisal.downloadAgain');
        // Gold Price
        Route::post('goldprice/store', [GoldPriceController::class, 'store'])->name('goldprice.store');
        Route::get('goldprice/latest', [GoldPriceController::class, 'latest'])->name('goldprice.latest');
        Route::get('goldprice/edit/{id}', [GoldPriceController::class, 'edit'])->name('goldprice.edit');
        Route::post('goldprice/update/{id}', [GoldPriceController::class, 'update'])->name('goldprice.update');
        Route::delete('goldprice/delete/{id}', [GoldPriceController::class, 'destroy'])->name('goldprice.delete');

        // SMS
        Route::get('sms/agents', [AgentSMSController::class, 'index'])->name('sms.agents');
        Route::post('sms/agents/send', [AgentSMSController::class, 'send'])->name('sms.agents.send');

        // SUPER ADMIN
        Route::middleware('role:super_admin')->group(function () {
            Route::resource('manage-admins', ManageAdminController::class);
        });
        

        // ====================================
        // 🟨 Second Gold Items (your new module)
        // =============================
// Second Appraisal Generator + PDF + Preview Routes
// =============================

// Generator Page
Route::get('second-appraisal-generator',
    [SecondAppraisalController::class, 'generator']
)->name('second-appraisal.generator');

// AJAX Preview HTML
Route::get('second-appraisal/data/{id}',
    [SecondAppraisalController::class, 'getData']
)->name('second-appraisal.data');

// PDF with Range
Route::get('second-appraisal/pdf/{id}',
    [SecondAppraisalController::class, 'downloadPdf']
)->name('second-appraisal.pdf');

        // ====================================
        Route::resource('second-gold-items', SecondGoldItemController::class)
            ->names([
                'index' => 'second_gold_items.index',
                'create' => 'second_gold_items.create',
                'store' => 'second_gold_items.store',
                'edit' => 'second_gold_items.edit',
                'update' => 'second_gold_items.update',
                'destroy' => 'second_gold_items.destroy',
                'show' => 'second_gold_items.show',
            ]);
    });
  

    
});

Route::get('appraisal/download-saved/{id}', [SecondAppraisalController::class, 'downloadSavedCertificate'])->name('admin.appraisal.downloadSaved');
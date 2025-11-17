<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ForgotPasswordController;
use App\Http\Controllers\Admin\GoldItemController;
use App\Http\Controllers\Admin\SubcategoryController;
use App\Http\Controllers\Admin\WebsiteBannerController;
use App\Http\Controllers\Admin\WebsiteSettingsController;
use App\Http\Controllers\Admin\GoldPriceController;
use App\Http\Controllers\Admin\ManageAdminController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\BranchController;
use App\Http\Controllers\Admin\BankController;
use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\Admin\AgentController;
use App\Http\Controllers\Admin\AppraisalController;
use Illuminate\Support\Facades\Route;
use App\Models\GoldPrice;

// ==============================
// 🌐 Redirect Root → Admin Login
// ==============================
Route::get('/', fn() => redirect()->route('admin.login'));


// ==============================
// 🔐 ADMIN ROUTE GROUP
// ==============================
Route::prefix('admin')->name('admin.')->group(function () {

    // ============================
    // 🧍 Guest Routes (Login / Forgot Password)
    // ============================
    Route::middleware('guest:admin')->group(function () {
        Route::get('login', [AdminController::class, 'showLoginForm'])->name('login');
        Route::post('login', [AdminController::class, 'login']);

        // Forgot Password Flow
        Route::get('forgot-password', [ForgotPasswordController::class, 'showForgotForm'])->name('forgot-password');
        Route::post('send-otp', [ForgotPasswordController::class, 'sendOTP'])->name('send-otp');
        Route::get('verify-otp', [ForgotPasswordController::class, 'showVerifyOTP'])->name('verify-otp');
        Route::post('verify-otp', [ForgotPasswordController::class, 'verifyOTP'])->name('verify-otp');
        Route::get('reset-password', [ForgotPasswordController::class, 'showResetForm'])->name('reset-password');
        Route::post('reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('reset-password');
    });

    // ============================
    // 🛡️ Protected Admin Routes
    // ============================
    Route::middleware('admin')->group(function () {

        // Dashboard
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::post('logout', [AdminController::class, 'logout'])->name('logout');

        // ============================
        // 🧾 Invoices
        // ============================
        Route::resource('invoices', InvoiceController::class);
        Route::get('invoices/search/ajax', [InvoiceController::class, 'index'])->name('invoices.search.ajax');
        Route::get('invoices/{id}/download', [InvoiceController::class, 'downloadPDF'])->name('invoices.download');

        // ============================
        // 🪙 Gold Items
        // ============================
        Route::resource('gold_items', GoldItemController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);

        // ============================
        // 👥 Customers
        // ============================
        Route::resource('customers', CustomerController::class);
        // Route::get('customers/search', ...) <-- DELETE THIS LINE
        Route::post('customers/{customer}/toggle-status', [CustomerController::class, 'toggleStatus'])->name('customers.toggle-status');

        // AJAX: Get Branches by Bank (used in Create Customer)
        Route::get('branches-by-bank/{bankId}', [CustomerController::class, 'getBranchesByBank'])
            ->name('branches.by-bank');
        // AJAX: Get Branches by Bank (used in Create Customer)
Route::get('branches-by-bank/{bankId}', [CustomerController::class, 'getBranchesByBank'])
    ->name('branches.by-bank');

        // ============================
        // 🧑‍💼 Agents
        // ============================
        Route::resource('agent', AgentController::class);
        Route::get('agent/{id}/certificate', [AgentController::class, 'certificate'])->name('agent.certificate');

        // ============================
        // 📂 Subcategories
        // ============================
        Route::resource('subcategories', SubcategoryController::class);
        Route::post('subcategories/{subcategory}/toggle-status', [SubcategoryController::class, 'toggleStatus'])->name('subcategories.toggle-status');
// My Profile (for all admins)
Route::get('profile', [ManageAdminController::class, 'myProfile'])->name('profile');
Route::put('profile', [ManageAdminController::class, 'updateMyProfile'])->name('profile.update');

        // ============================
        // ✉️ Contacts
        // ============================
        Route::resource('contacts', ContactController::class)->except(['create', 'store']);
        Route::post('contacts/{contact}/update-status', [ContactController::class, 'updateStatus'])->name('contacts.update-status');

        // ============================
        // 🏦 Banks & Branches
        // ============================
        Route::resource('bank', BankController::class);
        Route::resource('branch', BranchController::class);

        // ============================
        // ⚙️ Change Credentials
        // ============================
        Route::get('change-credentials', fn() => view('admin.change-credentials.index'))->name('change-credentials');
        Route::put('change-credentials', fn() => redirect()->back()->with('success', 'Password updated successfully!'))->name('change-credentials.update');

        // ============================
        // 🧾 Appraisal
        // ============================
        Route::get('appraisal', [AppraisalController::class, 'index'])->name('appraisal.index');
        Route::get('appraisal/data/{customer}/{type}', [AppraisalController::class, 'getData'])->name('appraisal.data');
        Route::get('appraisal/pdf/{customer}/{type}', [AppraisalController::class, 'downloadPdf'])->name('appraisal.pdf');
Route::get('appraisal/download-again/{id}', 
    [AppraisalController::class, 'downloadAgain']
)->name('appraisal.downloadAgain');

        // ============================
        // 💹 Gold Price
        // ============================
        Route::post('goldprice/store', [GoldPriceController::class, 'store'])->name('goldprice.store');
        Route::get('goldprice/latest', [GoldPriceController::class, 'latest'])->name('goldprice.latest');
        Route::get('goldprice/edit/{id}', [GoldPriceController::class, 'edit'])->name('goldprice.edit');
        Route::post('goldprice/update/{id}', [GoldPriceController::class, 'update'])->name('goldprice.update');
        Route::delete('goldprice/delete/{id}', [GoldPriceController::class, 'destroy'])->name('goldprice.delete');

        // ============================
        // 👑 SUPER ADMIN ROUTES
        // ============================
        Route::middleware('role:super_admin')->group(function () {
            Route::get('manage-admins', [ManageAdminController::class, 'index'])->name('manage_admins.index');
            Route::get('manage-admins/create', [ManageAdminController::class, 'create'])->name('manage_admins.create');
            Route::post('manage-admins', [ManageAdminController::class, 'store'])->name('manage_admins.store');
            Route::get('manage-admins/{admin}/edit', [ManageAdminController::class, 'edit'])->name('manage_admins.edit');
            Route::put('manage-admins/{admin}', [ManageAdminController::class, 'update'])->name('manage_admins.update');
            Route::delete('manage-admins/{admin}', [ManageAdminController::class, 'destroy'])->name('manage_admins.destroy');
        });
    });
});

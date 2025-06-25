<?php

use Illuminate\Support\Facades\Route;

// ==================== Importation des contrôleurs de pages publiques ====================
use App\Http\Controllers\IndexController;
use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\BlogDetailsController;
use App\Http\Controllers\JobsController;
use App\Http\Controllers\JobDetailsController;
use App\Http\Controllers\CandidateDetailsController;
use App\Http\Controllers\RecruitersController;
use App\Http\Controllers\RecruiterDetailsController;
use App\Http\Controllers\PricesController;

// ==================== Importation des contrôleurs d'authentification ====================
use App\Http\Controllers\AuthController;

// ==================== Importation des contrôleurs administratifs ====================
use App\Http\Controllers\AdminController;

// ==================== Importation des contrôleurs de dashboard ====================
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PostulController;

// ==================== Pages publiques ====================
Route::get('/', [IndexController::class, 'index'])->name('index');
Route::get('/about-us', [AboutUsController::class, 'index'])->name('about');
Route::get('/blog', [BlogController::class, 'index'])->name('blog');
Route::get('/load-more-blogs', [BlogController::class, 'loadMore'])->name('blogs.loadMore');
Route::get('/blogs/{id}/modal', [BlogController::class, 'showModal'])->name('blogs.modal');
Route::get('/jobs', [JobsController::class, 'index'])->name('jobs');
Route::get('/jobs/{id}/modal', [JobsController::class, 'showModal'])->name('jobs.modal');
Route::get('/candidate', [CandidateDetailsController::class, 'index'])->name('candidate');
Route::get('/recruiters', [RecruitersController::class, 'index'])->name('recruiters');
Route::get('/recruiters/details', [RecruiterDetailsController::class, 'index'])->name('recruiters.details');
Route::get('/prices', [PricesController::class, 'index'])->name('prices');

// ==================== Authentification ====================
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/verify-email/{token}', [AuthController::class, 'verifyEmail'])->name('verify.email');
Route::get('/password/forgot', [AuthController::class, 'showForgotForm'])->name('password.request');
Route::post('/password/email', [AuthController::class, 'sendResetLink'])->name('password.email');
Route::get('/password/reset/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
Route::post('/password/reset', [AuthController::class, 'resetPassword'])->name('password.update');

// ==================== Pages administratives ====================
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'adminDashboard'])->name('admin.dashboard');

    // Users
    Route::get('/users', [AdminController::class, 'userIndex'])->name('admin.users');
    Route::get('/users/filter', [AdminController::class, 'filterUsers'])->name('admin.users.filter');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('admin.users.store');
    Route::put('/users/{id}', [AdminController::class, 'updateUser'])->name('admin.users.update');
    Route::delete('/users/{id}', [AdminController::class, 'softDeleteUser'])->name('admin.users.softDelete');
    Route::post('/users/{id}/restore', [AdminController::class, 'restoreUser'])->name('admin.users.restore');
    Route::delete('/users/{id}/force', [AdminController::class, 'forceDeleteUser'])->name('admin.users.forceDelete');

    // Announces
    Route::get('/announces',           [AdminController::class, 'announcesIndex'])->name('admin.announces');
    Route::get('/announces/filter',    [AdminController::class, 'filterAnnounces'])->name('admin.announces.filter');
    Route::post('/announces',          [AdminController::class, 'storeAnnounce'])->name('admin.announces.store');
    Route::put('/announces/{id}',      [AdminController::class, 'updateAnnounce'])->name('admin.announces.update');
    Route::delete('/announces/{id}/force',   [AdminController::class, 'forceDeleteAnnounce'])->name('admin.announces.forceDelete');

    // Skills
    Route::get('/skills', [AdminController::class, 'skillsIndex'])->name('admin.skills');
    Route::get('/skills/filter', [AdminController::class, 'filterSkills'])->name('admin.skills.filter');
    Route::post('/skills', [AdminController::class, 'storeSkill'])->name('admin.skills.store');
    Route::put('/skills/{id}', [AdminController::class, 'updateSkill'])->name('admin.skills.update');
    Route::delete('/skills/{id}/force', [AdminController::class, 'forceDeleteSkill'])->name('admin.skills.forceDelete');

    // Languages
    Route::get   ('/languages',               [AdminController::class, 'languagesIndex'])->name('admin.languages');
    Route::get   ('/languages/filter',        [AdminController::class, 'filterLanguages'])->name('admin.languages.filter');
    Route::post  ('/languages',               [AdminController::class, 'storeLanguage'])->name('admin.languages.store');
    Route::put   ('/languages/{id}',          [AdminController::class, 'updateLanguage'])->name('admin.languages.update');
    Route::delete('/languages/{id}/force',    [AdminController::class, 'forceDeleteLanguage'])->name('admin.languages.forceDelete');

    // Education Levels
    Route::get   ('/education',                [AdminController::class, 'educationIndex'])->name('admin.education');
    Route::get   ('/education/filter',         [AdminController::class, 'filterEducation'])->name('admin.education.filter');
    Route::post  ('/education',                [AdminController::class, 'storeEducation'])->name('admin.education.store');
    Route::put   ('/education/{id}',           [AdminController::class, 'updateEducation'])->name('admin.education.update');
    Route::delete('/education/{id}/force',     [AdminController::class, 'forceDeleteEducation'])->name('admin.education.forceDelete');

    // Categories
    Route::get   ('/categories',               [AdminController::class, 'categoriesIndex'])->name('admin.categories');
    Route::get   ('/categories/filter',        [AdminController::class, 'filterCategories'])->name('admin.categories.filter');
    Route::post  ('/categories',               [AdminController::class, 'storeCategory'])->name('admin.categories.store');
    Route::put   ('/categories/{id}',          [AdminController::class, 'updateCategory'])->name('admin.categories.update');
    Route::delete('/categories/{id}/force',    [AdminController::class, 'forceDeleteCategory'])->name('admin.categories.forceDelete');

    // Subscriptions
    Route::get   ('/subscriptions',                   [AdminController::class, 'subscriptionsIndex'])->name('admin.subscriptions');
    Route::get   ('/subscriptions/filter',            [AdminController::class, 'filterSubscriptions'])->name('admin.subscriptions.filter');
    Route::post  ('/subscriptions',                   [AdminController::class, 'storeSubscription'])->name('admin.subscriptions.store');
    Route::put   ('/subscriptions/{id}',              [AdminController::class, 'updateSubscription'])->name('admin.subscriptions.update');
    Route::delete('/subscriptions/{id}/force',        [AdminController::class, 'forceDeleteSubscription'])->name('admin.subscriptions.forceDelete');

    // Blogs
    Route::get('/blogs', [AdminController::class, 'blogsIndex'])->name('admin.blogs');
    Route::get('/blogs/filter', [AdminController::class, 'filterBlogs'])->name('admin.blogs.filter');
    Route::post('/blogs', [AdminController::class, 'storeBlog'])->name('admin.blogs.store');
    Route::put('/blogs/{id}', [AdminController::class, 'updateBlog'])->name('admin.blogs.update');
    Route::delete('/blogs/{id}', [AdminController::class, 'softDeleteBlog'])->name('admin.blogs.softDelete');
    Route::post('/blogs/{id}/restore', [AdminController::class, 'restoreBlog'])->name('admin.blogs.restore');
    Route::delete('/blogs/{id}/force', [AdminController::class, 'forceDeleteBlog'])->name('admin.blogs.forceDelete');

    // Blog Sections
    Route::post  ('/blog-sections',           [AdminController::class, 'storeBlogSection'])->name('admin.blogSections.store');
    Route::put   ('/blog-sections/{id}',      [AdminController::class, 'updateBlogSection'])->name('admin.blogSections.update');
    Route::delete('/blog-sections/{id}/force', [AdminController::class, 'forceDeleteBlogSection'])->name('admin.blogSections.forceDelete');

    // Staff
    Route::get   ('/staff',                [AdminController::class, 'staffIndex'])->name('admin.staff');
    Route::get   ('/staff/filter',         [AdminController::class, 'filterStaff'])->name('admin.staff.filter');
    Route::post  ('/staff',                [AdminController::class, 'storeStaff'])->name('admin.staff.store');
    Route::put   ('/staff/{id}',           [AdminController::class, 'updateStaff'])->name('admin.staff.update');
    Route::delete('/staff/{id}/force',     [AdminController::class, 'forceDeleteStaff'])->name('admin.staff.forceDelete');
});


// ==================== Routes pour les utilisateurs connectés ====================
// ==================== CANDIDAT ====================
Route::prefix('dashboard/candidate')
    ->middleware(['auth', 'candidate'])
    ->group(function () {
        Route::get('/', [DashboardController::class, 'dashboard'])->name('dashboard.candidate');
        Route::delete('/postuls/{postul}/archive', [PostulController::class, 'archive'])->name('postuls.archive');
        Route::delete('/postuls/{postul}/unarchive', [PostulController::class, 'unarchive'])->name('postuls.unarchive');
        Route::get('/profile', [DashboardController::class, 'profile'])->name('dashboard.candidate.profile');
        Route::post('/postuls', [PostulController::class, 'store'])->middleware('auth')->name('postuls.store');
        Route::get('/settings', [DashboardController::class, 'settings'])->name('dashboard.settings');
        Route::put('/settings', [DashboardController::class, 'update'])->name('dashboard.settings.update');
        Route::post('/settings/reset-password', [DashboardController::class, 'sendResetPassword'])->name('dashboard.settings.resetPassword');
        Route::get('/profile/{id}/public', [DashboardController::class, 'showPublicProfile'])->name('dashboard.profile.public');
    });

// ==================== RECRUTEUR ====================
Route::prefix('dashboard/recruiter')
    ->middleware(['auth', 'recruiter'])
    ->group(function () {
        Route::get('/', [DashboardController::class, 'dashboard'])->name('dashboard.recruiter');
        Route::get('/profile', [DashboardController::class, 'profile'])->name('dashboard.recruiter.profile');
    });
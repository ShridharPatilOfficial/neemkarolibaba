<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\ActivitiesController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DonateController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\FuturePlanController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JoinUsController;
use App\Http\Controllers\MediaCoverageController;
use App\Http\Controllers\WorkInActionController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SiteSettingController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\ImpactStatController;
use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\Admin\FounderMemberController;
use App\Http\Controllers\Admin\OrgProfileController;
use App\Http\Controllers\Admin\DocumentController;
use App\Http\Controllers\Admin\GalleryItemController;
use App\Http\Controllers\Admin\PresidentMessageController;
use App\Http\Controllers\Admin\DonateSettingController;
use App\Http\Controllers\Admin\SubmissionController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\PrincipleController;
use App\Http\Controllers\Admin\TrustObjectiveController;
use App\Http\Controllers\Admin\WorkVideoController;
use App\Http\Controllers\Admin\MediaCoverageController as AdminMediaCoverageController;
use App\Http\Controllers\Admin\AnalyticsController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Models\Document;

// ─── Sitemap ─────────────────────────────────────────────────────────────────
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

// ─── Public Routes ───────────────────────────────────────────────────────────
Route::middleware('track.visitor')->group(function () {

    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::get('/about-us', [AboutController::class, 'index'])->name('about');
    Route::get('/about/founder-members', [AboutController::class, 'founderMembers'])->name('about.founders');
    Route::get('/about/organisation-profile', [AboutController::class, 'orgProfile'])->name('about.org-profile');
    Route::get('/about/documents', [AboutController::class, 'documents'])->name('about.documents');
    Route::get('/about/objectives', [AboutController::class, 'objectives'])->name('about.objectives');

    Route::get('/documents/{id}/view', function (int $id) {
        $doc = Document::where('is_active', true)->findOrFail($id);
        if ($doc->file_type === 'pdf') {
            return response()->file(Storage::disk('public')->path($doc->file_path), [
                'Content-Type'        => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . basename($doc->file_path) . '"',
            ]);
        }
        return Storage::disk('public')->download($doc->file_path, $doc->name . '.' . $doc->file_type);
    })->name('documents.view');

    Route::get('/our-activities', [ActivitiesController::class, 'index'])->name('activities');
    Route::get('/events', [EventsController::class, 'index'])->name('events');
    Route::get('/future-plan', [FuturePlanController::class, 'index'])->name('future-plan');

    Route::get('/join-us', [JoinUsController::class, 'index'])->name('join-us');
    Route::post('/join-us', [JoinUsController::class, 'store'])->name('join-us.store');

    Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery');

    Route::get('/contact-us', [ContactController::class, 'index'])->name('contact');
    Route::post('/contact-us', [ContactController::class, 'store'])->name('contact.store');

    Route::get('/donate-us', [DonateController::class, 'index'])->name('donate');
    Route::get('/media-coverage', [MediaCoverageController::class, 'index'])->name('media-coverage');
    Route::get('/work-in-action', [WorkInActionController::class, 'index'])->name('work-in-action');
});

// ─── Admin Auth ───────────────────────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::middleware('admin.auth')->group(function () {

        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/dashboard', [DashboardController::class, 'index']);
        Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics');

        Route::get('/settings', [SiteSettingController::class, 'index'])->name('settings');
        Route::post('/settings', [SiteSettingController::class, 'update'])->name('settings.update');

        Route::resource('sliders', SliderController::class)->except(['show']);
        Route::resource('partners', PartnerController::class)->except(['show']);
        Route::resource('stats', ImpactStatController::class)->except(['show']);

        Route::get('/content/{type}', [ContentController::class, 'index'])->name('content.index');
        Route::get('/content/{type}/create', [ContentController::class, 'create'])->name('content.create');
        Route::post('/content/{type}', [ContentController::class, 'store'])->name('content.store');
        Route::get('/content/{type}/{id}/edit', [ContentController::class, 'edit'])->name('content.edit');
        Route::put('/content/{type}/{id}', [ContentController::class, 'update'])->name('content.update');
        Route::delete('/content/{type}/{id}', [ContentController::class, 'destroy'])->name('content.destroy');

        Route::resource('members', FounderMemberController::class)->except(['show'])
            ->parameters(['members' => 'member']);

        Route::resource('org-profile', OrgProfileController::class)->except(['show'])
            ->parameters(['org-profile' => 'orgProfile']);

        Route::resource('documents', DocumentController::class)->except(['show']);
        Route::resource('gallery', GalleryItemController::class)->except(['show'])
            ->parameters(['gallery' => 'gallery']);
        Route::resource('president', PresidentMessageController::class)->except(['show'])
            ->parameters(['president' => 'president']);

        Route::get('/donate-settings', [DonateSettingController::class, 'index'])->name('donate.index');
        Route::post('/donate-settings', [DonateSettingController::class, 'update'])->name('donate.update');

        Route::get('/submissions/join-us', [SubmissionController::class, 'joinUs'])->name('submissions.join-us');
        Route::delete('/submissions/join-us/{joinUsSubmission}', [SubmissionController::class, 'destroyJoin'])->name('submissions.join-us.destroy');
        Route::get('/submissions/contact', [SubmissionController::class, 'contact'])->name('submissions.contact');
        Route::delete('/submissions/contact/{contactSubmission}', [SubmissionController::class, 'destroyContact'])->name('submissions.contact.destroy');

        Route::resource('users', AdminUserController::class)->except(['show'])
            ->parameters(['users' => 'user']);

        Route::resource('principles', PrincipleController::class)->except(['show'])
            ->parameters(['principles' => 'principle']);

        Route::resource('trust-objectives', TrustObjectiveController::class)->except(['show'])
            ->parameters(['trust-objectives' => 'trustObjective']);

        Route::resource('work-videos', WorkVideoController::class)->except(['show'])
            ->parameters(['work-videos' => 'workVideo']);

        Route::resource('media-coverage', AdminMediaCoverageController::class)->except(['show'])
            ->parameters(['media-coverage' => 'mediaCoverage']);
    });
});

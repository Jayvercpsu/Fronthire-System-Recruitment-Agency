<?php

use App\Http\Controllers\Admin\ContactController as AdminContactController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\InquiryController as AdminInquiryController;
use App\Http\Controllers\Admin\ApplicationController as AdminApplicationController;
use App\Http\Controllers\Admin\ExportController as AdminExportController;
use App\Http\Controllers\Admin\JobController as AdminJobController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Employer\ApplicantController as EmployerApplicantController;
use App\Http\Controllers\Employer\CompanyProfileController as EmployerCompanyProfileController;
use App\Http\Controllers\Employer\DashboardController as EmployerDashboardController;
use App\Http\Controllers\Employer\JobController as EmployerJobController;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\JobSeeker\ApplicationController as JobSeekerApplicationController;
use App\Http\Controllers\JobSeeker\DashboardController as JobSeekerDashboardController;
use App\Http\Controllers\JobSeeker\EducationController as JobSeekerEducationController;
use App\Http\Controllers\JobSeeker\ExperienceController as JobSeekerExperienceController;
use App\Http\Controllers\JobSeeker\JobBrowseController as JobSeekerJobBrowseController;
use App\Http\Controllers\JobSeeker\ProfileController as JobSeekerProfileController;
use App\Http\Controllers\Messaging\ConversationController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResumeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/employers', [PageController::class, 'employers'])->name('employers');
Route::get('/job-seekers', [PageController::class, 'jobSeekers'])->name('job-seekers');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');

Route::post('/inquiries/general', [InquiryController::class, 'storeGeneral'])
    ->middleware('throttle:contact-form')
    ->name('inquiries.general.store');

Route::post('/inquiries/employer', [InquiryController::class, 'storeEmployer'])
    ->middleware('throttle:employer-inquiry')
    ->name('inquiries.employer.store');

Route::post('/contact', [ContactController::class, 'store'])
    ->middleware('throttle:contact-form')
    ->name('contact.store');

Route::middleware(['auth', 'verified.role'])->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::patch('/notifications/read-all', [NotificationController::class, 'markAllRead'])->name('notifications.read-all');
    Route::patch('/notifications/{notification}', [NotificationController::class, 'markRead'])->name('notifications.read');
    Route::get('/resumes/{resume}', [ResumeController::class, 'show'])->name('resumes.show');
    Route::get('/resumes/{resume}/download', [ResumeController::class, 'download'])->name('resumes.download');
    Route::delete('/resumes/{resume}', [ResumeController::class, 'destroy'])->name('resumes.destroy');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified.role', 'role:employer'])->prefix('employer')->name('employer.')->group(function () {
    Route::get('/dashboard', [EmployerDashboardController::class, 'index'])->name('dashboard');

    Route::resource('jobs', EmployerJobController::class)->except('show');
    Route::get('/jobs/{job}/applicants', [EmployerApplicantController::class, 'index'])->name('jobs.applicants.index');
    Route::patch('/jobs/{job}/applications/{application}', [EmployerApplicantController::class, 'update'])->name('jobs.applications.update');

    Route::get('/company-profile', [EmployerCompanyProfileController::class, 'edit'])->name('company-profile.edit');
    Route::patch('/company-profile', [EmployerCompanyProfileController::class, 'update'])->name('company-profile.update');
});

Route::middleware(['auth', 'verified.role', 'role:job_seeker'])->prefix('job-seeker')->name('job-seeker.')->group(function () {
    Route::get('/dashboard', [JobSeekerDashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile-builder', [JobSeekerProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile-builder', [JobSeekerProfileController::class, 'update'])->name('profile.update');

    Route::post('/education', [JobSeekerEducationController::class, 'store'])->name('education.store');
    Route::patch('/education/{education}', [JobSeekerEducationController::class, 'update'])->name('education.update');
    Route::delete('/education/{education}', [JobSeekerEducationController::class, 'destroy'])->name('education.destroy');

    Route::post('/experiences', [JobSeekerExperienceController::class, 'store'])->name('experiences.store');
    Route::patch('/experiences/{experience}', [JobSeekerExperienceController::class, 'update'])->name('experiences.update');
    Route::delete('/experiences/{experience}', [JobSeekerExperienceController::class, 'destroy'])->name('experiences.destroy');

    Route::post('/resume', [ResumeController::class, 'store'])->name('resume.store');

    Route::get('/jobs', [JobSeekerJobBrowseController::class, 'index'])->name('jobs.index');
    Route::get('/jobs/{job}', [JobSeekerJobBrowseController::class, 'show'])->name('jobs.show');
    Route::post('/jobs/{job}/apply', [JobSeekerApplicationController::class, 'store'])
        ->middleware('throttle:job-apply')
        ->name('jobs.apply');

    Route::get('/applications', [JobSeekerApplicationController::class, 'index'])->name('applications.index');
    Route::get('/applications/{application}', [JobSeekerApplicationController::class, 'show'])->name('applications.show');
    Route::patch('/applications/{application}/withdraw', [JobSeekerApplicationController::class, 'withdraw'])->name('applications.withdraw');
});

Route::post('/job-seekers/resume', [ResumeController::class, 'store'])
    ->middleware(['auth', 'verified.role', 'role:job_seeker'])
    ->name('job-seekers.resume.store');

Route::middleware(['auth', 'verified.role', 'role:employer,job_seeker'])->prefix('chat')->name('chat.')->group(function () {
    Route::get('/', [ConversationController::class, 'index'])->name('index');
    Route::get('/{conversation}', [ConversationController::class, 'show'])->name('show');
    Route::post('/{conversation}/messages', [ConversationController::class, 'storeMessage'])
        ->middleware('throttle:messages-send')
        ->name('messages.store');
});

Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [AdminUserController::class, 'show'])->name('users.show');
    Route::patch('/users/{user}/status', [AdminUserController::class, 'updateStatus'])->name('users.status.update');
    Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');

    Route::get('/jobs', [AdminJobController::class, 'index'])->name('jobs.index');
    Route::patch('/jobs/{job}/status', [AdminJobController::class, 'updateStatus'])->name('jobs.status.update');
    Route::delete('/jobs/{job}', [AdminJobController::class, 'destroy'])->name('jobs.destroy');

    Route::get('/applications', [AdminApplicationController::class, 'index'])->name('applications.index');
    Route::get('/applications/{application}', [AdminApplicationController::class, 'show'])->name('applications.show');

    Route::get('/export/users', [AdminExportController::class, 'users'])->name('export.users');
    Route::get('/export/jobs', [AdminExportController::class, 'jobs'])->name('export.jobs');
    Route::get('/export/applications', [AdminExportController::class, 'applications'])->name('export.applications');

    Route::get('/inquiries', [AdminInquiryController::class, 'index'])->name('inquiries.index');
    Route::get('/inquiries/{inquiry}', [AdminInquiryController::class, 'show'])->name('inquiries.show');
    Route::delete('/inquiries/{inquiry}', [AdminInquiryController::class, 'destroy'])->name('inquiries.destroy');

    Route::get('/contacts', [AdminContactController::class, 'index'])->name('contacts.index');
    Route::get('/contacts/{contact}', [AdminContactController::class, 'show'])->name('contacts.show');
    Route::delete('/contacts/{contact}', [AdminContactController::class, 'destroy'])->name('contacts.destroy');
});

require __DIR__.'/auth.php';

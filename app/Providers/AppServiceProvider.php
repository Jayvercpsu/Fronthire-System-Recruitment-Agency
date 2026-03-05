<?php

namespace App\Providers;

use App\Models\Application;
use App\Models\Conversation;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Job;
use App\Models\Resume;
use App\Policies\ApplicationPolicy;
use App\Policies\ConversationPolicy;
use App\Policies\EducationPolicy;
use App\Policies\ExperiencePolicy;
use App\Policies\JobPolicy;
use App\Policies\ResumePolicy;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);

        Gate::policy(Job::class, JobPolicy::class);
        Gate::policy(Application::class, ApplicationPolicy::class);
        Gate::policy(Conversation::class, ConversationPolicy::class);
        Gate::policy(Education::class, EducationPolicy::class);
        Gate::policy(Experience::class, ExperiencePolicy::class);
        Gate::policy(Resume::class, ResumePolicy::class);

        Password::defaults(function () {
            return Password::min(10)
                ->letters()
                ->mixedCase()
                ->numbers()
                ->symbols();
        });

        RateLimiter::for('contact-form', function (Request $request) {
            return Limit::perMinute(5)->by($request->ip());
        });

        RateLimiter::for('employer-inquiry', function (Request $request) {
            return Limit::perMinute(5)->by($request->ip());
        });

        RateLimiter::for('job-apply', function (Request $request) {
            $user = $request->user();

            return Limit::perMinute(8)->by($user?->id ? "{$user->id}:apply" : $request->ip());
        });

        RateLimiter::for('messages-send', function (Request $request) {
            $user = $request->user();

            return Limit::perMinute(30)->by($user?->id ? "{$user->id}:message" : $request->ip());
        });
    }
}

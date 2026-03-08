@extends('layouts.public')

@section('title', 'Job Seekers | FrontHire Opportunities')
@section('meta_description', 'Create your FrontHire job seeker account and connect with quality opportunities in Calgary.')
@section('page_id', 'job-seekers')

@section('content')
<section class="relative overflow-hidden text-white">
    <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1573496130141-209d200cebd8?auto=format&fit=crop&w=2200&q=80')] bg-cover bg-center"></div>
    <div class="absolute inset-0 bg-gradient-to-r from-emerald-900/80 via-emerald-700/65 to-lime-700/35"></div>
    <div class="absolute inset-0 opacity-20" style="background-image: radial-gradient(circle at 1px 1px, rgba(255,255,255,0.35) 1px, transparent 0); background-size: 22px 22px;"></div>
    <div class="absolute -bottom-20 left-10 h-72 w-[30rem] rounded-[100%] border border-white/25 bg-gradient-to-r from-emerald-700/25 to-lime-200/20"></div>
    <div class="relative mx-auto grid w-full max-w-7xl gap-10 px-4 py-20 sm:px-6 lg:grid-cols-2 lg:px-8 lg:py-24">
        <div data-reveal data-aos="fade-up" data-aos-delay="80">
            <p class="mb-4 inline-flex rounded-full bg-white/20 px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em]">For Job Seekers</p>
            <h1 class="font-heading text-4xl font-extrabold leading-tight text-white drop-shadow sm:text-6xl">Find opportunities that match your skills and goals.</h1>
            <p class="mt-5 max-w-2xl text-base leading-relaxed text-emerald-50 sm:text-lg">FrontHire helps candidates discover quality roles faster with clear communication, transparent updates, and real recruiter support.</p>
            <a href="{{ route('register', ['role' => 'job_seeker']) }}" class="mt-8 inline-flex rounded-xl bg-white px-6 py-3 text-sm font-semibold text-emerald-700 shadow-lg shadow-emerald-900/20 transition hover:bg-emerald-50">Create Job Seeker Account</a>
        </div>
        <div data-reveal data-aos="fade-left" data-aos-delay="120">
            <img src="https://images.unsplash.com/photo-1484981138541-3d074aa97716?auto=format&fit=crop&w=1400&q=80" alt="Job seeker preparing for interview" class="h-full w-full rounded-3xl border border-white/30 object-cover shadow-2xl">
        </div>
    </div>
</section>

<section class="mx-auto w-full max-w-7xl px-4 py-16 sm:px-6 lg:px-8" data-aos="fade-up" data-aos-delay="80">
    <div class="mb-10 max-w-2xl" data-reveal>
        <p class="eyebrow">Benefits</p>
        <h2 class="section-title">Why candidates choose FrontHire</h2>
    </div>

    <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
        <article data-reveal data-aos="zoom-in" data-aos-delay="90" class="card-soft text-center">
            <i class="ri-briefcase-4-line text-3xl text-emerald-600"></i>
            <h3 class="mt-3 font-semibold text-slate-900">Quality Roles</h3>
            <p class="mt-2 text-sm text-slate-600">Access openings from trusted employers.</p>
        </article>
        <article data-reveal data-aos="zoom-in" data-aos-delay="130" class="card-soft text-center">
            <i class="ri-chat-follow-up-line text-3xl text-emerald-600"></i>
            <h3 class="mt-3 font-semibold text-slate-900">Guided Process</h3>
            <p class="mt-2 text-sm text-slate-600">Receive updates and support through hiring stages.</p>
        </article>
        <article data-reveal data-aos="zoom-in" data-aos-delay="170" class="card-soft text-center">
            <i class="ri-shield-user-line text-3xl text-emerald-600"></i>
            <h3 class="mt-3 font-semibold text-slate-900">Fair Screening</h3>
            <p class="mt-2 text-sm text-slate-600">Transparent screening focused on your strengths.</p>
        </article>
        <article data-reveal data-aos="zoom-in" data-aos-delay="210" class="card-soft text-center">
            <i class="ri-rocket-line text-3xl text-emerald-600"></i>
            <h3 class="mt-3 font-semibold text-slate-900">Career Growth</h3>
            <p class="mt-2 text-sm text-slate-600">Find roles that can move your career forward.</p>
        </article>
    </div>
</section>

<section class="bg-white py-16" data-aos="fade-up" data-aos-delay="80">
    <div class="mx-auto w-full max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="mb-8 max-w-2xl" data-reveal>
            <p class="eyebrow">Optional Resume Upload</p>
            <h2 class="section-title">Upload your resume for faster matching</h2>
        </div>

        @auth
            @if (auth()->user()->role === 'job_seeker')
                <div class="card-soft max-w-3xl" data-reveal data-aos="fade-up" data-aos-delay="120">
                    @if ($errors->has('resume'))
                        <div class="mb-4 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
                            {{ $errors->first('resume') }}
                        </div>
                    @endif

                    @if (! auth()->user()->hasVerifiedEmail())
                        <div class="mb-4 rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-700">
                            Verify your email before uploading a resume.
                        </div>
                    @endif

                    <form method="POST" action="{{ route('job-seekers.resume.store') }}" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <div>
                            <label for="resume" class="form-label">Resume File (PDF, DOC, DOCX up to 5MB)</label>
                            <input id="resume" name="resume" class="form-input file:mr-3 file:rounded-lg file:border-0 file:bg-emerald-100 file:px-3 file:py-2 file:text-sm file:font-semibold file:text-emerald-700" type="file" accept=".pdf,.doc,.docx" required>
                        </div>
                        <button type="submit" class="btn-primary" @if(! auth()->user()->hasVerifiedEmail()) disabled @endif>Upload Resume</button>
                    </form>

                    @if ($latestResume)
                        <p class="mt-4 text-sm text-slate-600">Latest upload: <span class="font-semibold text-slate-900">{{ $latestResume->original_name }}</span> ({{ $latestResume->created_at->format('M d, Y h:i A') }})</p>
                    @endif
                </div>
            @else
                <div class="card-soft max-w-3xl" data-reveal>
                    <p class="text-sm text-slate-600">Resume upload is available for job seeker accounts only.</p>
                </div>
            @endif
        @else
            <div class="card-soft max-w-3xl" data-reveal>
                <p class="text-sm text-slate-600">Please <a href="{{ route('login') }}" class="font-semibold text-emerald-700 hover:underline">sign in</a> or <a href="{{ route('register', ['role' => 'job_seeker']) }}" class="font-semibold text-emerald-700 hover:underline">create a job seeker account</a> to upload your resume.</p>
            </div>
        @endauth
    </div>
</section>
@endsection

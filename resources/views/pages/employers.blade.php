@extends('layouts.public')

@section('title', 'Employers | FrontHire Staffing Services')
@section('meta_description', 'Recruitment, screening, payroll support, and temporary staffing services tailored for employers.')
@section('page_id', 'employers')

@section('content')
<section class="relative isolate overflow-hidden text-white">
    <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1521791136064-7986c2920216?auto=format&fit=crop&w=2200&q=80')] bg-cover bg-center"></div>
    <div class="absolute inset-0 bg-gradient-to-r from-emerald-900/80 via-emerald-700/65 to-lime-700/35"></div>
    <div class="absolute inset-0 opacity-20" style="background-image: radial-gradient(circle at 1px 1px, rgba(255,255,255,0.38) 1px, transparent 0); background-size: 24px 24px;"></div>
    <div aria-hidden="true" class="pointer-events-none absolute -bottom-14 -left-20 h-64 w-[22rem] rounded-[100%] bg-gradient-to-r from-emerald-900/45 via-emerald-600/30 to-lime-300/40 blur-sm sm:-bottom-24 sm:h-96 sm:w-[42rem]"></div>
    <div aria-hidden="true" class="pointer-events-none absolute -bottom-10 left-3 h-40 w-[16rem] rounded-[100%] border border-white/25 bg-gradient-to-r from-emerald-700/25 to-lime-200/20 sm:-bottom-20 sm:left-10 sm:h-72 sm:w-[30rem]"></div>

    <div class="relative mx-auto w-full max-w-7xl px-4 py-20 sm:px-6 lg:px-8 lg:py-24" data-reveal data-aos="fade-up" data-aos-delay="80">
        <p class="mb-4 inline-flex rounded-full bg-white/20 px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em]">For Employers</p>
        <h1 class="max-w-4xl font-heading text-3xl font-extrabold leading-tight text-white drop-shadow sm:text-5xl lg:text-6xl">Scale your team with trusted staffing support.</h1>
        <p class="mt-5 max-w-3xl text-base leading-relaxed text-emerald-50 sm:text-lg">FrontHire helps you hire the right people quickly while keeping quality, productivity, and compliance in focus.</p>
        <a href="{{ route('register', ['role' => 'employer']) }}" class="mt-8 inline-flex rounded-xl bg-white px-6 py-3 text-sm font-semibold text-emerald-700 shadow-lg shadow-emerald-900/20 transition hover:bg-emerald-50">Create Employer Account</a>
    </div>
</section>

<section class="mx-auto w-full max-w-7xl px-4 py-16 sm:px-6 lg:px-8" data-aos="fade-up" data-aos-delay="80">
    <div class="mb-10 max-w-2xl" data-reveal>
        <p class="eyebrow">Services</p>
        <h2 class="section-title">Flexible manpower solutions for modern operations</h2>
    </div>

    <div class="grid gap-5 md:grid-cols-2">
        <article data-reveal data-aos="fade-up" data-aos-delay="100" class="card-soft">
            <h3 class="font-heading text-xl font-bold text-slate-900">Recruitment</h3>
            <p class="mt-2 text-sm leading-relaxed text-slate-600">Targeted sourcing to find qualified candidates for urgent and long-term hiring needs.</p>
        </article>
        <article data-reveal data-aos="fade-up" data-aos-delay="140" class="card-soft">
            <h3 class="font-heading text-xl font-bold text-slate-900">Screening</h3>
            <p class="mt-2 text-sm leading-relaxed text-slate-600">Interview, reference, and fit-based screening to reduce hiring risk and improve retention.</p>
        </article>
        <article data-reveal data-aos="fade-up" data-aos-delay="180" class="card-soft">
            <h3 class="font-heading text-xl font-bold text-slate-900">Payroll Support</h3>
            <p class="mt-2 text-sm leading-relaxed text-slate-600">Support for payroll administration and workforce coordination for smoother operations.</p>
        </article>
        <article data-reveal data-aos="fade-up" data-aos-delay="220" class="card-soft">
            <h3 class="font-heading text-xl font-bold text-slate-900">Temporary Staffing</h3>
            <p class="mt-2 text-sm leading-relaxed text-slate-600">Quick deployment of temporary manpower for seasonal peaks, projects, and shift gaps.</p>
        </article>
    </div>
</section>

<section class="bg-white py-16" data-aos="fade-up" data-aos-delay="80">
    <div class="mx-auto grid w-full max-w-7xl gap-8 px-4 sm:px-6 lg:grid-cols-2 lg:px-8">
        <div data-reveal data-aos="fade-right" data-aos-delay="100">
            <p class="eyebrow">Employer Inquiry</p>
            <h2 class="section-title">Tell us your staffing requirements</h2>
            <p class="mt-4 text-sm leading-relaxed text-slate-600">Submit your request and our team will contact you with staffing options.</p>
            <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?auto=format&fit=crop&w=1200&q=80" alt="Business team meeting" class="mt-6 h-64 w-full rounded-2xl object-cover">
        </div>

        <div data-reveal data-aos="fade-left" data-aos-delay="120" class="card-soft">
            @if ($errors->any())
                <div class="mb-4 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
                    Please review your submission and try again.
                </div>
            @endif

            <form method="POST" action="{{ route('inquiries.employer.store') }}" class="space-y-4" x-data="{ submitting: false }" @submit="submitting = true">
                @csrf
                <div>
                    <div class="floating-group">
                        <input id="company_name" name="company_name" value="{{ old('company_name') }}" required class="floating-input" type="text" placeholder=" ">
                        <label for="company_name" class="floating-label">Company Name</label>
                    </div>
                    @error('company_name') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                <div>
                    <div class="floating-group">
                        <input id="email" name="email" value="{{ old('email') }}" required class="floating-input" type="email" placeholder=" ">
                        <label for="email" class="floating-label">Email</label>
                    </div>
                    @error('email') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                <div>
                    <div class="floating-group">
                        <input id="phone" name="phone" value="{{ old('phone') }}" class="floating-input" type="text" placeholder=" ">
                        <label for="phone" class="floating-label">Phone</label>
                    </div>
                    @error('phone') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                <div>
                    <div class="floating-group">
                        <textarea id="message" name="message" rows="5" required minlength="5" class="floating-input" placeholder=" ">{{ old('message') }}</textarea>
                        <label for="message" class="floating-label">Message</label>
                    </div>
                    <p class="mt-1 text-xs font-medium text-slate-500">Minimum 5 characters.</p>
                    @error('message') <p class="form-error">{{ $message }}</p> @enderror
                </div>
                <button
                    type="submit"
                    :disabled="submitting"
                    :class="submitting ? 'cursor-not-allowed opacity-80' : ''"
                    :aria-busy="submitting"
                    class="btn-primary w-full justify-center"
                >
                    <span x-show="!submitting">Submit Inquiry</span>
                    <span x-show="submitting" class="inline-flex items-center gap-2">
                        <svg class="h-4 w-4 animate-spin" viewBox="0 0 24 24" fill="none">
                            <circle class="opacity-30" cx="12" cy="12" r="9" stroke="currentColor" stroke-width="3"></circle>
                            <path d="M12 3a9 9 0 0 1 9 9" stroke="currentColor" stroke-width="3" stroke-linecap="round"></path>
                        </svg>
                        Sending...
                    </span>
                </button>
            </form>
        </div>
    </div>
</section>

<section class="relative overflow-hidden py-24 text-white" data-aos="fade-up" data-aos-delay="90">
    <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1551836022-d5d88e9218df?auto=format&fit=crop&w=2200&q=80')] bg-cover bg-center"></div>
    <div class="absolute inset-0 bg-slate-900/55"></div>
    <div class="relative mx-auto w-full max-w-7xl px-4 text-center sm:px-6 lg:px-8" data-reveal>
        <h2 class="font-heading text-4xl font-extrabold tracking-wide sm:text-6xl">Accountants, Engineers, Chefs, Mechanics</h2>
        <p class="mt-3 text-3xl font-bold sm:text-5xl">What's your field?</p>
        <a href="{{ route('contact') }}" class="mt-8 inline-flex rounded-xl bg-emerald-600 px-8 py-3 text-base font-semibold text-white transition hover:bg-emerald-700">Contact Us</a>
    </div>
</section>
@endsection

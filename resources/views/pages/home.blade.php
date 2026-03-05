@extends('layouts.public')

@section('title', 'FrontHire | Recruitment & Staffing in Calgary')
@section('meta_description', 'FrontHire connects employers with dependable staffing and helps job seekers secure quality opportunities across industries.')
@section('page_id', 'home')

@section('content')
<section id="hero" class="relative overflow-hidden bg-gradient-to-r from-[#238f3e] via-[#74bf62] to-[#d7e4be] text-white">
    <div class="absolute inset-0 opacity-25" style="background-image: radial-gradient(circle at 1px 1px, rgba(255,255,255,0.38) 1px, transparent 0); background-size: 24px 24px;"></div>
    <div class="absolute -bottom-24 -left-20 h-96 w-[42rem] rounded-[100%] bg-gradient-to-r from-emerald-900/45 via-emerald-600/30 to-lime-300/40 blur-sm"></div>
    <div class="absolute -bottom-20 left-10 h-72 w-[30rem] rounded-[100%] border border-white/25 bg-gradient-to-r from-emerald-700/25 to-lime-200/20"></div>

    <div class="relative mx-auto grid w-full max-w-7xl gap-10 px-4 py-20 sm:px-6 lg:grid-cols-2 lg:px-8 lg:py-28">
        <div data-reveal data-aos="fade-up" data-aos-delay="80">
            <p class="mb-4 inline-flex rounded-full bg-white/20 px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em]">Calgary Recruitment Partner</p>
            <h1 class="font-heading text-4xl font-extrabold leading-tight text-white drop-shadow sm:text-6xl">Connecting reliable talent with growing businesses</h1>
            <p class="mt-5 max-w-xl text-base leading-relaxed text-emerald-50 sm:text-lg">FrontHire Manpower Agency provides skilled, pre-screened workers ready to perform from Day One.</p>
            <div class="mt-8 flex flex-wrap gap-3">
                <a href="{{ route('employers') }}" class="btn-gold">Hire Staff</a>
                <a href="{{ route('job-seekers') }}" class="btn-white-outline">Find Jobs</a>
            </div>
        </div>

        <div data-reveal data-aos="fade-left" data-aos-delay="120" class="relative">
            <img src="https://images.unsplash.com/photo-1521737604893-d14cc237f11d?auto=format&fit=crop&w=1400&q=80" alt="FrontHire professionals ready for work" class="h-full w-full rounded-3xl border border-white/30 object-cover shadow-2xl">
            <div class="absolute -bottom-6 left-6 rounded-2xl border border-emerald-200/40 bg-white/92 px-5 py-4 text-slate-900 shadow-xl">
                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-emerald-700">Placement Success</p>
                <p class="mt-1 text-2xl font-extrabold">95%</p>
            </div>
        </div>
    </div>
</section>

<section id="how-it-works" class="mx-auto w-full max-w-7xl px-4 py-16 sm:px-6 lg:px-8" data-aos="fade-up" data-aos-delay="60">
    <div class="mb-10 max-w-2xl" data-reveal>
        <p class="eyebrow">How It Works</p>
        <h2 class="section-title">Simple process, high-quality hiring outcomes</h2>
    </div>
    <div class="grid gap-5 md:grid-cols-3">
        <article data-reveal data-aos="fade-up" data-aos-delay="80" class="card-soft">
            <span class="badge-step">01</span>
            <h3 class="mt-4 font-heading text-xl font-bold text-slate-900">Tell us your needs</h3>
            <p class="mt-3 text-sm leading-relaxed text-slate-600">Share role requirements, shift schedules, and preferred candidate profiles.</p>
        </article>
        <article data-reveal data-aos="fade-up" data-aos-delay="140" class="card-soft">
            <span class="badge-step">02</span>
            <h3 class="mt-4 font-heading text-xl font-bold text-slate-900">We source and screen</h3>
            <p class="mt-3 text-sm leading-relaxed text-slate-600">Our recruiters shortlist vetted talent using skill, reliability, and fit-based checks.</p>
        </article>
        <article data-reveal data-aos="fade-up" data-aos-delay="200" class="card-soft">
            <span class="badge-step">03</span>
            <h3 class="mt-4 font-heading text-xl font-bold text-slate-900">You onboard quickly</h3>
            <p class="mt-3 text-sm leading-relaxed text-slate-600">Move from request to placement with clear communication and rapid turnaround.</p>
        </article>
    </div>
</section>

<section id="why-choose" class="bg-white py-16" data-aos="fade-up" data-aos-delay="60">
    <div class="mx-auto w-full max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="mb-10 max-w-2xl" data-reveal>
            <p class="eyebrow">Why Choose FrontHire</p>
            <h2 class="section-title">Built for reliable, scalable workforce delivery</h2>
        </div>
        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
            <div data-reveal data-aos="zoom-in" data-aos-delay="80" class="card-soft text-center">
                <i class="ri-shield-check-line text-3xl text-emerald-600"></i>
                <h3 class="mt-3 font-semibold text-slate-900">Vetted Talent</h3>
                <p class="mt-2 text-sm text-slate-600">Pre-screened candidates with role-fit verification.</p>
            </div>
            <div data-reveal data-aos="zoom-in" data-aos-delay="130" class="card-soft text-center">
                <i class="ri-time-line text-3xl text-emerald-600"></i>
                <h3 class="mt-3 font-semibold text-slate-900">Fast Turnaround</h3>
                <p class="mt-2 text-sm text-slate-600">Speedy hiring timelines without quality compromise.</p>
            </div>
            <div data-reveal data-aos="zoom-in" data-aos-delay="180" class="card-soft text-center">
                <i class="ri-hand-coin-line text-3xl text-emerald-600"></i>
                <h3 class="mt-3 font-semibold text-slate-900">Flexible Models</h3>
                <p class="mt-2 text-sm text-slate-600">Temporary, contract, and permanent staffing support.</p>
            </div>
            <div data-reveal data-aos="zoom-in" data-aos-delay="230" class="card-soft text-center">
                <i class="ri-customer-service-2-line text-3xl text-emerald-600"></i>
                <h3 class="mt-3 font-semibold text-slate-900">Dedicated Support</h3>
                <p class="mt-2 text-sm text-slate-600">Responsive account management from first call to placement.</p>
            </div>
        </div>
    </div>
</section>

<section id="industries" class="mx-auto w-full max-w-7xl px-4 py-16 sm:px-6 lg:px-8" data-aos="fade-up" data-aos-delay="60">
    <div class="mb-10 max-w-2xl" data-reveal>
        <p class="eyebrow">Industries We Serve</p>
        <h2 class="section-title">Specialized staffing coverage across sectors</h2>
    </div>
    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        <div data-reveal data-aos="fade-up" data-aos-delay="80" class="card-soft flex items-center gap-3"><i class="ri-building-line text-2xl text-emerald-600"></i><span class="font-semibold text-slate-800">Construction</span></div>
        <div data-reveal data-aos="fade-up" data-aos-delay="110" class="card-soft flex items-center gap-3"><i class="ri-hotel-line text-2xl text-emerald-600"></i><span class="font-semibold text-slate-800">Hospitality</span></div>
        <div data-reveal data-aos="fade-up" data-aos-delay="140" class="card-soft flex items-center gap-3"><i class="ri-truck-line text-2xl text-emerald-600"></i><span class="font-semibold text-slate-800">Logistics</span></div>
        <div data-reveal data-aos="fade-up" data-aos-delay="170" class="card-soft flex items-center gap-3"><i class="ri-tools-line text-2xl text-emerald-600"></i><span class="font-semibold text-slate-800">Manufacturing</span></div>
        <div data-reveal data-aos="fade-up" data-aos-delay="200" class="card-soft flex items-center gap-3"><i class="ri-store-2-line text-2xl text-emerald-600"></i><span class="font-semibold text-slate-800">Retail</span></div>
        <div data-reveal data-aos="fade-up" data-aos-delay="230" class="card-soft flex items-center gap-3"><i class="ri-heart-pulse-line text-2xl text-emerald-600"></i><span class="font-semibold text-slate-800">Care Support</span></div>
    </div>
</section>

<section id="testimonials" class="bg-white py-16" data-aos="fade-up" data-aos-delay="60">
    <div class="mx-auto w-full max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="mb-10 max-w-2xl" data-reveal>
            <p class="eyebrow">Testimonials</p>
            <h2 class="section-title">What clients and candidates say</h2>
        </div>
        <div class="grid gap-5 lg:grid-cols-3">
            <figure data-reveal data-aos="fade-up" data-aos-delay="80" class="card-soft">
                <blockquote class="text-sm leading-relaxed text-slate-600">"FrontHire delivered qualified staff fast. Their screening process saved us hiring time every month."</blockquote>
                <figcaption class="mt-4 text-sm font-semibold text-slate-900">Operations Manager, Calgary</figcaption>
            </figure>
            <figure data-reveal data-aos="fade-up" data-aos-delay="130" class="card-soft">
                <blockquote class="text-sm leading-relaxed text-slate-600">"Professional support and clear communication from start to finish. Great partner for scaling teams."</blockquote>
                <figcaption class="mt-4 text-sm font-semibold text-slate-900">HR Lead, Alberta</figcaption>
            </figure>
            <figure data-reveal data-aos="fade-up" data-aos-delay="180" class="card-soft">
                <blockquote class="text-sm leading-relaxed text-slate-600">"I found a stable role quickly. The process was smooth and the team was very supportive."</blockquote>
                <figcaption class="mt-4 text-sm font-semibold text-slate-900">Placed Job Seeker</figcaption>
            </figure>
        </div>
    </div>
</section>

<section class="mx-auto w-full max-w-7xl px-4 py-16 sm:px-6 lg:px-8" data-aos="fade-up" data-aos-delay="90">
    <div data-reveal class="overflow-hidden rounded-3xl bg-gradient-to-r from-emerald-700 to-teal-600 px-6 py-10 text-white sm:px-10">
        <div class="flex flex-col items-start justify-between gap-6 md:flex-row md:items-center">
            <div>
                <h2 class="font-heading text-3xl font-bold">Need reliable staffing support this week?</h2>
                <p class="mt-2 text-emerald-50">Talk to our recruiters and get a workforce plan tailored to your operations.</p>
            </div>
            <a href="{{ route('employers') }}" class="rounded-xl bg-white px-5 py-3 text-sm font-semibold text-emerald-700 transition hover:bg-emerald-50">Start Hiring</a>
        </div>
    </div>
</section>

<section id="home-contact" class="border-y border-slate-200 bg-white py-16" data-aos="fade-up" data-aos-delay="90">
    <div class="mx-auto grid w-full max-w-7xl gap-8 px-4 sm:px-6 lg:grid-cols-2 lg:px-8">
        <div data-reveal>
            <p class="eyebrow">Contact Us</p>
            <h2 class="section-title">Let us know what you need</h2>
            <p class="mt-4 text-sm leading-relaxed text-slate-600">Send us your inquiry and our team will respond as quickly as possible.</p>
            <ul class="mt-6 space-y-2 text-sm text-slate-600">
                <li><i class="ri-mail-line mr-2 text-emerald-600"></i>hello@fronthire.ca</li>
                <li><i class="ri-phone-line mr-2 text-emerald-600"></i>+1 (403) 702-0088</li>
                <li><i class="ri-map-pin-line mr-2 text-emerald-600"></i>Unit 127 1717 60 st Southeast Calgary, Alberta T2A 7Y7</li>
            </ul>
        </div>

        <div data-reveal class="card-soft">
            @if ($errors->any())
                <div class="mb-4 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
                    Please fix the form errors and try again.
                </div>
            @endif

            <form method="POST" action="{{ route('inquiries.general.store') }}" class="space-y-4">
                @csrf
                <div>
                    <div class="floating-group">
                        <input id="name" name="name" value="{{ old('name') }}" required class="floating-input" type="text" placeholder=" ">
                        <label for="name" class="floating-label">Name</label>
                    </div>
                    @error('name') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
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
                </div>

                <div>
                    <div class="floating-group">
                        <textarea id="message" name="message" rows="5" required class="floating-input" placeholder=" ">{{ old('message') }}</textarea>
                        <label for="message" class="floating-label">Message</label>
                    </div>
                    @error('message') <p class="form-error">{{ $message }}</p> @enderror
                </div>
                <button type="submit" class="btn-primary w-full justify-center">Send Message</button>
            </form>
        </div>
    </div>
</section>
@endsection

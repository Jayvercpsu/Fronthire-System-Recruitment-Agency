@extends('layouts.public')

@section('title', 'About FrontHire | Recruitment Agency Story')
@section('meta_description', 'Learn about FrontHire, our mission, vision, and journey supporting employers and job seekers.')
@section('page_id', 'about')

@section('content')
<section class="relative isolate overflow-hidden text-white">
    <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1552664730-d307ca884978?auto=format&fit=crop&w=2200&q=80')] bg-cover bg-center"></div>
    <div class="absolute inset-0 bg-gradient-to-r from-emerald-900/80 via-emerald-700/65 to-lime-700/35"></div>
    <div class="absolute inset-0 opacity-20" style="background-image: radial-gradient(circle at 1px 1px, rgba(255,255,255,0.38) 1px, transparent 0); background-size: 24px 24px;"></div>
    <div aria-hidden="true" class="pointer-events-none absolute -bottom-14 -left-20 h-64 w-[22rem] rounded-[100%] bg-gradient-to-r from-emerald-900/45 via-emerald-600/30 to-lime-300/40 blur-sm sm:-bottom-24 sm:h-96 sm:w-[42rem]"></div>
    <div aria-hidden="true" class="pointer-events-none absolute -bottom-10 left-3 h-40 w-[16rem] rounded-[100%] border border-white/25 bg-gradient-to-r from-emerald-700/25 to-lime-200/20 sm:-bottom-20 sm:left-10 sm:h-72 sm:w-[30rem]"></div>

    <div class="relative mx-auto w-full max-w-7xl px-4 py-20 sm:px-6 lg:px-8 lg:py-24" data-reveal data-aos="fade-up" data-aos-delay="80">
        <p class="mb-4 inline-flex rounded-full bg-white/20 px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em]">About FrontHire</p>
        <h1 class="max-w-4xl font-heading text-3xl font-extrabold leading-tight text-white drop-shadow sm:text-5xl lg:text-6xl">A people-first staffing partner for growing teams and careers.</h1>
        <p class="mt-5 max-w-3xl text-base leading-relaxed text-emerald-50 sm:text-lg">We help employers hire with confidence and guide job seekers toward reliable opportunities.</p>
        <a href="{{ route('contact') }}" class="mt-8 inline-flex rounded-xl bg-white px-6 py-3 text-sm font-semibold text-emerald-700 shadow-lg shadow-emerald-900/20 transition hover:bg-emerald-50">Talk to Us</a>
    </div>
</section>

<section class="mx-auto grid w-full max-w-7xl gap-8 px-4 py-16 sm:px-6 lg:grid-cols-2 lg:px-8" data-aos="fade-up" data-aos-delay="80">
    <article data-reveal data-aos="fade-right" data-aos-delay="100" class="card-soft">
        <p class="eyebrow">Our Story</p>
        <h2 class="mt-2 font-heading text-2xl font-bold text-slate-900">How FrontHire started</h2>
        <p class="mt-4 text-sm leading-relaxed text-slate-600">FrontHire began with a clear goal: reduce hiring friction for employers while helping job seekers access better opportunities. We combine practical recruitment methods with responsive support to deliver dependable placements.</p>
    </article>

    <article data-reveal data-aos="fade-left" data-aos-delay="120" class="card-soft">
        <p class="eyebrow">Mission & Vision</p>
        <h2 class="mt-2 font-heading text-2xl font-bold text-slate-900">What drives us</h2>
        <ul class="mt-4 space-y-3 text-sm leading-relaxed text-slate-600">
            <li><span class="font-semibold text-slate-900">Mission:</span> Connect employers and candidates through efficient, ethical, and reliable recruitment.</li>
            <li><span class="font-semibold text-slate-900">Vision:</span> Be a trusted manpower partner known for quality staffing and long-term value.</li>
        </ul>
    </article>
</section>

<section class="bg-white py-16" data-aos="fade-up" data-aos-delay="80">
    <div class="mx-auto w-full max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="mb-10 max-w-2xl" data-reveal>
            <p class="eyebrow">Mini Timeline</p>
            <h2 class="section-title">Our growth milestones</h2>
        </div>

        <div class="space-y-4">
            <article data-reveal data-aos="fade-up" data-aos-delay="100" class="card-soft flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                <h3 class="font-semibold text-slate-900">2024 - Foundation</h3>
                <p class="text-sm text-slate-600">Launched FrontHire to serve Calgary employers and local job seekers.</p>
            </article>
            <article data-reveal data-aos="fade-up" data-aos-delay="140" class="card-soft flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                <h3 class="font-semibold text-slate-900">2025 - Service Expansion</h3>
                <p class="text-sm text-slate-600">Expanded recruitment, screening, and temporary staffing coverage.</p>
            </article>
            <article data-reveal data-aos="fade-up" data-aos-delay="180" class="card-soft flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                <h3 class="font-semibold text-slate-900">2026 - Digital Experience</h3>
                <p class="text-sm text-slate-600">Launched a modern platform for employer inquiries and candidate onboarding.</p>
            </article>
        </div>
    </div>
</section>
@endsection

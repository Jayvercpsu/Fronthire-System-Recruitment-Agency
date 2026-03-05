@extends('layouts.public')

@section('title', 'About FrontHire | Recruitment Agency Story')
@section('meta_description', 'Learn about FrontHire, our mission, vision, and journey supporting employers and job seekers.')
@section('page_id', 'about')

@section('content')
<section class="bg-gradient-to-r from-[#1d8d45] via-[#52b861] to-[#d0e2b8] py-20 text-white">
    <div class="mx-auto w-full max-w-7xl px-4 sm:px-6 lg:px-8" data-reveal data-aos="fade-up" data-aos-delay="80">
        <p class="eyebrow bg-white/20 text-white">About FrontHire</p>
        <h1 class="mt-3 max-w-3xl font-heading text-4xl font-extrabold sm:text-5xl">A people-first staffing partner for growing teams and careers.</h1>
        <p class="mt-4 max-w-2xl text-emerald-50">We were built to solve real hiring and employment challenges with speed, clarity, and accountability.</p>
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

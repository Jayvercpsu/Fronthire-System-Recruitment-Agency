<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'FrontHire | Recruitment and Manpower Solutions')</title>
    <meta name="description" content="@yield('meta_description', 'FrontHire helps employers find reliable manpower and helps job seekers find better opportunities in Calgary and beyond.')">
    <meta name="robots" content="index, follow">
    <meta property="og:title" content="@yield('title', 'FrontHire | Recruitment and Manpower Solutions')">
    <meta property="og:description" content="@yield('meta_description', 'FrontHire helps employers find reliable manpower and helps job seekers find better opportunities.')">
    <meta property="og:type" content="website">
    <link rel="icon" type="image/png" href="{{ asset('images/logo/fronthire.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Sora:wght@600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body data-page="@yield('page_id', 'default')" data-page-transitions="off" class="text-slate-900 antialiased">
    <header x-data="{ open: false }" class="fixed inset-x-0 top-0 z-50 border-b border-slate-200/70 bg-white/80 backdrop-blur-xl">
        <div class="mx-auto flex h-[4.5rem] w-full max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <img src="{{ asset('images/logo/fronthire.png') }}" alt="FrontHire recruitment logo" class="h-16 w-16 object-contain sm:h-20 sm:w-20 scale-[2]">
                <div>
                    <p class="font-heading text-lg font-extrabold leading-none text-slate-900">FrontHire</p>
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-emerald-700">Manpower Agency</p>
                </div>
            </a>

            <nav class="hidden items-center gap-7 md:flex">
                <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'text-emerald-700' : 'text-slate-600 hover:text-emerald-700' }} text-sm font-semibold">Home</a>
                <a href="{{ route('employers') }}" class="{{ request()->routeIs('employers') ? 'text-emerald-700' : 'text-slate-600 hover:text-emerald-700' }} text-sm font-semibold">Employers</a>
                <a href="{{ route('job-seekers') }}" class="{{ request()->routeIs('job-seekers') ? 'text-emerald-700' : 'text-slate-600 hover:text-emerald-700' }} text-sm font-semibold">Job Seekers</a>
                <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'text-emerald-700' : 'text-slate-600 hover:text-emerald-700' }} text-sm font-semibold">About</a>
                <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'text-emerald-700' : 'text-slate-600 hover:text-emerald-700' }} text-sm font-semibold">Contact</a>
            </nav>

            <div class="hidden items-center gap-3 md:flex">
                @auth
                    <a href="{{ route('dashboard') }}" class="rounded-xl border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700 transition hover:border-emerald-200 hover:bg-emerald-50 hover:text-emerald-700">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="rounded-xl border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700 transition hover:border-emerald-200 hover:bg-emerald-50 hover:text-emerald-700">Sign In</a>
                    <a href="{{ route('register', ['role' => 'job_seeker']) }}" class="rounded-xl bg-emerald-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-emerald-700">Get Started</a>
                @endauth
            </div>

            <button @click="open = !open" type="button" class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 text-slate-700 md:hidden">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>

        @if (request()->routeIs('home'))
            <div class="hidden border-t border-emerald-100/70 bg-white/70 py-2 lg:block">
                <div class="mx-auto flex w-full max-w-7xl items-center gap-2 px-4 sm:px-6 lg:px-8">
                    <a href="#hero" data-scrollspy-link class="scrollspy-link is-active">Hero</a>
                    <a href="#how-it-works" data-scrollspy-link class="scrollspy-link">How It Works</a>
                    <a href="#why-choose" data-scrollspy-link class="scrollspy-link">Why Us</a>
                    <a href="#industries" data-scrollspy-link class="scrollspy-link">Industries</a>
                    <a href="#testimonials" data-scrollspy-link class="scrollspy-link">Testimonials</a>
                    <a href="#home-contact" data-scrollspy-link class="scrollspy-link">Contact</a>
                </div>
            </div>
        @endif

        <div x-show="open" x-transition class="border-t border-slate-200 bg-white md:hidden">
            <div class="space-y-1 px-4 py-3">
                <a href="{{ route('home') }}" class="block rounded-xl px-3 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100">Home</a>
                <a href="{{ route('employers') }}" class="block rounded-xl px-3 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100">Employers</a>
                <a href="{{ route('job-seekers') }}" class="block rounded-xl px-3 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100">Job Seekers</a>
                <a href="{{ route('about') }}" class="block rounded-xl px-3 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100">About</a>
                <a href="{{ route('contact') }}" class="block rounded-xl px-3 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100">Contact</a>

                @auth
                    <a href="{{ route('dashboard') }}" class="mt-2 block rounded-xl bg-emerald-600 px-3 py-2 text-center text-sm font-semibold text-white">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="mt-2 block rounded-xl border border-slate-200 px-3 py-2 text-center text-sm font-semibold text-slate-700">Sign In</a>
                    <a href="{{ route('register', ['role' => 'job_seeker']) }}" class="block rounded-xl bg-emerald-600 px-3 py-2 text-center text-sm font-semibold text-white">Get Started</a>
                @endauth
            </div>
        </div>
    </header>

    <main class="pt-20 lg:pt-28">
        @if (session('success'))
            <div class="mx-auto mb-4 mt-4 w-full max-w-7xl px-4 sm:px-6 lg:px-8">
                <div data-flash-alert class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="mx-auto mb-4 mt-4 w-full max-w-7xl px-4 sm:px-6 lg:px-8">
                <div data-flash-alert class="rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-medium text-rose-700">
                    {{ session('error') }}
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="border-t border-slate-200 bg-white/90">
        <div class="mx-auto grid w-full max-w-7xl gap-10 px-4 py-12 sm:px-6 lg:grid-cols-3 lg:px-8">
            <div>
                <div class="mb-4 flex items-center gap-3">
                    <img src="{{ asset('images/logo/fronthire.png') }}" alt="FrontHire footer logo" class="h-9 w-auto">
                    <span class="font-heading text-xl font-bold text-slate-900">FrontHire</span>
                </div>
                <p class="text-sm leading-relaxed text-slate-600">Helping businesses scale with dependable manpower and helping candidates build stronger careers.</p>
            </div>

            <div>
                <h3 class="font-heading text-base font-bold text-slate-900">Contact</h3>
                <ul class="mt-4 space-y-2 text-sm text-slate-600">
                    <li><i class="ri-mail-line mr-2 text-emerald-700"></i><a href="mailto:hello@fronthire.ca" class="hover:text-emerald-700">hello@fronthire.ca</a></li>
                    <li><i class="ri-phone-line mr-2 text-emerald-700"></i><a href="tel:+14037020088" class="hover:text-emerald-700">+1 (403) 702-0088</a></li>
                    <li><i class="ri-map-pin-line mr-2 text-emerald-700"></i>Unit 127 1717 60 st Southeast Calgary, Alberta T2A 7Y7</li>
                </ul>
            </div>

            <div>
                <h3 class="font-heading text-base font-bold text-slate-900">Social</h3>
                <div class="mt-4 space-y-2 text-sm text-slate-600">
                    <p><a href="https://www.facebook.com/share/1AbajhWJ6j/?mibextid=wwXIfr" target="_blank" rel="noopener" class="inline-flex items-center gap-2 hover:text-emerald-700"><i class="ri-facebook-circle-line"></i>Facebook</a></p>
                    {{-- <p class="inline-flex items-center gap-2"><i class="ri-linkedin-box-line text-slate-400"></i>LinkedIn: Coming soon</p>
                    <p class="inline-flex items-center gap-2"><i class="ri-instagram-line text-slate-400"></i>Instagram: Coming soon</p> --}}
                </div>
            </div>
        </div>
        <div class="border-t border-slate-200 py-4 text-center text-xs text-slate-500">
            {{ now()->year }} FrontHire. All rights reserved.
        </div>
    </footer>

    <button type="button" class="back-to-top" data-back-to-top aria-label="Back to top" aria-hidden="true">
        <i class="ri-arrow-up-line text-lg back-to-top-icon" aria-hidden="true"></i>
    </button>
</body>
</html>

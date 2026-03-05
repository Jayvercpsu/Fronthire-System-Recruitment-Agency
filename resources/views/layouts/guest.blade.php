<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'FrontHire') }} | Auth</title>
        <meta name="description" content="Secure FrontHire account access for employers and job seekers.">
        <link rel="icon" type="image/png" href="{{ asset('images/logo/fronthire.png') }}">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Sora:wght@600;700&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="page-enter min-h-screen text-slate-900 antialiased">
        <div class="relative min-h-screen overflow-hidden">
            <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1520607162513-77705c0f0d4a?auto=format&fit=crop&w=1800&q=80')] bg-cover bg-center"></div>
            <div class="absolute inset-0 bg-gradient-to-br from-emerald-900/75 via-emerald-700/60 to-slate-900/65"></div>
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_20%_10%,rgba(255,255,255,0.25),transparent_36%),radial-gradient(circle_at_80%_0%,rgba(255,255,255,0.18),transparent_28%)]"></div>

            <div class="relative mx-auto flex min-h-screen w-full max-w-lg flex-col justify-center px-4 py-10 sm:px-6">
                <a href="{{ route('home') }}" class="mx-auto mb-6 flex items-center gap-3 rounded-2xl border border-emerald-200/90 bg-white/88 px-5 py-3 shadow-lg shadow-emerald-900/20 backdrop-blur-sm" data-aos="zoom-in" data-aos-delay="80">
                    <x-application-logo class="h-12 w-auto" />
                    <span class="font-heading text-3xl font-bold tracking-tight text-emerald-950">FrontHire</span>
                </a>

                <div class="rounded-3xl border border-emerald-200 bg-white p-6 shadow-2xl shadow-emerald-900/30 sm:p-8" data-aos="fade-up" data-aos-delay="120">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>

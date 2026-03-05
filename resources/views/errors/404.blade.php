<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>404 | FrontHire</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo/fronthire.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;700;800&family=Sora:wght@700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
</head>
<body class="flex min-h-screen items-center justify-center bg-slate-100 px-4 text-slate-900">
    <div class="w-full max-w-xl rounded-3xl border border-slate-200 bg-white p-8 text-center shadow-xl shadow-slate-200/50">
        <img src="{{ asset('images/logo/fronthire.png') }}" alt="FrontHire logo" class="mx-auto mb-5 h-12 w-auto">
        <p class="eyebrow mx-auto w-fit">404 Error</p>
        <h1 class="mt-3 font-heading text-4xl font-extrabold">Page not found</h1>
        <p class="mt-3 text-sm text-slate-600">The page you requested does not exist or may have been moved.</p>
        <a href="{{ route('home') }}" class="btn-primary mx-auto mt-6 w-fit">Return Home</a>
    </div>
</body>
</html>

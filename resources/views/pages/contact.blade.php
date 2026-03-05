@extends('layouts.public')

@section('title', 'Contact FrontHire | Recruitment Support')
@section('meta_description', 'Reach FrontHire for recruitment and manpower support in Calgary, Alberta.')
@section('page_id', 'contact')

@section('content')
<section class="bg-gradient-to-r from-[#1f8f45] via-[#55b861] to-[#d4e4b8] py-20 text-white">
    <div class="mx-auto w-full max-w-7xl px-4 sm:px-6 lg:px-8" data-reveal data-aos="fade-up" data-aos-delay="80">
        <p class="eyebrow bg-white/20 text-white">Contact</p>
        <h1 class="mt-3 font-heading text-4xl font-extrabold sm:text-5xl">Talk to FrontHire</h1>
        <p class="mt-4 max-w-2xl text-emerald-50">Need staffing support or have a question? Send us a message and we will reply promptly.</p>
    </div>
</section>

<section class="mx-auto grid w-full max-w-7xl gap-8 px-4 py-16 sm:px-6 lg:grid-cols-2 lg:px-8" data-aos="fade-up" data-aos-delay="80">
    <div data-reveal class="space-y-6" data-aos="fade-right" data-aos-delay="100">
        <article class="card-soft">
            <h2 class="font-heading text-xl font-bold text-slate-900">Contact Information</h2>
            <ul class="mt-4 space-y-3 text-sm text-slate-600">
                <li><i class="ri-mail-line mr-2 text-emerald-700"></i><a href="mailto:hello@fronthire.ca" class="hover:text-emerald-700">hello@fronthire.ca</a></li>
                <li><i class="ri-phone-line mr-2 text-emerald-700"></i><a href="tel:+14037020088" class="hover:text-emerald-700">+1 (403) 702-0088</a></li>
                <li><i class="ri-map-pin-line mr-2 text-emerald-700"></i>Unit 127 1717 60 st Southeast Calgary, Alberta T2A 7Y7</li>
            </ul>
        </article>

        <article class="card-soft overflow-hidden p-0">
            <iframe
                title="FrontHire Calgary Location"
                class="h-72 w-full"
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"
                src="https://www.google.com/maps?q=1717+60+St+SE+Calgary+AB+T2A+7Y7&output=embed">
            </iframe>
        </article>
    </div>

    <div data-reveal data-aos="fade-left" data-aos-delay="120" class="card-soft">
        @if ($errors->any())
            <div class="mb-4 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
                Please fix the form errors and submit again.
            </div>
        @endif

        <form method="POST" action="{{ route('contact.store') }}" class="space-y-4" x-data="{ submitting: false }" @submit="submitting = true">
            @csrf
            <div>
                <div class="floating-group">
                    <input id="name" name="name" value="{{ old('name') }}" required class="floating-input" type="text" placeholder=" ">
                    <label for="name" class="floating-label">Name</label>
                </div>
                @error('name') <p class="form-error">{{ $message }}</p> @enderror
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
                <span x-show="!submitting">Send Message</span>
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
</section>
@endsection

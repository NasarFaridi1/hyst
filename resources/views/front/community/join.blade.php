@extends('front.layouts.app')

@section('title', 'Join ' . ($circle->name ?? 'Foodie Circle') . ' | HYST Community')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8" style="background: #F5F5F0;">
    <div class="max-w-md w-full bg-[#0D0B09] rounded-3xl shadow-2xl border border-white/10 overflow-hidden text-white relative">
        
        <!-- Top Gradient Strip -->
        <div class="h-2.5 w-full bg-gradient-to-r from-[#C25A2A] via-[#D97040] to-[#FBBF24]"></div>

        <div class="p-7 sm:p-9 text-center">
            
            <!-- Avatar / Icon -->
            <div class="w-20 h-20 mx-auto rounded-3xl bg-gradient-to-br from-[#C25A2A] to-[#8C3D1A] flex items-center justify-center text-4xl shadow-xl shadow-[#C25A2A]/40 mb-6 border border-white/15">
                🍕
            </div>

            <!-- Badge -->
            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/10 border border-white/15 text-xs font-semibold text-amber-300 uppercase tracking-wider mb-4">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                Foodie Circle Invitation
            </div>

            <!-- Title -->
            <h1 class="text-2xl sm:text-3xl font-extrabold text-white mb-2 tracking-tight">
                {{ $circle->name }}
            </h1>

            <p class="text-xs sm:text-sm text-stone-300 mb-6 leading-relaxed">
                <span class="text-white font-semibold">{{ $circle->creator->name ?? 'Your friend' }}</span> has invited you to connect on HYST! Join this circle to share real food thoughts, swap favorite dishes, and discover local kitchens together.
            </p>

            <!-- Mini Perk Highlights -->
            <div class="space-y-2 mb-8 text-left bg-white/5 border border-white/10 rounded-2xl p-4">
                <div class="flex items-center gap-3 text-xs text-stone-200">
                    <span class="text-amber-400">✨</span>
                    <span>Share honest dining reviews & food photos</span>
                </div>
                <div class="flex items-center gap-3 text-xs text-stone-200">
                    <span class="text-emerald-400">🏷️</span>
                    <span>Direct restaurant ordering with zero hidden markups</span>
                </div>
                <div class="flex items-center gap-3 text-xs text-stone-200">
                    <span class="text-blue-400">💬</span>
                    <span>Recommend dishes your friends will love</span>
                </div>
            </div>

            @if($requiresAuth)
                <!-- Guest State: Prompt Login -->
                <div class="space-y-3">
                    <a href="/login" class="w-full inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-2xl bg-gradient-to-r from-[#C25A2A] to-[#D97040] hover:from-[#B04E20] hover:to-[#C25A2A] text-white font-bold text-sm shadow-lg shadow-[#C25A2A]/40 hover:shadow-xl transition-all">
                        <span>Sign In / Register to Join</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </a>
                    <a href="/" class="block text-xs text-stone-400 hover:text-stone-200 pt-1">
                        Maybe later, browse restaurants →
                    </a>
                </div>
            @else
                <!-- Logged In State: Accept Invitation Form -->
                <form action="{{ route('front.community.join.submit') }}" method="POST" class="space-y-3">
                    @csrf
                    <input type="hidden" name="code" value="{{ $circle->invite_code }}">

                    <button type="submit" class="w-full inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-2xl bg-gradient-to-r from-[#C25A2A] to-[#D97040] hover:from-[#B04E20] hover:to-[#C25A2A] text-white font-bold text-sm shadow-lg shadow-[#C25A2A]/40 hover:shadow-xl transition-all cursor-pointer">
                        <span>Accept & Join Circle 🎉</span>
                    </button>

                    <a href="/" class="block text-xs text-stone-400 hover:text-stone-200 pt-1">
                        Not now, continue browsing
                    </a>
                </form>
            @endif

        </div>
    </div>
</div>
@endsection

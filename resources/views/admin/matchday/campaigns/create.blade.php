@extends('layouts.app')

@section('content')
<div class="p-4 sm:p-6 lg:p-8 max-w-4xl mx-auto">

    <!-- Top Breadcrumb & Heading -->
    <div class="flex items-center justify-between gap-4 mb-6">
        <div>
            <div class="flex items-center gap-2 text-xs text-gray-500 mb-1">
                <a href="{{ route('admin.matchday.campaigns.index') }}" class="hover:text-gray-900 transition">Campaign Settings</a>
                <span>/</span>
                <span class="text-gray-900 font-semibold">New Campaign</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900">Create Matchday Campaign</h1>
            <p class="text-sm text-gray-500 mt-1">Set order unlock rules and card incentives for your customers.</p>
        </div>
        <a href="{{ route('admin.matchday.campaigns.index') }}" 
           class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-semibold transition">
            <i data-lucide="arrow-left" style="width:16px; height:16px;"></i>
            <span>Back</span>
        </a>
    </div>

    <div class="bg-white p-6 sm:p-8 rounded-3xl border border-gray-100 shadow-sm">
        <form action="{{ route('admin.matchday.campaigns.store') }}" method="POST">
            @csrf

            <!-- Name -->
            <div class="mb-5">
                <label class="block text-xs font-bold text-gray-700 mb-1.5">
                    Campaign Name <span class="text-rose-500">*</span>
                </label>
                <input type="text" 
                       name="name" 
                       value="{{ old('name', 'England Matchday Football Festival') }}" 
                       required 
                       placeholder="e.g. England Euro / Football Festival"
                       class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#C25A2A]/40 focus:border-[#C25A2A]">
                @error('name') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <!-- Description -->
            <div class="mb-5">
                <label class="block text-xs font-bold text-gray-700 mb-1.5">Description</label>
                <textarea name="description" 
                          rows="3" 
                          placeholder="Short description of this campaign..."
                          class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#C25A2A]/40 focus:border-[#C25A2A]">{{ old('description', 'Order food directly from your favorite local restaurants on Hyst and unlock free England player cards to build your squad.') }}</textarea>
            </div>

            <!-- Parameters Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-5">
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1.5">
                        Min Order Amount (£) <span class="text-rose-500">*</span>
                    </label>
                    <input type="number" 
                           step="0.50" 
                           name="min_order_amount" 
                           value="{{ old('min_order_amount', '15.00') }}" 
                           required 
                           class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm font-bold focus:outline-none focus:ring-2 focus:ring-[#C25A2A]/40 focus:border-[#C25A2A]">
                    <span class="text-[11px] text-gray-400 mt-1 block">Orders equal or above this earn a card pack.</span>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1.5">
                        Cards Presented per Pack <span class="text-rose-500">*</span>
                    </label>
                    <input type="number" 
                           name="choices_per_order" 
                           value="{{ old('choices_per_order', 3) }}" 
                           min="1" max="10" required 
                           class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm font-bold focus:outline-none focus:ring-2 focus:ring-[#C25A2A]/40 focus:border-[#C25A2A]">
                    <span class="text-[11px] text-gray-400 mt-1 block">Customer picks 1 player from this batch.</span>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1.5">
                        Pack Expiry (Days) <span class="text-rose-500">*</span>
                    </label>
                    <input type="number" 
                           name="entitlement_expiry_days" 
                           value="{{ old('entitlement_expiry_days', 14) }}" 
                           min="1" max="365" required 
                           class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm font-bold focus:outline-none focus:ring-2 focus:ring-[#C25A2A]/40 focus:border-[#C25A2A]">
                    <span class="text-[11px] text-gray-400 mt-1 block">Days customer has to open their pack.</span>
                </div>
            </div>

            <!-- Dates -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1.5">Start Date & Time</label>
                    <input type="datetime-local" 
                           name="starts_at" 
                           value="{{ old('starts_at') }}" 
                           class="w-full border border-gray-200 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#C25A2A]/40">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1.5">End Date & Time</label>
                    <input type="datetime-local" 
                           name="ends_at" 
                           value="{{ old('ends_at') }}" 
                           class="w-full border border-gray-200 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#C25A2A]/40">
                </div>
            </div>

            <!-- Active Status -->
            <div class="mb-8 p-4 rounded-2xl bg-gray-50 border border-gray-200/80 flex items-center justify-between">
                <div>
                    <div class="text-sm font-bold text-gray-900">Campaign Active</div>
                    <div class="text-xs text-gray-500">Enable automated card pack rewards on completed qualifying orders.</div>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" class="sr-only peer" checked>
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-600"></div>
                </label>
            </div>

            <div class="flex items-center gap-3">
                <button type="submit" 
                        class="flex-1 bg-[#C25A2A] hover:bg-[#a94c20] text-white py-3 px-6 rounded-xl font-bold text-sm shadow-md transition text-center">
                    Create Campaign
                </button>
                <a href="{{ route('admin.matchday.campaigns.index') }}" 
                   class="px-5 py-3 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-semibold transition text-center">
                    Cancel
                </a>
            </div>

        </form>
    </div>

</div>
@endsection

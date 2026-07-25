@extends('layouts.app')

@section('title', 'Create Gift Card')

@section('content')

<div class="max-w-5xl mx-auto px-6 py-8">

    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                Create Gift Card
            </h1>

            <p class="text-gray-500 mt-1">
                Create a new Hyst Gift Card
            </p>
        </div>

        <a href="{{ route('admin.gift-cards.index') }}"
           class="px-5 py-3 rounded-xl border border-gray-300 hover:bg-gray-100">

            Back

        </a>

    </div>

    <form action="{{ route('admin.gift-cards.store') }}"
          method="POST">

        @csrf

        <div class="bg-white rounded-2xl shadow p-8">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Gift Card Code --}}
                <div>

                    <label class="block mb-2 font-medium text-gray-700">
                        Gift Card Code
                    </label>

                    <div class="flex">

                        <input
                            type="text"
                            id="code"
                            name="code"
                            value="{{ old('code') }}"
                            class="w-full rounded-l-xl border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-indigo-500 focus:outline-none">

                        <button
                            type="button"
                            onclick="generateCode()"
                            class="bg-indigo-600 text-white px-5 rounded-r-xl hover:bg-indigo-700">

                            Generate

                        </button>

                    </div>

                    @error('code')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror

                </div>

                {{-- Title --}}
                <div>

                    <label class="block mb-2 font-medium text-gray-700">
                        Title
                    </label>

                    <input
                        type="text"
                        name="title"
                        value="{{ old('title') }}"
                        class="w-full rounded-xl border border-gray-300 px-4 py-3">

                    @error('title')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror

                </div>

                {{-- Amount --}}
                <div>

                    <label class="block mb-2 font-medium text-gray-700">
                        Gift Card Amount (£)
                    </label>

                    <input
                        type="number"
                        step="0.01"
                        name="amount"
                        value="{{ old('amount') }}"
                        class="w-full rounded-xl border border-gray-300 px-4 py-3">

                </div>

                {{-- Minimum Order --}}
                <div>

                    <label class="block mb-2 font-medium text-gray-700">
                        Minimum Order (£)
                    </label>

                    <input
                        type="number"
                        step="0.01"
                        name="minimum_order_amount"
                        value="{{ old('minimum_order_amount',0) }}"
                        class="w-full rounded-xl border border-gray-300 px-4 py-3">

                </div>

                {{-- Per User --}}
                <div>

                    <label class="block mb-2 font-medium text-gray-700">
                        Per User Limit
                    </label>

                    <input
                        type="number"
                        name="per_user_limit"
                        value="{{ old('per_user_limit',1) }}"
                        class="w-full rounded-xl border border-gray-300 px-4 py-3">

                </div>

                {{-- Total Usage --}}
                <div>

                    <label class="block mb-2 font-medium text-gray-700">
                        Total Usage Limit
                    </label>

                    <input
                        type="number"
                        name="total_usage_limit"
                        value="{{ old('total_usage_limit') }}"
                        class="w-full rounded-xl border border-gray-300 px-4 py-3">

                </div>

                {{-- Start Date --}}
                <div>

                    <label class="block mb-2 font-medium text-gray-700">
                        Start Date
                    </label>

                    <input
                        type="datetime-local"
                        name="starts_at"
                        value="{{ old('starts_at') }}"
                        class="w-full rounded-xl border border-gray-300 px-4 py-3">

                </div>

                {{-- Expiry Date --}}
                <div>

                    <label class="block mb-2 font-medium text-gray-700">
                        Expiry Date
                    </label>

                    <input
                        type="datetime-local"
                        name="expires_at"
                        value="{{ old('expires_at') }}"
                        class="w-full rounded-xl border border-gray-300 px-4 py-3">

                </div>

                {{-- Status --}}
                <div>

                    <label class="block mb-2 font-medium text-gray-700">
                        Status
                    </label>

                    <select
                        name="status"
                        class="w-full rounded-xl border border-gray-300 px-4 py-3">

                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>

                    </select>

                </div>

                {{-- Description --}}
                <div class="md:col-span-2">

                    <label class="block mb-2 font-medium text-gray-700">
                        Description
                    </label>

                    <textarea
                        rows="5"
                        name="description"
                        class="w-full rounded-xl border border-gray-300 px-4 py-3">{{ old('description') }}</textarea>

                </div>

            </div>

            <div class="mt-8 flex gap-4">

                <button
                    class="bg-[#C25A2A] hover:bg-[#C25A2A]/80 text-white px-8 py-3 rounded-xl">

                    Save Gift Card

                </button>

                <a href="{{ route('admin.gift-cards.index') }}"
                   class="px-8 py-3 rounded-xl border border-gray-300 hover:bg-gray-100">

                    Cancel

                </a>

            </div>

        </div>

    </form>

</div>

<script>

function generateCode()
{
    let chars='ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

    let code='HYST-';

    for(let i=0;i<8;i++)
    {
        code+=chars.charAt(Math.floor(Math.random()*chars.length));
    }

    document.getElementById('code').value=code;
}

</script>

@endsection
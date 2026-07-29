@extends('layouts.app')

@section('title', 'Edit Gift Card')

@section('content')

<div class="max-w-5xl mx-auto px-6 py-8">

    <div class="flex items-center justify-between mb-8">

        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                Edit Gift Card
            </h1>

            <p class="text-gray-500 mt-1">
                Update gift card details
            </p>
        </div>

        <a href="{{ route('admin.gift-cards.index') }}"
           class="px-5 py-3 rounded-xl border border-gray-300 hover:bg-gray-100">

            Back

        </a>

    </div>

    <form action="{{ route('admin.gift-cards.update',$giftCard->id) }}"
          method="POST">

        @csrf
        @method('PUT')

        <div class="bg-white rounded-2xl shadow p-8">

            {{-- Information Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

                <div class="bg-blue-50 rounded-xl p-5 border">
                    <p class="text-sm text-gray-500">Original Amount</p>

                    <h2 class="text-2xl font-bold text-blue-600">
                        £{{ number_format($giftCard->amount,2) }}
                    </h2>
                </div>

                <div class="bg-green-50 rounded-xl p-5 border">
                    <p class="text-sm text-gray-500">Remaining Balance</p>

                    <h2 class="text-2xl font-bold text-green-600">
                        £{{ number_format($giftCard->balance,2) }}
                    </h2>
                </div>

                <div class="bg-purple-50 rounded-xl p-5 border">
                    <p class="text-sm text-gray-500">Total Used</p>

                    <h2 class="text-2xl font-bold text-purple-600">
                        {{ $giftCard->total_used }}
                    </h2>
                </div>

            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Code --}}
                <div>

                    <label class="block mb-2 font-medium">
                        Gift Card Code
                    </label>

                    <div class="flex">

                        <input
                            id="code"
                            type="text"
                            name="code"
                            value="{{ old('code',$giftCard->code) }}"
                            class="w-full rounded-l-xl border border-gray-300 px-4 py-3">

                        <button
                            type="button"
                            onclick="generateCode()"
                            class="bg-indigo-600 text-white px-5 rounded-r-xl">

                            Generate

                        </button>

                    </div>

                </div>

                {{-- Title --}}
                <div>

                    <label class="block mb-2 font-medium">
                        Title
                    </label>

                    <input
                        type="text"
                        name="title"
                        value="{{ old('title',$giftCard->title) }}"
                        class="w-full rounded-xl border border-gray-300 px-4 py-3">

                </div>

                {{-- Minimum Order --}}
                <div>

                    <label class="block mb-2 font-medium">
                        Minimum Order (£)
                    </label>

                    <input
                        type="number"
                        step="0.01"
                        name="minimum_order_amount"
                        value="{{ old('minimum_order_amount',$giftCard->minimum_order_amount) }}"
                        class="w-full rounded-xl border border-gray-300 px-4 py-3">

                </div>

                {{-- Per User Limit --}}
                <div>

                    <label class="block mb-2 font-medium">
                        Per User Limit
                    </label>

                    <input
                        type="number"
                        name="per_user_limit"
                        value="{{ old('per_user_limit',$giftCard->per_user_limit) }}"
                        class="w-full rounded-xl border border-gray-300 px-4 py-3">

                </div>

                {{-- Total Usage --}}
                <div>

                    <label class="block mb-2 font-medium">
                        Total Usage Limit
                    </label>

                    <input
                        type="number"
                        name="total_usage_limit"
                        value="{{ old('total_usage_limit',$giftCard->total_usage_limit) }}"
                        class="w-full rounded-xl border border-gray-300 px-4 py-3">

                </div>

                {{-- Status --}}
                <div>

                    <label class="block mb-2 font-medium">
                        Status
                    </label>

                    <select
                        name="status"
                        class="w-full rounded-xl border border-gray-300 px-4 py-3">

                        <option value="active"
                            {{ $giftCard->status=='active' ? 'selected' : '' }}>
                            Active
                        </option>

                        <option value="inactive"
                            {{ $giftCard->status=='inactive' ? 'selected' : '' }}>
                            Inactive
                        </option>

                    </select>

                </div>

                {{-- Applicable Order Type --}}
                <div>

                    <label class="block mb-2 font-medium">
                        Applicable Order Type
                    </label>

                    <select
                        name="applicable_type"
                        class="w-full rounded-xl border border-gray-300 px-4 py-3">

                        <option value="all" {{ old('applicable_type', $giftCard->applicable_type ?? 'all') == 'all' ? 'selected' : '' }}>All Order Types</option>
                        <option value="delivery" {{ old('applicable_type', $giftCard->applicable_type) == 'delivery' ? 'selected' : '' }}>Delivery Only</option>
                        <option value="dine_in" {{ old('applicable_type', $giftCard->applicable_type) == 'dine_in' ? 'selected' : '' }}>Dine-In Only</option>
                        <option value="takeaway" {{ old('applicable_type', $giftCard->applicable_type) == 'takeaway' ? 'selected' : '' }}>Takeaway Only</option>

                    </select>

                    @error('applicable_type')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror

                </div>

                {{-- Start Date --}}
                <div>

                    <label class="block mb-2 font-medium">
                        Start Date
                    </label>

                    <input
                        type="datetime-local"
                        name="starts_at"
                        value="{{ old('starts_at',$giftCard->starts_at ? $giftCard->starts_at->format('Y-m-d\TH:i') : '') }}"
                        class="w-full rounded-xl border border-gray-300 px-4 py-3">

                </div>

                {{-- Expiry Date --}}
                <div>

                    <label class="block mb-2 font-medium">
                        Expiry Date
                    </label>

                    <input
                        type="datetime-local"
                        name="expires_at"
                        value="{{ old('expires_at',$giftCard->expires_at ? $giftCard->expires_at->format('Y-m-d\TH:i') : '') }}"
                        class="w-full rounded-xl border border-gray-300 px-4 py-3">

                </div>

                {{-- Description --}}
                <div class="md:col-span-2">

                    <label class="block mb-2 font-medium">
                        Description
                    </label>

                    <textarea
                        rows="5"
                        name="description"
                        class="w-full rounded-xl border border-gray-300 px-4 py-3">{{ old('description',$giftCard->description) }}</textarea>

                </div>

            </div>

            <div class="mt-8 flex gap-4">

                <button
                    class="bg-[#C25A2A] hover:bg-[#C25A2A]/80 text-white px-8 py-3 rounded-xl">

                    Update Gift Card

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
function generateCode() {

    let chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";

    let code = "HYST-";

    for(let i=0;i<8;i++)
    {
        code += chars.charAt(Math.floor(Math.random()*chars.length));
    }

    document.getElementById('code').value = code;
}
</script>

@endsection
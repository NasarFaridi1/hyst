@extends('layouts.app')
@section('content')
<div class="p-8">
  <div class="flex justify-between items-center mb-8">
    <div>
      <h1 class="text-2xl font-medium">Product Charges Management</h1>
      <p class="text-gray-500 text-sm mt-1">Configure the HYST additional percentage charge applied to products on the frontend.</p>
    </div>
  </div>

  @if(session('success'))
    <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg text-sm flex items-center gap-2">
      <i data-lucide="check-circle" class="w-5 h-5 text-green-600"></i>
      <span>{{ session('success') }}</span>
    </div>
  @endif

  @if($errors->any())
    <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm">
      <ul class="list-disc pl-5">
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <div class="max-w-2xl bg-white p-8 rounded-xl border border-gray-100 shadow-sm">
    <form action="{{ route('system_admin.product-charges.update') }}" method="POST">
      @csrf

      <div class="mb-6">
        <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">Charge Label / Title</label>
        <input type="text" id="title" name="title" value="{{ old('title', $charge->title ?? 'HYST Additional Charge') }}" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#C25A2A] focus:border-transparent outline-none text-sm" placeholder="e.g. HYST Additional Charge">
        <p class="text-xs text-gray-400 mt-1">This title will be displayed in the checkout summary breakdown.</p>
      </div>

      <div class="mb-6">
        <label for="percentage" class="block text-sm font-semibold text-gray-700 mb-2">Additional Charge Percentage (%)</label>
        <div class="relative">
          <input type="number" step="0.01" min="0" max="100" id="percentage" name="percentage" value="{{ old('percentage', $charge->percentage ?? 0.00) }}" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#C25A2A] focus:border-transparent outline-none text-sm pr-10" placeholder="0.00" required>
          <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-400 font-semibold text-sm">
            %
          </div>
        </div>
        <p class="text-xs text-gray-500 mt-2">
          <strong>How it works:</strong> If you set <strong>10%</strong>, a product with a base price of <strong>£10.00</strong> will be displayed on the frontend as <strong>£11.00</strong>. The customer sees only the final calculated total (£11.00) on product cards and listings. At checkout, the summary breakdown will itemize the HYST charge explicitly.
        </p>
      </div>

      <div class="mb-6">
        <label class="flex items-center gap-3 cursor-pointer">
          <input type="checkbox" name="is_active" value="1" {{ old('is_active', $charge->is_active ?? true) ? 'checked' : '' }} class="w-4 h-4 text-[#C25A2A] rounded border-gray-300 focus:ring-[#C25A2A]">
          <span class="text-sm font-medium text-gray-700">Enable HYST Additional Charge</span>
        </label>
      </div>

      <div class="pt-4 border-t border-gray-100 flex items-center justify-end">
        <button type="submit" class="bg-[#C25A2A] text-white px-6 py-2.5 rounded-lg hover:bg-[#a84c22] transition-colors text-sm font-medium flex items-center gap-2">
          <i data-lucide="save" class="w-4 h-4"></i> Save Changes
        </button>
      </div>
    </form>
  </div>
</div>
@endsection

@extends('layouts.app')
@section('content')
<div class="p-8">
  <div class="flex flex-col md:flex-row justify-between items-center mb-8">
    <div>
      <h1 class="text-2xl font-medium">System Admin Dashboard</h1>
      <p class="text-gray-500 text-sm mt-1">Overview of system charges and catalog status</p>
    </div>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm">
      <div class="flex justify-between items-center">
        <div>
          <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">Active HYST Charge</p>
          <h3 class="text-2xl font-bold text-[#C25A2A] mt-1">
            {{ $activeCharge ? number_format($activeCharge->percentage, 2) . '%' : '0.00%' }}
          </h3>
          <p class="text-xs text-gray-400 mt-1">
            Status: {{ ($activeCharge && $activeCharge->is_active) ? 'Active' : 'Disabled' }}
          </p>
        </div>
        <div class="w-12 h-12 bg-orange-50 rounded-full flex items-center justify-center text-[#C25A2A]">
          <i data-lucide="percent" class="w-6 h-6"></i>
        </div>
      </div>
    </div>

    <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm">
      <div class="flex justify-between items-center">
        <div>
          <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">Total Products</p>
          <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ number_format($totalProducts) }}</h3>
          <p class="text-xs text-gray-400 mt-1">Items subject to charge percentage</p>
        </div>
        <div class="w-12 h-12 bg-blue-50 rounded-full flex items-center justify-center text-blue-600">
          <i data-lucide="package" class="w-6 h-6"></i>
        </div>
      </div>
    </div>

    <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm">
      <div class="flex justify-between items-center">
        <div>
          <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">Total Orders Processed</p>
          <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ number_format($totalOrders) }}</h3>
          <p class="text-xs text-gray-400 mt-1">Total HYST Collected: £{{ number_format($totalHystChargesCollected, 2) }}</p>
        </div>
        <div class="w-12 h-12 bg-green-50 rounded-full flex items-center justify-center text-green-600">
          <i data-lucide="shopping-bag" class="w-6 h-6"></i>
        </div>
      </div>
    </div>
  </div>

  <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm">
    <h2 class="text-lg font-semibold text-gray-800 mb-2">Quick Actions</h2>
    <p class="text-sm text-gray-500 mb-4">Manage the additional percentage charge applied to products on the store front.</p>
    <a href="{{ route('system_admin.product-charges.index') }}" class="inline-flex items-center gap-2 bg-[#C25A2A] text-white px-4 py-2.5 rounded-lg hover:bg-[#a84c22] transition-colors text-sm font-medium">
      <i data-lucide="percent" class="w-4 h-4"></i> Manage Product Charges
    </a>
  </div>
</div>
@endsection

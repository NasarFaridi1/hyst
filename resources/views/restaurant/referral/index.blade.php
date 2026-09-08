@extends('layouts.app')

@section('content')

<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
      integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer" />

<div class="max-w-7xl mx-auto px-4 py-6">

    <!-- Header -->
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
            <i class="fas fa-user-friends text-[#C25A2A]"></i> Restaurant Referral Program Settings
        </h2>
        <p class="text-sm text-gray-500 mt-1">
            Configure how your customers refer their friends to order from your restaurant. Set referee discounts, minimum order requirements, and referrer rewards!
        </p>
    </div>

    @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg flex items-center justify-between">
            <div class="flex items-center gap-2">
                <i class="fas fa-check-circle text-green-500"></i>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif

    <!-- Main Grid: Settings & Stats -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Form Card -->
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2 border-b pb-3">
                <i class="fas fa-sliders text-[#C25A2A]"></i> Referral Settings & Rules
            </h3>

            <form action="{{ route('restaurant.referral.settings.update') }}" method="POST" class="space-y-5">
                @csrf

                <!-- Enable/Disable Switch -->
                <div class="flex items-center justify-between bg-orange-50 p-4 rounded-lg border border-orange-100">
                    <div>
                        <span class="text-sm font-bold text-gray-800 block">Referral Program Status</span>
                        <span class="text-xs text-gray-500">Enable or pause customer referrals for your restaurant</span>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" value="1" class="sr-only peer" {{ ($setting->is_active ?? 1) ? 'checked' : '' }}>
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#C25A2A]"></div>
                    </label>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Referee Discount Type -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Friend's Discount Type</label>
                        <select name="referee_discount_type" class="w-full text-sm rounded-lg border-gray-300 focus:border-[#C25A2A] focus:ring-[#C25A2A]">
                            <option value="fixed" {{ ($setting->referee_discount_type ?? 'fixed') == 'fixed' ? 'selected' : '' }}>Fixed Amount (£)</option>
                            <option value="percentage" {{ ($setting->referee_discount_type ?? '') == 'percentage' ? 'selected' : '' }}>Percentage (%)</option>
                        </select>
                        <p class="text-xs text-gray-400 mt-1">Discount the referred friend receives at checkout.</p>
                    </div>

                    <!-- Referee Discount Value -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Friend's Discount Value</label>
                        <input type="number" step="0.01" name="referee_discount_value" value="{{ old('referee_discount_value', $setting->referee_discount_value ?? 5.00) }}" required class="w-full text-sm rounded-lg border-gray-300 focus:border-[#C25A2A] focus:ring-[#C25A2A]">
                        <p class="text-xs text-gray-400 mt-1">e.g., 5.00 for £5 off or 15 for 15% off.</p>
                    </div>
                </div>

                <!-- Minimum Order Subtotal -->
                <div>
                    <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Minimum Order Subtotal (£)</label>
                    <input type="number" step="0.01" name="min_order_amount" value="{{ old('min_order_amount', $setting->min_order_amount ?? 10.00) }}" required class="w-full text-sm rounded-lg border-gray-300 focus:border-[#C25A2A] focus:ring-[#C25A2A]">
                    <p class="text-xs text-gray-400 mt-1">Minimum cart value required for friend to apply referral code.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Referrer Reward Type -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Referrer's Reward Type</label>
                        <select name="referrer_reward_type" class="w-full text-sm rounded-lg border-gray-300 focus:border-[#C25A2A] focus:ring-[#C25A2A]">
                            <option value="fixed" {{ ($setting->referrer_reward_type ?? 'fixed') == 'fixed' ? 'selected' : '' }}>Fixed Coupon (£)</option>
                            <option value="percentage" {{ ($setting->referrer_reward_type ?? '') == 'percentage' ? 'selected' : '' }}>Percentage Coupon (%)</option>
                        </select>
                        <p class="text-xs text-gray-400 mt-1">Reward earned by referrer after friend's order completes.</p>
                    </div>

                    <!-- Referrer Reward Value -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 uppercase mb-1">Referrer's Reward Value</label>
                        <input type="number" step="0.01" name="referrer_reward_value" value="{{ old('referrer_reward_value', $setting->referrer_reward_value ?? 5.00) }}" required class="w-full text-sm rounded-lg border-gray-300 focus:border-[#C25A2A] focus:ring-[#C25A2A]">
                        <p class="text-xs text-gray-400 mt-1">e.g., 5.00 for £5 reward coupon.</p>
                    </div>
                </div>

                <div class="pt-3 border-t flex justify-end">
                    <button type="submit" class="px-6 py-2.5 bg-[#C25A2A] hover:bg-[#A54A1F] text-white font-semibold text-sm rounded-lg shadow transition">
                        <i class="fas fa-save mr-1"></i> Save Referral Settings
                    </button>
                </div>
            </form>
        </div>

        <!-- Summary & Stats Column -->
        <div class="space-y-4">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                <h4 class="text-sm font-bold text-gray-700 uppercase tracking-wider mb-3">Referral Overview</h4>
                
                <div class="space-y-3">
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <span class="text-xs text-gray-600 font-medium">Completed Referrals</span>
                        <span class="text-base font-bold text-gray-800">{{ number_format($stats['completed_count'] ?? 0) }}</span>
                    </div>

                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <span class="text-xs text-gray-600 font-medium">Pending Referrals</span>
                        <span class="text-base font-bold text-amber-600">{{ number_format($stats['pending_count'] ?? 0) }}</span>
                    </div>

                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <span class="text-xs text-gray-600 font-medium">Total Rewards Granted</span>
                        <span class="text-base font-bold text-emerald-600">£{{ number_format($stats['total_rewards'] ?? 0, 2) }}</span>
                    </div>
                </div>
            </div>

            <!-- Flow Summary Box -->
            <div class="bg-amber-50 rounded-xl border border-amber-200 p-5">
                <h4 class="text-sm font-bold text-amber-900 flex items-center gap-2 mb-2">
                    <i class="fas fa-lightbulb text-amber-600"></i> How It Works For Customers
                </h4>
                <ol class="text-xs text-amber-800 space-y-2 list-decimal list-inside">
                    <li>Customer orders from your restaurant.</li>
                    <li>Customer gets a unique referral code/link to share with friends.</li>
                    <li>Friend enters code at checkout to get friend's discount.</li>
                    <li>Once friend's order is completed, referrer receives their reward coupon!</li>
                </ol>
            </div>
        </div>
    </div>

    <!-- Recent Referral Activity Table -->
    <div class="mt-8 bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
            <h3 class="text-base font-semibold text-gray-800">Recent Referral Log</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-left text-sm">
                <thead class="bg-gray-50 text-gray-500 font-medium text-xs uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-3">Referrer</th>
                        <th class="px-6 py-3">Referred Friend</th>
                        <th class="px-6 py-3">Order ID</th>
                        <th class="px-6 py-3">Friend Discount</th>
                        <th class="px-6 py-3">Referrer Reward</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white text-gray-700">
                    @forelse($usages as $usage)
                        <tr>
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $usage->referrer->name ?? 'User #'.$usage->referrer_id }}</td>
                            <td class="px-6 py-4">{{ $usage->referee->name ?? 'User #'.$usage->referee_id }}</td>
                            <td class="px-6 py-4">#{{ $usage->referee_order_id }}</td>
                            <td class="px-6 py-4 text-emerald-600 font-semibold">£{{ number_format($usage->referee_discount_amount, 2) }}</td>
                            <td class="px-6 py-4 text-blue-600 font-semibold">£{{ number_format($usage->referrer_reward_amount, 2) }}</td>
                            <td class="px-6 py-4">
                                @if($usage->status === 'completed')
                                    <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Completed</span>
                                @elseif($usage->status === 'pending')
                                    <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-amber-100 text-amber-800">Pending Order Completion</span>
                                @else
                                    <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Cancelled</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-xs text-gray-500">{{ $usage->created_at->format('M d, Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-gray-400">
                                No referral activity recorded yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($usages->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $usages->links() }}
            </div>
        @endif
    </div>

</div>

@endsection

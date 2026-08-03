@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">

    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Loyalty Rewards Module</h1>
            <p class="text-sm text-gray-600 mt-1">Configure your restaurant's loyalty rule and view customer reward redemptions.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-800 rounded-xl p-4 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span>🎉</span>
                <span class="font-medium text-sm">{{ session('success') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-green-600 hover:text-green-800 text-sm font-bold">&times;</button>
        </div>
    @endif

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <div class="text-sm font-medium text-gray-500 mb-1">Total Rewards Issued</div>
            <div class="text-3xl font-extrabold text-gray-900">{{ $stats['total_issued'] }}</div>
        </div>
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <div class="text-sm font-medium text-gray-500 mb-1">Active Customer Rewards</div>
            <div class="text-3xl font-extrabold text-blue-600">{{ $stats['active_rewards'] }}</div>
        </div>
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <div class="text-sm font-medium text-gray-500 mb-1">Redeemed Rewards</div>
            <div class="text-3xl font-extrabold text-green-600">{{ $stats['redeemed_rewards'] }}</div>
        </div>
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <div class="text-sm font-medium text-gray-500 mb-1">Total Discount Given</div>
            <div class="text-3xl font-extrabold text-amber-600">£{{ number_format($stats['total_discount_given'], 2) }}</div>
        </div>
    </div>

    <!-- Configure Rule Card -->
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 md:p-8 mb-10">
        <div class="border-b border-gray-100 pb-4 mb-6 flex items-center justify-between">
            <h2 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                <span>🎁</span> Loyalty Reward Configuration
            </h2>
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ ($rule && $rule->is_active) ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600' }}">
                {{ ($rule && $rule->is_active) ? '● Active' : '○ Inactive' }}
            </span>
        </div>

        <form action="{{ route('restaurant.loyalty-rewards.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                
                <div>
                    <label for="min_order_amount" class="block text-sm font-semibold text-gray-700 mb-2">
                        Minimum Qualifying Order (£) <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500 font-bold">£</span>
                        <input type="number" step="0.01" min="0.01" name="min_order_amount" id="min_order_amount" required
                            value="{{ old('min_order_amount', $rule->min_order_amount ?? 20.00) }}"
                            class="w-full pl-8 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-black focus:border-black text-sm"
                            placeholder="20.00">
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Order amount customer must spend to earn reward.</p>
                </div>

                <div>
                    <label for="reward_amount" class="block text-sm font-semibold text-gray-700 mb-2">
                        Reward Amount (£) <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500 font-bold">£</span>
                        <input type="number" step="0.01" min="0.01" name="reward_amount" id="reward_amount" required
                            value="{{ old('reward_amount', $rule->reward_amount ?? 5.00) }}"
                            class="w-full pl-8 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-black focus:border-black text-sm"
                            placeholder="5.00">
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Discount amount given for their NEXT order.</p>
                </div>

                <div>
                    <label for="expiry_days" class="block text-sm font-semibold text-gray-700 mb-2">
                        Reward Expiry Period (Days) <span class="text-red-500">*</span>
                    </label>
                    <input type="number" min="1" name="expiry_days" id="expiry_days" required
                        value="{{ old('expiry_days', $rule->expiry_days ?? 30) }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-black focus:border-black text-sm"
                        placeholder="30">
                    <p class="text-xs text-gray-500 mt-1">Days before earned reward expires.</p>
                </div>

                <div>
                    <label for="max_uses_per_user" class="block text-sm font-semibold text-gray-700 mb-2">
                        Max Uses per Customer (Optional)
                    </label>
                    <input type="number" min="1" name="max_uses_per_user" id="max_uses_per_user"
                        value="{{ old('max_uses_per_user', $rule->max_uses_per_user ?? '') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-black focus:border-black text-sm"
                        placeholder="Unlimited (leave empty)">
                    <p class="text-xs text-gray-500 mt-1">Leave empty for unlimited cycle.</p>
                </div>

            </div>

            <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $rule->is_active ?? true) ? 'checked' : '' }} class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-black relative"></div>
                    <span class="ml-3 text-sm font-semibold text-gray-900">Enable Loyalty Rewards Module</span>
                </label>

                <div class="flex items-center gap-3">
                    @if($rule)
                        <button type="button" onclick="if(confirm('Delete this loyalty rule?')) document.getElementById('deleteRuleForm').submit();"
                            class="px-4 py-2.5 text-sm font-medium text-red-600 hover:text-red-800 transition">
                            Remove Rule
                        </button>
                    @endif
                    <button type="submit" class="bg-black hover:bg-gray-800 text-white font-bold px-6 py-3 rounded-xl transition text-sm shadow">
                        Save Loyalty Rule
                    </button>
                </div>
            </div>
        </form>

        @if($rule)
            <form id="deleteRuleForm" action="{{ route('restaurant.loyalty-rewards.destroy') }}" method="POST" class="hidden">
                @csrf
                @method('DELETE')
            </form>
        @endif
    </div>

    <!-- Recent Customer Rewards Activity -->
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100">
            <h3 class="text-lg font-bold text-gray-900">Recent Customer Loyalty Rewards Activity</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50 text-xs font-bold text-gray-500 uppercase tracking-wider">
                    <tr>
                        <th class="p-4">Customer</th>
                        <th class="p-4">Reward Amount</th>
                        <th class="p-4">Earned From Order</th>
                        <th class="p-4">Status</th>
                        <th class="p-4">Expires At</th>
                        <th class="p-4">Redeemed Order</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse($recentRewards as $reward)
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="p-4 font-semibold text-gray-900">
                                {{ $reward->user->name ?? 'Customer #'.$reward->user_id }}
                                <div class="text-xs font-normal text-gray-500">{{ $reward->user->email ?? '' }}</div>
                            </td>
                            <td class="p-4 font-bold text-emerald-600">
                                £{{ number_format($reward->reward_amount, 2) }}
                            </td>
                            <td class="p-4 text-gray-600">
                                @if($reward->earnedFromOrder)
                                    <a href="/restaurant/orders/{{ $reward->earned_from_order_id }}" class="text-blue-600 hover:underline font-medium">
                                        Order #{{ $reward->earned_from_order_id }} (£{{ number_format($reward->earnedFromOrder->total_amount, 2) }})
                                    </a>
                                @else
                                    —
                                @endif
                            </td>
                            <td class="p-4">
                                @if($reward->status === 'used')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-800">
                                        Redeemed
                                    </span>
                                @elseif($reward->status === 'expired' || ($reward->expires_at && $reward->expires_at->isPast()))
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-gray-100 text-gray-600">
                                        Expired
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-blue-100 text-blue-800">
                                        Active (Available)
                                    </span>
                                @endif
                            </td>
                            <td class="p-4 text-gray-500 text-xs">
                                {{ $reward->expires_at ? $reward->expires_at->format('d M Y, h:i A') : 'N/A' }}
                            </td>
                            <td class="p-4 text-gray-600">
                                @if($reward->usedInOrder)
                                    <a href="/restaurant/orders/{{ $reward->used_in_order_id }}" class="text-purple-600 hover:underline font-medium">
                                        Order #{{ $reward->used_in_order_id }}
                                    </a>
                                    <div class="text-xs text-gray-400">{{ $reward->used_at ? $reward->used_at->format('d M Y') : '' }}</div>
                                @else
                                    —
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-gray-500 text-sm">
                                No customer loyalty rewards issued yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($recentRewards->hasPages())
            <div class="p-4 border-t border-gray-100">
                {{ $recentRewards->links() }}
            </div>
        @endif
    </div>

</div>
@endsection

@extends('layouts.app')

@section('content')

<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
      integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer" />

<div class="max-w-7xl mx-auto px-4 py-6">

    <!-- Header & Action -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                <i class="fas fa-gift text-[#C25A2A]"></i> Loyalty Rewards Module
            </h2>
            <p class="text-sm text-gray-500 mt-1">
                Configure automatic order reward rules for your customers. When customers spend the minimum amount, they automatically earn a discount for their next order!
            </p>
        </div>

        <button onclick="openCreateModal()"
           class="inline-flex items-center px-4 py-2.5 bg-[#C25A2A] hover:bg-[#A54A1F] text-white font-semibold text-sm rounded-lg shadow-md transition duration-200 cursor-pointer">
            <i class="fas fa-plus mr-2"></i>
            Add Loyalty Rule
        </button>
    </div>

    <!-- Alert Notifications -->
    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-lg flex items-center justify-between">
            <div class="flex items-center">
                <i class="fas fa-check-circle text-emerald-500 text-lg mr-3"></i>
                <span>{{ session('success') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-lg flex items-center justify-between">
            <div class="flex items-center">
                <i class="fas fa-exclamation-triangle text-rose-500 text-lg mr-3"></i>
                <span>{{ session('error') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
    @endif

    <!-- Statistics Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Active Rules</p>
                <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $stats['active_rules'] }} / {{ $stats['total_rules'] }}</h3>
            </div>
            <div class="w-12 h-12 bg-amber-50 rounded-full flex items-center justify-between justify-center text-[#C25A2A]">
                <i class="fas fa-[#C25A2A] fa-sliders text-xl"></i>
            </div>
        </div>

        <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Total Rewards Issued</p>
                <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ number_format($stats['total_issued']) }}</h3>
            </div>
            <div class="w-12 h-12 bg-blue-50 rounded-full flex items-center justify-center text-blue-600">
                <i class="fas fa-award text-xl"></i>
            </div>
        </div>

        <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Redeemed Rewards</p>
                <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ number_format($stats['total_redeemed']) }}</h3>
            </div>
            <div class="w-12 h-12 bg-emerald-50 rounded-full flex items-center justify-center text-emerald-600">
                <i class="fas fa-receipt text-xl"></i>
            </div>
        </div>

        <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Customer Savings</p>
                <h3 class="text-2xl font-bold text-emerald-600 mt-1">£{{ number_format($stats['total_discount'], 2) }}</h3>
            </div>
            <div class="w-12 h-12 bg-purple-50 rounded-full flex items-center justify-center text-purple-600">
                <i class="fas fa-coins text-xl"></i>
            </div>
        </div>
    </div>

    <!-- Section 1: Loyalty Rules Table -->
    <div class="bg-white rounded-xl shadow border border-gray-200 overflow-hidden mb-10">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex items-center justify-between">
            <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                <i class="fas fa-cogs text-gray-500"></i> Active Loyalty Rules
            </h3>
            <span class="text-xs bg-gray-200 text-gray-700 font-semibold px-2.5 py-1 rounded-full">
                {{ $rules->count() }} Configured
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Rule Name</th>
                        <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Min. Order</th>
                        <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Reward Value</th>
                        <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Expiry</th>
                        <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Max Usages</th>
                        <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3.5 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($rules as $rule)
                        <tr class="hover:bg-gray-50/80 transition">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="font-bold text-gray-900">{{ $rule->name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="font-semibold text-gray-700">£{{ number_format($rule->minimum_order_amount, 2) }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($rule->reward_type === 'percentage')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-purple-100 text-purple-800">
                                        <i class="fas fa-percent text-xs mr-1"></i> {{ number_format($rule->reward_value, 0) }}% Off
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                                        <i class="fas fa-tag text-xs mr-1"></i> £{{ number_format($rule->reward_value, 2) }} Off
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                <i class="far fa-clock text-gray-400 mr-1"></i> {{ $rule->expiry_days }} Days
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                {{ $rule->max_usage }} {{ Str::plural('use', $rule->max_usage) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <form action="{{ route('restaurant.loyalty-rewards.toggle', $rule->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="cursor-pointer">
                                        @if($rule->is_active)
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800 hover:bg-emerald-200 transition">
                                                <span class="w-2 h-2 rounded-full bg-emerald-500 mr-1.5"></span> Active
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-600 hover:bg-gray-200 transition">
                                                <span class="w-2 h-2 rounded-full bg-gray-400 mr-1.5"></span> Inactive
                                            </span>
                                        @endif
                                    </button>
                                </form>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end gap-2">
                                    <button onclick="openEditModal({{ json_encode($rule) }})" 
                                            class="text-blue-600 hover:text-blue-900 p-1.5 hover:bg-blue-50 rounded transition">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form action="{{ route('restaurant.loyalty-rewards.destroy', $rule->id) }}" 
                                          method="POST" 
                                          onsubmit="return confirm('Are you sure you want to delete this loyalty rule?');" 
                                          class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-rose-600 hover:text-rose-900 p-1.5 hover:bg-rose-50 rounded transition">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-10 text-center text-gray-500">
                                <div class="flex flex-col items-center justify-center">
                                    <i class="fas fa-gift text-4xl text-gray-300 mb-3"></i>
                                    <p class="font-medium text-gray-600">No Loyalty Rules Configured Yet</p>
                                    <p class="text-xs text-gray-400 mt-1 mb-4">Create your first rule so customers earn rewards on qualifying orders!</p>
                                    <button onclick="openCreateModal()" class="px-4 py-2 bg-[#C25A2A] text-white text-xs font-semibold rounded-lg hover:bg-[#A54A1F]">
                                        <i class="fas fa-plus mr-1"></i> Add First Rule
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Section 2: Issued Customer Rewards History -->
    <div class="bg-white rounded-xl shadow border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex items-center justify-between">
            <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                <i class="fas fa-history text-gray-500"></i> Issued Customer Rewards Log
            </h3>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Customer</th>
                        <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Earned From Order</th>
                        <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Reward Value</th>
                        <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Expires At</th>
                        <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Issued Date</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($issuedRewards as $reward)
                        <tr class="hover:bg-gray-50/80 transition">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="font-medium text-gray-900">{{ $reward->user?->name ?? 'Customer' }}</div>
                                <div class="text-xs text-gray-500">{{ $reward->user?->email }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span class="font-semibold text-gray-800">#{{ $reward->order_id }}</span>
                                <span class="text-xs text-gray-500 ml-1">(£{{ number_format($reward->earnedFromOrder?->total_amount ?? 0, 2) }})</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($reward->reward_type === 'percentage')
                                    <span class="font-bold text-purple-700">{{ number_format($reward->reward_value, 0) }}% OFF</span>
                                @else
                                    <span class="font-bold text-emerald-700">£{{ number_format($reward->reward_value, 2) }} OFF</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($reward->status === 'available')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                                        Available
                                    </span>
                                @elseif($reward->status === 'used')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                                        Used
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-gray-100 text-gray-600">
                                        Expired
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                {{ $reward->expires_at ? $reward->expires_at->format('d M Y, h:i A') : 'No Expiry' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $reward->created_at->format('d M Y, h:i A') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500 text-sm">
                                No rewards have been issued yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($issuedRewards->hasPages())
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                {{ $issuedRewards->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Add/Edit Rule Modal -->
<div id="ruleModal" class="fixed inset-0 z-50 hidden bg-gray-900/60 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-2xl transform transition-all">
        <div class="flex items-center justify-between pb-4 border-b border-gray-100">
            <h3 id="modalTitle" class="text-xl font-bold text-gray-800">Add Loyalty Rule</h3>
            <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times text-lg"></i>
            </button>
        </div>

        <form id="ruleForm" action="{{ route('restaurant.loyalty-rewards.store') }}" method="POST" class="mt-4 space-y-4">
            @csrf
            <input type="hidden" id="formMethod" name="_method" value="POST">

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Rule Name</label>
                <input type="text" name="name" id="ruleName" required 
                       placeholder="e.g. Spend £20 Get £5 Off Next Order" 
                       class="w-full px-3.5 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#C25A2A] focus:border-[#C25A2A] text-sm">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Min. Order Amount (£)</label>
                    <input type="number" step="0.01" min="0.01" name="minimum_order_amount" id="minAmount" required 
                           placeholder="20.00" 
                           class="w-full px-3.5 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#C25A2A] focus:border-[#C25A2A] text-sm">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Reward Type</label>
                    <select name="reward_type" id="rewardType" required 
                            class="w-full px-3.5 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#C25A2A] focus:border-[#C25A2A] text-sm">
                        <option value="fixed">Fixed Amount (£)</option>
                        <option value="percentage">Percentage (%)</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Reward Value</label>
                    <input type="number" step="0.01" min="0.01" name="reward_value" id="rewardValue" required 
                           placeholder="5.00" 
                           class="w-full px-3.5 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#C25A2A] focus:border-[#C25A2A] text-sm">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Expiry (Days)</label>
                    <input type="number" min="1" name="expiry_days" id="expiryDays" required 
                           placeholder="30" value="30"
                           class="w-full px-3.5 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#C25A2A] focus:border-[#C25A2A] text-sm">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Max Usages Per Reward</label>
                    <input type="number" min="1" name="max_usage" id="maxUsage" required 
                           placeholder="1" value="1"
                           class="w-full px-3.5 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#C25A2A] focus:border-[#C25A2A] text-sm">
                </div>

                <div class="flex items-center pt-6">
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="is_active" id="isActive" value="1" checked class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#C25A2A] relative"></div>
                        <span class="ml-3 text-sm font-semibold text-gray-700">Active Rule</span>
                    </label>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                <button type="button" onclick="closeModal()" 
                        class="px-4 py-2 border border-gray-300 text-gray-700 font-semibold text-sm rounded-lg hover:bg-gray-50 transition">
                    Cancel
                </button>
                <button type="submit" 
                        class="px-5 py-2 bg-[#C25A2A] hover:bg-[#A54A1F] text-white font-semibold text-sm rounded-lg shadow-md transition">
                    Save Loyalty Rule
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openCreateModal() {
        document.getElementById('modalTitle').innerText = 'Add Loyalty Rule';
        document.getElementById('ruleForm').action = "{{ route('restaurant.loyalty-rewards.store') }}";
        document.getElementById('formMethod').value = 'POST';
        
        document.getElementById('ruleName').value = '';
        document.getElementById('minAmount').value = '20.00';
        document.getElementById('rewardType').value = 'fixed';
        document.getElementById('rewardValue').value = '5.00';
        document.getElementById('expiryDays').value = '30';
        document.getElementById('maxUsage').value = '1';
        document.getElementById('isActive').checked = true;

        document.getElementById('ruleModal').classList.remove('hidden');
    }

    function openEditModal(rule) {
        document.getElementById('modalTitle').innerText = 'Edit Loyalty Rule';
        document.getElementById('ruleForm').action = "/restaurant/loyalty-rewards/" + rule.id;
        document.getElementById('formMethod').value = 'PUT';

        document.getElementById('ruleName').value = rule.name;
        document.getElementById('minAmount').value = rule.minimum_order_amount;
        document.getElementById('rewardType').value = rule.reward_type;
        document.getElementById('rewardValue').value = rule.reward_value;
        document.getElementById('expiryDays').value = rule.expiry_days;
        document.getElementById('maxUsage').value = rule.max_usage;
        document.getElementById('isActive').checked = rule.is_active == 1;

        document.getElementById('ruleModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('ruleModal').classList.add('hidden');
    }
</script>

@endsection

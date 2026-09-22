@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto">

    <!-- Header & Platform Settings Trigger -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
        <div>
            <h1 class="text-4xl font-extrabold text-gray-900 flex items-center gap-3">
                <span>🛵 All Platforms Orders</span>
            </h1>
            <p class="text-gray-500 mt-1">Manage orders from Uber Eats, Deliveroo, Just Eat & Direct Website in one place.</p>
        </div>

        <button onclick="document.getElementById('credentialsModal').classList.remove('hidden')" 
                class="bg-black hover:bg-gray-800 text-white font-bold px-6 py-3 rounded-2xl shadow flex items-center gap-2 text-sm transition">
            <span>⚙️ Platform Integration Settings</span>
        </button>
    </div>

    <!-- Store Status Controls Header (Open / Pause Store per Platform) -->
    <div class="bg-white p-6 rounded-2xl shadow mb-8 border border-gray-100">
        <h3 class="text-sm font-bold text-gray-700 uppercase tracking-wider mb-4">Live Store Intake Status</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            
            <!-- Uber Eats Status -->
            @php $ueCred = $credentialsList['ubereats'] ?? null; @endphp
            <div class="p-4 rounded-xl border flex items-center justify-between {{ ($ueCred->store_status ?? 'open') === 'open' ? 'bg-emerald-50 border-emerald-200' : 'bg-amber-50 border-amber-200' }}">
                <div class="flex items-center gap-3">
                    <span class="bg-black text-white font-black text-xs px-2 py-1 rounded">UBER</span>
                    <div>
                        <h4 class="font-bold text-gray-900 text-sm">Uber Eats</h4>
                        <span class="text-xs font-semibold {{ ($ueCred->store_status ?? 'open') === 'open' ? 'text-emerald-700' : 'text-amber-700' }}">
                            {{ strtoupper($ueCred->store_status ?? 'OPEN') }}
                        </span>
                    </div>
                </div>
                <form method="POST" action="{{ route('restaurant.platform_orders.toggle_status') }}">
                    @csrf
                    <input type="hidden" name="platform" value="ubereats">
                    <input type="hidden" name="status" value="{{ ($ueCred->store_status ?? 'open') === 'open' ? 'paused' : 'open' }}">
                    <button type="submit" class="text-xs font-bold px-3 py-1.5 rounded-lg border {{ ($ueCred->store_status ?? 'open') === 'open' ? 'bg-amber-600 text-white hover:bg-amber-700' : 'bg-emerald-600 text-white hover:bg-emerald-700' }}">
                        {{ ($ueCred->store_status ?? 'open') === 'open' ? 'Pause Intake' : 'Open Store' }}
                    </button>
                </form>
            </div>

            <!-- Deliveroo Status -->
            @php $dlCred = $credentialsList['deliveroo'] ?? null; @endphp
            <div class="p-4 rounded-xl border flex items-center justify-between {{ ($dlCred->store_status ?? 'open') === 'open' ? 'bg-teal-50 border-teal-200' : 'bg-amber-50 border-amber-200' }}">
                <div class="flex items-center gap-3">
                    <span class="bg-teal-600 text-white font-black text-xs px-2 py-1 rounded">DELIVEROO</span>
                    <div>
                        <h4 class="font-bold text-gray-900 text-sm">Deliveroo</h4>
                        <span class="text-xs font-semibold {{ ($dlCred->store_status ?? 'open') === 'open' ? 'text-teal-700' : 'text-amber-700' }}">
                            {{ strtoupper($dlCred->store_status ?? 'OPEN') }}
                        </span>
                    </div>
                </div>
                <form method="POST" action="{{ route('restaurant.platform_orders.toggle_status') }}">
                    @csrf
                    <input type="hidden" name="platform" value="deliveroo">
                    <input type="hidden" name="status" value="{{ ($dlCred->store_status ?? 'open') === 'open' ? 'paused' : 'open' }}">
                    <button type="submit" class="text-xs font-bold px-3 py-1.5 rounded-lg border {{ ($dlCred->store_status ?? 'open') === 'open' ? 'bg-amber-600 text-white hover:bg-amber-700' : 'bg-emerald-600 text-white hover:bg-emerald-700' }}">
                        {{ ($dlCred->store_status ?? 'open') === 'open' ? 'Pause Intake' : 'Open Store' }}
                    </button>
                </form>
            </div>

            <!-- Just Eat Status -->
            @php $jeCred = $credentialsList['justeat'] ?? null; @endphp
            <div class="p-4 rounded-xl border flex items-center justify-between {{ ($jeCred->store_status ?? 'open') === 'open' ? 'bg-red-50 border-red-200' : 'bg-amber-50 border-amber-200' }}">
                <div class="flex items-center gap-3">
                    <span class="bg-red-600 text-white font-black text-xs px-2 py-1 rounded">JUST EAT</span>
                    <div>
                        <h4 class="font-bold text-gray-900 text-sm">Just Eat</h4>
                        <span class="text-xs font-semibold {{ ($jeCred->store_status ?? 'open') === 'open' ? 'text-red-700' : 'text-amber-700' }}">
                            {{ strtoupper($jeCred->store_status ?? 'OPEN') }}
                        </span>
                    </div>
                </div>
                <form method="POST" action="{{ route('restaurant.platform_orders.toggle_status') }}">
                    @csrf
                    <input type="hidden" name="platform" value="justeat">
                    <input type="hidden" name="status" value="{{ ($jeCred->store_status ?? 'open') === 'open' ? 'paused' : 'open' }}">
                    <button type="submit" class="text-xs font-bold px-3 py-1.5 rounded-lg border {{ ($jeCred->store_status ?? 'open') === 'open' ? 'bg-amber-600 text-white hover:bg-amber-700' : 'bg-emerald-600 text-white hover:bg-emerald-700' }}">
                        {{ ($jeCred->store_status ?? 'open') === 'open' ? 'Pause Intake' : 'Open Store' }}
                    </button>
                </form>
            </div>

        </div>
    </div>

    <!-- Platform Filter Tabs (All, Uber Eats, Deliveroo, Just Eat) -->
    <div class="flex border-b border-gray-200 mb-6 gap-2">
        <a href="{{ route('restaurant.platform_orders.index', ['tab' => 'all']) }}" 
           class="px-6 py-3 font-bold text-sm border-b-2 transition flex items-center gap-2 {{ $tab === 'all' ? 'border-black text-black' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
            📦 All Platforms <span class="bg-gray-200 text-gray-800 text-xs px-2 py-0.5 rounded-full">{{ $counts['all'] }}</span>
        </a>
        <a href="{{ route('restaurant.platform_orders.index', ['tab' => 'ubereats']) }}" 
           class="px-6 py-3 font-bold text-sm border-b-2 transition flex items-center gap-2 {{ $tab === 'ubereats' ? 'border-black text-black' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
            🟢 Uber Eats <span class="bg-emerald-100 text-emerald-800 text-xs px-2 py-0.5 rounded-full">{{ $counts['ubereats'] }}</span>
        </a>
        <a href="{{ route('restaurant.platform_orders.index', ['tab' => 'deliveroo']) }}" 
           class="px-6 py-3 font-bold text-sm border-b-2 transition flex items-center gap-2 {{ $tab === 'deliveroo' ? 'border-black text-black' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
            🦘 Deliveroo <span class="bg-teal-100 text-teal-800 text-xs px-2 py-0.5 rounded-full">{{ $counts['deliveroo'] }}</span>
        </a>
        <a href="{{ route('restaurant.platform_orders.index', ['tab' => 'justeat']) }}" 
           class="px-6 py-3 font-bold text-sm border-b-2 transition flex items-center gap-2 {{ $tab === 'justeat' ? 'border-black text-black' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
            🔴 Just Eat <span class="bg-red-100 text-red-800 text-xs px-2 py-0.5 rounded-full">{{ $counts['justeat'] }}</span>
        </a>
    </div>

    <!-- Flash Notifications -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl mb-6 font-semibold">
            {{ session('success') }}
        </div>
    @endif

    <!-- Orders Stream Table -->
    <div class="bg-white rounded-2xl shadow overflow-hidden border border-gray-100">
        <table class="w-full text-left">
            <thead class="bg-gray-50 text-gray-600 text-xs uppercase font-bold border-b">
                <tr>
                    <th class="p-4">Platform</th>
                    <th class="p-4">Order Ref</th>
                    <th class="p-4">Customer Info</th>
                    <th class="p-4">Items</th>
                    <th class="p-4">Total</th>
                    <th class="p-4">Status</th>
                    <th class="p-4 text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y text-sm">
                @forelse($orders as $order)
                <tr class="hover:bg-gray-50/80 transition">
                    <td class="p-4">
                        @if(($order->platform_source ?? 'internal') === 'ubereats')
                            <span class="bg-black text-white px-2.5 py-1 rounded text-xs font-black">🟢 UBER EATS</span>
                        @elseif(($order->platform_source ?? 'internal') === 'deliveroo')
                            <span class="bg-teal-600 text-white px-2.5 py-1 rounded text-xs font-black">🦘 DELIVEROO</span>
                        @elseif(($order->platform_source ?? 'internal') === 'justeat')
                            <span class="bg-red-600 text-white px-2.5 py-1 rounded text-xs font-black">🔴 JUST EAT</span>
                        @else
                            <span class="bg-orange-500 text-white px-2.5 py-1 rounded text-xs font-black">🌐 WEBSITE</span>
                        @endif
                    </td>
                    <td class="p-4 font-bold text-gray-900">
                        {{ $order->platform_display_code ?: ('#ORDER-' . $order->id) }}
                        <div class="text-xs font-normal text-gray-400">{{ $order->created_at->diffForHumans() }}</div>
                    </td>
                    <td class="p-4">
                        <div class="font-bold text-gray-800">{{ $order->user->name ?? 'Marketplace Customer' }}</div>
                        <div class="text-xs text-gray-500">{{ $order->phone ?: 'No phone provided' }}</div>
                    </td>
                    <td class="p-4 max-w-xs truncate text-xs text-gray-600">
                        @if($order->items && count($order->items) > 0)
                            {{ implode(', ', $order->items->pluck('product.name')->toArray()) }}
                        @else
                            Order #{{ $order->id }} Items
                        @endif
                    </td>
                    <td class="p-4 font-extrabold text-gray-900">
                        £{{ number_format($order->total_amount, 2) }}
                    </td>
                    <td class="p-4">
                        <span class="bg-blue-100 text-blue-800 text-xs font-bold px-2.5 py-1 rounded-full uppercase">
                            {{ $order->platform_order_status ?: $order->status }}
                        </span>
                    </td>
                    <td class="p-4 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <!-- Accept Order Form -->
                            <form method="POST" action="{{ route('restaurant.platform_orders.accept', $order->id) }}" class="inline">
                                @csrf
                                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold px-3 py-1.5 rounded-lg shadow">
                                    ✓ Accept
                                </button>
                            </form>

                            <!-- Mark Prepared Form -->
                            <form method="POST" action="{{ route('restaurant.platform_orders.mark_prepared', $order->id) }}" class="inline">
                                @csrf
                                <button type="submit" class="bg-black hover:bg-gray-800 text-white text-xs font-bold px-3 py-1.5 rounded-lg shadow">
                                    🍳 Ready
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="p-8 text-center text-gray-400">
                        No orders found for this platform selection.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $orders->links() }}
    </div>

</div>

<!-- Integration Settings Modal Drawer -->
<div id="credentialsModal" class="hidden fixed inset-0 bg-black/60 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-3xl w-full p-8 max-h-[90vh] overflow-y-auto shadow-2xl">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-extrabold text-gray-900">⚙️ Platform Credentials Settings</h2>
            <button onclick="document.getElementById('credentialsModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 text-2xl font-bold">&times;</button>
        </div>

        <div class="space-y-8 divide-y">
            
            <!-- Uber Eats Settings Form -->
            @php $ue = $credentialsList['ubereats'] ?? null; @endphp
            <form method="POST" action="{{ route('restaurant.platform_orders.save_credentials') }}" class="pt-4">
                @csrf
                <input type="hidden" name="platform" value="ubereats">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-extrabold text-lg text-gray-900 flex items-center gap-2">
                        <span class="bg-black text-white text-xs font-black px-2 py-0.5 rounded">UBER</span> Uber Eats Marketplace Settings
                    </h3>
                    <label class="flex items-center gap-2 text-xs font-bold text-gray-700">
                        <input type="checkbox" name="is_enabled" value="1" {{ ($ue->is_enabled ?? 0) ? 'checked' : '' }} class="rounded text-black"> Enable Uber Eats
                    </label>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1">Uber Store UUID *</label>
                        <input type="text" name="store_id" value="{{ $ue->store_id ?? '' }}" placeholder="a11e6f29-6850-4d8d-b88d-0ae69cec1111" class="w-full text-xs border rounded-xl p-3">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1">Client ID *</label>
                        <input type="text" name="client_id" value="{{ $ue->client_id ?? '' }}" placeholder="3b4tk4b3s1413F1VBAeLG..." class="w-full text-xs border rounded-xl p-3">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1">Client Secret *</label>
                        <input type="password" name="client_secret" value="{{ $ue->client_secret ?? '' }}" placeholder="Client Secret key" class="w-full text-xs border rounded-xl p-3">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1">Webhook Signing Secret</label>
                        <input type="text" name="webhook_secret" value="{{ $ue->webhook_secret ?? '' }}" placeholder="whsec_xxx" class="w-full text-xs border rounded-xl p-3">
                    </div>
                </div>
                <button type="submit" class="mt-4 bg-black text-white text-xs font-bold px-5 py-2.5 rounded-xl hover:bg-gray-800">
                    Save Uber Eats Credentials
                </button>
            </form>

            <!-- Deliveroo Settings Form -->
            @php $dl = $credentialsList['deliveroo'] ?? null; @endphp
            <form method="POST" action="{{ route('restaurant.platform_orders.save_credentials') }}" class="pt-6">
                @csrf
                <input type="hidden" name="platform" value="deliveroo">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-extrabold text-lg text-teal-700 flex items-center gap-2">
                        <span class="bg-teal-600 text-white text-xs font-black px-2 py-0.5 rounded">DELIVEROO</span> Deliveroo Partner Settings
                    </h3>
                    <label class="flex items-center gap-2 text-xs font-bold text-gray-700">
                        <input type="checkbox" name="is_enabled" value="1" {{ ($dl->is_enabled ?? 0) ? 'checked' : '' }} class="rounded text-teal-600"> Enable Deliveroo
                    </label>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1">Deliveroo Site / Location ID *</label>
                        <input type="text" name="store_id" value="{{ $dl->store_id ?? '' }}" placeholder="site_UK_LON_89432" class="w-full text-xs border rounded-xl p-3">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1">API Access Token / Key *</label>
                        <input type="password" name="client_secret" value="{{ $dl->client_secret ?? '' }}" placeholder="dlvr_token_xxx" class="w-full text-xs border rounded-xl p-3">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1">Webhook Secret</label>
                        <input type="text" name="webhook_secret" value="{{ $dl->webhook_secret ?? '' }}" placeholder="wh_secret_xxx" class="w-full text-xs border rounded-xl p-3">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1">Default Prep Time (Minutes)</label>
                        <input type="number" name="prep_time_minutes" value="{{ $dl->prep_time_minutes ?? 15 }}" placeholder="15" class="w-full text-xs border rounded-xl p-3">
                    </div>
                </div>
                <button type="submit" class="mt-4 bg-teal-600 text-white text-xs font-bold px-5 py-2.5 rounded-xl hover:bg-teal-700">
                    Save Deliveroo Credentials
                </button>
            </form>

            <!-- Just Eat Settings Form -->
            @php $je = $credentialsList['justeat'] ?? null; @endphp
            <form method="POST" action="{{ route('restaurant.platform_orders.save_credentials') }}" class="pt-6">
                @csrf
                <input type="hidden" name="platform" value="justeat">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-extrabold text-lg text-red-700 flex items-center gap-2">
                        <span class="bg-red-600 text-white text-xs font-black px-2 py-0.5 rounded">JUST EAT</span> Just Eat Partner Settings
                    </h3>
                    <label class="flex items-center gap-2 text-xs font-bold text-gray-700">
                        <input type="checkbox" name="is_enabled" value="1" {{ ($je->is_enabled ?? 0) ? 'checked' : '' }} class="rounded text-red-600"> Enable Just Eat
                    </label>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1">Just Eat Merchant / Restaurant ID *</label>
                        <input type="text" name="store_id" value="{{ $je->store_id ?? '' }}" placeholder="JE_STORE_94821" class="w-full text-xs border rounded-xl p-3">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1">API Key / Token *</label>
                        <input type="password" name="client_secret" value="{{ $je->client_secret ?? '' }}" placeholder="je_api_key_xxx" class="w-full text-xs border rounded-xl p-3">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-600 mb-1">Webhook Secret</label>
                        <input type="text" name="webhook_secret" value="{{ $je->webhook_secret ?? '' }}" placeholder="je_wh_secret_xxx" class="w-full text-xs border rounded-xl p-3">
                    </div>
                </div>
                <button type="submit" class="mt-4 bg-red-600 text-white text-xs font-bold px-5 py-2.5 rounded-xl hover:bg-red-700">
                    Save Just Eat Credentials
                </button>
            </form>

        </div>
    </div>
</div>

@endsection

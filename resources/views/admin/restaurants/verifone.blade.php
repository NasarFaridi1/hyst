@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto p-4 md:p-8">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div>
            <div class="flex items-center gap-2 text-sm text-gray-500 mb-2">
                <a href="{{ route('admin.restaurants.index') }}" class="hover:text-gray-900 transition flex items-center gap-1">
                    ← Back to Restaurants
                </a>
            </div>
            <h1 class="text-3xl font-bold text-gray-900">
                Verifone POS Integration
            </h1>
            <p class="text-gray-500 mt-1 text-sm">
                Managing Verifone Cloud POS credentials for <strong class="text-gray-800">{{ $restaurant->name }}</strong>
            </p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('admin.restaurants.edit', $restaurant->id) }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2.5 rounded-xl text-sm font-semibold transition flex items-center gap-1.5">
                ✏️ Edit Restaurant
            </a>
            <a href="{{ route('admin.restaurants.index') }}" class="bg-gray-800 hover:bg-black text-white px-4 py-2.5 rounded-xl text-sm font-semibold transition">
                Restaurant List
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl mb-6 font-medium flex items-center gap-2 text-sm">
            <span>✅</span> {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-rose-50 border border-rose-200 text-rose-800 px-4 py-3 rounded-xl mb-6 font-medium flex items-center gap-2 text-sm">
            <span>⚠️</span> {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="bg-rose-50 border border-rose-200 text-rose-800 px-4 py-3 rounded-xl mb-6 text-sm">
            <ul class="list-disc pl-5 font-medium">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.restaurants.verifone.update', $restaurant->id) }}">
        @csrf

        <!-- 5. VERIFONE POS CLOUD INTEGRATION CARD -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
            <div class="flex items-center justify-between pb-5 mb-6 border-b border-gray-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-orange-50 text-[#C25A2A] flex items-center justify-center font-bold text-lg">
                        📲
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-gray-900">Verifone Cloud POS Integration (Nexo)</h2>
                        <p class="text-xs text-gray-500">Configure terminal credentials for in-store card payments & receipt printing</p>
                    </div>
                </div>

                <button type="button" onclick="testVerifoneTerminalConnection()" class="bg-orange-50 hover:bg-orange-100 text-[#C25A2A] border border-orange-200 font-bold px-3.5 py-2 rounded-xl text-xs transition flex items-center gap-1.5 cursor-pointer">
                    🔌 Test Terminal Status
                </button>
            </div>

            <div id="verifoneStatusAlert" class="hidden mb-6 p-4 rounded-xl text-xs font-medium border"></div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Enable Integration -->
                <div class="md:col-span-2 bg-orange-50/40 p-4 rounded-xl border border-orange-100 flex items-center justify-between">
                    <div>
                        <span class="block text-sm font-bold text-gray-900">Enable Verifone POS Machine</span>
                        <span class="text-xs text-gray-500">Allow cashier to charge cards on Verifone machine & print receipts</span>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="verifone_enabled" value="1" {{ old('verifone_enabled', $restaurant->verifone_enabled) ? 'checked' : '' }} class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#C25A2A]"></div>
                    </label>
                </div>

                <!-- Environment -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Environment</label>
                    <select name="verifone_environment" class="w-full border border-gray-200 rounded-xl p-3.5 text-sm text-gray-900 focus:ring-2 focus:ring-[#C25A2A] outline-none bg-gray-50/50">
                        <option value="sandbox" {{ old('verifone_environment', $restaurant->verifone_environment) === 'sandbox' ? 'selected' : '' }}>🧪 Sandbox (Test / CST POS)</option>
                        <option value="production" {{ old('verifone_environment', $restaurant->verifone_environment) === 'production' ? 'selected' : '' }}>🚀 Production (Live Terminal)</option>
                    </select>
                </div>

                <!-- Terminal Serial Number -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Terminal Serial Number *</label>
                    <input type="text" name="verifone_serial_number" id="verifoneSerialNumberInput" value="{{ old('verifone_serial_number', $restaurant->verifone_serial_number) }}" placeholder="e.g. 453-217-464"
                        class="w-full border border-gray-200 rounded-xl p-3.5 text-sm text-gray-900 focus:ring-2 focus:ring-[#C25A2A] outline-none bg-gray-50/50 focus:bg-white font-mono">
                </div>

                <!-- Verifone User UID -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">User UID (Portal URL)</label>
                    <input type="text" name="verifone_uid" id="verifoneUidInput" value="{{ old('verifone_uid', $restaurant->verifone_uid) }}" placeholder="e.g. 777c31b3-a85f-4823-93a5-9055d1b"
                        class="w-full border border-gray-200 rounded-xl p-3.5 text-sm text-gray-900 focus:ring-2 focus:ring-[#C25A2A] outline-none bg-gray-50/50 focus:bg-white">
                </div>

                <!-- Verifone API Key -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">API Key</label>
                    <input type="password" name="verifone_api_key" id="verifoneApiKeyInput" value="{{ old('verifone_api_key', $restaurant->verifone_api_key) }}" placeholder="cGEFFLjYuUCtmerXlhTf..."
                        class="w-full border border-gray-200 rounded-xl p-3.5 text-sm text-gray-900 focus:ring-2 focus:ring-[#C25A2A] outline-none bg-gray-50/50 focus:bg-white">
                </div>

                <!-- POI ID (Auto-Fetched) -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2 flex items-center justify-between">
                        <span>POI ID (Auto-Fetched)</span>
                        <span class="text-[10px] text-gray-400 font-normal">🤖 Fetched via Status API</span>
                    </label>
                    <input type="text" name="verifone_poiid" id="verifonePoiIdInput" value="{{ old('verifone_poiid', $restaurant->verifone_poiid) }}" placeholder="e.g. T650P-T1"
                        class="w-full border border-gray-200 rounded-xl p-3.5 text-sm text-gray-700 bg-gray-100/70 font-mono">
                </div>

                <!-- Entity UID (Auto-Fetched Header x-site-entity-id) -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2 flex items-center justify-between">
                        <span>Entity UID (Header x-site-entity-id)</span>
                        <span class="text-[10px] text-gray-400 font-normal">🤖 Fetched via Status API</span>
                    </label>
                    <input type="text" name="verifone_entity_uid" id="verifoneEntityUidInput" value="{{ old('verifone_entity_uid', $restaurant->verifone_entity_uid) }}" placeholder="e.g. 09b22bfd-a2b2-4afc-8bd9-4ef77f2f57ae"
                        class="w-full border border-gray-200 rounded-xl p-3.5 text-sm text-gray-700 bg-gray-100/70 font-mono">
                </div>

                <!-- POS Sale ID -->
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Sale ID (Default: RetailPOS)</label>
                    <input type="text" name="verifone_sale_id" value="{{ old('verifone_sale_id', $restaurant->verifone_sale_id ?? 'RetailPOS') }}" placeholder="RetailPOS"
                        class="w-full border border-gray-200 rounded-xl p-3.5 text-sm text-gray-900 focus:ring-2 focus:ring-[#C25A2A] outline-none bg-gray-50/50 focus:bg-white">
                </div>
            </div>
        </div>

        <!-- Submit Buttons -->
        <div class="flex items-center justify-end gap-3 mt-6">
            <a href="{{ route('admin.restaurants.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold text-sm px-6 py-3.5 rounded-xl transition">
                Cancel
            </a>
            <button type="submit" class="bg-[#C25A2A] hover:bg-[#A84B22] text-white font-bold text-sm px-8 py-3.5 rounded-xl shadow-lg hover:shadow-xl transition transform active:scale-95 flex items-center gap-2">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                Save Verifone Settings
            </button>
        </div>
    </form>
</div>

<script>
function testVerifoneTerminalConnection() {
    const alertBox = document.getElementById('verifoneStatusAlert');
    if (alertBox) {
        alertBox.className = 'mb-6 p-4 rounded-xl text-xs font-medium bg-blue-50 border border-blue-200 text-blue-800';
        alertBox.innerHTML = '⏳ Testing connection to Verifone POS Cloud...';
        alertBox.classList.remove('hidden');
    }

    const sn = document.getElementById('verifoneSerialNumberInput')?.value || '';
    const uid = document.getElementById('verifoneUidInput')?.value || '';
    const apiKey = document.getElementById('verifoneApiKeyInput')?.value || '';
    const env = document.querySelector('[name="verifone_environment"]')?.value || 'sandbox';

    fetch('{{ route("admin.restaurants.verifone.status", $restaurant->id) }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            verifone_serial_number: sn,
            verifone_uid: uid,
            verifone_api_key: apiKey,
            verifone_environment: env
        })
    })
    .then(res => res.json())
    .then(data => {
        if (data.poi_id && document.getElementById('verifonePoiIdInput')) {
            document.getElementById('verifonePoiIdInput').value = data.poi_id;
        }
        if (data.entity_uid && document.getElementById('verifoneEntityUidInput')) {
            document.getElementById('verifoneEntityUidInput').value = data.entity_uid;
        }

        if (alertBox) {
            if (data.success && data.connected) {
                alertBox.className = 'mb-6 p-4 rounded-xl text-xs font-medium bg-emerald-50 border border-emerald-200 text-emerald-800';
                alertBox.innerHTML = '🟢 <strong>Terminal Online & Connected!</strong><br>POI ID: <strong>' + (data.poi_id || 'N/A') + '</strong> | Entity UID: <strong>' + (data.entity_uid || 'N/A') + '</strong><br>Ready to process payments & print receipts.';
            } else if (data.success) {
                alertBox.className = 'mb-6 p-4 rounded-xl text-xs font-medium bg-amber-50 border border-amber-200 text-amber-800';
                alertBox.innerHTML = '🟡 <strong>Terminal Offline / Disconnected</strong><br>POI ID: <strong>' + (data.poi_id || 'N/A') + '</strong> | Entity UID: <strong>' + (data.entity_uid || 'N/A') + '</strong><br>Check physical machine connection.';
            } else {
                alertBox.className = 'mb-6 p-4 rounded-xl text-xs font-medium bg-rose-50 border border-rose-200 text-rose-800';
                alertBox.innerHTML = '🔴 <strong>Connection Failed:</strong> ' + (data.error || 'Unable to reach Verifone Cloud POS API.');
            }
        }
    })
    .catch(err => {
        if (alertBox) {
            alertBox.className = 'mb-6 p-4 rounded-xl text-xs font-medium bg-rose-50 border border-rose-200 text-rose-800';
            alertBox.innerHTML = '🔴 <strong>Connection Error:</strong> Could not connect to server.';
        }
    });
}
</script>
@endsection

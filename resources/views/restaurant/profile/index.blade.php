@extends('layouts.app')

@section('content')

    <div class="max-w-5xl mx-auto px-4 py-6 md:py-8">

        <!-- Page Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 tracking-tight">
                    Restaurant Profile
                </h1>
                <p class="text-sm md:text-base text-gray-500 mt-1">
                    Manage your store information, location, operating hours, and security settings.
                </p>
            </div>
            <div class="flex items-center gap-3">
                <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-xs font-semibold {{ ($restaurant->restaurant_status === 'Open' || ($restaurant->is_open ?? false)) ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-rose-50 text-rose-700 border border-rose-200' }}">
                    <span class="w-2 h-2 rounded-full {{ ($restaurant->restaurant_status === 'Open' || ($restaurant->is_open ?? false)) ? 'bg-emerald-500 animate-pulse' : 'bg-rose-500' }}"></span>
                    {{ ($restaurant->restaurant_status === 'Open' || ($restaurant->is_open ?? false)) ? 'Store Open' : 'Store Closed' }}
                </span>
            </div>
        </div>

        <form method="POST" action="/restaurant/profile/update" enctype="multipart/form-data" class="space-y-8">
            @csrf

            <!-- 1. BASIC INFORMATION CARD -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
                <div class="flex items-center gap-3 pb-5 mb-6 border-b border-gray-100">
                    <div class="w-10 h-10 rounded-xl bg-orange-50 text-[#C25A2A] flex items-center justify-center font-bold">
                        🏪
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-gray-900">Basic Details</h2>
                        <p class="text-xs text-gray-500">Essential details about your restaurant</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Restaurant Name -->
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                            Restaurant Name
                        </label>
                        <input type="text" name="name" value="{{ old('name', $restaurant->name) }}" required
                            class="w-full border border-gray-200 rounded-xl p-3.5 text-sm text-gray-900 focus:ring-2 focus:ring-[#C25A2A] focus:border-[#C25A2A] outline-none transition bg-gray-50/50 focus:bg-white">
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2 flex items-center justify-between">
                            <span>Email Address</span>
                            <span class="text-[10px] text-gray-400 font-normal">🔒 Read-only</span>
                        </label>
                        <input type="email" name="email" value="{{ $restaurant->email }}" @disabled(true) @readonly(true)
                            class="w-full border border-gray-200 rounded-xl p-3.5 text-sm text-gray-500 bg-gray-100/70 cursor-not-allowed">
                    </div>

                    <!-- Phone -->
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                            Phone Number
                        </label>
                        <input type="text" name="phone" value="{{ old('phone', $restaurant->phone) }}" required
                            class="w-full border border-gray-200 rounded-xl p-3.5 text-sm text-gray-900 focus:ring-2 focus:ring-[#C25A2A] focus:border-[#C25A2A] outline-none transition bg-gray-50/50 focus:bg-white">
                    </div>

                    <!-- Description -->
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                            Description
                        </label>
                        <textarea name="description" rows="3" required placeholder="Describe your restaurant cuisines, specialties..."
                            class="w-full border border-gray-200 rounded-xl p-3.5 text-sm text-gray-900 focus:ring-2 focus:ring-[#C25A2A] focus:border-[#C25A2A] outline-none transition bg-gray-50/50 focus:bg-white resize-y">{{ old('description', $restaurant->description) }}</textarea>
                    </div>

                    <!-- Dietary Categories -->
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                            Dietary Categories (Serving Categories)
                        </label>
                        @php
                            $savedDietary = old('dietary_categories', $restaurant->dietary_categories ?? []);
                        @endphp
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 p-4 border border-gray-200 rounded-xl bg-orange-50/30">
                            <label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 bg-white cursor-pointer hover:border-[#C25A2A] transition">
                                <input type="checkbox" name="dietary_categories[]" value="halal" {{ in_array('halal', $savedDietary) ? 'checked' : '' }} class="w-4 h-4 text-[#C25A2A] rounded border-gray-300 focus:ring-[#C25A2A]">
                                <span class="text-sm font-semibold text-gray-800">🌙 Halal</span>
                            </label>
                            <label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 bg-white cursor-pointer hover:border-[#C25A2A] transition">
                                <input type="checkbox" name="dietary_categories[]" value="vegan" {{ in_array('vegan', $savedDietary) ? 'checked' : '' }} class="w-4 h-4 text-[#C25A2A] rounded border-gray-300 focus:ring-[#C25A2A]">
                                <span class="text-sm font-semibold text-gray-800">🌱 Vegan</span>
                            </label>
                            <label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 bg-white cursor-pointer hover:border-[#C25A2A] transition">
                                <input type="checkbox" name="dietary_categories[]" value="vegetable" {{ in_array('vegetable', $savedDietary) ? 'checked' : '' }} class="w-4 h-4 text-[#C25A2A] rounded border-gray-300 focus:ring-[#C25A2A]">
                                <span class="text-sm font-semibold text-gray-800">🥗 Vegetable</span>
                            </label>
                        </div>
                        <p class="text-xs text-gray-400 mt-1">Select all categories your restaurant serves.</p>
                    </div>
                </div>
            </div>

            <!-- 2. LOCATION & ADDRESS CARD -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
                <div class="flex items-center gap-3 pb-5 mb-6 border-b border-gray-100">
                    <div class="w-10 h-10 rounded-xl bg-orange-50 text-[#C25A2A] flex items-center justify-center font-bold">
                        📍
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-gray-900">Location & Address</h2>
                        <p class="text-xs text-gray-500">Set accurate map position and physical address</p>
                    </div>
                </div>

                <!-- Leaflet Map Search -->
                <div class="mb-6 bg-orange-50/40 p-5 rounded-2xl border border-orange-100">
                    <label class="font-bold text-gray-800 block mb-2 flex items-center gap-2 text-sm">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#C25A2A" stroke-width="2.2"><path d="M12 21s-7-6.2-7-11a7 7 0 0 1 14 0c0 4.8-7 11-7 11z"/><circle cx="12" cy="10" r="2.5"/></svg>
                        Search Address on Map
                    </label>
                    <div class="relative">
                        <input
                            type="text"
                            id="leafletSearchInput"
                            value="{{ $restaurant->location }}"
                            placeholder="Type to search area, street name, postcode..."
                            class="w-full border border-gray-200 rounded-xl p-3.5 pr-10 text-sm focus:outline-none focus:ring-2 focus:ring-[#C25A2A] bg-white text-gray-800 shadow-sm"
                            autocomplete="off"
                        >
                        <div id="leafletSearchResults" class="absolute left-0 right-0 top-full bg-white border border-gray-200 rounded-xl mt-1 max-h-60 overflow-y-auto z-[9999] shadow-xl hidden"></div>
                    </div>
                    <div id="restaurantMapContainer" class="mt-4 rounded-xl border border-gray-200 overflow-hidden shadow-inner" style="height: 240px;">
                        <div id="restaurantMap" style="width: 100%; height: 100%;"></div>
                    </div>
                    <p class="text-xs text-[#C25A2A] mt-2 font-medium">💡 Drag marker on map or search above to auto-fill address coordinates.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Address (Location) -->
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                            Address (Full Location)
                        </label>
                        <input type="text" name="location" value="{{ old('location', $restaurant->location) }}" required
                            class="w-full border border-gray-200 rounded-xl p-3.5 text-sm text-gray-900 focus:ring-2 focus:ring-[#C25A2A] focus:border-[#C25A2A] outline-none transition bg-gray-50/50 focus:bg-white">
                    </div>

                    <!-- City -->
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                            City
                        </label>
                        <input type="text" name="city" value="{{ old('city', $restaurant->city) }}" required
                            class="w-full border border-gray-200 rounded-xl p-3.5 text-sm text-gray-900 focus:ring-2 focus:ring-[#C25A2A] focus:border-[#C25A2A] outline-none transition bg-gray-50/50 focus:bg-white">
                    </div>

                    <!-- State -->
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                            State
                        </label>
                        <input type="text" name="state" value="{{ old('state', $restaurant->state) }}" required
                            class="w-full border border-gray-200 rounded-xl p-3.5 text-sm text-gray-900 focus:ring-2 focus:ring-[#C25A2A] focus:border-[#C25A2A] outline-none transition bg-gray-50/50 focus:bg-white">
                    </div>

                    <!-- Country -->
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                            Country
                        </label>
                        <input type="text" name="country" value="{{ old('country', $restaurant->country) }}" required
                            class="w-full border border-gray-200 rounded-xl p-3.5 text-sm text-gray-900 focus:ring-2 focus:ring-[#C25A2A] focus:border-[#C25A2A] outline-none transition bg-gray-50/50 focus:bg-white">
                    </div>

                    <!-- Postal Code -->
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                            Postal Code
                        </label>
                        <input type="text" name="postcode" value="{{ old('postcode', $restaurant->postcode) }}" required
                            class="w-full border border-gray-200 rounded-xl p-3.5 text-sm text-gray-900 focus:ring-2 focus:ring-[#C25A2A] focus:border-[#C25A2A] outline-none transition bg-gray-50/50 focus:bg-white">
                    </div>

                    <!-- Latitude -->
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                            Latitude
                        </label>
                        <input type="text" name="latitude" id="latitude" value="{{ old('latitude', $restaurant->latitude) }}" required
                            class="w-full border border-gray-200 rounded-xl p-3.5 text-sm text-gray-900 focus:ring-2 focus:ring-[#C25A2A] focus:border-[#C25A2A] outline-none transition bg-gray-50/50 focus:bg-white">
                    </div>

                    <!-- Longitude -->
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                            Longitude
                        </label>
                        <input type="text" name="longitude" id="longitude" value="{{ old('longitude', $restaurant->longitude) }}" required
                            class="w-full border border-gray-200 rounded-xl p-3.5 text-sm text-gray-900 focus:ring-2 focus:ring-[#C25A2A] focus:border-[#C25A2A] outline-none transition bg-gray-50/50 focus:bg-white">
                    </div>
                </div>
            </div>

            <!-- 3. OPERATING HOURS & DELIVERY OPTIONS CARD -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
                <div class="flex items-center gap-3 pb-5 mb-6 border-b border-gray-100">
                    <div class="w-10 h-10 rounded-xl bg-orange-50 text-[#C25A2A] flex items-center justify-center font-bold">
                        🕒
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-gray-900">Working Hours & Delivery Options</h2>
                        <p class="text-xs text-gray-500">Configure store timing and order delivery methods</p>
                    </div>
                </div>

                <!-- Working Days -->
                <div class="mb-6">
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-3">
                        Working Days
                    </label>
                    @php
                        $selectedDays = old(
                            'working_days',
                            $restaurant->working_days ? explode(',', $restaurant->working_days) : []
                        );
                    @endphp
                    <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-7 gap-2.5">
                        @foreach([
                            'Monday',
                            'Tuesday',
                            'Wednesday',
                            'Thursday',
                            'Friday',
                            'Saturday',
                            'Sunday'
                        ] as $day)
                            <label class="flex flex-col items-center justify-center p-3 rounded-xl border border-gray-200 cursor-pointer hover:border-[#C25A2A] hover:bg-orange-50/30 transition text-center group">
                                <input type="checkbox" name="working_days[]" value="{{ $day }}"
                                    {{ in_array($day, $selectedDays) ? 'checked' : '' }}
                                    class="w-4 h-4 text-[#C25A2A] rounded border-gray-300 focus:ring-[#C25A2A] mb-1.5">
                                <span class="text-xs font-semibold text-gray-700 group-hover:text-[#C25A2A] transition">{{ $day }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Opening & Closing Time -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                            Opening Time
                        </label>
                        <input type="time" name="opening_time" value="{{ old('opening_time', $restaurant->opening_time) }}"
                            class="w-full border border-gray-200 rounded-xl p-3.5 text-sm text-gray-900 focus:ring-2 focus:ring-[#C25A2A] focus:border-[#C25A2A] outline-none transition bg-gray-50/50 focus:bg-white">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                            Closing Time
                        </label>
                        <input type="time" name="closing_time" value="{{ old('closing_time', $restaurant->closing_time) }}"
                            class="w-full border border-gray-200 rounded-xl p-3.5 text-sm text-gray-900 focus:ring-2 focus:ring-[#C25A2A] focus:border-[#C25A2A] outline-none transition bg-gray-50/50 focus:bg-white">
                    </div>
                </div>

                <div class="border-t border-gray-100 pt-6">
                    <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wider mb-4">Service & Delivery Methods</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-600 mb-1.5">
                                🍽️ Dine In
                            </label>
                            <select name="dine_in" class="w-full border border-gray-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-[#C25A2A] outline-none bg-gray-50/50 focus:bg-white">
                                <option value="1" {{ $restaurant->dine_in ? 'selected' : '' }}>Enable</option>
                                <option value="0" {{ !$restaurant->dine_in ? 'selected' : '' }}>Disable</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-600 mb-1.5">
                                🪑 Table Booking
                            </label>
                            <select name="table_book" class="w-full border border-gray-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-[#C25A2A] outline-none bg-gray-50/50 focus:bg-white">
                                <option value="1" {{ $restaurant->table_book ? 'selected' : '' }}>Enable</option>
                                <option value="0" {{ !$restaurant->table_book ? 'selected' : '' }}>Disable</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-600 mb-1.5">
                                🚚 Home Delivery
                            </label>
                            <select name="home_delivery" class="w-full border border-gray-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-[#C25A2A] outline-none bg-gray-50/50 focus:bg-white">
                                <option value="1" {{ $restaurant->home_delivery ? 'selected' : '' }}>Enable</option>
                                <option value="0" {{ !$restaurant->home_delivery ? 'selected' : '' }}>Disable</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-600 mb-1.5">
                                ⚡ ASAP Delivery
                            </label>
                            <select name="allow_asap" class="w-full border border-gray-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-[#C25A2A] outline-none bg-gray-50/50 focus:bg-white">
                                <option value="1" {{ ($restaurant->allow_asap ?? true) ? 'selected' : '' }}>Enable</option>
                                <option value="0" {{ !($restaurant->allow_asap ?? true) ? 'selected' : '' }}>Disable</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-600 mb-1.5">
                                📅 Schedule Delivery
                            </label>
                            <select name="allow_schedule" class="w-full border border-gray-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-[#C25A2A] outline-none bg-gray-50/50 focus:bg-white">
                                <option value="1" {{ ($restaurant->allow_schedule ?? true) ? 'selected' : '' }}>Enable</option>
                                <option value="0" {{ !($restaurant->allow_schedule ?? true) ? 'selected' : '' }}>Disable</option>
                            </select>
                        </div>
                    </div>
                </div>

                           <div class="border-t border-gray-100 pt-6 mt-6">
                    <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wider mb-4">🔔 Order Alert Ringtone</h3>
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 items-end">
                        <div class="lg:col-span-1">
                            <label class="block text-xs font-bold text-gray-600 mb-1.5">
                                Select Ringtone Sound
                            </label>
                            <select name="notification_sound" id="notification_sound_select" class="w-full border border-gray-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-[#C25A2A] outline-none bg-gray-50/50 focus:bg-white">
                                <option value="hyst_notification.mp3" {{ ($restaurant->notification_sound ?? 'hyst_notification.mp3') == 'hyst_notification.mp3' ? 'selected' : '' }}>Default Chime 🔔</option>
                                <option value="hyst_voice.mp3" {{ ($restaurant->notification_sound ?? '') == 'hyst_voice.mp3' ? 'selected' : '' }}>HYST Voice ("HYST Notification") 🗣️</option>
                                <option value="hyst_voice_order.mp3" {{ ($restaurant->notification_sound ?? '') == 'hyst_voice_order.mp3' ? 'selected' : '' }}>HYST Voice ("New Order Received") 📢</option>
                                <option value="cash_register.mp3" {{ ($restaurant->notification_sound ?? '') == 'cash_register.mp3' ? 'selected' : '' }}>Cash Register 💰</option>
                                <option value="loud_alarm.mp3" {{ ($restaurant->notification_sound ?? '') == 'loud_alarm.mp3' ? 'selected' : '' }}>Loud Alarm 🚨</option>
                                <option value="bell_ring.mp3" {{ ($restaurant->notification_sound ?? '') == 'bell_ring.mp3' ? 'selected' : '' }}>Service Bell 🛎️</option>
                            </select>
                        </div>
                        <div class="flex flex-wrap sm:flex-nowrap gap-2 lg:col-span-2">
                            <button type="button" onclick="previewRingtoneSound()" class="w-full sm:w-auto px-4 py-3 bg-gray-900 hover:bg-[#C25A2A] text-white font-bold rounded-xl text-xs transition flex items-center justify-center gap-2 shadow-sm">
                                <span>▶</span> Test & Preview
                            </button>
                            
                            <a id="download_ringtone_btn" 
                               href="/sounds/{{ $restaurant->notification_sound ?? 'hyst_notification.mp3' }}" 
                               download="{{ $restaurant->notification_sound ?? 'hyst_notification.mp3' }}" 
                               class="w-full sm:w-auto px-4 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-xs transition flex items-center justify-center gap-2 shadow-sm">
                                <span>⬇️</span> Download Ringtone MP3
                            </a>
                        </div>
                    </div>

                    <!-- 📲 MOBILE RINGTONE SETTING INSTRUCTIONS -->
                    <div class="mt-5 bg-orange-50/60 border border-orange-200/80 rounded-xl p-4 text-gray-700 text-xs leading-relaxed">
                        <div class="flex items-center gap-2 font-bold text-gray-900 text-sm mb-2">
                            <span>📲 How to Set Custom Ringtone on iPhone & Android Devices</span>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-3">
                            <!-- iPhone / iOS Guide -->
                            <div class="bg-white rounded-lg p-3.5 border border-orange-100 shadow-2xs">
                                <div class="font-bold text-gray-900 flex items-center gap-1.5 mb-1.5 text-xs">
                                    <span> iPhone (iOS) Setting Instructions:</span>
                                </div>
                                <ol class="list-decimal list-inside space-y-1.5 text-gray-600">
                                    <li>Click <strong>Download Ringtone MP3</strong> above to save the sound file to iPhone Downloads.</li>
                                    <li>Open the free <strong>GarageBand</strong> app on iPhone (or iTunes / Finder on Mac).</li>
                                    <li>Import the downloaded audio file, long-press the track, and tap <strong>Share &gt; Ringtone</strong>.</li>
                                    <li>Go to <strong>Settings &gt; Sounds &amp; Haptics &gt; Default Alerts / Text Tone / Ringtone </strong> and select your new <strong>HYST Ringtone</strong>!</li>
                                </ol>
                            </div>

                            <!-- Android Guide -->
                            <div class="bg-white rounded-lg p-3.5 border border-orange-100 shadow-2xs">
                                <div class="font-bold text-gray-900 flex items-center gap-1.5 mb-1.5 text-xs">
                                    <span>🤖 Android Device Setting Instructions:</span>
                                </div>
                                <ol class="list-decimal list-inside space-y-1.5 text-gray-600">
                                    <li>Click <strong>Download Ringtone MP3</strong> above to save the audio file to your device.</li>
                                    <li>Go to <strong>Settings &gt; Sound &amp; Vibration &gt; Notification Sound</strong> (or Ringtone).</li>
                                    <li>Tap <strong>+ Add Custom Sound</strong> (or <em>My Sounds / Custom Tone</em>).</li>
                                    <li>Select the downloaded HYST ringtone file from your <strong>Downloads</strong> folder and tap <strong>Done</strong>!</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    function previewRingtoneSound() {
                        const selectEl = document.getElementById('notification_sound_select');
                        const soundFile = selectEl ? selectEl.value : 'hyst_notification.mp3';
                        if (typeof window.playNotificationSound === 'function') {
                            window.playNotificationSound({ soundUrl: '/sounds/' + soundFile });
                        } else {
                            const audio = new Audio('/sounds/' + soundFile);
                            audio.play().catch(e => console.log(e));
                        }
                    }

                    document.addEventListener('DOMContentLoaded', function() {
                        const selectEl = document.getElementById('notification_sound_select');
                        const downloadBtn = document.getElementById('download_ringtone_btn');
                        if (selectEl && downloadBtn) {
                            selectEl.addEventListener('change', function() {
                                const selectedFile = this.value || 'hyst_notification.mp3';
                                downloadBtn.href = '/sounds/' + selectedFile;
                                downloadBtn.setAttribute('download', selectedFile);
                            });
                        }
                    });
                </script>
            </div>

            <!-- 4. MEDIA & HYGIENE CERTIFICATION CARD -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
                <div class="flex items-center gap-3 pb-5 mb-6 border-b border-gray-100">
                    <div class="w-10 h-10 rounded-xl bg-orange-50 text-[#C25A2A] flex items-center justify-center font-bold">
                        🛡️
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-gray-900">Media & Certification</h2>
                        <p class="text-xs text-gray-500">Upload banner image and hygiene rating document</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Restaurant Image -->
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                            Restaurant Image
                        </label>
                        @if($restaurant->image)
                            <div class="mb-3 flex items-center gap-4">
                                <img src="{{ asset('storage/' . $restaurant->image) }}" class="w-20 h-20 rounded-xl object-cover border border-gray-200 shadow-sm">
                                <span class="text-xs text-gray-400 font-medium">Current Image Uploaded</span>
                            </div>
                        @endif
                        <input type="file" name="image" accept=".jpg,.jpeg,.png,.webp"
                            class="w-full text-xs text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-orange-50 file:text-[#C25A2A] hover:file:bg-orange-100 border border-gray-200 rounded-xl p-2 cursor-pointer">
                    </div>

                    <!-- Hygiene Rating & Certificate -->
                    <div>
                        <div class="mb-4">
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                                Hygiene Rating (0.0 to 5.0)
                            </label>
                            <input type="number" name="hygiene_rating" step="0.1" min="0" max="5"
                                value="{{ old('hygiene_rating', $restaurant->hygiene_rating) }}"
                                class="w-full border border-gray-200 rounded-xl p-3.5 text-sm text-gray-900 focus:ring-2 focus:ring-[#C25A2A] outline-none bg-gray-50/50 focus:bg-white">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2 flex items-center justify-between">
                                <span>Hygiene Certificate</span>
                                @if($restaurant->hygiene_certificate)
                                    <a href="{{ asset($restaurant->hygiene_certificate) }}" class="text-xs text-[#C25A2A] hover:underline font-semibold" target="_blank">
                                        View Current File 📄
                                    </a>
                                @endif
                            </label>
                            <input type="file" name="hygiene_certificate" accept=".pdf,.jpg,.jpeg,.png"
                                class="w-full text-xs text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-orange-50 file:text-[#C25A2A] hover:file:bg-orange-100 border border-gray-200 rounded-xl p-2 cursor-pointer">
                        </div>
                    </div>
                </div>
            </div>

            <!-- 5. PAYMENT GATEWAY SETTINGS CARD -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
                <div class="flex items-center gap-3 pb-5 mb-6 border-b border-gray-100">
                    <div class="w-10 h-10 rounded-xl bg-orange-50 text-[#C25A2A] flex items-center justify-center font-bold">
                        💳
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-gray-900">Payment Gateway Settings</h2>
                        <p class="text-xs text-gray-500">Configure your Worldpay payment gateway credentials</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Worldpay Business ID -->
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                            Worldpay Business ID
                        </label>
                        <input type="text" name="worldpay_business_id" value="{{ old('worldpay_business_id', $restaurant->worldpay_business_id) }}" placeholder="example: 90809"
                            class="w-full border border-gray-200 rounded-xl p-3.5 text-sm text-gray-900 focus:ring-2 focus:ring-[#C25A2A] focus:border-[#C25A2A] outline-none transition bg-gray-50/50 focus:bg-white">
                    </div>

                    <!-- Worldpay Username -->
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                            Worldpay Username
                        </label>
                        <input type="text" name="worldpay_username" value="{{ old('worldpay_username', $restaurant->worldpay_username) }}" placeholder="example: 90809.1"
                            class="w-full border border-gray-200 rounded-xl p-3.5 text-sm text-gray-900 focus:ring-2 focus:ring-[#C25A2A] focus:border-[#C25A2A] outline-none transition bg-gray-50/50 focus:bg-white">
                    </div>

                    <!-- Worldpay Password -->
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                            Worldpay Password
                        </label>
                        <input type="text" name="worldpay_password" value="{{ old('worldpay_password', $restaurant->worldpay_password) }}" placeholder="example: dsgfdhdfhag51621gsdf"
                            class="w-full border border-gray-200 rounded-xl p-3.5 text-sm text-gray-900 focus:ring-2 focus:ring-[#C25A2A] focus:border-[#C25A2A] outline-none transition bg-gray-50/50 focus:bg-white">
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end pt-2">
                <button type="submit" class="w-full md:w-auto bg-[#C25A2A] hover:bg-[#A84B22] text-white font-bold text-base px-10 py-4 rounded-xl shadow-lg hover:shadow-xl transition transform active:scale-95 flex items-center justify-center gap-2">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                    Update Profile
                </button>
            </div>
        </form>

        <!-- 6. SECURITY / CHANGE PASSWORD CARD -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8 mt-10">
            <div class="flex items-center gap-3 pb-5 mb-6 border-b border-gray-100">
                <div class="w-10 h-10 rounded-xl bg-gray-100 text-gray-800 flex items-center justify-center font-bold">
                    🔒
                </div>
                <div>
                    <h2 class="text-lg font-bold text-gray-900">Change Password</h2>
                    <p class="text-xs text-gray-500">Keep your account secure by updating your credentials</p>
                </div>
            </div>

            <form method="POST" action="{{ route('restaurant.profile.change-password') }}">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                            Current Password
                        </label>
                        <input
                            type="password"
                            name="current_password"
                            required
                            placeholder="••••••••"
                            class="w-full border border-gray-200 rounded-xl p-3.5 text-sm text-gray-900 focus:ring-2 focus:ring-[#C25A2A] outline-none @error('current_password') border-red-500 @enderror">
                        @error('current_password')
                            <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                            New Password
                        </label>
                        <input
                            type="password"
                            name="new_password"
                            required
                            placeholder="Min. 8 characters"
                            class="w-full border border-gray-200 rounded-xl p-3.5 text-sm text-gray-900 focus:ring-2 focus:ring-[#C25A2A] outline-none @error('new_password') border-red-500 @enderror">
                        @error('new_password')
                            <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                            Confirm New Password
                        </label>
                        <input
                            type="password"
                            name="new_password_confirmation"
                            required
                            placeholder="Re-enter password"
                            class="w-full border border-gray-200 rounded-xl p-3.5 text-sm text-gray-900 focus:ring-2 focus:ring-[#C25A2A] outline-none">
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="w-full md:w-auto bg-gray-900 hover:bg-black text-white font-bold text-sm px-8 py-3.5 rounded-xl shadow transition">
                        Update Password
                    </button>
                </div>
            </form>
        </div>

    </div>

@endsection

{{-- Leaflet Assets & Auto-fill Script --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const latInput = document.querySelector('[name="latitude"]');
    const lngInput = document.querySelector('[name="longitude"]');
    const locationInput = document.querySelector('[name="location"]');
    const cityInput = document.querySelector('[name="city"]');
    const stateInput = document.querySelector('[name="state"]');
    const countryInput = document.querySelector('[name="country"]');
    const postcodeInput = document.querySelector('[name="postcode"]');

    const searchInput = document.getElementById('leafletSearchInput');
    const searchResults = document.getElementById('leafletSearchResults');

    let defaultLat = parseFloat(latInput?.value) || 51.5074;
    let defaultLng = parseFloat(lngInput?.value) || -0.1278;

    const map = L.map('restaurantMap', {
        center: [defaultLat, defaultLng],
        zoom: (latInput?.value && lngInput?.value) ? 15 : 12,
    });

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    let marker = L.marker([defaultLat, defaultLng], { draggable: true }).addTo(map);

    function updateAddressFromCoords(lat, lng) {
        if (latInput) latInput.value = lat.toFixed(7);
        if (lngInput) lngInput.value = lng.toFixed(7);

        fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&addressdetails=1`, {
            headers: { 'Accept-Language': 'en-GB' }
        })
        .then(res => res.json())
        .then(data => {
            if (!data) return;
            const a = data.address || {};
            const street = [a.house_number, a.road || a.pedestrian || a.suburb || a.neighbourhood].filter(Boolean).join(', ');
            const fullAddress = data.display_name || street || '';
            const city = a.city || a.town || a.village || a.county || '';
            const state = a.state || a.county || '';
            const country = a.country || 'United Kingdom';
            const postcode = a.postcode || '';

            if (locationInput) locationInput.value = fullAddress;
            if (cityInput) cityInput.value = city;
            if (stateInput) stateInput.value = state;
            if (countryInput) countryInput.value = country;
            if (postcodeInput) postcodeInput.value = postcode;
            if (searchInput) searchInput.value = fullAddress;
        })
        .catch(err => console.error('Reverse geocode error:', err));
    }

    marker.on('dragend', function (e) {
        const coord = e.target.getLatLng();
        updateAddressFromCoords(coord.lat, coord.lng);
    });

    map.on('click', function (e) {
        marker.setLatLng(e.latlng);
        updateAddressFromCoords(e.latlng.lat, e.latlng.lng);
    });

    let searchDebounce;
    if (searchInput) {
        searchInput.addEventListener('input', function (e) {
            const q = e.target.value.trim();
            clearTimeout(searchDebounce);
            if (q.length < 3) {
                searchResults.classList.add('hidden');
                searchResults.innerHTML = '';
                return;
            }
            searchDebounce = setTimeout(() => {
                fetch(`https://nominatim.openstreetmap.org/search?format=json&addressdetails=1&limit=6&countrycodes=gb&q=${encodeURIComponent(q)}`, {
                    headers: { 'Accept-Language': 'en-GB' }
                })
                .then(res => res.json())
                .then(results => {
                    searchResults.innerHTML = '';
                    if (!results || !results.length) {
                        searchResults.classList.add('hidden');
                        return;
                    }
                    results.forEach(r => {
                        const item = document.createElement('div');
                        item.className = 'p-3 hover:bg-[#FFF7F3] cursor-pointer border-b border-gray-100 text-sm text-gray-800 font-medium transition';
                        item.textContent = r.display_name;
                        item.addEventListener('click', function () {
                            const lat = parseFloat(r.lat);
                            const lng = parseFloat(r.lon);

                            map.setView([lat, lng], 16);
                            marker.setLatLng([lat, lng]);

                            const a = r.address || {};
                            const street = [a.house_number, a.road || a.pedestrian || a.suburb || a.neighbourhood].filter(Boolean).join(', ');
                            const fullAddress = r.display_name || street || '';
                            const city = a.city || a.town || a.village || a.county || '';
                            const state = a.state || a.county || '';
                            const country = a.country || 'United Kingdom';
                            const postcode = a.postcode || '';

                            if (locationInput) locationInput.value = fullAddress;
                            if (cityInput) cityInput.value = city;
                            if (stateInput) stateInput.value = state;
                            if (countryInput) countryInput.value = country;
                            if (postcodeInput) postcodeInput.value = postcode;
                            if (latInput) latInput.value = lat.toFixed(7);
                            if (lngInput) lngInput.value = lng.toFixed(7);

                            searchInput.value = fullAddress;
                            searchResults.classList.add('hidden');
                        });
                        searchResults.appendChild(item);
                    });
                    searchResults.classList.remove('hidden');
                })
                .catch(err => console.error('Search error:', err));
            }, 350);
        });

        document.addEventListener('click', function (e) {
            if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
                searchResults.classList.add('hidden');
            }
        });
    }
});
</script>
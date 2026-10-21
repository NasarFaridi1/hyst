@php
    $blog = $blog ?? null;
    $defaultBaseUrl = rtrim(config('app.url', 'https://hyst.uk'), '/');
    $defaultCanonical = ($blog && ($blog->slug || $blog->id)) ? $defaultBaseUrl . '/blog/' . ($blog->slug ?? $blog->id) : $defaultBaseUrl . '/blog/your-slug';
    $defaultOgImage = ($blog && !empty($blog->image)) ? asset($blog->image) : asset('twitter.jpeg');
    $defaultMetaTitle = $blog?->meta_title ?? ($blog?->title ? $blog->title . ' | HYST Blog' : 'Food Guide | HYST Blog');
    $defaultMetaDesc = $blog?->meta_description ?? (!empty($blog?->description) ? Str::limit(strip_tags($blog->description), 155) : 'Read our local Hounslow food guide on HYST.');
@endphp

<div class="mt-10 pt-8 border-t border-gray-200">
    <!-- Header with Badges -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <div class="flex items-center gap-3">
                <span class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-orange-100 text-orange-600 text-lg">🚀</span>
                <div>
                    <h2 class="text-xl font-bold text-gray-900">SEO & Structured Data Settings</h2>
                    <p class="text-xs sm:text-sm text-gray-500">Configure search engine meta tags, Open Graph social previews, and JSON-LD schema.</p>
                </div>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span> Google & Schema Ready
            </span>
        </div>
    </div>

    <!-- Navigation Tabs -->
    <div class="border-b border-gray-200 mb-6">
        <nav class="flex gap-4 sm:gap-6 -mb-px text-sm font-semibold overflow-x-auto" id="seoTabs">
            <button type="button" class="seo-tab active py-3 px-1 border-b-2 border-orange-600 text-orange-600 flex items-center gap-2 whitespace-nowrap" data-target="tab-seo-meta">
                <span>🔍</span> Meta Tags
            </button>
            <button type="button" class="seo-tab py-3 px-1 border-b-2 border-transparent text-gray-500 hover:text-gray-700 flex items-center gap-2 whitespace-nowrap" data-target="tab-seo-og">
                <span>📱</span> Open Graph / Social
            </button>
            <button type="button" class="seo-tab py-3 px-1 border-b-2 border-transparent text-gray-500 hover:text-gray-700 flex items-center gap-2 whitespace-nowrap" data-target="tab-seo-schema">
                <span>📄</span> JSON-LD Schema
            </button>
            <button type="button" class="seo-tab py-3 px-1 border-b-2 border-transparent text-gray-500 hover:text-gray-700 flex items-center gap-2 whitespace-nowrap" data-target="tab-seo-preview">
                <span>👁️</span> Live Previews & Validator
            </button>
        </nav>
    </div>

    <!-- TAB 1: SEO Meta Tags -->
    <div id="tab-seo-meta" class="seo-tab-panel space-y-6">
        <div class="bg-gray-50/70 p-6 rounded-2xl border border-gray-100 space-y-6">
            <!-- SEO Meta Title -->
            <div>
                <div class="flex items-center justify-between mb-2">
                    <label class="block text-sm font-semibold text-gray-800">
                        SEO Meta Title
                        <span class="text-xs text-gray-400 font-normal ml-1">(Optional - falls back to Blog Title + " | HYST Blog")</span>
                    </label>
                    <span id="metaTitleCount" class="text-xs font-mono font-medium text-gray-400">0 / 60 chars</span>
                </div>
                <input type="text" name="meta_title" id="inputMetaTitle"
                       value="{{ old('meta_title', $blog?->meta_title ?? '') }}"
                       placeholder="e.g. Best Halal Indian Restaurants in Hounslow | HYST Guide"
                       class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-white focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none text-sm transition">
                <p class="text-xs text-gray-400 mt-1.5">Recommended: 50-60 characters. Appears as the clickable headline in Google search results.</p>
            </div>

            <!-- Meta Description -->
            <div>
                <div class="flex items-center justify-between mb-2">
                    <label class="block text-sm font-semibold text-gray-800">
                        Meta Description
                        <span class="text-xs text-gray-400 font-normal ml-1">(Optional - falls back to blog content excerpt)</span>
                    </label>
                    <span id="metaDescCount" class="text-xs font-mono font-medium text-gray-400">0 / 160 chars</span>
                </div>
                <textarea name="meta_description" id="inputMetaDesc" rows="3"
                          placeholder="e.g. Explore our curated guide to top dining spots in Hounslow. Discover mouthwatering curries, fresh biryanis, opening times, and order directly on HYST."
                          class="w-full border border-gray-200 rounded-xl p-4 bg-white focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none text-sm transition">{{ old('meta_description', $blog?->meta_description ?? '') }}</textarea>
                <p class="text-xs text-gray-400 mt-1.5">Recommended: 150-160 characters. Provides a summary under the title link in search engine results.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Meta Keywords -->
                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-2">
                        Meta Keywords <span class="text-xs text-gray-400 font-normal">(Optional)</span>
                    </label>
                    <input type="text" name="meta_keywords" id="inputMetaKeywords"
                           value="{{ old('meta_keywords', $blog?->meta_keywords ?? '') }}"
                           placeholder="e.g. hounslow food, indian takeaway, biryani, halal food"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-white focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none text-sm transition">
                    <p class="text-xs text-gray-400 mt-1.5">Comma-separated keywords relating directly to this article.</p>
                </div>

                <!-- Canonical URL -->
                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-2">
                        Canonical URL
                        <span class="text-xs text-gray-400 font-normal ml-1">(Optional - auto-defaults to post URL)</span>
                    </label>
                    <input type="url" name="canonical_url" id="inputCanonical"
                       value="{{ old('canonical_url', $blog?->canonical_url ?? '') }}"
                       placeholder="{{ $defaultCanonical }}"
                       class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-white focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none text-sm transition">
                    <p class="text-xs text-gray-400 mt-1.5">Specifies the preferred URL version to prevent duplicate content issues across web crawlers.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- TAB 2: Open Graph / Social Sharing -->
    <div id="tab-seo-og" class="seo-tab-panel hidden space-y-6">
        <div class="bg-gray-50/70 p-6 rounded-2xl border border-gray-100 space-y-6">
            <div class="p-4 bg-blue-50 border border-blue-200 rounded-xl text-blue-800 text-xs leading-relaxed">
                ℹ️ <strong>Open Graph</strong> tags ensure rich visual previews when your blog is shared on WhatsApp, Facebook, LinkedIn, iMessage, and Twitter/X.
            </div>

            <!-- OG Title -->
            <div>
                <label class="block text-sm font-semibold text-gray-800 mb-2">
                    Open Graph Title
                    <span class="text-xs text-gray-400 font-normal ml-1">(Defaults to SEO Meta Title or Blog Title)</span>
                </label>
                <input type="text" name="og_title" id="inputOgTitle"
                       value="{{ old('og_title', $blog?->og_title ?? '') }}"
                       placeholder="e.g. 10 Best Food Spots in Hounslow You Must Try"
                       class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-white focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none text-sm transition">
            </div>

            <!-- OG Description -->
            <div>
                <label class="block text-sm font-semibold text-gray-800 mb-2">
                    Open Graph Description
                    <span class="text-xs text-gray-400 font-normal ml-1">(Defaults to Meta Description)</span>
                </label>
                <textarea name="og_description" id="inputOgDesc" rows="3"
                          placeholder="Short engaging hook for social media feeds..."
                          class="w-full border border-gray-200 rounded-xl p-4 bg-white focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none text-sm transition">{{ old('og_description', $blog?->og_description ?? '') }}</textarea>
            </div>

            <!-- OG Image -->
            <div>
                <label class="block text-sm font-semibold text-gray-800 mb-2">
                    Open Graph Image (1200 x 630 px recommended)
                    <span class="text-xs text-gray-400 font-normal ml-1">(Defaults to Featured Image)</span>
                </label>

                @if(!empty($blog?->og_image))
                    <div class="mb-3 flex items-center gap-4 bg-white p-3 rounded-xl border border-gray-200">
                        <img src="{{ Str::startsWith($blog->og_image, ['http://', 'https://']) ? $blog->og_image : asset($blog->og_image) }}"
                             alt="OG Image" class="w-20 h-14 object-cover rounded-lg border border-gray-200">
                        <div class="text-xs text-gray-600">
                            <span class="font-semibold block text-gray-800">Current Custom OG Image</span>
                            <span class="text-gray-400 truncate block max-w-xs">{{ $blog->og_image }}</span>
                        </div>
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Upload OG Image File</label>
                        <input type="file" name="og_image_file" id="inputOgFile" accept="image/*"
                               class="w-full border border-gray-200 rounded-xl p-2.5 bg-white focus:ring-2 focus:ring-orange-500 outline-none text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">OR Provide External OG Image URL</label>
                        <input type="url" name="og_image_url" id="inputOgUrl"
                               value="{{ old('og_image_url', (!empty($blog?->og_image) && Str::startsWith($blog->og_image, ['http://', 'https://'])) ? $blog->og_image : '') }}"
                               placeholder="https://images.unsplash.com/..."
                               class="w-full border border-gray-200 rounded-xl px-4 py-2.5 bg-white focus:ring-2 focus:ring-orange-500 outline-none text-sm">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- TAB 3: JSON-LD Schema (BlogPosting) -->
    <div id="tab-seo-schema" class="seo-tab-panel hidden space-y-6">
        <div class="bg-gray-50/70 p-6 rounded-2xl border border-gray-100 space-y-6">
            <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-xl text-emerald-800 text-xs leading-relaxed flex items-start gap-3">
                <span class="text-base">💎</span>
                <div>
                    <strong>Schema.org BlogPosting Structured Data:</strong> This metadata is injected into the HTML <code>&lt;head&gt;</code> using <code>&lt;script type="application/ld+json"&gt;</code>. It powers Google Rich Results, Top Stories, knowledge panels, and helps search engines accurately index authors, dates, and media.
                </div>
            </div>

            <!-- Headline & Description -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-2">
                        Schema Headline
                        <span class="text-xs text-gray-400 font-normal ml-1">(Defaults to Blog Title)</span>
                    </label>
                    <input type="text" name="schema_headline" id="inputSchemaHeadline"
                           value="{{ old('schema_headline', $blog?->schema_headline ?? '') }}"
                           placeholder="Defaults to Blog Title"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-white focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none text-sm transition">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-2">
                        Schema Description
                        <span class="text-xs text-gray-400 font-normal ml-1">(Defaults to Meta Description)</span>
                    </label>
                    <input type="text" name="schema_description" id="inputSchemaDesc"
                           value="{{ old('schema_description', $blog?->schema_description ?? '') }}"
                           placeholder="Defaults to Meta Description"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-white focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none text-sm transition">
                </div>
            </div>

            <!-- Author & Publisher -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-2">
                        Author Name
                        <span class="text-xs text-gray-400 font-normal ml-1">(Default: "HYST")</span>
                    </label>
                    <input type="text" name="schema_author" id="inputSchemaAuthor"
                           value="{{ old('schema_author', $blog?->schema_author ?? 'HYST') }}"
                           placeholder="HYST or Author Name"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-white focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none text-sm transition">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-2">
                        Publisher Name
                        <span class="text-xs text-gray-400 font-normal ml-1">(Default: "HYST")</span>
                    </label>
                    <input type="text" name="schema_publisher" id="inputSchemaPublisher"
                           value="{{ old('schema_publisher', $blog?->schema_publisher ?? 'HYST') }}"
                           placeholder="HYST"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-white focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none text-sm transition">
                </div>
            </div>

            <!-- Published & Modified Dates -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-2">
                        Date Published
                        <span class="text-xs text-gray-400 font-normal ml-1">(Leave empty for auto creation date)</span>
                    </label>
                    <input type="datetime-local" name="schema_date_published" id="inputSchemaPublished"
                           value="{{ old('schema_date_published', (!empty($blog?->schema_date_published)) ? $blog->schema_date_published->format('Y-m-d\TH:i') : '') }}"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-white focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none text-sm transition">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-2">
                        Date Modified
                        <span class="text-xs text-gray-400 font-normal ml-1">(Leave empty for auto update date)</span>
                    </label>
                    <input type="datetime-local" name="schema_date_modified" id="inputSchemaModified"
                           value="{{ old('schema_date_modified', (!empty($blog?->schema_date_modified)) ? $blog->schema_date_modified->format('Y-m-d\TH:i') : '') }}"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-white focus:ring-2 focus:ring-orange-500 focus:border-orange-500 outline-none text-sm transition">
                </div>
            </div>

            <!-- Schema Image Override -->
            <div>
                <label class="block text-sm font-semibold text-gray-800 mb-2">
                    Schema Article Image
                    <span class="text-xs text-gray-400 font-normal ml-1">(Optional - falls back to OG Image or Featured Image)</span>
                </label>

                @if(!empty($blog?->schema_image))
                    <div class="mb-3 flex items-center gap-4 bg-white p-3 rounded-xl border border-gray-200">
                        <img src="{{ Str::startsWith($blog->schema_image, ['http://', 'https://']) ? $blog->schema_image : asset($blog->schema_image) }}"
                             alt="Schema Image" class="w-20 h-14 object-cover rounded-lg border border-gray-200">
                        <div class="text-xs text-gray-600">
                            <span class="font-semibold block text-gray-800">Current Custom Schema Image</span>
                            <span class="text-gray-400 truncate block max-w-xs">{{ $blog->schema_image }}</span>
                        </div>
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <input type="file" name="schema_image_file" accept="image/*"
                               class="w-full border border-gray-200 rounded-xl p-2.5 bg-white focus:ring-2 focus:ring-orange-500 outline-none text-sm">
                    </div>
                    <div>
                        <input type="url" name="schema_image_url"
                               value="{{ old('schema_image_url', (!empty($blog?->schema_image) && Str::startsWith($blog->schema_image, ['http://', 'https://'])) ? $blog->schema_image : '') }}"
                               placeholder="https://..."
                               class="w-full border border-gray-200 rounded-xl px-4 py-2.5 bg-white focus:ring-2 focus:ring-orange-500 outline-none text-sm">
                    </div>
                </div>
            </div>

            <!-- Advanced Custom JSON-LD Override -->
            <div class="pt-4 border-t border-gray-200">
                <button type="button" onclick="document.getElementById('customJsonWrapper').classList.toggle('hidden')"
                        class="text-xs font-semibold text-gray-600 hover:text-orange-600 flex items-center gap-1.5 focus:outline-none">
                    <span>⚙️</span> Advanced: Custom JSON-LD Schema Override (Optional) &darr;
                </button>
                <div id="customJsonWrapper" class="{{ old('schema_custom_json', $blog?->schema_custom_json ?? '') ? '' : 'hidden' }} mt-3 space-y-2">
                    <p class="text-xs text-gray-400">If you provide valid JSON here, it will replace the auto-generated BlogPosting JSON-LD schema.</p>
                    <textarea name="schema_custom_json" id="inputCustomJson" rows="6"
                              placeholder='{ "@context": "https://schema.org", "@type": "BlogPosting", ... }'
                              class="w-full font-mono text-xs border border-gray-200 rounded-xl p-4 bg-gray-900 text-emerald-400 focus:ring-2 focus:ring-orange-500 outline-none transition">{{ old('schema_custom_json', $blog?->schema_custom_json ?? '') }}</textarea>
                    <button type="button" id="btnValidateCustomJson" class="text-xs font-medium text-orange-600 hover:underline">
                        Format & Validate Custom JSON
                    </button>
                    <span id="customJsonMsg" class="text-xs font-semibold ml-2"></span>
                </div>
            </div>
        </div>
    </div>

    <!-- TAB 4: Live Previews & Validation -->
    <div id="tab-seo-preview" class="seo-tab-panel hidden space-y-8">
        <!-- Google SERP Preview Card -->
        <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-bold text-gray-800 flex items-center gap-2">
                    <svg class="w-4 h-4 text-blue-600" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/></svg>
                    Google Search Result (SERP) Preview
                </h3>
                <span class="text-xs px-2.5 py-0.5 rounded-full bg-blue-50 text-blue-700 font-semibold">Desktop & Mobile</span>
            </div>

            <!-- Simulated Google Snippet -->
            <div class="max-w-2xl bg-white p-5 rounded-xl border border-gray-100 shadow-inner space-y-1 font-sans">
                <!-- Favicon & URL Breadcrumb -->
                <div class="flex items-center gap-2 text-xs text-gray-700">
                    <div class="w-4 h-4 rounded-full bg-orange-600 flex items-center justify-center text-white text-[9px] font-bold">H</div>
                    <div class="truncate">
                        <span class="text-gray-900 font-medium">HYST</span>
                        <span class="text-gray-400 mx-1">›</span>
                        <span id="previewBreadcrumb" class="text-gray-500 font-mono text-[11px]">{{ $defaultCanonical }}</span>
                    </div>
                </div>

                <!-- Clickable Title -->
                <h4 id="previewTitle" class="text-lg text-blue-800 hover:underline cursor-pointer font-medium leading-snug line-clamp-1 pt-0.5">
                    {{ old('meta_title', $defaultMetaTitle) }}
                </h4>

                <!-- Snippet Description -->
                <p id="previewDescription" class="text-xs text-gray-600 leading-relaxed line-clamp-2 pt-0.5">
                    {{ old('meta_description', $defaultMetaDesc) }}
                </p>
            </div>
        </div>

        <!-- Social Media Sharing Card Preview -->
        <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-bold text-gray-800 flex items-center gap-2">
                    <span>📱</span> Social Media Sharing Card Preview (Facebook / LinkedIn / X)
                </h3>
                <span class="text-xs px-2.5 py-0.5 rounded-full bg-purple-50 text-purple-700 font-semibold">Open Graph</span>
            </div>

            <!-- Simulated Social Card -->
            <div class="max-w-md bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-sm">
                <div class="h-44 bg-gray-100 relative overflow-hidden flex items-center justify-center">
                    <img id="previewOgImg" src="{{ $defaultOgImage }}" alt="Social Preview" class="w-full h-full object-cover">
                    <div class="absolute bottom-2 left-2 px-2 py-0.5 bg-black/70 text-white text-[10px] font-mono rounded backdrop-blur">
                        1200 × 630
                    </div>
                </div>
                <div class="p-4 bg-gray-50/90 space-y-1 border-t border-gray-100">
                    <span class="text-[11px] font-bold text-gray-400 uppercase tracking-wider block">HYST.UK</span>
                    <h5 id="previewOgTitle" class="text-sm font-bold text-gray-900 line-clamp-1">
                        {{ old('og_title', $blog?->og_title ?? $defaultMetaTitle) }}
                    </h5>
                    <p id="previewOgDesc" class="text-xs text-gray-500 line-clamp-2 leading-relaxed">
                        {{ old('og_description', $blog?->og_description ?? $defaultMetaDesc) }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Real-Time JSON-LD Schema Inspector & Validator -->
        <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
                <div>
                    <h3 class="text-sm font-bold text-gray-800 flex items-center gap-2">
                        <span>📄</span> Real-Time JSON-LD Schema Inspector
                    </h3>
                    <p class="text-xs text-gray-500">Live output generated from your inputs to be placed in <code>&lt;head&gt;</code>.</p>
                </div>
                <button type="button" id="btnRunValidator" class="inline-flex items-center gap-1.5 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl shadow-sm transition">
                    <span>✓</span> Validate Schema Now
                </button>
            </div>

            <div id="validatorAlert" class="hidden mb-4 p-3 rounded-xl text-xs font-medium border"></div>

            <pre id="schemaJsonLive" class="bg-gray-950 text-emerald-400 p-4 rounded-xl text-xs font-mono overflow-x-auto max-h-80 border border-gray-800"></pre>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // 1. Tab switching
    const tabs = document.querySelectorAll('.seo-tab');
    const panels = document.querySelectorAll('.seo-tab-panel');

    tabs.forEach(tab => {
        tab.addEventListener('click', function () {
            tabs.forEach(t => {
                t.classList.remove('active', 'border-orange-600', 'text-orange-600');
                t.classList.add('border-transparent', 'text-gray-500');
            });
            panels.forEach(p => p.classList.add('hidden'));

            this.classList.add('active', 'border-orange-600', 'text-orange-600');
            this.classList.remove('border-transparent', 'text-gray-500');

            const targetId = this.getAttribute('data-target');
            const targetPanel = document.getElementById(targetId);
            if (targetPanel) {
                targetPanel.classList.remove('hidden');
            }

            if (targetId === 'tab-seo-preview') {
                updateAllPreviews();
            }
        });
    });

    // 2. Character counters
    const inputMetaTitle = document.getElementById('inputMetaTitle');
    const inputMetaDesc = document.getElementById('inputMetaDesc');
    const metaTitleCount = document.getElementById('metaTitleCount');
    const metaDescCount = document.getElementById('metaDescCount');

    function updateCounts() {
        if (inputMetaTitle && metaTitleCount) {
            const len = inputMetaTitle.value.length;
            metaTitleCount.textContent = len + ' / 60 chars';
            metaTitleCount.className = len > 60 ? 'text-xs font-mono font-medium text-amber-600 font-bold' : 'text-xs font-mono font-medium text-gray-400';
        }
        if (inputMetaDesc && metaDescCount) {
            const len = inputMetaDesc.value.length;
            metaDescCount.textContent = len + ' / 160 chars';
            metaDescCount.className = len > 160 ? 'text-xs font-mono font-medium text-amber-600 font-bold' : 'text-xs font-mono font-medium text-gray-400';
        }
    }

    if (inputMetaTitle) inputMetaTitle.addEventListener('input', function() { updateCounts(); updateAllPreviews(); });
    if (inputMetaDesc) inputMetaDesc.addEventListener('input', function() { updateCounts(); updateAllPreviews(); });
    updateCounts();

    // 3. Real-time Previews
    const inputMainTitle = document.querySelector('input[name="title"]');
    const inputMainSlug = document.querySelector('input[name="slug"]');
    const inputCanonical = document.getElementById('inputCanonical');
    const inputOgTitle = document.getElementById('inputOgTitle');
    const inputOgDesc = document.getElementById('inputOgDesc');
    const inputOgUrl = document.getElementById('inputOgUrl');
    const inputSchemaHeadline = document.getElementById('inputSchemaHeadline');
    const inputSchemaDesc = document.getElementById('inputSchemaDesc');
    const inputSchemaAuthor = document.getElementById('inputSchemaAuthor');
    const inputSchemaPublisher = document.getElementById('inputSchemaPublisher');
    const inputSchemaPublished = document.getElementById('inputSchemaPublished');
    const inputSchemaModified = document.getElementById('inputSchemaModified');
    const inputCustomJson = document.getElementById('inputCustomJson');

    const previewTitle = document.getElementById('previewTitle');
    const previewBreadcrumb = document.getElementById('previewBreadcrumb');
    const previewDescription = document.getElementById('previewDescription');
    const previewOgTitle = document.getElementById('previewOgTitle');
    const previewOgDesc = document.getElementById('previewOgDesc');
    const previewOgImg = document.getElementById('previewOgImg');
    const schemaJsonLive = document.getElementById('schemaJsonLive');

    const baseUrl = "{{ $defaultBaseUrl }}";
    const defaultImage = "{{ $defaultOgImage }}";

    function updateAllPreviews() {
        const blogTitle = (inputMainTitle ? inputMainTitle.value.trim() : '') || 'Your Blog Post Title';
        const rawSlug = inputMainSlug ? inputMainSlug.value.trim() : '';
        const effectiveSlug = rawSlug ? rawSlug.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)+/g, '') : 'your-blog-slug';

        const metaTitleVal = (inputMetaTitle && inputMetaTitle.value.trim()) ? inputMetaTitle.value.trim() : (blogTitle + ' | HYST Blog');
        const metaDescVal = (inputMetaDesc && inputMetaDesc.value.trim()) ? inputMetaDesc.value.trim() : 'Explore top restaurant recommendations, food guides & local dining news in Hounslow on HYST.';
        const canonicalVal = (inputCanonical && inputCanonical.value.trim()) ? inputCanonical.value.trim() : (baseUrl + '/blog/' + effectiveSlug);

        const ogTitleVal = (inputOgTitle && inputOgTitle.value.trim()) ? inputOgTitle.value.trim() : metaTitleVal;
        const ogDescVal = (inputOgDesc && inputOgDesc.value.trim()) ? inputOgDesc.value.trim() : metaDescVal;
        const ogImageVal = (inputOgUrl && inputOgUrl.value.trim()) ? inputOgUrl.value.trim() : defaultImage;

        if (previewTitle) previewTitle.textContent = metaTitleVal;
        if (previewBreadcrumb) previewBreadcrumb.textContent = canonicalVal;
        if (previewDescription) previewDescription.textContent = metaDescVal;

        if (previewOgTitle) previewOgTitle.textContent = ogTitleVal;
        if (previewOgDesc) previewOgDesc.textContent = ogDescVal;
        if (previewOgImg) previewOgImg.src = ogImageVal;

        // Build live JSON-LD
        let schemaObj;
        if (inputCustomJson && inputCustomJson.value.trim()) {
            try {
                schemaObj = JSON.parse(inputCustomJson.value.trim());
            } catch(e) {
                schemaObj = { error: 'Invalid Custom JSON syntax: ' + e.message };
            }
        } else {
            const headline = (inputSchemaHeadline && inputSchemaHeadline.value.trim()) ? inputSchemaHeadline.value.trim() : blogTitle;
            const description = (inputSchemaDesc && inputSchemaDesc.value.trim()) ? inputSchemaDesc.value.trim() : metaDescVal;
            const author = (inputSchemaAuthor && inputSchemaAuthor.value.trim()) ? inputSchemaAuthor.value.trim() : 'HYST';
            const publisher = (inputSchemaPublisher && inputSchemaPublisher.value.trim()) ? inputSchemaPublisher.value.trim() : 'HYST';
            const datePub = (inputSchemaPublished && inputSchemaPublished.value) ? new Date(inputSchemaPublished.value).toISOString() : new Date().toISOString();
            const dateMod = (inputSchemaModified && inputSchemaModified.value) ? new Date(inputSchemaModified.value).toISOString() : datePub;

            schemaObj = {
                "@context": "https://schema.org",
                "@type": "BlogPosting",
                "mainEntityOfPage": {
                    "@type": "WebPage",
                    "@id": canonicalVal
                },
                "headline": headline,
                "description": description,
                "image": ogImageVal,
                "url": canonicalVal,
                "datePublished": datePub,
                "dateModified": dateMod,
                "author": {
                    "@type": "Organization",
                    "name": author
                },
                "publisher": {
                    "@type": "Organization",
                    "name": publisher,
                    "logo": {
                        "@type": "ImageObject",
                        "url": baseUrl + "/twitter.jpeg"
                    }
                }
            };
        }

        if (schemaJsonLive) {
            schemaJsonLive.textContent = JSON.stringify(schemaObj, null, 2);
        }
    }

    // Attach listeners
    [inputMainTitle, inputMainSlug, inputCanonical, inputOgTitle, inputOgDesc, inputOgUrl, inputSchemaHeadline, inputSchemaDesc, inputSchemaAuthor, inputSchemaPublisher, inputSchemaPublished, inputSchemaModified].forEach(el => {
        if (el) el.addEventListener('input', updateAllPreviews);
    });

    // Custom JSON Formatter & Validator button
    const btnValidateCustomJson = document.getElementById('btnValidateCustomJson');
    const customJsonMsg = document.getElementById('customJsonMsg');
    if (btnValidateCustomJson && inputCustomJson) {
        btnValidateCustomJson.addEventListener('click', function () {
            try {
                const parsed = JSON.parse(inputCustomJson.value.trim());
                inputCustomJson.value = JSON.stringify(parsed, null, 2);
                customJsonMsg.textContent = '✓ Valid JSON formatted!';
                customJsonMsg.className = 'text-xs font-semibold ml-2 text-emerald-600';
                updateAllPreviews();
            } catch (err) {
                customJsonMsg.textContent = '✕ Syntax Error: ' + err.message;
                customJsonMsg.className = 'text-xs font-semibold ml-2 text-red-600';
            }
        });
    }

    // Schema Validation Button
    const btnRunValidator = document.getElementById('btnRunValidator');
    const validatorAlert = document.getElementById('validatorAlert');
    if (btnRunValidator && validatorAlert) {
        btnRunValidator.addEventListener('click', function () {
            updateAllPreviews();
            try {
                const schema = JSON.parse(schemaJsonLive.textContent);
                const errors = [];

                if (schema['@context'] !== 'https://schema.org') errors.push('@context must be "https://schema.org"');
                if (schema['@type'] !== 'BlogPosting') errors.push('@type must be "BlogPosting"');
                if (!schema.headline) errors.push('Missing "headline" property');
                if (!schema.description) errors.push('Missing "description" property');
                if (!schema.image) errors.push('Missing "image" property');
                if (!schema.author || !schema.author.name) errors.push('Missing "author" or "author.name"');
                if (!schema.publisher || !schema.publisher.name) errors.push('Missing "publisher" or "publisher.name"');
                if (!schema.datePublished) errors.push('Missing "datePublished"');
                if (!schema.dateModified) errors.push('Missing "dateModified"');

                validatorAlert.classList.remove('hidden');
                if (errors.length === 0) {
                    validatorAlert.className = 'mb-4 p-4 rounded-xl text-xs font-medium border bg-emerald-50 border-emerald-200 text-emerald-800';
                    validatorAlert.innerHTML = '<strong>✓ Validation Passed!</strong> All required BlogPosting Schema fields are complete and valid: <code>headline</code>, <code>description</code>, <code>image</code>, <code>author</code>, <code>publisher</code>, <code>datePublished</code>, and <code>dateModified</code>.';
                } else {
                    validatorAlert.className = 'mb-4 p-4 rounded-xl text-xs font-medium border bg-red-50 border-red-200 text-red-800';
                    validatorAlert.innerHTML = '<strong>✕ Validation Issues Found:</strong><ul class="list-disc list-inside mt-1">' + errors.map(e => '<li>' + e + '</li>').join('') + '</ul>';
                }
            } catch (err) {
                validatorAlert.classList.remove('hidden');
                validatorAlert.className = 'mb-4 p-4 rounded-xl text-xs font-medium border bg-red-50 border-red-200 text-red-800';
                validatorAlert.textContent = 'Invalid Schema JSON: ' + err.message;
            }
        });
    }

    // Initial run
    updateAllPreviews();
});
</script>

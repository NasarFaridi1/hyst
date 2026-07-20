@extends('front.layouts.app')
@section('content')

    {{-- ══════════════════════════════════════
         PAGE HERO
    ══════════════════════════════════════ --}}
    <section style="position:relative; background:#0D0D0D; color:#fff; padding:72px 0 56px; overflow:hidden;">
        {{-- subtle grid texture --}}
        <div style="position:absolute;inset:0;background-image:radial-gradient(rgba(194,90,42,0.08) 1px,transparent 1px);background-size:32px 32px;pointer-events:none;"></div>
        <div style="position:absolute;right:0;top:0;width:480px;height:100%;background:linear-gradient(135deg,transparent 50%,rgba(194,90,42,0.06) 100%);pointer-events:none;"></div>

        <div style="max-width:1280px;margin:0 auto;padding:0 24px;position:relative;">
            <div style="display:inline-flex;align-items:center;gap:8px;background:rgba(232,55,14,0.18);border:1px solid rgba(232,55,14,0.4);padding:7px 16px;border-radius:999px;margin-bottom:20px;">
                <i data-lucide="megaphone" style="width:14px;height:14px;color:#C25A2A;flex-shrink:0;"></i>
                <span style="font-size:12px;font-weight:600;color:#C25A2A;font-family:'Poppins',sans-serif;letter-spacing:.04em;">Promotions &amp; Offers</span>
            </div>
            <h1 style="font-family:'Poppins',sans-serif;font-size:46px;font-weight:800;line-height:1.15;margin:0 0 14px;letter-spacing:-.5px;">
                Marketing <span style="color:#C25A2A;">Banners</span>
            </h1>
            <p style="font-size:16px;color:#D1D5DB;line-height:1.8;margin:0;max-width:480px;">
                Explore our latest deals, seasonal offers, and exclusive promotions curated just for you.
            </p>

            {{-- category filter pills --}}
            @if($categories->count())
            <div style="display:flex;flex-wrap:wrap;gap:10px;margin-top:32px;">
                <a href="{{ route('front.banners.index') }}"
                   style="padding:8px 20px;border-radius:999px;font-size:13px;font-family:'Poppins',sans-serif;font-weight:600;text-decoration:none;transition:all .18s;
                          {{ !request('category') ? 'background:#C25A2A;color:#fff;border:2px solid #C25A2A;' : 'background:transparent;color:#D1D5DB;border:2px solid rgba(255,255,255,0.2);' }}">
                    All
                </a>
                @foreach($categories as $cat)
                <a href="{{ route('front.banners.index', ['category' => $cat->id]) }}"
                   style="padding:8px 20px;border-radius:999px;font-size:13px;font-family:'Poppins',sans-serif;font-weight:600;text-decoration:none;transition:all .18s;
                          {{ request('category') == $cat->id ? 'background:#C25A2A;color:#fff;border:2px solid #C25A2A;' : 'background:transparent;color:#D1D5DB;border:2px solid rgba(255,255,255,0.2);' }}"
                   onmouseover="if(this.style.background!='rgb(194, 90, 42)')this.style.borderColor='rgba(255,255,255,0.5)'"
                   onmouseout="if(this.style.background!='rgb(194, 90, 42)')this.style.borderColor='rgba(255,255,255,0.2)'">
                    {{ $cat->name }}
                </a>
                @endforeach
            </div>
            @endif
        </div>
    </section>

    
   

    {{-- ══════════════════════════════════════
         BANNERS GRID
    ══════════════════════════════════════ --}}
    <section style="background:rgba(245,240,232,0.95);padding:64px 0;">
        <div style="max-width:1280px;margin:0 auto;padding:0 24px;">

            {{-- section header --}}
            <div style="display:flex;justify-content:space-between;align-items:flex-end;margin-bottom:36px;flex-wrap:wrap;gap:12px;">
                <div>
                    <p style="color:#C25A2A;font-family:'Poppins',sans-serif;font-weight:700;font-size:12px;letter-spacing:.1em;text-transform:uppercase;margin:0 0 6px;">All Promotions</p>
                    <h2 style="font-family:'Poppins',sans-serif;font-size:32px;font-weight:800;margin:0;letter-spacing:-.4px;color:#0D0D0D;">
                        Current Offers
                        <span style="font-size:16px;font-weight:600;color:#9CA3AF;margin-left:10px;">{{ $banners->total() }} banners</span>
                    </h2>
                </div>
            </div>

            @if($banners->count())
            <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:24px;" class="banners-grid">
                @foreach($banners as $banner)
                <div style="background:#fff;border-radius:20px;overflow:hidden;box-shadow:0 2px 16px rgba(0,0,0,.07);border:1px solid #F0F0EC;transition:all .22s;"
                     onmouseover="this.style.transform='translateY(-5px)';this.style.boxShadow='0 20px 48px rgba(0,0,0,.13)';this.style.borderColor='#C25A2A';"
                     onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 2px 16px rgba(0,0,0,.07)';this.style.borderColor='#F0F0EC';">

                    {{-- image area --}}
                    <div style="position:relative;overflow:hidden;height:210px;background:#0D0D0D;">
                        @if($banner->banner_image)
                            <img src="{{ asset($banner->banner_image) }}"
                                 style="width:100%;height:100%;object-fit:cover;transition:transform .5s;display:block;"
                                 onmouseover="this.style.transform='scale(1.06)'"
                                 onmouseout="this.style.transform='scale(1)'">
                        @else
                            <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;background:linear-gradient(135deg,#1a1a1a,#2d2d2d);">
                                <i data-lucide="image" style="width:44px;height:44px;color:#444;"></i>
                            </div>
                        @endif

                        {{-- category badge --}}
                        @if($banner->category)
                        <div style="position:absolute;top:14px;left:14px;background:rgba(13,13,13,0.85);backdrop-filter:blur(6px);padding:5px 12px;border-radius:999px;border:1px solid rgba(255,255,255,0.12);">
                            <span style="font-size:11px;font-weight:600;color:#fff;font-family:'Poppins',sans-serif;">
                                {{ $banner->category->name }}
                            </span>
                        </div>
                        @endif

                        {{-- active indicator --}}
                        <div style="position:absolute;top:14px;right:14px;width:10px;height:10px;border-radius:50%;
                                    background:{{ $banner->status ? '#22C55E' : '#9CA3AF' }};
                                    box-shadow:{{ $banner->status ? '0 0 0 3px rgba(34,197,94,0.3)' : 'none' }};"></div>
                    </div>

                    {{-- content --}}
                    <div style="padding:22px 20px 20px;">
                        @if($banner->subtitle)
                        <p style="font-size:11px;font-weight:700;color:#C25A2A;font-family:'Poppins',sans-serif;letter-spacing:.08em;text-transform:uppercase;margin:0 0 6px;">
                            {{ $banner->subtitle }}
                        </p>
                        @endif

                        <h3 style="font-family:'Poppins',sans-serif;font-weight:700;font-size:17px;margin:0 0 10px;line-height:1.35;color:#0D0D0D;">
                            {{ $banner->title }}
                        </h3>

                        @if($banner->description)
                        <p style="color:#6B7280;font-size:13px;line-height:1.7;margin:0 0 18px;">
                            {{ Str::limit($banner->description, 100) }}
                        </p>
                        @endif

                        <div style="display:flex;align-items:center;justify-content:space-between;padding-top:14px;border-top:1px solid #F0F0EC;">
                            <a href="{{ route('front.banners.show',$banner->id) }}"
                               style="display:inline-flex;align-items:center;gap:6px;padding:9px 18px;background:#0D0D0D;color:#fff;border-radius:10px;font-family:'Poppins',sans-serif;font-size:13px;font-weight:600;text-decoration:none;transition:background .18s;"
                               onmouseover="this.style.background='#C25A2A'" onmouseout="this.style.background='#0D0D0D'">
                                <i data-lucide="arrow-right" style="width:14px;height:14px;"></i> View Details
                            </a>
                            <span style="font-size:11px;color:#9CA3AF;">{{ $banner->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- pagination --}}
            @if($banners->hasPages())
            <div style="margin-top:48px;display:flex;justify-content:center;gap:8px;flex-wrap:wrap;">
                {{-- prev --}}
                @if($banners->onFirstPage())
                    <span style="padding:10px 18px;border-radius:10px;border:1px solid #E5E7EB;color:#9CA3AF;font-size:13px;font-family:'Poppins',sans-serif;cursor:default;">
                        ← Prev
                    </span>
                @else
                    <a href="{{ $banners->previousPageUrl() }}"
                       style="padding:10px 18px;border-radius:10px;border:1px solid #E5E7EB;color:#374151;font-size:13px;font-family:'Poppins',sans-serif;text-decoration:none;transition:all .15s;"
                       onmouseover="this.style.borderColor='#C25A2A';this.style.color='#C25A2A'"
                       onmouseout="this.style.borderColor='#E5E7EB';this.style.color='#374151'">
                        ← Prev
                    </a>
                @endif

                @foreach($banners->getUrlRange(1, $banners->lastPage()) as $page => $url)
                    @if($page == $banners->currentPage())
                        <span style="padding:10px 16px;border-radius:10px;background:#C25A2A;color:#fff;font-size:13px;font-family:'Poppins',sans-serif;font-weight:700;">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}"
                           style="padding:10px 16px;border-radius:10px;border:1px solid #E5E7EB;color:#374151;font-size:13px;font-family:'Poppins',sans-serif;text-decoration:none;transition:all .15s;"
                           onmouseover="this.style.borderColor='#C25A2A';this.style.color='#C25A2A'"
                           onmouseout="this.style.borderColor='#E5E7EB';this.style.color='#374151'">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach

                {{-- next --}}
                @if($banners->hasMorePages())
                    <a href="{{ $banners->nextPageUrl() }}"
                       style="padding:10px 18px;border-radius:10px;border:1px solid #E5E7EB;color:#374151;font-size:13px;font-family:'Poppins',sans-serif;text-decoration:none;transition:all .15s;"
                       onmouseover="this.style.borderColor='#C25A2A';this.style.color='#C25A2A'"
                       onmouseout="this.style.borderColor='#E5E7EB';this.style.color='#374151'">
                        Next →
                    </a>
                @else
                    <span style="padding:10px 18px;border-radius:10px;border:1px solid #E5E7EB;color:#9CA3AF;font-size:13px;font-family:'Poppins',sans-serif;cursor:default;">
                        Next →
                    </span>
                @endif
            </div>
            @endif

            @else
            {{-- empty state --}}
            <div style="text-align:center;padding:80px 24px;">
                <div style="width:80px;height:80px;background:#F3F4F6;border-radius:20px;display:flex;align-items:center;justify-content:center;margin:0 auto 20px;">
                    <i data-lucide="megaphone" style="width:36px;height:36px;color:#9CA3AF;"></i>
                </div>
                <h3 style="font-family:'Poppins',sans-serif;font-size:20px;font-weight:700;color:#0D0D0D;margin:0 0 8px;">No Banners Found</h3>
                <p style="color:#6B7280;font-size:14px;margin:0 0 24px;">There are no active promotions in this category right now.</p>
                <a href="{{ route('front.banners.index') }}"
                   style="display:inline-flex;align-items:center;gap:8px;padding:12px 24px;background:#C25A2A;color:#fff;border-radius:12px;font-family:'Poppins',sans-serif;font-size:14px;font-weight:600;text-decoration:none;">
                    <i data-lucide="arrow-left" style="width:15px;height:15px;"></i> View All Offers
                </a>
            </div>
            @endif
        </div>
    </section>

    {{-- ══════════════════════════════════════
         CTA STRIP  (reuses offer-section style)
    ══════════════════════════════════════ --}}
    <section style="background:#0D0D0D;padding:64px 0;color:#fff;">
        <div style="max-width:1280px;margin:0 auto;padding:0 24px;text-align:center;">
            <p style="color:#C25A2A;font-family:'Poppins',sans-serif;font-weight:700;font-size:12px;letter-spacing:.1em;text-transform:uppercase;margin:0 0 12px;">Don't Miss Out</p>
            <h2 style="font-family:'Poppins',sans-serif;font-size:38px;font-weight:800;line-height:1.2;margin:0 0 16px;letter-spacing:-.4px;">
                Ready to <span style="color:#C25A2A;">Order?</span>
            </h2>
            <p style="color:#D1D5DB;font-size:15px;line-height:1.8;margin:0 auto 32px;max-width:420px;">
                Browse our restaurants and take advantage of these exclusive deals today.
            </p>
            <a href="/#restaurants"
               style="display:inline-flex;align-items:center;gap:9px;padding:15px 36px;background:#C25A2A;color:#fff;border-radius:12px;font-family:'Poppins',sans-serif;font-size:15px;font-weight:700;text-decoration:none;transition:background .18s;"
               onmouseover="this.style.background='#a8481f'" onmouseout="this.style.background='#C25A2A'">
                <i data-lucide="shopping-bag" style="width:18px;height:18px;"></i> Browse Restaurants
            </a>
        </div>
    </section>

    <style>
        @media(max-width:900px){
            .banners-grid{ grid-template-columns:repeat(2,1fr) !important; }
        }
        @media(max-width:600px){
            .banners-grid{ grid-template-columns:1fr !important; }
        }
    </style>

@endsection
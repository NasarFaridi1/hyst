@extends('front.layouts.app')

@section('title', 'Latest Blogs & Articles | HYST')
@section('meta_description', 'Explore our latest stories, restaurant updates, food guides, and articles on HYST.')

@section('content')
<div style="background:#F9F8F6; min-height:100vh; padding-bottom:80px;">
    <!-- HERO HEADER -->
    <div style="background: linear-gradient(135deg, #0D0D0D 0%, #1A1A1A 100%); color:#fff; padding:60px 20px; text-align:center; position:relative; overflow:hidden;">
        <div style="max-width:900px; margin:0 auto; position:relative; z-index:2;">
            <span style="display:inline-block; background:rgba(194, 90, 42, 0.2); color:#C25A2A; border:1px solid rgba(194, 90, 42, 0.4); padding:6px 18px; border-radius:99px; font-size:13px; font-weight:700; letter-spacing:1px; text-transform:uppercase; margin-bottom:16px;">
                HYST News & Articles
            </span>
            <h1 style="font-family:'Syne', sans-serif; font-size:42px; font-weight:800; margin-bottom:16px; color:#ffffff; line-height:1.2;">
                Stories, News & Culinary Guides
            </h1>
            <p style="color:#9CA3AF; font-size:16px; max-width:640px; margin:0 auto 32px; line-height:1.7;">
                Stay informed with the latest updates from our restaurant partners, food culture, delivery insights, and exclusive content.
            </p>

            <!-- Search Form -->
            <form action="{{ route('front.blogs.index') }}" method="GET" style="max-width:540px; margin:0 auto; display:flex; gap:10px; background:#fff; padding:6px; border-radius:16px; box-shadow:0 10px 30px rgba(0,0,0,0.25);">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search articles, guides, or recipes..."
                       style="flex:1; border:none; outline:none; padding:12px 18px; font-size:14px; border-radius:12px; color:#111;">
                <button type="submit" style="background:#C25A2A; color:#fff; border:none; padding:12px 24px; border-radius:12px; font-weight:700; font-size:14px; cursor:pointer; transition:background .2s;"
                        onmouseover="this.style.background='#a64b20'" onmouseout="this.style.background='#C25A2A'">
                    Search
                </button>
            </form>
        </div>
    </div>

    <!-- MAIN CONTAINER -->
    <div style="max-width:1280px; margin:0 auto; padding:50px 20px 0;">
        @if(request()->filled('search'))
            <div style="margin-bottom:30px; display:flex; justify-content:space-between; align-items:center;">
                <h3 style="font-family:'Syne', sans-serif; font-size:20px; color:#111;">
                    Search results for: "<span style="color:#C25A2A;">{{ request('search') }}</span>"
                </h3>
                <a href="{{ route('front.blogs.index') }}" style="color:#C25A2A; font-weight:600; text-decoration:none; font-size:14px;">
                    Clear Search
                </a>
            </div>
        @endif

        @if($blogs->count() > 0)
            <!-- BLOG GRID -->
            <div style="display:grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap:30px;">
                @foreach($blogs as $blog)
                    <article style="background:#ffffff; border-radius:20px; overflow:hidden; border:1px solid #E8E6E0; box-shadow:0 4px 20px rgba(0,0,0,0.04); display:flex; flex-direction:column; transition:transform .2s, box-shadow .2s;"
                             onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 12px 30px rgba(0,0,0,0.08)';"
                             onmouseout="this.style.transform='none'; this.style.boxShadow='0 4px 20px rgba(0,0,0,0.04)';">
                        
                        <!-- MEDIA PREVIEW -->
                        <div style="position:relative; width:100%; height:220px; background:#000; overflow:hidden;">
                            @if($blog->image)
                                <img src="{{ asset($blog->image) }}" alt="{{ $blog->title }}"
                                     style="width:100%; height:100%; object-fit:cover;">
                            @else
                                <div style="width:100%; height:100%; background:linear-gradient(135deg, #1f2937, #111827); display:flex; align-items:center; justify-content:center; color:#9CA3AF;">
                                    <i data-lucide="newspaper" style="width:48px; height:48px; opacity:0.5;"></i>
                                </div>
                            @endif

                            @if($blog->video)
                                <div style="position:absolute; top:12px; right:12px; background:rgba(0,0,0,0.75); color:#fff; font-size:11px; font-weight:700; padding:4px 10px; border-radius:30px; display:flex; align-items:center; gap:5px; backdrop-filter:blur(4px);">
                                    <span>🎬 Video</span>
                                </div>
                            @endif

                            <div style="position:absolute; bottom:12px; left:12px; background:rgba(255,255,255,0.9); color:#111; font-size:11px; font-weight:700; padding:4px 10px; border-radius:8px;">
                                {{ $blog->created_at ? $blog->created_at->format('M d, Y') : 'Recent' }}
                            </div>
                        </div>

                        <!-- CONTENT -->
                        <div style="padding:24px; flex:1; display:flex; flex-direction:column;">
                            <h2 style="font-family:'Syne', sans-serif; font-size:20px; font-weight:700; color:#111827; line-height:1.4; margin-bottom:12px; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden;">
                                <a href="{{ route('front.blogs.show', $blog->slug) }}" style="color:inherit; text-decoration:none;"
                                   onmouseover="this.style.color='#C25A2A'" onmouseout="this.style.color='#111827'">
                                    {{ $blog->title }}
                                </a>
                            </h2>

                            <p style="color:#6B7280; font-size:14px; line-height:1.6; margin-bottom:20px; display:-webkit-box; -webkit-line-clamp:3; -webkit-box-orient:vertical; overflow:hidden; flex:1;">
                                {{ Str::limit(strip_tags($blog->description), 140) }}
                            </p>

                            <div style="border-top:1px solid #F3F4F6; pt:16px; margin-top:auto; display:flex; justify-content:space-between; align-items:center;">
                                <a href="{{ route('front.blogs.show', $blog->slug) }}"
                                   style="color:#C25A2A; font-weight:700; font-size:14px; text-decoration:none; display:flex; align-items:center; gap:6px;">
                                    Read Article &rarr;
                                </a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            <!-- PAGINATION -->
            <div style="margin-top:50px; display:flex; justify-content:center;">
                {{ $blogs->links() }}
            </div>
        @else
            <!-- EMPTY STATE -->
            <div style="background:#ffffff; border-radius:24px; padding:60px 20px; text-align:center; border:1px solid #E8E6E0; max-width:600px; margin:40px auto;">
                <div style="width:70px; height:70px; background:#FFF5F3; color:#C25A2A; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 20px; font-size:28px;">
                    📰
                </div>
                <h3 style="font-family:'Syne', sans-serif; font-size:22px; font-weight:700; color:#111; margin-bottom:10px;">
                    No Blog Posts Available
                </h3>
                <p style="color:#6B7280; font-size:15px; margin-bottom:24px;">
                    We couldn't find any articles matching your request. Please check back soon or try a different search.
                </p>
                @if(request()->filled('search'))
                    <a href="{{ route('front.blogs.index') }}" style="background:#C25A2A; color:#fff; text-decoration:none; padding:12px 28px; border-radius:12px; font-weight:700; display:inline-block;">
                        View All Articles
                    </a>
                @endif
            </div>
        @endif
    </div>
</div>
@endsection

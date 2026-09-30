@extends('front.layouts.app')

@section('title', 'Latest Blogs, Food Stories & News | HYST')
@section('meta_description', 'Discover the latest food guides, restaurant highlights, updates, and culinary stories from HYST.')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Syne:wght@600;700;800&family=DM+Sans:wght@400;500;600;700&display=swap');

    .blog-page-bg {
        background-color: #FAF8F5;
        min-height: 100vh;
        font-family: 'DM Sans', sans-serif;
        color: #1F2937;
    }

    .blog-hero-card {
        background: linear-gradient(135deg, #111827 0%, #1F2937 100%);
        border-radius: 32px;
        padding: 60px 32px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 20px 50px rgba(0,0,0,0.12);
    }

    .blog-hero-card::before {
        content: '';
        position: absolute;
        top: -40%; right: -20%;
        width: 500px; height: 500px;
        background: radial-gradient(circle, rgba(194, 90, 42, 0.25) 0%, rgba(0,0,0,0) 70%);
        border-radius: 50%;
        pointer-events: none;
    }

    .blog-search-box {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 99px;
        padding: 6px 8px 6px 24px;
        box-shadow: 0 12px 35px rgba(0,0,0,0.15);
        display: flex;
        align-items: center;
        max-width: 580px;
        margin: 0 auto;
        transition: all 0.3s ease;
    }

    .blog-search-box:focus-within {
        box-shadow: 0 16px 40px rgba(194, 90, 42, 0.25);
        transform: translateY(-2px);
    }

    .blog-search-input {
        border: none;
        outline: none;
        background: transparent;
        font-size: 15px;
        width: 100%;
        color: #111827;
        font-family: 'DM Sans', sans-serif;
    }

    .blog-search-btn {
        background: linear-gradient(135deg, #C25A2A 0%, #E8570E 100%);
        color: #ffffff;
        border: none;
        padding: 12px 28px;
        border-radius: 99px;
        font-weight: 700;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.25s ease;
        box-shadow: 0 4px 15px rgba(194, 90, 42, 0.35);
        flex-shrink: 0;
    }

    .blog-search-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 8px 20px rgba(194, 90, 42, 0.45);
        background: linear-gradient(135deg, #d3622e 0%, #f05e15 100%);
    }

    /* CARD DESIGN */
    .blog-card {
        background: #FFFFFF;
        border-radius: 24px;
        border: 1px solid #EFECE6;
        box-shadow: 0 6px 24px rgba(0, 0, 0, 0.03);
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .blog-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
        border-color: #E2DDD5;
    }

    .blog-card-img-wrap {
        position: relative;
        width: 100%;
        height: 230px;
        overflow: hidden;
        background: #F3F0EB;
    }

    .blog-card-img-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .blog-card:hover .blog-card-img-wrap img {
        transform: scale(1.05);
    }

    .blog-badge {
        position: absolute;
        top: 14px;
        left: 14px;
        background: rgba(255, 255, 255, 0.92);
        backdrop-filter: blur(8px);
        color: #111827;
        font-size: 11px;
        font-weight: 700;
        padding: 5px 12px;
        border-radius: 99px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .blog-video-badge {
        position: absolute;
        top: 14px;
        right: 14px;
        background: rgba(194, 90, 42, 0.92);
        backdrop-filter: blur(8px);
        color: #ffffff;
        font-size: 11px;
        font-weight: 700;
        padding: 5px 12px;
        border-radius: 99px;
        box-shadow: 0 4px 12px rgba(194, 90, 42, 0.3);
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .blog-card-body {
        padding: 26px;
        display: flex;
        flex-direction: column;
        flex: 1;
    }

    .blog-card-title {
        font-family: 'Syne', sans-serif;
        font-size: 20px;
        font-weight: 700;
        color: #111827;
        line-height: 1.35;
        margin-bottom: 12px;
        transition: color 0.2s ease;
    }

    .blog-card:hover .blog-card-title {
        color: #C25A2A;
    }

    .blog-card-desc {
        color: #6B7280;
        font-size: 14px;
        line-height: 1.65;
        margin-bottom: 22px;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        flex: 1;
    }

    .blog-card-footer {
        border-top: 1px solid #F3F0EC;
        padding-top: 16px;
        margin-top: auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .blog-read-btn {
        color: #C25A2A;
        font-weight: 700;
        font-size: 14px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: gap 0.2s ease;
    }

    .blog-card:hover .blog-read-btn {
        gap: 10px;
    }

    /* FEATURED HERO POST CARD */
    .featured-post-card {
        background: #FFFFFF;
        border-radius: 28px;
        border: 1px solid #EFECE6;
        box-shadow: 0 8px 30px rgba(0,0,0,0.04);
        overflow: hidden;
        display: grid;
        grid-template-columns: 1.1fr 1fr;
        margin-bottom: 50px;
        transition: all 0.3s ease;
    }

    .featured-post-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 45px rgba(0,0,0,0.08);
    }

    @media (max-width: 900px) {
        .featured-post-card {
            grid-template-columns: 1fr;
        }
        .blog-hero-card {
            padding: 40px 20px;
            border-radius: 24px;
        }
        .blog-hero-title {
            font-size: 30px !important;
        }
    }
</style>

<div class="blog-page-bg">
    <div style="max-width: 1240px; margin: 0 auto; padding: 40px 20px 80px;">
        
        <!-- HERO SECTION -->
        <div class="blog-hero-card" style="margin-bottom: 50px;">
            <div style="max-width: 760px; margin: 0 auto; text-align: center; position: relative; z-index: 2;">
                <div style="display: inline-flex; align-items: center; gap: 8px; background: rgba(194, 90, 42, 0.15); border: 1px solid rgba(194, 90, 42, 0.3); color: #FFAA80; padding: 6px 18px; border-radius: 99px; font-size: 12px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; margin-bottom: 20px;">
                    <span>✦</span> HYST Journal & Stories
                </div>
                <h1 class="blog-hero-title" style="font-family: 'Syne', sans-serif; font-size: 44px; font-weight: 800; color: #FFFFFF; margin-bottom: 18px; line-height: 1.25; letter-spacing: -0.5px;">
                    Insights, Food Guides & <span style="color: #FF8A50;">Stories</span>
                </h1>
                <p style="color: #9CA3AF; font-size: 16px; line-height: 1.7; margin: 0 auto 36px; max-width: 580px;">
                    Explore curated articles, restaurant news, culinary trends, and local guides from the HYST team.
                </p>

                <!-- Search Form -->
                <form action="{{ route('front.blogs.index') }}" method="GET" class="blog-search-box">
                    <i data-lucide="search" style="width: 18px; height: 18px; color: #9CA3AF; margin-right: 12px; flex-shrink: 0;"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search articles, guides, recipes..." class="blog-search-input">
                    <button type="submit" class="blog-search-btn">Search</button>
                </form>
            </div>
        </div>

        @if(request()->filled('search'))
            <div style="margin-bottom: 32px; display: flex; justify-content: space-between; align-items: center; background: #FFFFFF; padding: 16px 24px; border-radius: 18px; border: 1px solid #EFECE6;">
                <div style="font-family: 'Syne', sans-serif; font-size: 17px; font-weight: 700; color: #111827;">
                    Search Results for <span style="color: #C25A2A;">"{{ request('search') }}"</span>
                </div>
                <a href="{{ route('front.blogs.index') }}" style="color: #6B7280; font-size: 13px; font-weight: 600; text-decoration: none; display: flex; align-items: center; gap: 4px;">
                    <span>✕</span> Clear Search
                </a>
            </div>
        @endif

        @if($blogs->count() > 0)
            <!-- FEATURED POST (Only on page 1 without search) -->
            @if(!request()->filled('search') && $blogs->currentPage() == 1 && $blogs->first())
                @php $featured = $blogs->first(); @endphp
                <div class="featured-post-card">
                    <div style="position: relative; min-height: 280px; background: #111827; overflow: hidden;">
                        @if($featured->image)
                            <img src="{{ asset($featured->image) }}" alt="{{ $featured->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: #9CA3AF; font-size: 40px; background: linear-gradient(135deg, #1f2937, #111827);">
                                📰
                            </div>
                        @endif
                        <span class="blog-badge">Featured Story</span>
                        @if($featured->video)
                            <span class="blog-video-badge">🎬 Video Included</span>
                        @endif
                    </div>
                    <div style="padding: 40px 36px; display: flex; flex-direction: column; justify-content: center;">
                        <div style="font-size: 12px; color: #9CA3AF; font-weight: 600; margin-bottom: 12px; display: flex; align-items: center; gap: 12px;">
                            <span>📅 {{ $featured->created_at ? $featured->created_at->format('M d, Y') : 'Recent' }}</span>
                            <span>•</span>
                            <span>⏱️ {{ max(1, ceil(str_word_count(strip_tags($featured->description ?? '')) / 200)) }} min read</span>
                        </div>
                        <h2 style="font-family: 'Syne', sans-serif; font-size: 26px; font-weight: 700; color: #111827; line-height: 1.35; margin-bottom: 14px;">
                            <a href="{{ route('front.blogs.show', $featured->slug) }}" style="color: inherit; text-decoration: none;">
                                {{ $featured->title }}
                            </a>
                        </h2>
                        <p style="color: #6B7280; font-size: 15px; line-height: 1.65; margin-bottom: 24px; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
                            {{ Str::limit(strip_tags($featured->description), 160) }}
                        </p>
                        <div>
                            <a href="{{ route('front.blogs.show', $featured->slug) }}" style="display: inline-flex; align-items: center; gap: 8px; background: #111827; color: #FFFFFF; font-weight: 700; font-size: 14px; padding: 12px 24px; border-radius: 99px; text-decoration: none; transition: all 0.2s ease;">
                                Read Featured Story &rarr;
                            </a>
                        </div>
                    </div>
                </div>
            @endif

            <!-- BLOG GRID -->
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(340px, 1fr)); gap: 30px;">
                @foreach($blogs as $index => $blog)
                    {{-- Skip first item if featured is displayed above --}}
                    @if(!request()->filled('search') && $blogs->currentPage() == 1 && $index == 0)
                        @continue
                    @endif

                    <article class="blog-card">
                        <div class="blog-card-img-wrap">
                            @if($blog->image)
                                <img src="{{ asset($blog->image) }}" alt="{{ $blog->title }}" loading="lazy">
                            @else
                                <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: #9CA3AF; font-size: 36px; background: #EFECE6;">
                                    📰
                                </div>
                            @endif

                            <span class="blog-badge">Article</span>

                            @if($blog->video)
                                <span class="blog-video-badge">🎬 Video</span>
                            @endif
                        </div>

                        <div class="blog-card-body">
                            <div style="font-size: 12px; color: #9CA3AF; font-weight: 600; margin-bottom: 10px; display: flex; align-items: center; gap: 10px;">
                                <span>{{ $blog->created_at ? $blog->created_at->format('M d, Y') : 'Recent' }}</span>
                                <span>•</span>
                                <span>{{ max(1, ceil(str_word_count(strip_tags($blog->description ?? '')) / 200)) }} min read</span>
                            </div>

                            <h2 class="blog-card-title">
                                <a href="{{ route('front.blogs.show', $blog->slug) }}" style="color: inherit; text-decoration: none;">
                                    {{ $blog->title }}
                                </a>
                            </h2>

                            <p class="blog-card-desc">
                                {{ Str::limit(strip_tags($blog->description), 130) }}
                            </p>

                            <div class="blog-card-footer">
                                <a href="{{ route('front.blogs.show', $blog->slug) }}" class="blog-read-btn">
                                    Read Article <span>&rarr;</span>
                                </a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            <!-- PAGINATION -->
            <div style="margin-top: 55px; display: flex; justify-content: center;">
                {{ $blogs->links() }}
            </div>
        @else
            <!-- EMPTY STATE -->
            <div style="background: #FFFFFF; border-radius: 28px; padding: 60px 24px; text-align: center; border: 1px solid #EFECE6; max-width: 540px; margin: 40px auto; box-shadow: 0 10px 30px rgba(0,0,0,0.03);">
                <div style="width: 72px; height: 72px; background: #FFF5F0; color: #C25A2A; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; font-size: 30px;">
                    📖
                </div>
                <h3 style="font-family: 'Syne', sans-serif; font-size: 22px; font-weight: 700; color: #111827; margin-bottom: 10px;">
                    No Articles Found
                </h3>
                <p style="color: #6B7280; font-size: 15px; margin-bottom: 26px; line-height: 1.6;">
                    We couldn't find any articles matching your search. Try exploring all published posts.
                </p>
                @if(request()->filled('search'))
                    <a href="{{ route('front.blogs.index') }}" style="background: linear-gradient(135deg, #C25A2A 0%, #E8570E 100%); color: #ffffff; text-decoration: none; padding: 12px 28px; border-radius: 99px; font-weight: 700; display: inline-block; box-shadow: 0 4px 15px rgba(194, 90, 42, 0.3);">
                        View All Articles
                    </a>
                @endif
            </div>
        @endif

    </div>
</div>
@endsection

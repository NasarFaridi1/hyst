@extends('front.layouts.app')

@section('title', $blog->title . ' | HYST Journal')
@section('meta_description', Str::limit(strip_tags($blog->description), 160))

@section('content')
@php
    $videoEmbed = null;
    $isVideoUrl = false;
    $isVideoFile = false;

    if ($blog->video) {
        if (Str::startsWith($blog->video, ['http://', 'https://'])) {
            $isVideoUrl = true;
            if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $blog->video, $matches)) {
                $videoEmbed = 'https://www.youtube.com/embed/' . $matches[1] . '?autoplay=0';
            } elseif (preg_match('/vimeo\.com\/(?:.*\/)?([0-9]+)/', $blog->video, $matches)) {
                $videoEmbed = 'https://player.vimeo.com/video/' . $matches[1];
            } else {
                $videoEmbed = $blog->video;
            }
        } else {
            $isVideoFile = true;
        }
    }
@endphp

<style>
    @import url('https://fonts.googleapis.com/css2?family=Syne:wght@600;700;800&family=DM+Sans:wght@400;500;600;700&display=swap');

    .blog-detail-bg {
        background-color: #FAF8F5;
        min-height: 100vh;
        font-family: 'DM Sans', sans-serif;
        color: #1F2937;
    }

    .article-card {
        background: #FFFFFF;
        border-radius: 28px;
        padding: 44px;
        border: 1px solid #EFECE6;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.03);
    }

    .sidebar-card {
        background: #FFFFFF;
        border-radius: 28px;
        padding: 30px;
        border: 1px solid #EFECE6;
        box-shadow: 0 6px 24px rgba(0, 0, 0, 0.03);
        position: sticky;
        top: 100px;
    }

    /* CKEditor & Rich Text Styling */
    .blog-content-body {
        font-size: 16px;
        line-height: 1.85;
        color: #374151;
    }

    .blog-content-body p {
        margin-bottom: 1.5rem;
        line-height: 1.85;
        color: #374151;
    }

    .blog-content-body h1 {
        font-family: 'Syne', sans-serif;
        color: #111827;
        font-size: 30px;
        font-weight: 800;
        margin-top: 36px;
        margin-bottom: 18px;
        line-height: 1.3;
    }

    .blog-content-body h2 {
        font-family: 'Syne', sans-serif;
        color: #111827;
        font-size: 24px;
        font-weight: 700;
        margin-top: 32px;
        margin-bottom: 16px;
        line-height: 1.35;
    }

    .blog-content-body h3 {
        font-family: 'Syne', sans-serif;
        color: #111827;
        font-size: 20px;
        font-weight: 700;
        margin-top: 26px;
        margin-bottom: 14px;
    }

    .blog-content-body h4, .blog-content-body h5, .blog-content-body h6 {
        font-family: 'Syne', sans-serif;
        color: #111827;
        font-weight: 700;
        margin-top: 22px;
        margin-bottom: 12px;
    }

    .blog-content-body ul {
        list-style-type: disc !important;
        padding-left: 1.75rem !important;
        margin-bottom: 1.5rem !important;
    }

    .blog-content-body ol {
        list-style-type: decimal !important;
        padding-left: 1.75rem !important;
        margin-bottom: 1.5rem !important;
    }

    .blog-content-body li {
        margin-bottom: 0.6rem;
        line-height: 1.75;
        color: #374151;
    }

    .blog-content-body strong, .blog-content-body b {
        font-weight: 700;
        color: #111827;
    }

    .blog-content-body a {
        color: #C25A2A;
        text-decoration: underline;
        font-weight: 600;
    }

    .blog-content-body a:hover {
        color: #a64b20;
    }

    .blog-content-body blockquote {
        border-left: 4px solid #C25A2A;
        background: #FFF7F3;
        color: #4B5563;
        font-style: italic;
        padding: 16px 24px;
        margin: 28px 0;
        border-radius: 0 16px 16px 0;
    }

    .blog-content-body img, .blog-content-body figure img {
        max-width: 100%;
        height: auto;
        border-radius: 18px;
        margin: 28px 0;
        box-shadow: 0 8px 24px rgba(0,0,0,0.06);
    }

    .blog-content-body table {
        width: 100%;
        border-collapse: collapse;
        margin: 28px 0;
        font-size: 14px;
    }

    .blog-content-body th, .blog-content-body td {
        border: 1px solid #E5E7EB;
        padding: 12px 16px;
        text-align: left;
    }

    .blog-content-body th {
        background: #F9FAFB;
        font-weight: 700;
        color: #111827;
    }

    .recent-item-link {
        display: flex;
        gap: 14px;
        text-decoration: none;
        color: inherit;
        transition: all 0.2s ease;
    }

    .recent-item-link:hover .recent-title {
        color: #C25A2A;
    }

    @media (max-width: 900px) {
        .detail-grid {
            grid-template-columns: 1fr !important;
        }
        .article-card {
            padding: 24px;
            border-radius: 20px;
        }
        .article-title {
            font-size: 26px !important;
        }
    }
</style>

<div class="blog-detail-bg">
    <div style="max-width: 1200px; margin: 0 auto; padding: 40px 20px 80px;">
        
        <!-- BREADCRUMB -->
        <div style="display: flex; align-items: center; gap: 8px; font-size: 13px; color: #6B7280; margin-bottom: 28px;">
            <a href="/" style="color: #6B7280; text-decoration: none; font-weight: 500;">Home</a>
            <span style="color: #D1D5DB;">/</span>
            <a href="{{ route('front.blogs.index') }}" style="color: #6B7280; text-decoration: none; font-weight: 500;">Blogs</a>
            <span style="color: #D1D5DB;">/</span>
            <span style="color: #C25A2A; font-weight: 600; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 320px;">
                {{ $blog->title }}
            </span>
        </div>

        <div class="detail-grid" style="display: grid; grid-template-columns: 1fr 340px; gap: 36px;">
            
            <!-- MAIN ARTICLE COLUMN -->
            <div>
                <article class="article-card">
                    
                    <!-- CATEGORY & META BADGES -->
                    <div style="display: flex; flex-wrap: wrap; align-items: center; gap: 12px; margin-bottom: 18px;">
                        <span style="background: #FFF5F0; color: #C25A2A; font-size: 12px; font-weight: 700; padding: 5px 14px; border-radius: 99px; border: 1px solid rgba(194, 90, 42, 0.2);">
                            Article
                        </span>
                        @if($blog->video)
                            <span style="background: #F3E8FF; color: #7E22CE; font-size: 12px; font-weight: 700; padding: 5px 14px; border-radius: 99px; border: 1px solid rgba(126, 34, 206, 0.2);">
                                🎬 Video Story
                            </span>
                        @endif
                    </div>

                    <!-- TITLE -->
                    <h1 class="article-title" style="font-family: 'Syne', sans-serif; font-size: 36px; font-weight: 800; color: #111827; line-height: 1.3; margin-bottom: 20px; letter-spacing: -0.3px;">
                        {{ $blog->title }}
                    </h1>

                    <!-- METADATA BAR -->
                    <div style="display: flex; align-items: center; gap: 16px; font-size: 13px; color: #9CA3AF; font-weight: 500; margin-bottom: 32px; padding-bottom: 20px; border-bottom: 1px solid #F3F0EC;">
                        <span style="display: flex; align-items: center; gap: 6px;">
                            <span>📅</span> {{ $blog->created_at ? $blog->created_at->format('F d, Y') : 'Recent' }}
                        </span>
                        <span>•</span>
                        <span style="display: flex; align-items: center; gap: 6px;">
                            <span>⏱️</span> {{ max(1, ceil(str_word_count(strip_tags($blog->description ?? '')) / 200)) }} min read
                        </span>
                    </div>

                    <!-- FEATURED IMAGE -->
                    @if($blog->image)
                        <div style="margin-bottom: 36px; border-radius: 22px; overflow: hidden; max-height: 480px; box-shadow: 0 10px 30px rgba(0,0,0,0.06); background: #F3F0EB;">
                            <img src="{{ asset($blog->image) }}" alt="{{ $blog->title }}" style="width: 100%; height: auto; display: block; object-fit: cover;">
                        </div>
                    @endif

                    <!-- FEATURED VIDEO SECTION -->
                    @if($blog->video)
                        <div style="margin-bottom: 40px; background: #FAF8F5; padding: 20px; border-radius: 24px; border: 1px solid #EFECE6;">
                            <h3 style="font-family: 'Syne', sans-serif; font-size: 18px; font-weight: 700; color: #111827; margin-bottom: 14px; display: flex; align-items: center; gap: 8px;">
                                🎬 Video Coverage
                            </h3>
                            <div style="border-radius: 18px; overflow: hidden; background: #000000; box-shadow: 0 8px 25px rgba(0,0,0,0.15); aspect-ratio: 16/9; width: 100%;">
                                @if($isVideoFile)
                                    <video controls style="width: 100%; height: 100%; object-fit: contain;">
                                        <source src="{{ asset($blog->video) }}">
                                        Your browser does not support the video tag.
                                    </video>
                                @elseif($videoEmbed && Str::contains($videoEmbed, ['youtube.com', 'vimeo.com']))
                                    <iframe src="{{ $videoEmbed }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen style="width: 100%; height: 100%;"></iframe>
                                @else
                                    <video controls style="width: 100%; height: 100%;">
                                        <source src="{{ $blog->video }}">
                                    </video>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- ARTICLE CONTENT -->
                    <div class="blog-content-body ck-content">
                        {!! $blog->description !!}
                    </div>

                    <!-- FOOTER ACTIONS -->
                    <div style="margin-top: 45px; padding-top: 24px; border-top: 1px solid #F3F0EC; display: flex; justify-content: space-between; align-items: center;">
                        <a href="{{ route('front.blogs.index') }}" style="display: inline-flex; align-items: center; gap: 8px; background: #FAF8F5; border: 1px solid #EFECE6; color: #C25A2A; font-weight: 700; text-decoration: none; font-size: 14px; padding: 10px 20px; border-radius: 99px; transition: all 0.2s ease;">
                            &larr; Back to all articles
                        </a>
                    </div>
                </article>
            </div>

            <!-- SIDEBAR -->
            <div>
                <div class="sidebar-card">
                    <h3 style="font-family: 'Syne', sans-serif; font-size: 18px; font-weight: 700; color: #111827; margin-bottom: 22px; padding-bottom: 12px; border-bottom: 2px solid #F3F0EC;">
                        Recent Articles
                    </h3>

                    @if($recentBlogs->count() > 0)
                        <div style="display: flex; flex-direction: column; gap: 20px;">
                            @foreach($recentBlogs as $recent)
                                <a href="{{ route('front.blogs.show', $recent->slug) }}" class="recent-item-link">
                                    @if($recent->image)
                                        <img src="{{ asset($recent->image) }}" alt="{{ $recent->title }}" style="width: 72px; height: 72px; object-fit: cover; border-radius: 14px; flex-shrink: 0; background: #F3F0EB;">
                                    @else
                                        <div style="width: 72px; height: 72px; background: #F3F0EC; border-radius: 14px; flex-shrink: 0; display: flex; align-items: center; justify-content: center; color: #9CA3AF; font-size: 22px;">📰</div>
                                    @endif
                                    <div style="display: flex; flex-direction: column; justify-content: center;">
                                        <h4 class="recent-title" style="font-family: 'Syne', sans-serif; font-size: 14px; font-weight: 700; color: #111827; line-height: 1.4; margin-bottom: 4px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; transition: color 0.2s ease;">
                                            {{ $recent->title }}
                                        </h4>
                                        <span style="font-size: 11px; color: #9CA3AF; font-weight: 500;">
                                            {{ $recent->created_at ? $recent->created_at->format('M d, Y') : '' }}
                                        </span>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <p style="color: #9CA3AF; font-size: 13px;">No other recent articles.</p>
                    @endif

                    <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #F3F0EC;">
                        <a href="{{ route('front.blogs.index') }}" style="display: block; text-align: center; background: #FFF5F0; color: #C25A2A; font-weight: 700; font-size: 13px; padding: 12px; border-radius: 99px; text-decoration: none; border: 1px solid rgba(194, 90, 42, 0.15); transition: background 0.2s ease;">
                            Explore All Blogs &rarr;
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

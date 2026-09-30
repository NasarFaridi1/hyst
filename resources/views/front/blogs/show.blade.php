@extends('front.layouts.app')

@section('title', $blog->title . ' | HYST Blog')
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

<div style="background:#F9F8F6; min-height:100vh; padding:40px 20px 80px;">
    <div style="max-width:1100px; margin:0 auto;">
        
        <!-- BREADCRUMB -->
        <div style="display:flex; align-items:center; gap:8px; font-size:13px; color:#6B7280; margin-bottom:24px;">
            <a href="/" style="color:#6B7280; text-decoration:none;">Home</a>
            <span>&rsaquo;</span>
            <a href="{{ route('front.blogs.index') }}" style="color:#6B7280; text-decoration:none;">Blogs</a>
            <span>&rsaquo;</span>
            <span style="color:#C25A2A; font-weight:600; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; max-width:300px;">{{ $blog->title }}</span>
        </div>

        <div style="display:grid; grid-template-columns: 1fr 340px; gap:40px;">
            
            <!-- MAIN ARTICLE COLUMN -->
            <div>
                <article style="background:#ffffff; border-radius:24px; padding:36px; border:1px solid #E8E6E0; box-shadow:0 6px 30px rgba(0,0,0,0.04);">
                    
                    <!-- TITLE & METADATA -->
                    <span style="display:inline-block; background:#FFF5F3; color:#C25A2A; font-size:12px; font-weight:700; padding:4px 14px; border-radius:30px; margin-bottom:14px;">
                        Article
                    </span>

                    <h1 style="font-family:'Syne', sans-serif; font-size:34px; font-weight:800; color:#111827; line-height:1.3; margin-bottom:16px;">
                        {{ $blog->title }}
                    </h1>

                    <div style="display:flex; align-items:center; gap:16px; font-size:13px; color:#9CA3AF; margin-bottom:28px; padding-bottom:20px; border-b:1px solid #F3F4F6;">
                        <span style="display:flex; align-items:center; gap:6px;">
                            📅 {{ $blog->created_at ? $blog->created_at->format('F d, Y') : 'Recent' }}
                        </span>
                        <span>•</span>
                        <span style="display:flex; align-items:center; gap:6px;">
                            ⏱️ {{ max(1, ceil(str_word_count(strip_tags($blog->description ?? '')) / 200)) }} min read
                        </span>
                    </div>

                    <!-- FEATURED IMAGE -->
                    @if($blog->image)
                        <div style="margin-bottom:30px; border-radius:18px; overflow:hidden; max-height:480px; box-shadow:0 4px 20px rgba(0,0,0,0.08);">
                            <img src="{{ asset($blog->image) }}" alt="{{ $blog->title }}" style="width:100%; height:auto; display:block; object-fit:cover;">
                        </div>
                    @endif

                    <!-- FEATURED VIDEO SECTION -->
                    @if($blog->video)
                        <div style="margin-bottom:36px;">
                            <h3 style="font-family:'Syne', sans-serif; font-size:18px; font-weight:700; color:#111; margin-bottom:12px; display:flex; align-items:center; gap:8px;">
                                🎬 Video Coverage
                            </h3>
                            <div style="border-radius:18px; overflow:hidden; background:#000; box-shadow:0 6px 24px rgba(0,0,0,0.15); aspect-ratio:16/9; width:100%;">
                                @if($isVideoFile)
                                    <video controls style="width:100%; height:100%; object-fit:contain;">
                                        <source src="{{ asset($blog->video) }}">
                                        Your browser does not support the video tag.
                                    </video>
                                @elseif($videoEmbed && Str::contains($videoEmbed, ['youtube.com', 'vimeo.com']))
                                    <iframe src="{{ $videoEmbed }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen style="width:100%; height:100%;"></iframe>
                                @else
                                    <video controls style="width:100%; height:100%;">
                                        <source src="{{ $blog->video }}">
                                    </video>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- ARTICLE CONTENT -->
                    <div class="blog-content-body ck-content" style="font-family:'DM Sans', sans-serif; font-size:16px; line-height:1.8; color:#374151;">
                        {!! $blog->description !!}
                    </div>

                    <!-- BACK LINK -->
                    <div style="margin-top:40px; padding-top:24px; border-top:1px solid #F3F4F6; display:flex; justify-content:space-between; align-items:center;">
                        <a href="{{ route('front.blogs.index') }}" style="display:inline-flex; align-items:center; gap:8px; color:#C25A2A; font-weight:700; text-decoration:none; font-size:14px;">
                            &larr; Back to all blogs
                        </a>
                    </div>
                </article>
            </div>

            <!-- SIDEBAR -->
            <div>
                <div style="background:#ffffff; border-radius:24px; padding:28px; border:1px solid #E8E6E0; box-shadow:0 4px 20px rgba(0,0,0,0.04); position:sticky; top:100px;">
                    <h3 style="font-family:'Syne', sans-serif; font-size:18px; font-weight:700; color:#111; margin-bottom:20px; padding-bottom:12px; border-bottom:2px solid #F3F4F6;">
                        Recent Articles
                    </h3>

                    @if($recentBlogs->count() > 0)
                        <div style="display:flex; flex-direction:column; gap:20px;">
                            @foreach($recentBlogs as $recent)
                                <a href="{{ route('front.blogs.show', $recent->slug) }}" style="display:flex; gap:14px; text-decoration:none; color:inherit; group;"
                                   onmouseover="this.querySelector('.rec-title').style.color='#C25A2A'"
                                   onmouseout="this.querySelector('.rec-title').style.color='#111827'">
                                    @if($recent->image)
                                        <img src="{{ asset($recent->image) }}" alt="{{ $recent->title }}" style="width:70px; height:70px; object-fit:cover; border-radius:12px; flex-shrink:0;">
                                    @else
                                        <div style="width:70px; height:70px; background:#F3F4F6; border-radius:12px; flex-shrink:0; display:flex; align-items:center; justify-content:center; color:#9CA3AF; font-size:20px;">📰</div>
                                    @endif
                                    <div>
                                        <h4 class="rec-title" style="font-family:'Syne', sans-serif; font-size:14px; font-weight:700; color:#111827; line-height:1.4; margin-bottom:4px; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; transition:color .2s;">
                                            {{ $recent->title }}
                                        </h4>
                                        <span style="font-size:11px; color:#9CA3AF;">
                                            {{ $recent->created_at ? $recent->created_at->format('M d, Y') : '' }}
                                        </span>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <p style="color:#9CA3AF; font-size:13px;">No other recent articles.</p>
                    @endif

                    <div style="margin-top:30px; padding-top:20px; border-top:1px solid #F3F4F6;">
                        <a href="{{ route('front.blogs.index') }}" style="display:block; text-align:center; background:#FFF5F3; color:#C25A2A; font-weight:700; font-size:13px; padding:12px; border-radius:12px; text-decoration:none;">
                            Explore All Blogs &rarr;
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    /* CKEditor & Rich Text Styling */
    .blog-content-body p { margin-bottom: 1.25rem; line-height: 1.85; color: #374151; }
    .blog-content-body h1 { font-family: 'Syne', sans-serif; color: #111827; font-size: 28px; font-weight: 800; margin-top: 32px; margin-bottom: 16px; }
    .blog-content-body h2 { font-family: 'Syne', sans-serif; color: #111827; font-size: 24px; font-weight: 700; margin-top: 28px; margin-bottom: 14px; }
    .blog-content-body h3 { font-family: 'Syne', sans-serif; color: #111827; font-size: 20px; font-weight: 700; margin-top: 24px; margin-bottom: 12px; }
    .blog-content-body h4, .blog-content-body h5, .blog-content-body h6 { font-family: 'Syne', sans-serif; color: #111827; font-weight: 700; margin-top: 20px; margin-bottom: 10px; }
    .blog-content-body ul { list-style-type: disc !important; padding-left: 1.75rem !important; margin-bottom: 1.25rem !important; }
    .blog-content-body ol { list-style-type: decimal !important; padding-left: 1.75rem !important; margin-bottom: 1.25rem !important; }
    .blog-content-body li { margin-bottom: 0.5rem; line-height: 1.75; color: #374151; }
    .blog-content-body strong, .blog-content-body b { font-weight: 700; color: #111827; }
    .blog-content-body a { color: #C25A2A; text-decoration: underline; font-weight: 600; }
    .blog-content-body a:hover { color: #a64b20; }
    .blog-content-body blockquote { border-left: 4px solid #C25A2A; background: #FFF5F3; color: #4B5563; font-style: italic; padding: 14px 20px; margin: 24px 0; border-radius: 0 12px 12px 0; }
    .blog-content-body img, .blog-content-body figure img { max-width: 100%; height: auto; border-radius: 14px; margin: 24px 0; box-shadow: 0 4px 15px rgba(0,0,0,0.06); }
    .blog-content-body table { width: 100%; border-collapse: collapse; margin: 24px 0; font-size: 14px; }
    .blog-content-body th, .blog-content-body td { border: 1px solid #E5E7EB; padding: 12px 16px; text-align: left; }
    .blog-content-body th { background: #F9FAFB; font-weight: 700; color: #111827; }

    @media (max-width: 900px) {
        div[style*="grid-template-columns: 1fr 340px"] {
            grid-template-columns: 1fr !important;
        }
    }
</style>
@endsection

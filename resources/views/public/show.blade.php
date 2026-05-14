@extends('layouts.app')

@section('title', $article->title)

@section('extra_styles')
<style>
    nav {
        position: sticky; top: 0; z-index: 100;
        background: rgba(250,248,244,.92); backdrop-filter: blur(12px);
        border-bottom: 1px solid var(--border);
    }
    .nav-inner {
        max-width: 900px; margin: 0 auto; padding: 1rem 2rem;
        display: flex; align-items: center; justify-content: space-between;
    }
    .nav-logo { font-family: 'Playfair Display', serif; font-size: 1.3rem; text-decoration: none; color: var(--ink); }
    .nav-logo span { color: var(--gold); }
    .nav-back { font-size: .875rem; color: var(--muted); text-decoration: none; }
    .nav-back:hover { color: var(--gold); }

    .article-wrap { max-width: 720px; margin: 0 auto; padding: 3rem 2rem 5rem; }

    .article-category {
        font-size: .78rem; font-weight: 700; letter-spacing: .1em; text-transform: uppercase;
        color: var(--gold); margin-bottom: .8rem; display: block;
    }
    .article-title {
        font-family: 'Playfair Display', serif;
        font-size: clamp(1.8rem, 5vw, 2.8rem);
        line-height: 1.15; margin-bottom: 1.2rem;
    }
    .article-meta {
        display: flex; gap: 1.2rem; align-items: center; flex-wrap: wrap;
        padding: 1rem 0; border-top: 1px solid var(--border); border-bottom: 1px solid var(--border);
        margin-bottom: 2.5rem; font-size: .85rem; color: var(--muted);
    }
    .article-meta strong { color: var(--ink); }
    .tags { display: flex; gap: .4rem; flex-wrap: wrap; margin-bottom: 2rem; }
    .tag {
        font-size: .78rem; padding: .25rem .65rem; border-radius: 50px;
        background: var(--cream); color: var(--muted); border: 1px solid var(--border);
    }

    .article-body {
        font-family: 'DM Serif Text', serif;
        font-size: 1.1rem; line-height: 1.85; color: #2a2720;
    }
    .article-body p { margin-bottom: 1.5em; }
    .article-body h2 {
        font-family: 'Playfair Display', serif;
        font-size: 1.6rem; margin: 2em 0 1em;
    }

    .related-section { max-width: 900px; margin: 0 auto; padding: 2rem 2rem 4rem; }
    .related-heading {
        font-family: 'Playfair Display', serif;
        font-size: 1.3rem; margin-bottom: 1.5rem;
        padding-top: 2rem; border-top: 1px solid var(--border);
    }
    .related-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 1rem; }
    .related-card {
        background: #fff; border: 1px solid var(--border); border-radius: 12px; padding: 1.25rem;
        text-decoration: none; color: inherit; transition: transform .2s;
    }
    .related-card:hover { transform: translateY(-2px); }
    .related-card .cat { font-size: .75rem; font-weight: 700; color: var(--gold); text-transform: uppercase; letter-spacing: .08em; }
    .related-card h4 { font-family: 'Playfair Display', serif; font-size: 1rem; margin-top: .4rem; }

    footer { text-align: center; padding: 2rem; font-size: .82rem; color: var(--muted); border-top: 1px solid var(--border); }
    footer a { color: var(--gold); }

    @import url('https://fonts.googleapis.com/css2?family=DM+Serif+Text:ital@0;1&display=swap');
</style>
@endsection

@section('content')
<nav>
    <div class="nav-inner">
        <a href="/" class="nav-logo">ink<span>well</span></a>
        <a href="/" class="nav-back">← Back to all articles</a>
    </div>
</nav>

<article class="article-wrap">
    <span class="article-category">{{ $article->category }}</span>
    <h1 class="article-title">{{ $article->title }}</h1>

    <div class="article-meta">
        <strong>{{ $article->author->name }}</strong>
        <span>{{ $article->created_at->format('M j, Y') }}</span>
        <span>👁 {{ $article->views }} views</span>
    </div>

    @if($article->tags && count($article->tags) > 0)
        <div class="tags">
            @foreach ($article->tags as $tag)
                <span class="tag">#{{ trim($tag) }}</span>
            @endforeach
        </div>
    @endif

    <div class="article-body">
        {!! nl2br(e($article->content)) !!}
    </div>
</article>

@if($related->isNotEmpty())
    <section class="related-section">
        <h2 class="related-heading">Related Articles</h2>
        <div class="related-grid">
            @foreach ($related as $rel)
                <a href="{{ route('article.show', $rel->slug) }}" class="related-card">
                    <span class="cat">{{ $rel->category }}</span>
                    <h4>{{ $rel->title }}</h4>
                    <p style="font-size: .9rem; color: var(--muted); margin-top: .5rem;">{{ Str::limit($rel->excerpt, 80) }}</p>
                </a>
            @endforeach
        </div>
    </section>
@endif

<footer>
    <p>&copy; 2024 Inkwell. All rights reserved.</p>
</footer>
@endsection

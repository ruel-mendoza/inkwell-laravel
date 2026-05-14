@extends('layouts.app')

@section('title', 'Inkwell — Articles & Records')

@section('extra_styles')
<style>
    /* NAV */
    nav {
        position: sticky; top: 0; z-index: 100;
        background: rgba(250,248,244,.92);
        backdrop-filter: blur(12px);
        border-bottom: 1px solid var(--border);
    }
    .nav-inner {
        max-width: 1200px; margin: 0 auto;
        padding: 1rem 2rem;
        display: flex; align-items: center; gap: 2rem;
    }
    .nav-logo {
        font-family: 'Playfair Display', serif;
        font-size: 1.4rem;
        color: var(--ink);
        text-decoration: none;
        display: flex; align-items: center; gap: .5rem;
        flex-shrink: 0;
    }
    .nav-logo span { color: var(--gold); }
    .nav-search {
        flex: 1; max-width: 400px;
        position: relative;
    }
    .nav-search input {
        width: 100%;
        padding: .55rem 1rem .55rem 2.4rem;
        border: 1.5px solid var(--border);
        border-radius: 50px;
        background: var(--white);
        font-family: 'DM Sans', sans-serif;
        font-size: .875rem;
        color: var(--ink);
        outline: none;
        transition: border-color .2s;
    }
    .nav-search input:focus { border-color: var(--gold); }
    .nav-search::before {
        content: '🔍';
        position: absolute; left: .8rem; top: 50%;
        transform: translateY(-50%);
        font-size: .8rem; opacity: .5; pointer-events: none;
    }
    .nav-links { margin-left: auto; display: flex; gap: 1rem; }
    .nav-links a {
        font-size: .875rem; font-weight: 500;
        color: var(--ink); text-decoration: none;
        transition: color .2s;
    }
    .nav-links a:hover { color: var(--gold); }

    /* MAIN */
    .hero {
        max-width: 1200px; margin: 0 auto;
        padding: 4rem 2rem 2rem;
    }
    .hero h1 {
        font-family: 'Playfair Display', serif;
        font-size: 2.2rem;
        margin-bottom: .5rem;
    }
    .hero p { color: var(--muted); font-size: .95rem; margin-bottom: 2rem; }

    .filters {
        display: flex; gap: 1rem; flex-wrap: wrap;
        margin-bottom: 2rem; padding: 0 2rem;
        max-width: 1200px; margin-left: auto; margin-right: auto;
    }
    .filter-label {
        font-weight: 500; color: var(--ink); margin-right: .5rem;
    }
    .category-pills {
        display: flex; gap: .5rem; flex-wrap: wrap;
    }
    .category-pill {
        padding: .4rem .8rem; border-radius: 50px;
        border: 1px solid var(--border); background: var(--white);
        color: var(--ink); text-decoration: none;
        font-size: .85rem; transition: all .2s;
    }
    .category-pill.active {
        background: var(--gold); color: var(--white); border-color: var(--gold);
    }
    .category-pill:hover { border-color: var(--gold); }

    .articles-wrap { max-width: 1200px; margin: 0 auto; padding: 2rem; }

    .featured-section h2 {
        font-family: 'Playfair Display', serif; font-size: 1.2rem;
        margin-bottom: 1.5rem; padding-top: 1rem;
        border-top: 1px solid var(--border);
    }
    .featured-grid {
        display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1.5rem; margin-bottom: 3rem;
    }
    .article-card {
        background: var(--white); border: 1px solid var(--border);
        border-radius: var(--radius); padding: 1.5rem; overflow: hidden;
        transition: transform .2s, box-shadow .2s; text-decoration: none; color: inherit;
    }
    .article-card:hover { transform: translateY(-4px); box-shadow: 0 12px 32px rgba(15,14,12,.15); }
    .article-card .category {
        font-size: .75rem; font-weight: 700; color: var(--gold);
        text-transform: uppercase; letter-spacing: .08em;
    }
    .article-card h3 {
        font-family: 'Playfair Display', serif;
        font-size: 1.25rem; margin: .6rem 0; line-height: 1.2;
    }
    .article-card .excerpt {
        color: var(--muted); font-size: .9rem; line-height: 1.6;
        display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
    }
    .article-card .meta {
        margin-top: 1rem; padding-top: 1rem; border-top: 1px solid var(--border);
        display: flex; justify-content: space-between; font-size: .8rem; color: var(--muted);
    }

    .no-articles {
        text-align: center; padding: 3rem 2rem;
        color: var(--muted);
    }
    .no-articles p { margin-bottom: 1rem; }

    footer { text-align: center; padding: 2rem; font-size: .82rem;
        color: var(--muted); border-top: 1px solid var(--border); }
    footer a { color: var(--gold); }
</style>
@endsection

@section('content')
<nav>
    <div class="nav-inner">
        <a href="/" class="nav-logo">ink<span>well</span></a>
        <form method="GET" class="nav-search">
            <input type="text" name="q" placeholder="Search articles..." value="{{ request('q') }}">
        </form>
        <div class="nav-links">
            @auth
                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" style="background: none; border: none; color: var(--gold); cursor: pointer; font-size: .875rem; font-weight: 500;">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}">Login</a>
            @endauth
        </div>
    </div>
</nav>

<div class="articles-wrap">
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
    @endif

    @if($featured->isNotEmpty())
        <div class="featured-section">
            <h2>✨ Featured</h2>
            <div class="featured-grid">
                @foreach ($featured as $article)
                    <a href="{{ route('article.show', $article->slug) }}" class="article-card">
                        <span class="category">{{ $article->category }}</span>
                        <h3>{{ $article->title }}</h3>
                        <p class="excerpt">{{ $article->excerpt }}</p>
                        <div class="meta">
                            <span>{{ $article->created_at->format('M j, Y') }}</span>
                            <span>👁 {{ $article->views }}</span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif

    <div class="featured-section">
        <h2>All Articles</h2>
        @if($regular->isNotEmpty())
            <div class="featured-grid">
                @foreach ($regular as $article)
                    <a href="{{ route('article.show', $article->slug) }}" class="article-card">
                        <span class="category">{{ $article->category }}</span>
                        <h3>{{ $article->title }}</h3>
                        <p class="excerpt">{{ $article->excerpt }}</p>
                        <div class="meta">
                            <span>{{ $article->created_at->format('M j, Y') }}</span>
                            <span>👁 {{ $article->views }}</span>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="no-articles">
                <p>No articles found.</p>
            </div>
        @endif
    </div>
</div>

<footer>
    <p>&copy; 2024 Inkwell. All rights reserved.</p>
</footer>
@endsection

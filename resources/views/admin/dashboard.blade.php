@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('extra_styles')
<style>
    .admin-wrapper {
        display: flex;
        min-height: 100vh;
    }

    .sidebar {
        width: 240px;
        background: var(--ink);
        color: white;
        padding: 2rem 0;
        position: fixed;
        height: 100vh;
        overflow-y: auto;
    }

    .sidebar-brand {
        padding: 0 1.5rem;
        margin-bottom: 2rem;
    }

    .sidebar-brand a {
        font-family: 'Playfair Display', serif;
        font-size: 1.3rem;
        color: white;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: .5rem;
    }

    .sidebar-brand span {
        color: var(--gold);
    }

    .sidebar-nav {
        list-style: none;
        padding: 0;
    }

    .sidebar-nav li {
        margin: 0;
    }

    .sidebar-nav a {
        display: block;
        padding: .8rem 1.5rem;
        color: rgba(255,255,255,.7);
        text-decoration: none;
        transition: all .2s;
        border-left: 3px solid transparent;
    }

    .sidebar-nav a:hover,
    .sidebar-nav a.active {
        background: rgba(201,150,58,.1);
        color: white;
        border-left-color: var(--gold);
    }

    .main-content {
        margin-left: 240px;
        flex: 1;
        padding: 2rem;
    }

    .top-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid var(--border);
    }

    .top-bar h1 {
        font-family: 'Playfair Display', serif;
        font-size: 2rem;
    }

    .top-bar-actions {
        display: flex;
        gap: 1rem;
    }

    .btn-primary,
    .btn-secondary,
    .btn-danger {
        padding: .6rem 1.2rem;
        border: none;
        border-radius: 6px;
        font-weight: 500;
        cursor: pointer;
        transition: all .2s;
        text-decoration: none;
        display: inline-block;
    }

    .btn-primary {
        background: var(--gold);
        color: white;
    }

    .btn-primary:hover {
        background: #b08530;
    }

    .btn-secondary {
        background: var(--cream);
        color: var(--ink);
    }

    .btn-danger {
        background: var(--error);
        color: white;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-bottom: 3rem;
    }

    .stat-card {
        background: white;
        border: 1px solid var(--border);
        border-radius: 8px;
        padding: 1.5rem;
        text-align: center;
    }

    .stat-label {
        font-size: .85rem;
        color: var(--muted);
        text-transform: uppercase;
        letter-spacing: .05em;
        margin-bottom: .5rem;
    }

    .stat-value {
        font-size: 2.2rem;
        font-weight: 700;
        color: var(--gold);
    }

    .recent-section {
        background: white;
        border: 1px solid var(--border);
        border-radius: 8px;
        overflow: hidden;
    }

    .section-header {
        padding: 1.5rem;
        border-bottom: 1px solid var(--border);
        font-weight: 500;
    }

    .recent-list {
        list-style: none;
        padding: 0;
    }

    .recent-item {
        padding: 1rem 1.5rem;
        border-bottom: 1px solid var(--border);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .recent-item:last-child {
        border-bottom: none;
    }

    .recent-title {
        font-weight: 500;
    }

    .recent-meta {
        font-size: .85rem;
        color: var(--muted);
    }

    @media (max-width: 768px) {
        .sidebar {
            width: 200px;
        }
        .main-content {
            margin-left: 200px;
        }
    }
</style>
@endsection

@section('content')
<div class="admin-wrapper">
    <aside class="sidebar">
        <div class="sidebar-brand">
            <a href="{{ route('article.index') }}">ink<span>well</span></a>
        </div>

        <nav class="sidebar-nav">
            <li><a href="{{ route('admin.dashboard') }}" class="@routeIs('admin.dashboard') active @endrouteIs">📊 Dashboard</a></li>
            <li><a href="{{ route('admin.articles.index') }}" class="@routeIs('admin.articles.*') active @endrouteIs">📝 Articles</a></li>
            <li>
                <form method="POST" action="{{ route('logout') }}" style="display: block; margin-top: 2rem;">
                    @csrf
                    <button type="submit" style="width: 100%; text-align: left; padding: .8rem 1.5rem; background: none; border: none; color: rgba(255,255,255,.7); cursor: pointer; text-decoration: none; transition: all .2s; border-left: 3px solid transparent;">🚪 Logout</button>
                </form>
            </li>
        </nav>
    </aside>

    <main class="main-content">
        <div class="top-bar">
            <h1>Dashboard</h1>
            <div class="top-bar-actions">
                <a href="{{ route('admin.articles.create') }}" class="btn-primary">+ New Article</a>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-label">Total Articles</div>
                <div class="stat-value">{{ $stats['total'] }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Published</div>
                <div class="stat-value">{{ $stats['published'] }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Drafts</div>
                <div class="stat-value">{{ $stats['drafts'] }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Total Views</div>
                <div class="stat-value">{{ number_format($stats['views']) }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Users</div>
                <div class="stat-value">{{ $stats['users'] }}</div>
            </div>
        </div>

        <div class="recent-section">
            <div class="section-header">Recent Articles</div>
            @if($recentArticles->isNotEmpty())
                <ul class="recent-list">
                    @foreach ($recentArticles as $article)
                        <li class="recent-item">
                            <div>
                                <div class="recent-title">{{ $article->title }}</div>
                                <div class="recent-meta">
                                    {{ $article->status }} • {{ $article->created_at->format('M j, Y') }}
                                </div>
                            </div>
                            <div>
                                <a href="{{ route('admin.articles.edit', $article) }}" class="btn-secondary">Edit</a>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @else
                <div style="padding: 2rem; text-align: center; color: var(--muted);">
                    No articles yet. <a href="{{ route('admin.articles.create') }}">Create one</a>
                </div>
            @endif
        </div>
    </main>
</div>
@endsection

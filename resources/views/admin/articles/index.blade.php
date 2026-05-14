@extends('layouts.app')

@section('title', 'Articles')

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

    .btn-primary {
        padding: .6rem 1.2rem;
        background: var(--gold);
        color: white;
        border: none;
        border-radius: 6px;
        font-weight: 500;
        cursor: pointer;
        transition: all .2s;
        text-decoration: none;
        display: inline-block;
    }

    .btn-primary:hover {
        background: #b08530;
    }

    .articles-table {
        width: 100%;
        background: white;
        border: 1px solid var(--border);
        border-radius: 8px;
        overflow: hidden;
    }

    .articles-table th {
        background: var(--cream);
        padding: 1rem;
        text-align: left;
        font-weight: 600;
        border-bottom: 1px solid var(--border);
    }

    .articles-table td {
        padding: 1rem;
        border-bottom: 1px solid var(--border);
    }

    .articles-table tr:last-child td {
        border-bottom: none;
    }

    .article-actions {
        display: flex;
        gap: .5rem;
    }

    .btn-edit,
    .btn-delete {
        padding: .4rem .8rem;
        border: none;
        border-radius: 4px;
        font-size: .85rem;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
        transition: all .2s;
    }

    .btn-edit {
        background: var(--gold);
        color: white;
    }

    .btn-edit:hover {
        background: #b08530;
    }

    .btn-delete {
        background: var(--error);
        color: white;
    }

    .btn-delete:hover {
        background: #a02a1f;
    }

    .status-badge {
        display: inline-block;
        padding: .3rem .6rem;
        border-radius: 50px;
        font-size: .8rem;
        font-weight: 500;
    }

    .status-published {
        background: #d4edda;
        color: #155724;
    }

    .status-draft {
        background: #fff3cd;
        color: #856404;
    }

    .featured-badge {
        display: inline-block;
        padding: .2rem .4rem;
        background: var(--gold);
        color: white;
        border-radius: 3px;
        font-size: .75rem;
        margin-left: .3rem;
    }

    .no-articles {
        padding: 3rem;
        text-align: center;
        color: var(--muted);
        background: white;
        border: 1px solid var(--border);
        border-radius: 8px;
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
            <li><a href="{{ route('admin.dashboard') }}">📊 Dashboard</a></li>
            <li><a href="{{ route('admin.articles.index') }}" class="active">📝 Articles</a></li>
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
            <h1>Articles</h1>
            <a href="{{ route('admin.articles.create') }}" class="btn-primary">+ New Article</a>
        </div>

        @if (session('success'))
            <div class="alert alert-success" style="margin-bottom: 1.5rem;">{{ session('success') }}</div>
        @endif

        @if($articles->isNotEmpty())
            <table class="articles-table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Views</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($articles as $article)
                        <tr>
                            <td>
                                {{ $article->title }}
                                @if($article->featured)
                                    <span class="featured-badge">★ Featured</span>
                                @endif
                            </td>
                            <td>{{ $article->category }}</td>
                            <td>
                                <span class="status-badge status-{{ $article->status }}">
                                    {{ ucfirst($article->status) }}
                                </span>
                            </td>
                            <td>{{ $article->views }}</td>
                            <td>{{ $article->created_at->format('M j, Y') }}</td>
                            <td>
                                <div class="article-actions">
                                    <a href="{{ route('admin.articles.edit', $article) }}" class="btn-edit">Edit</a>
                                    <form method="POST" action="{{ route('admin.articles.destroy', $article) }}" style="display: inline;" onsubmit="return confirm('Are you sure?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-delete">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $articles->links() }}
        @else
            <div class="no-articles">
                <p>No articles yet. <a href="{{ route('admin.articles.create') }}">Create one</a></p>
            </div>
        @endif
    </main>
</div>
@endsection

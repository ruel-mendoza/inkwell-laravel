@extends('layouts.app')

@section('title', 'Create Article')

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

    .form-card {
        background: white;
        border: 1px solid var(--border);
        border-radius: 8px;
        padding: 2rem;
        max-width: 900px;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        display: block;
        margin-bottom: .5rem;
        font-weight: 600;
        color: var(--ink);
    }

    .form-group input,
    .form-group textarea,
    .form-group select {
        width: 100%;
        padding: .8rem;
        border: 1.5px solid var(--border);
        border-radius: 6px;
        font-family: 'DM Sans', sans-serif;
        font-size: .95rem;
        color: var(--ink);
        outline: none;
        transition: border-color .2s;
    }

    .form-group input:focus,
    .form-group textarea:focus,
    .form-group select:focus {
        border-color: var(--gold);
    }

    .form-group textarea {
        resize: vertical;
        min-height: 250px;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
    }

    .form-checkbox {
        display: flex;
        gap: .5rem;
        align-items: center;
        margin-bottom: 1rem;
    }

    .form-checkbox input {
        width: auto;
    }

    .form-help {
        font-size: .85rem;
        color: var(--muted);
        margin-top: .3rem;
    }

    .form-error {
        color: var(--error);
        font-size: .85rem;
        margin-top: .3rem;
    }

    .form-actions {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
    }

    .btn-primary,
    .btn-secondary {
        padding: .8rem 1.5rem;
        border: none;
        border-radius: 6px;
        font-weight: 500;
        cursor: pointer;
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

    .btn-secondary:hover {
        background: var(--border);
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
            <h1>New Article</h1>
        </div>

        <div class="form-card">
            <form method="POST" action="{{ route('admin.articles.store') }}" novalidate>
                @csrf

                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" required>
                    @error('title')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="category">Category</label>
                        <input type="text" name="category" id="category" value="{{ old('category', 'General') }}" required>
                        @error('category')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" id="status" required>
                            <option value="draft" @selected(old('status') === 'draft')>Draft</option>
                            <option value="published" @selected(old('status') === 'published')>Published</option>
                        </select>
                        @error('status')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="excerpt">Excerpt</label>
                    <textarea name="excerpt" id="excerpt" placeholder="A brief summary...">{{ old('excerpt') }}</textarea>
                    @error('excerpt')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="content">Content</label>
                    <textarea name="content" id="content" required>{{ old('content') }}</textarea>
                    @error('content')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="tags">Tags (comma-separated)</label>
                    <input type="text" name="tags" id="tags" value="{{ old('tags') }}" placeholder="e.g., laravel, web, tutorial">
                    <div class="form-help">Separate tags with commas</div>
                    @error('tags')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-checkbox">
                    <input type="checkbox" name="featured" id="featured" @checked(old('featured'))>
                    <label for="featured" style="margin-bottom: 0;">Featured Article</label>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-primary">Create Article</button>
                    <a href="{{ route('admin.articles.index') }}" class="btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </main>
</div>
@endsection

@extends('layouts.app')

@section('title', 'Sign In')

@section('extra_styles')
<style>
    body {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem;
    }

    .page-wrap {
        display: grid;
        grid-template-columns: 1fr 1fr;
        max-width: 900px;
        width: 100%;
        min-height: 520px;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 30px 80px rgba(15,14,12,.18);
    }

    .panel-left {
        background: var(--ink);
        padding: 3.5rem;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        position: relative;
        overflow: hidden;
    }
    .panel-left::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(ellipse at 30% 70%, rgba(201,150,58,.2) 0%, transparent 60%);
    }
    .brand { position: relative; z-index: 1; }
    .brand-mark {
        width: 44px; height: 44px;
        background: var(--gold);
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.4rem;
        margin-bottom: 1.5rem;
    }
    .brand h1 {
        font-family: 'Playfair Display', serif;
        font-size: 2.2rem;
        color: #fff;
        line-height: 1.1;
        margin-bottom: .75rem;
    }
    .brand p {
        color: var(--muted);
        font-size: .9rem;
        font-weight: 300;
        line-height: 1.6;
    }

    .panel-right {
        background: var(--white);
        padding: 3.5rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    .panel-right h2 {
        font-family: 'Playfair Display', serif;
        font-size: 1.8rem;
        margin-bottom: .5rem;
    }
    .panel-right p {
        color: var(--muted);
        margin-bottom: 2rem;
        font-size: .9rem;
    }

    .form-group {
        margin-bottom: 1.2rem;
    }
    .form-group label {
        display: block;
        margin-bottom: .4rem;
        font-weight: 500;
        color: var(--ink);
    }
    .form-group input {
        width: 100%;
        padding: .7rem 1rem;
        border: 1.5px solid var(--border);
        border-radius: 8px;
        font-family: 'DM Sans', sans-serif;
        font-size: .95rem;
        color: var(--ink);
        outline: none;
        transition: border-color .2s;
    }
    .form-group input:focus {
        border-color: var(--gold);
    }

    .form-error {
        color: var(--error);
        font-size: .85rem;
        margin-top: .3rem;
    }

    .btn {
        width: 100%;
        padding: .8rem 1.5rem;
        background: var(--gold);
        color: var(--white);
        border: none;
        border-radius: 8px;
        font-family: 'DM Sans', sans-serif;
        font-weight: 500;
        cursor: pointer;
        transition: background .2s;
    }
    .btn:hover {
        background: #b08530;
    }

    @media (max-width: 768px) {
        .page-wrap {
            grid-template-columns: 1fr;
        }
        .panel-left {
            display: none;
        }
    }
</style>
@endsection

@section('content')
<div class="page-wrap">
    <div class="panel-left">
        <div class="brand">
            <div class="brand-mark">📝</div>
            <h1>Inkwell</h1>
            <p>Your thoughts, beautifully published.</p>
        </div>
    </div>

    <div class="panel-right">
        <h2>Welcome back</h2>
        <p>Sign in to your Inkwell account</p>

        @if ($errors->any())
            <div class="alert alert-error">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('authenticate') }}">
            @csrf

            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" value="{{ old('username') }}" required>
                @error('username')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" required>
                @error('password')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn">Sign in</button>
        </form>

        <p style="margin-top: 1.5rem; font-size: .85rem; color: var(--muted); text-align: center;">
            Demo: admin / password
        </p>
    </div>
</div>
@endsection

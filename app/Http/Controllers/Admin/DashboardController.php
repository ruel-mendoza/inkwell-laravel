<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index()
    {
        $stats = [
            'total' => Article::count(),
            'published' => Article::published()->count(),
            'drafts' => Article::where('status', 'draft')->count(),
            'views' => Article::sum('views'),
            'users' => User::count(),
        ];

        $recentArticles = Article::orderByDesc('created_at')->limit(5)->get();

        return view('admin.dashboard', [
            'stats' => $stats,
            'recentArticles' => $recentArticles,
        ]);
    }
}

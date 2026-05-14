<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Article;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user (demo credentials from original system)
        $admin = User::firstOrCreate(
            ['username' => 'admin'],
            [
                'name' => 'Administrator',
                'email' => 'admin@cms.local',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        // Import articles
        $articles = [
            [
                'title' => 'Welcome to the CMS',
                'slug' => 'welcome-to-the-cms',
                'excerpt' => 'This is your first article. Start managing your content today.',
                'content' => 'Welcome to your new Content Management System! This platform allows you to create, edit, and manage articles with ease. Log in to the admin dashboard to get started.',
                'category' => 'Announcements',
                'tags' => ['welcome', 'cms', 'getting-started'],
                'status' => 'published',
                'featured' => true,
                'cover_image' => '',
                'author_id' => $admin->id,
                'views' => 42,
            ],
            [
                'title' => 'Getting Started with Content Creation',
                'slug' => 'getting-started-with-content-creation',
                'excerpt' => 'Learn how to create compelling articles and manage your records effectively.',
                'content' => 'Content creation is at the heart of any great website. In this article, we\'ll explore best practices for writing engaging content, organizing your articles into categories, and using tags effectively to help readers find what they\'re looking for.',
                'category' => 'Tutorials',
                'tags' => ['tutorial', 'content', 'writing'],
                'status' => 'published',
                'featured' => false,
                'cover_image' => '',
                'author_id' => $admin->id,
                'views' => 19,
            ],
            [
                'title' => 'Draft: Future Plans',
                'slug' => 'draft-future-plans',
                'excerpt' => 'An upcoming article about what\'s next.',
                'content' => 'This is a draft article. It won\'t appear on the public site until published.',
                'category' => 'General',
                'tags' => ['draft', 'plans'],
                'status' => 'draft',
                'featured' => false,
                'cover_image' => '',
                'author_id' => $admin->id,
                'views' => 0,
            ],
        ];

        foreach ($articles as $article) {
            Article::firstOrCreate(
                ['slug' => $article['slug']],
                $article
            );
        }
    }
}

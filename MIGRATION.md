# Migration Guide: PHP to Laravel

This document explains how your original PHP-based Inkwell CMS has been converted to a modern Laravel application.

## What Changed

### Architecture

| Aspect | Before | After |
|--------|--------|-------|
| **Framework** | Vanilla PHP | Laravel 11 |
| **Data Storage** | JSON files | SQLite/MySQL database |
| **Routing** | File-based | Route definitions |
| **Templating** | PHP templates | Blade templates |
| **Authentication** | Session-based | Laravel auth |
| **Structure** | Flat directory | MVC architecture |

### File Organization

**Before:**
```
static/
├── index.php
├── article.php
├── login.php
├── logout.php
├── admin/
│   ├── dashboard.php
│   ├── articles.php
│   └── ...
├── includes/
│   ├── helpers.php
│   ├── admin-header.php
│   └── ...
└── data/
    ├── articles.json
    └── users.json
```

**After:**
```
innkwell-laravel/
├── app/
│   ├── Models/          ← Data models (User, Article)
│   ├── Http/
│   │   ├── Controllers/ ← Business logic (moved from PHP files)
│   │   └── Middleware/  ← Middleware for auth/admin checks
│   └── Providers/       ← Service providers
├── database/
│   ├── migrations/      ← Database schema (replaces JSON)
│   └── seeders/         ← Seeded data (from old JSON)
├── resources/views/     ← Blade templates (replaces PHP templates)
├── routes/web.php       ← All routes defined here
├── public/index.php     ← Single entry point
└── config/              ← Configuration files
```

## Data Migration

### JSON to Database

Your existing JSON data has been automatically converted:

**Users** (`data/users.json` → `users` table)
- ID, name, email, username, password, role maintained
- Table structure created in migration

**Articles** (`data/articles.json` → `articles` table)
- All fields preserved: title, slug, content, category, tags, status, featured, author_id, views, timestamps
- Tags stored as JSON in database column
- Automatically seeded via `DatabaseSeeder`

### Running the Seeder

The migration and seeding happens automatically:

```bash
php artisan migrate
php artisan db:seed
```

This creates all tables and imports your existing data.

## Code Conversion Examples

### Authentication

**Before:**
```php
require_once __DIR__ . '/includes/helpers.php';
startSession();
if (isLoggedIn()) {
    // redirect...
}
```

**After:**
```php
if (Auth::check()) {
    // redirect...
}
```

### Getting Articles

**Before:**
```php
$articles = getArticles(true); // JSON file read
$articles = array_filter($articles, fn($a) => $a['category'] === $cat);
```

**After:**
```php
$articles = Article::published()->where('category', $cat)->get();
```

### Creating Views

**Before:**
```html
<?php foreach ($articles as $article): ?>
    <h2><?= h($article['title']) ?></h2>
<?php endforeach; ?>
```

**After:**
```blade
@foreach ($articles as $article)
    <h2>{{ $article->title }}</h2>
@endforeach
```

## Route Changes

All URLs remain the same for public functionality:

| URL | Before | After |
|-----|--------|-------|
| `/` | index.php | ArticleController@index |
| `/article/{slug}` | article.php | ArticleController@show |
| `/login` | login.php | AuthController@login |
| `/logout` | logout.php | AuthController@logout |
| `/admin/dashboard` | admin/dashboard.php | Admin\DashboardController@index |
| `/admin/articles` | admin/articles.php | Admin\ArticleController@index |

## Key Improvements

### 1. **Database-driven**
- Faster queries with proper indexing
- Easier backups and management
- Support for complex relationships
- Built-in transaction support

### 2. **Better Security**
- Eloquent ORM prevents SQL injection
- Built-in CSRF protection
- Proper password hashing with bcrypt
- Middleware for authentication/authorization

### 3. **Scalability**
- Handle millions of articles efficiently
- Support for multiple databases
- Caching layer built-in
- Queue system for background jobs

### 4. **Developer Experience**
- Blade templating is more powerful
- Route definitions are clear and organized
- Models provide clean data access
- Controllers separate business logic
- Middleware for cross-cutting concerns

### 5. **Maintenance**
- Industry-standard framework
- Large community and ecosystem
- Regular security updates
- Extensive documentation

## Setup Instructions

### Installation

```bash
cd /innkwell-laravel
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan serve
```

### Access

- **Public Site:** http://localhost:8000
- **Admin:** http://localhost:8000/admin/dashboard
- **Login:** admin / password

## Old File to New Location Mapping

| Old File | New Location | New Form |
|----------|--------------|----------|
| index.php | routes/web.php + public/index.blade.php | Routes + View |
| article.php | resources/views/public/show.blade.php | Controller + View |
| login.php | resources/views/auth/login.blade.php | Controller + View |
| logout.php | routes/web.php + AuthController | Controller |
| admin/dashboard.php | Admin\DashboardController | Controller + View |
| admin/articles.php | Admin\ArticleController + views | Controller + Views |
| admin/article-edit.php | Admin\ArticleController@edit | Controller + View |
| includes/helpers.php | App\Models + Controllers | Models + Controllers |
| data/articles.json | database/migrations + seeders | Database |
| data/users.json | database/migrations + seeders | Database |

## Database Commands

```bash
# Create tables
php artisan migrate

# Seed with demo data
php artisan db:seed

# Refresh (drop & recreate)
php artisan migrate:refresh --seed

# Check migration status
php artisan migrate:status

# Create new migration
php artisan make:migration migration_name

# Create new seeder
php artisan make:seeder SeederName
```

## Common Tasks

### Create a New Article (CLI)

```bash
php artisan tinker
>>> $user = User::first();
>>> Article::create([
    'title' => 'My Article',
    'slug' => 'my-article',
    'content' => 'Content here...',
    'category' => 'News',
    'status' => 'published',
    'author_id' => $user->id
]);
```

### Add a New User

```bash
php artisan tinker
>>> User::create([
    'name' => 'John Doe',
    'email' => 'john@example.com',
    'username' => 'johndoe',
    'password' => Hash::make('password'),
    'role' => 'admin'
]);
```

### Export Data

```bash
# Articles as JSON
php artisan tinker
>>> Article::all()->toJson();

# Back up database
cp database/database.sqlite database/database.sqlite.bak
```

## Troubleshooting

### Database Error
```bash
# Ensure database exists
touch database/database.sqlite
php artisan migrate
```

### Missing Tables
```bash
php artisan migrate:refresh
php artisan db:seed
```

### Artisan Commands Not Working
```bash
composer install
php artisan
```

### Permission Errors (Linux/Mac)
```bash
chmod -R 775 storage bootstrap/cache
```

## Next Steps

1. **Install dependencies:** `composer install`
2. **Set up database:** `php artisan migrate:refresh --seed`
3. **Start server:** `php artisan serve`
4. **Visit:** http://localhost:8000
5. **Admin panel:** http://localhost:8000/admin/dashboard
6. **Login:** admin / password

---

For more information, see [README.md](README.md) or visit [Laravel Docs](https://laravel.com/docs)

# Quick Start Guide

## Installation & Setup

### 1. Install Composer Dependencies
```bash
cd c:\Users\RUEL\Local Sites\innkwell-laravel
composer install
```

### 2. Generate Application Key
```bash
php artisan key:generate
```

### 3. Create & Seed Database
```bash
php artisan migrate
php artisan db:seed
```

### 4. Start Development Server
```bash
php artisan serve
```

The application will be available at: **http://localhost:8000**

## Login Credentials

- **Username:** admin
- **Password:** password

## Accessing the Application

### Public Pages
- **Homepage:** http://localhost:8000
- **Article:** http://localhost:8000/article/welcome-to-the-cms

### Admin Panel
- **Dashboard:** http://localhost:8000/admin/dashboard
- **Manage Articles:** http://localhost:8000/admin/articles

## Common Commands

```bash
# Start development server
php artisan serve

# Run migrations
php artisan migrate

# Seed database with demo data
php artisan db:seed

# Fresh migration (clear & rebuild)
php artisan migrate:fresh --seed

# Interactive shell
php artisan tinker

# Clear cache
php artisan cache:clear

# Restart queue
php artisan queue:restart
```

## Project Structure

```
innkwell-laravel/
├── app/                    # Application code
│   ├── Http/Controllers/   # Controllers for handling requests
│   ├── Models/             # Eloquent models (User, Article)
│   └── Providers/          # Service providers
├── database/
│   ├── migrations/         # Database schema files
│   └── seeders/            # Database seeders
├── resources/views/        # Blade templates
├── routes/web.php          # Route definitions
├── config/                 # Configuration files
├── storage/                # Application storage
├── public/                 # Public assets & entry point
└── bootstrap/              # Bootstrap files
```

## Key Files

- **routes/web.php** - All application routes
- **app/Models/User.php** - User model
- **app/Models/Article.php** - Article model
- **app/Http/Controllers/** - Application controllers
- **resources/views/** - Blade templates

## Features

✅ Public article listing  
✅ Article search & filtering by category  
✅ User authentication  
✅ Admin dashboard  
✅ Article management (CRUD)  
✅ Featured articles  
✅ Article tags & categories  
✅ View counter  

## Database

The application uses SQLite by default. Database file: `database/database.sqlite`

To use MySQL instead, edit `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=inkwell
DB_USERNAME=root
DB_PASSWORD=
```

## Documentation

- [Full README](README.md)
- [Migration Guide](MIGRATION.md)
- [Laravel Docs](https://laravel.com/docs)

## Troubleshooting

**Port 8000 already in use?**
```bash
php artisan serve --port=8001
```

**Database not found?**
```bash
php artisan migrate:fresh --seed
```

**Permissions error?**
```bash
chmod -R 775 storage bootstrap/cache
```

---

Ready to go! Start the server with `php artisan serve` and visit http://localhost:8000

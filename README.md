# Inkwell CMS - Laravel Edition

A beautiful, elegant content management system built with Laravel for managing articles and records.

## Features

- 📝 **Article Management** - Create, edit, and manage articles with ease
- 🎯 **Featured Articles** - Highlight important content
- 🏷️ **Categorization & Tags** - Organize content effectively
- 👤 **User Authentication** - Secure admin panel with role-based access
- 📊 **Dashboard** - Quick overview of your content
- 🎨 **Beautiful UI** - Elegant, responsive design
- 🔍 **Search & Filter** - Find articles by category or keyword

## Requirements

- PHP 8.1 or higher
- SQLite or MySQL
- Composer

## Installation

### 1. Clone or Extract the Project

```bash
cd /innkwell-laravel
```

### 2. Install Dependencies

```bash
composer install
```

### 3. Set Up Environment

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Create Database

```bash
php artisan migrate
php artisan db:seed
```

### 5. Start the Development Server

```bash
php artisan serve
```

The application will be available at `http://localhost:8000`

## Default Credentials

**Username:** `admin`  
**Password:** `password`

## Directory Structure

```
innkwell-laravel/
├── app/
│   ├── Console/           - Artisan commands
│   ├── Exceptions/        - Exception handling
│   ├── Http/
│   │   ├── Controllers/   - Application controllers
│   │   ├── Kernel.php     - HTTP kernel
│   │   └── Middleware/    - Custom middleware
│   ├── Models/            - Eloquent models
│   ├── Providers/         - Service providers
│   └── Application.php    - Main application class
├── bootstrap/             - Bootstrap files
├── config/                - Configuration files
├── database/
│   ├── migrations/        - Database migrations
│   └── seeders/           - Database seeders
├── public/                - Public entry point
├── resources/
│   └── views/             - Blade templates
├── routes/                - Route definitions
├── storage/               - Application storage
├── tests/                 - Tests
├── .env                   - Environment variables
└── composer.json          - Project dependencies
```

## Usage

### Public Site

- **Homepage:** `/` - Browse published articles
- **Search:** Use the search bar to find articles by title or excerpt
- **Categories:** Filter articles by category
- **Article:** Click an article to read the full content

### Admin Panel

- **Dashboard:** `/admin/dashboard` - Overview and statistics
- **Articles:** `/admin/articles` - Manage all articles
- **Create:** `/admin/articles/create` - Create new article
- **Edit:** `/admin/articles/{id}/edit` - Edit article
- **Logout:** Post to `/logout` - Sign out

## Database Schema

### Users Table

- id (Primary Key)
- name
- email (Unique)
- username (Unique)
- password
- role (admin, user)
- email_verified_at
- remember_token
- timestamps

### Articles Table

- id (Primary Key)
- title
- slug (Unique)
- excerpt
- content
- category
- tags (JSON)
- status (draft, published)
- featured (Boolean)
- cover_image
- author_id (Foreign Key → users.id)
- views (Integer)
- timestamps

## Development

### Running Migrations

```bash
php artisan migrate
```

### Running Seeders

```bash
php artisan db:seed
```

### Refresh Database (Drop & Recreate)

```bash
php artisan migrate:refresh --seed
```

## Converting from Original Project

This Laravel version replaces the original PHP project with:

- **Eloquent ORM** instead of JSON file storage
- **Blade templating** for dynamic views
- **Laravel routing** for cleaner URLs
- **Built-in authentication** with middleware
- **Database migrations** for schema management
- **Proper MVC architecture** for better maintainability

## Styling

The application uses an elegant color scheme:

- **Ink** (#0f0e0c) - Primary dark color
- **Paper** (#faf8f4) - Primary light color  
- **Gold** (#c9963a) - Accent color
- **Muted** (#8a8070) - Secondary text color

Typography uses:
- **Playfair Display** - Display & headings
- **DM Sans** - Body text
- **DM Serif Text** - Article content

## License

Inkwell CMS is open source software.

## Support

For issues or questions, please refer to the codebase or the original project documentation.

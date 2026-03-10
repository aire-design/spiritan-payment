# Quick Start & Commands Guide

This document lists the most common terminal commands for managing, extending, and debugging the Spiritan Digital Financial Management System.

### 1. Starting the Application

For local development, use Composer's concurrent script to boot the backend and frontend simultaneously:

```bash
composer run dev
```

_(This commands runs `php artisan serve` and `npm run dev` in the background)._

### 2. Database Management (The Professional Way)

Laravel uses **Migrations** instead of raw SQL dumps. This ensures the database can be recreated on any machine with a single command.

If you are setting up the project for the first time, run:

```bash
php artisan migrate --seed
```

_This creates all tables and populates them with initial data (like the Admin account and default classes)._

If you've pulled new code that contains database changes, migrate the structure:

```bash
php artisan migrate
```

If you need to completely reset the database and seed it with realistic dummy data (WARNING: Destructive):

```bash
php artisan migrate:fresh --seed
```

### 3. Creating an Admin Account

#### Method A: Using Seeders (Default)

The easiest way to get started is to use the default seeder which creates administrative roles:

```bash
php artisan db:seed
```

**Default Credentials:**

- **Email:** `admin@spiritan.local`
- **Password:** `password`
- **Role:** Select `Admin` on the login screen.

#### Method B: Using Artisan Tinker (Manual)

To create a custom admin with your own credentials:

1. Run `php artisan tinker`.
2. Execute the following in the shell:

```php
App\Models\User::create([
    'first_name' => 'Admin',
    'last_name' => 'User',
    'email' => 'admin@example.com',
    'phone' => '08000000000',
    'role' => 'super_admin',
    'password' => Hash::make('your-password'),
]);
```

### 4. Parent Account Backfilling

If an administrator uploads students _before_ their parents register on the portal, run this command to safely loop through the database and link any accounts that have perfectly matching email addresses. It is safe to run this on a cron-job nightly or manually:

```bash
php artisan parents:link
```

### 4. Cache Clearing

If the system behaves weirdly, configuration changes aren't taking effect, or views aren't visibly updating:

```bash
php artisan optimize:clear
```

### 5. Managing Paystack Webhooks

When pushing to a live server, you must provide your domain to Paystack's dashboard.

- **Webhook URL:** `https://yourdomain.com/api/paystack/webhook`
- Ensure that the `PAYSTACK_SECRET_KEY` in your `.env` file perfectly matches the one in your dashboard, or the system will reject successful payments as fraudulent.

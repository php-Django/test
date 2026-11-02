# User Portal --- Laravel Interview Preparation Project

A beginner-friendly Laravel project for practising the backend features
commonly discussed in PHP/Laravel interviews.

This project includes:

-   User registration, login and logout
-   An authenticated dashboard
-   Profile viewing and updating
-   Multiple education qualifications for each user
-   HTML welcome emails
-   Asynchronous email delivery using Laravel's database queue
-   A practical Laravel, PHP and Composer command reference

> **Learning note:** This README is written as a step-by-step guide.
> Search this file with `Ctrl+F` for terms such as `CREATE PROJECT`,
> `MIGRATION`, `QUEUE`, `LOGIN`, `TROUBLESHOOTING`, or `INTERVIEW`.

------------------------------------------------------------------------

## Table of contents

1.  [What are we building?](#1-what-are-we-building)
2.  [How the application works](#2-how-the-application-works)
3.  [Requirements](#3-requirements)
4.  [Create the project](#4-create-the-project)
5.  [Configure the database](#5-configure-the-database)
6.  [Generate files with Artisan](#6-generate-files-with-artisan)
7.  [Database design](#7-database-design)
8.  [Models and relationships](#8-models-and-relationships)
9.  [Controllers and routes](#9-controllers-and-routes)
10. [Blade views](#10-blade-views)
11. [Asynchronous welcome email](#11-asynchronous-welcome-email)
12. [Run the project](#12-run-the-project)
13. [Test the features](#13-test-the-features)
14. [Important Laravel commands](#14-important-laravel-commands)
15. [Important PHP and Composer
    commands](#15-important-php-and-composer-commands)
16. [Useful database and debugging
    commands](#16-useful-database-and-debugging-commands)
17. [Interview questions to
    practise](#17-interview-questions-to-practise)
18. [Troubleshooting](#18-troubleshooting)
19. [Production checklist](#19-production-checklist)

------------------------------------------------------------------------

## 1. What are we building?

We are building a small **User Portal**.

A person can create an account, log in, update their profile and save
more than one education qualification.

For example, one user may have:

  Degree   Institution
  -------- --------------------
  10th     ABC School
  12th     XYZ School
  B.Tech   Example University
  MCA      Example Institute

Each education record belongs to one user. One user can have many
education records.

### Features

  -----------------------------------------------------------------------
  Feature                             What it does
  ----------------------------------- -----------------------------------
  Register                            Creates a new user account

  Login                               Checks email and password

  Logout                              Ends the user's session

  Dashboard                           Shows basic account information

  Profile                             Updates name, phone, date of birth
                                      and address

  Education                           Adds, lists, updates and deletes
                                      qualifications

  Welcome email                       Sends an HTML email after
                                      registration

  Queue                               Sends the email in the background,
                                      not during the user's wait
  -----------------------------------------------------------------------

------------------------------------------------------------------------

## 2. How the application works

### Registration flow

1.  The user submits the registration form.
2.  Laravel validates the submitted information.
3.  Laravel saves the user in the `users` table.
4.  Laravel logs the user in and regenerates the session ID.
5.  Laravel places a welcome-email job in the database queue.
6.  The registration request redirects the user to the dashboard.
7.  A separate queue worker reads the job and sends the email through
    SMTP.

**Important:** A queue worker must be running for queued emails to be
processed. The web request does not wait for SMTP delivery, but it still
has to store the queue job successfully.

### Database relationship

``` text
users
-----
id (primary key)
name
email
password
phone
date_of_birth
address
created_at
updated_at
       |
       | one user has many qualifications
       |
       +------------------------------+
                                      |
education_qualifications              |
------------------------              |
id (primary key)                      |
user_id (foreign key) ----------------+
degree
institution
field_of_study
start_year
end_year
grade
created_at
updated_at
```

### Queue flow

``` text
Registration request
        |
        v
Create user in database
        |
        v
Insert email job into jobs table
        |
        +-----------------------> Return response to user
        |
        v
Queue worker reads the job
        |
        v
Send HTML email through SMTP
        |
        v
Job is completed and removed from jobs table
```

------------------------------------------------------------------------

## 3. Requirements

Install these tools before starting:

-   PHP 8.3 or later for Laravel 13
-   Composer
-   MySQL
-   A terminal (PowerShell, Command Prompt, Linux terminal, or macOS
    Terminal)
-   A code editor such as VS Code

Check the installed versions:

``` bash
php -v
composer --version
```

Check that PHP has the extensions required by your Laravel installation.
Common extensions include `openssl`, `pdo`, `pdo_mysql`, `mbstring`,
`tokenizer`, `xml`, `ctype`, `curl`, `fileinfo` and `zip`.

Check the Laravel version after creating the project:

``` bash
php artisan --version
```

> **Version note:** Laravel releases have different PHP requirements. If
> your PHP version cannot run Laravel 13, install a Laravel major
> version compatible with your PHP version. Do not blindly copy a
> version number from an old tutorial.

------------------------------------------------------------------------

## 4. CREATE PROJECT --- Create a Laravel project

### Step 1: Create the project with Composer

``` bash
composer create-project laravel/laravel user-portal
```

Composer downloads Laravel and installs the project's PHP dependencies.

### Step 2: Enter the project folder

``` bash
cd user-portal
```

### Step 3: Generate the application key

``` bash
php artisan key:generate
```

Laravel uses the application key for encryption-related features.

### Step 4: Start the development server

``` bash
php artisan serve
```

Open the URL printed in the terminal, normally:

``` text
http://127.0.0.1:8000
```

Keep this terminal open while using the development server. Press
`Ctrl+C` to stop it.

------------------------------------------------------------------------

## 5. DATABASE --- Configure MySQL

### Step 1: Create the database

Run this in MySQL:

``` sql
CREATE DATABASE user_portal;
```

### Step 2: Configure `.env`

Open the `.env` file in the project root and set your database details:

``` dotenv
APP_NAME="User Portal"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=user_portal
DB_USERNAME=root
DB_PASSWORD=
```

Change the username and password to match your own MySQL installation.

### Step 3: Clear cached configuration

``` bash
php artisan config:clear
```

### Step 4: Run migrations

``` bash
php artisan migrate
```

A **migration** is a version-controlled PHP file that describes a
database change, such as creating a table or adding a column.

Useful migration commands:

``` bash
php artisan migrate:status
php artisan migrate
php artisan migrate:rollback
php artisan migrate:refresh
php artisan migrate:fresh
```

**Warning:** `migrate:fresh` drops all tables and recreates them. It
deletes existing table data. Never run it on a database whose data you
need to keep.

------------------------------------------------------------------------

## 6. ARTISAN GENERATORS --- Generate models, migrations and controllers

Artisan is Laravel's command-line tool. It helps generate files and run
common application tasks.

Run these commands from the project root.

### Models and migrations

``` bash
php artisan make:model EducationQualification -m
php artisan make:migration add_profile_fields_to_users_table --table=users
```

What do the options mean?

-   `make:model` creates an Eloquent model.
-   `-m` also creates a migration.
-   `make:migration` creates a migration file.
-   `--table=users` tells Laravel which existing table the migration
    will change.

Laravel already provides a `User` model and a users-table migration in a
normal new application.

### Controllers

``` bash
php artisan make:controller Auth/RegisterController
php artisan make:controller Auth/LoginController
php artisan make:controller DashboardController
php artisan make:controller ProfileController
php artisan make:controller EducationController
```

### Mail class

``` bash
php artisan make:mail WelcomeMail
```

### Queue migrations

Check whether the jobs and failed-jobs migrations already exist before
generating them.

``` bash
php artisan make:queue-table
php artisan make:queue-failed-table
```

If your Laravel version does not recognise one of these commands, check
the available commands:

``` bash
php artisan list
php artisan help make:queue-table
```

### Create view folders

Linux/macOS/Git Bash:

``` bash
mkdir -p resources/views/layouts
mkdir -p resources/views/auth
mkdir -p resources/views/profile
mkdir -p resources/views/emails
```

Windows PowerShell:

``` powershell
New-Item -ItemType Directory -Force resources/views/layouts
New-Item -ItemType Directory -Force resources/views/auth
New-Item -ItemType Directory -Force resources/views/profile
New-Item -ItemType Directory -Force resources/views/emails
```

------------------------------------------------------------------------

## 7. DATABASE DESIGN --- Tables and migrations

The project uses these main tables:

  Table                        Purpose
  ---------------------------- --------------------------------------------------
  `users`                      User account and profile information
  `education_qualifications`   Multiple education records per user
  `jobs`                       Pending queued jobs, including welcome emails
  `failed_jobs`                Jobs that failed after their configured attempts

Depending on the Laravel version and queue configuration, additional
queue-related tables may be available.

### Add profile columns to `users`

Migration file:

`database/migrations/xxxx_xx_xx_xxxxxx_add_profile_fields_to_users_table.php`

``` php
public function up(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->string('phone', 20)->nullable();
        $table->date('date_of_birth')->nullable();
        $table->text('address')->nullable();
    });
}

public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn([
            'phone',
            'date_of_birth',
            'address',
        ]);
    });
}
```

### Create `education_qualifications`

Migration file:

`database/migrations/xxxx_xx_xx_xxxxxx_create_education_qualifications_table.php`

``` php
public function up(): void
{
    Schema::create('education_qualifications', function (Blueprint $table) {
        $table->id();

        $table->foreignId('user_id')
            ->constrained()
            ->cascadeOnDelete();

        $table->string('degree');
        $table->string('institution');
        $table->string('field_of_study')->nullable();
        $table->year('start_year')->nullable();
        $table->year('end_year')->nullable();
        $table->string('grade')->nullable();

        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('education_qualifications');
}
```

### Understand the foreign key

``` php
$table->foreignId('user_id')
    ->constrained()
    ->cascadeOnDelete();
```

-   `foreignId('user_id')` creates the user ID column.
-   `constrained()` links it to the `id` column of the `users` table.
-   `cascadeOnDelete()` automatically deletes a user's education records
    if that user is deleted.

### Run migrations

``` bash
php artisan migrate
```

------------------------------------------------------------------------

## 8. MODELS --- Eloquent relationships

### User model

File: `app/Models/User.php`

Add the profile columns to the existing `$fillable` property. Keep the
existing Laravel traits, casts and other configuration.

``` php
protected $fillable = [
    'name',
    'email',
    'password',
    'phone',
    'date_of_birth',
    'address',
];

public function educationQualifications()
{
    return $this->hasMany(EducationQualification::class);
}
```

### EducationQualification model

File: `app/Models/EducationQualification.php`

``` php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EducationQualification extends Model
{
    protected $fillable = [
        'degree',
        'institution',
        'field_of_study',
        'start_year',
        'end_year',
        'grade',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
```

### Understand the relationships

In `User.php`:

``` php
return $this->hasMany(EducationQualification::class);
```

This means one user can have many education records.

In `EducationQualification.php`:

``` php
return $this->belongsTo(User::class);
```

This means each education record belongs to one user.

### Why create through the relationship?

``` php
Auth::user()->educationQualifications()->create($validated);
```

Laravel automatically fills in the authenticated user's ID. It also
helps prevent a user from creating an education record for another user.

------------------------------------------------------------------------

## 9. CONTROLLERS AND ROUTES

### Controllers

Generate the controllers:

``` bash
php artisan make:controller Auth/RegisterController
php artisan make:controller Auth/LoginController
php artisan make:controller DashboardController
php artisan make:controller ProfileController
php artisan make:controller EducationController
```

The controllers handle the application logic:

  Controller              Responsibility
  ----------------------- ----------------------------------------------
  `RegisterController`    Validate and register a user
  `LoginController`       Login and logout
  `DashboardController`   Show dashboard data
  `ProfileController`     Display and update profile
  `EducationController`   Add, edit, list and delete education records

### Routes

File: `routes/web.php`

``` php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EducationController;

Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'create'])
        ->name('register');

    Route::post('/register', [RegisterController::class, 'store'])
        ->name('register.store');

    Route::get('/login', [LoginController::class, 'create'])
        ->name('login');

    Route::post('/login', [LoginController::class, 'store'])
        ->name('login.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::post('/logout', [LoginController::class, 'destroy'])
        ->name('logout');

    Route::get('/profile', [ProfileController::class, 'index'])
        ->name('profile');

    Route::put('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::get('/education', [EducationController::class, 'index'])
        ->name('education.index');

    Route::post('/education', [EducationController::class, 'store'])
        ->name('education.store');

    Route::put('/education/{id}', [EducationController::class, 'update'])
        ->name('education.update');

    Route::delete('/education/{id}', [EducationController::class, 'destroy'])
        ->name('education.destroy');
});
```

### What is middleware?

Middleware filters an incoming HTTP request before it reaches the
controller.

-   `guest`: intended for visitors who are not logged in.
-   `auth`: protects routes so only authenticated users can access them.

### Check all routes

``` bash
php artisan route:list
```

Filter routes where supported:

``` bash
php artisan route:list --path=profile
php artisan route:list --path=education
php artisan route:list --name=login
```

------------------------------------------------------------------------

## 10. BLADE VIEWS --- User interface

Create these Blade files:

``` text
resources/views/
├── layouts/
│   └── app.blade.php
├── auth/
│   ├── register.blade.php
│   └── login.blade.php
├── dashboard.blade.php
├── profile/
│   ├── index.blade.php
│   └── education.blade.php
└── emails/
    └── welcome.blade.php
```

The views are responsible for displaying HTML to the user.

### What is Blade?

Blade is Laravel's templating engine. A Blade file usually ends in
`.blade.php`.

Common Blade syntax:

``` php
{{-- Comment --}}

{{ $user->name }}

@if($user)
    <p>User exists</p>
@else
    <p>User not found</p>
@endif

@foreach($users as $user)
    <p>{{ $user->name }}</p>
@endforeach

@csrf

@method('PUT')

@extends('layouts.app')

@section('content')
    <h1>Welcome</h1>
@endsection
```

### Important form concepts

``` html
<form method="POST" action="/profile">
    @csrf
    @method('PUT')
</form>
```

-   `@csrf` adds a CSRF token to protect the form.
-   HTML forms do not directly support `PUT`, `PATCH` or `DELETE`.
-   `@method('PUT')` tells Laravel to treat the POST form as a PUT
    request.

Use `{{ }}` to display escaped user data. Avoid printing untrusted user
input using `{!! !!}`.

------------------------------------------------------------------------

## 11. QUEUE --- Send the HTML welcome email asynchronously

This is an important interview topic.

### Step 1: Generate the Mailable

``` bash
php artisan make:mail WelcomeMail
```

File: `app/Mail/WelcomeMail.php`

``` php
<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WelcomeMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $afterCommit = true;

    public function __construct(public User $user)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Welcome to User Portal!'
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.welcome'
        );
    }
}
```

### Step 2: Create the HTML email view

File: `resources/views/emails/welcome.blade.php`

``` html
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
</head>
<body style="margin:0; padding:30px; background:#f4f4f4;
             font-family:Arial,sans-serif;">

    <div style="max-width:600px; margin:auto; background:white;
                padding:30px; border-radius:8px;">

        <h2 style="color:#2563eb;">Welcome to User Portal!</h2>

        <p>Hello {{ $user->name }},</p>

        <p>Thank you for registering with us.
           Your account has been successfully created.</p>

        <p>You can now log in and manage your profile
           and education qualifications.</p>

        <p>Regards,<br><strong>User Portal Team</strong></p>
    </div>

</body>
</html>
```

### Step 3: Configure the queue

In `.env`:

``` dotenv
QUEUE_CONNECTION=database
```

Generate queue migrations if they are not already present:

``` bash
php artisan make:queue-table
php artisan make:queue-failed-table
```

Run migrations:

``` bash
php artisan migrate
```

### Step 4: Configure SMTP

Example `.env` settings for Gmail:

``` dotenv
MAIL_MAILER=smtp
MAIL_SCHEME=tls
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-gmail-app-password

MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```

Use a Gmail App Password if your account supports it. Do not commit real
mail credentials to Git.

### Step 5: Dispatch the welcome email

In the registration controller:

``` php
Mail::to($user->email)->queue(
    new WelcomeMail($user)
);
```

The `WelcomeMail` class implements `ShouldQueue`, and `queue()`
explicitly dispatches it to the queue.

### Step 6: Run the worker

Open a second terminal:

``` bash
php artisan queue:work database --tries=3 --timeout=90
```

The worker keeps checking for jobs and processes them.

### Step 7: Inspect failed jobs

``` bash
php artisan queue:failed
php artisan queue:retry all
php artisan queue:forget 1
php artisan queue:flush
```

Be careful: `queue:flush` removes all failed-job records. It does not
retry them.

### Important queue interview concepts

  -----------------------------------------------------------------------
  Term                                Meaning
  ----------------------------------- -----------------------------------
  Queue                               A place where jobs wait to be
                                      processed

  Job                                 A unit of background work

  Worker                              A process that takes jobs from a
                                      queue

  `ShouldQueue`                       Marks a job or queued Mailable for
                                      asynchronous processing

  Retry                               Attempts a failed job again

  Failed job                          A job that exhausted its allowed
                                      attempts

  Database driver                     Stores queued jobs in a database
                                      table

  Redis driver                        Stores queue data in Redis
  -----------------------------------------------------------------------

**Production note:** A database queue still needs a running worker. Use
Supervisor or systemd to keep the worker alive on a server. Configure
worker timeout, retry-after and process limits consistently.

------------------------------------------------------------------------

## 12. RUN PROJECT --- Start everything

Use two terminals.

### Terminal 1: Laravel web server

``` bash
php artisan serve
```

### Terminal 2: Queue worker

``` bash
php artisan queue:work database --tries=3 --timeout=90
```

Open:

``` text
http://127.0.0.1:8000
```

Useful URLs:

  Page        URL
  ----------- --------------
  Register    `/register`
  Login       `/login`
  Dashboard   `/`
  Profile     `/profile`
  Education   `/education`

------------------------------------------------------------------------

## 13. TESTING --- Check that the features work

### Manual test checklist

-   [ ] Register a new user.
-   [ ] Confirm the user exists in the `users` table.
-   [ ] Confirm a job appears in the `jobs` table.
-   [ ] Confirm registration redirects without waiting for SMTP
    delivery.
-   [ ] Confirm the queue worker sends the email.
-   [ ] Check the HTML email in the inbox.
-   [ ] Log out.
-   [ ] Log in with the new account.
-   [ ] Update the profile.
-   [ ] Add two or more education qualifications.
-   [ ] Confirm both qualifications are linked to the logged-in user.
-   [ ] Edit a qualification.
-   [ ] Delete a qualification.
-   [ ] Try to access another user's qualification by changing the
    record ID.
-   [ ] Try to open the dashboard while logged out.

### Generate a test file

``` bash
php artisan make:test RegistrationTest
php artisan make:test ProfileTest
php artisan make:test EducationTest
```

Run all tests:

``` bash
php artisan test
```

Run one test file:

``` bash
php artisan test tests/Feature/RegistrationTest.php
```

Run tests with more detailed output:

``` bash
php artisan test --testdox
```

A good automated test should verify not just the response, but also
database changes and authorization.

------------------------------------------------------------------------

## 14. LARAVEL COMMANDS --- Developer command reference

Search for the command you need with `Ctrl+F`.

### A. Project and application information

``` bash
php artisan
php artisan list
php artisan --version
php artisan about
php artisan env
```

### B. Generate common files

``` bash
php artisan make:model Product
php artisan make:model Product -m
php artisan make:model Product -mc
php artisan make:model Product -mcr
php artisan make:controller ProductController
php artisan make:controller ProductController --resource
php artisan make:middleware CheckRole
php artisan make:request StoreProductRequest
php artisan make:service ProductService
php artisan make:job ProcessProduct
php artisan make:event ProductCreated
php artisan make:listener SendProductNotification
php artisan make:notification ProductNotification
php artisan make:mail OrderMail
php artisan make:command ImportProducts
php artisan make:seeder ProductSeeder
php artisan make:factory ProductFactory
php artisan make:test ProductTest
php artisan make:test ProductTest --unit
```

**Note:** `make:service` is not included in every Laravel installation.
If Artisan says the command does not exist, create the service PHP class
manually or use a project-specific generator.

Some useful option meanings:

  Option   Meaning
  -------- --------------------------------
  `-m`     Generate a migration
  `-c`     Generate a controller
  `-f`     Generate a factory
  `-s`     Generate a seeder
  `-r`     Generate a resource controller

### C. Database and migrations

``` bash
php artisan migrate
php artisan migrate:status
php artisan migrate:rollback
php artisan migrate:rollback --step=2
php artisan migrate:refresh
php artisan migrate:fresh
php artisan migrate:fresh --seed
php artisan db:seed
php artisan db:seed --class=UserSeeder
php artisan make:migration add_status_to_orders_table --table=orders
```

Remember: `migrate:fresh` deletes all existing tables before rebuilding
them.

### D. Routes

``` bash
php artisan route:list
php artisan route:list --path=api
php artisan route:list --path=admin
php artisan route:list --name=users
php artisan route:clear
php artisan route:cache
```

### E. Cache and configuration

``` bash
php artisan cache:clear
php artisan config:clear
php artisan config:cache
php artisan route:clear
php artisan route:cache
php artisan view:clear
php artisan view:cache
php artisan optimize:clear
php artisan optimize
```

Do not cache configuration while expecting Laravel to read newly changed
`.env` values. Run `config:clear` during local troubleshooting, then
rebuild the cache when deploying.

### F. Queue commands

``` bash
php artisan queue:work
php artisan queue:work database
php artisan queue:work --queue=high,default
php artisan queue:work --tries=3
php artisan queue:work --timeout=90
php artisan queue:listen
php artisan queue:restart
php artisan queue:failed
php artisan queue:retry all
php artisan queue:retry 5
php artisan queue:forget 5
php artisan queue:flush
```

`queue:restart` asks workers to restart after their current job. A
process manager should start them again.

### G. Storage and files

``` bash
php artisan storage:link
php artisan make:filesystem
```

`storage:link` creates the public storage symbolic link when the
application uses the standard public disk.

### H. Maintenance and application tasks

``` bash
php artisan down
php artisan up
php artisan schedule:list
php artisan schedule:run
php artisan event:list
php artisan clear-compiled
php artisan serve --host=0.0.0.0 --port=8000
```

Do not expose the development server publicly as a production web
server.

### I. Artisan Tinker

Tinker opens an interactive PHP shell with Laravel loaded.

``` bash
php artisan tinker
```

Example commands inside Tinker:

``` php
App\Models\User::count();

App\Models\User::first();

App\Models\User::where('email', 'test@example.com')->first();

App\Models\User::with('educationQualifications')->first();

$user = App\Models\User::first();

$user->educationQualifications()->count();

$user->educationQualifications()->create([
    'degree' => 'B.Tech',
    'institution' => 'Example University',
    'field_of_study' => 'Computer Science',
    'start_year' => 2020,
    'end_year' => 2024,
    'grade' => '8.5 CGPA',
]);
```

Exit Tinker:

``` php
exit
```

------------------------------------------------------------------------

## 15. PHP AND COMPOSER COMMANDS

### A. PHP commands

``` bash
php -v
php --ini
php -m
php -i
php -l app/Http/Controllers/ProfileController.php
php artisan --version
```

  Command             Meaning
  ------------------- ----------------------------------------------
  `php -v`            Shows PHP version
  `php --ini`         Shows loaded php.ini file
  `php -m`            Lists PHP extensions
  `php -i`            Shows PHP configuration
  `php -l file.php`   Checks PHP syntax without executing the file

### B. Composer commands

``` bash
composer --version
composer install
composer update
composer require vendor/package
composer require --dev vendor/package
composer remove vendor/package
composer dump-autoload
composer validate
composer show
composer show laravel/framework
composer outdated
composer diagnose
composer clear-cache
```

Understand the difference:

  -----------------------------------------------------------------------
  Command                             What it does
  ----------------------------------- -----------------------------------
  `composer install`                  Installs dependencies from the lock
                                      file when available

  `composer update`                   Resolves and updates dependencies,
                                      potentially changing the lock file

  `composer require`                  Adds a package to the project

  `composer remove`                   Removes a package

  `composer dump-autoload`            Regenerates Composer's autoloader

  `composer validate`                 Checks composer.json and lock-file
                                      consistency

  `composer show`                     Lists installed packages

  `composer outdated`                 Shows packages with newer versions
                                      available
  -----------------------------------------------------------------------

**Interview tip:** In deployment, prefer `composer install` with the
committed `composer.lock`. Do not casually run `composer update` on a
production server.

### C. Basic Git commands

``` bash
git init
git status
git add .
git add README.md
git commit -m "Initial Laravel user portal"
git branch
git switch -c feature/profile
git log --oneline
git diff
git pull
git push
git remote -v
```

Before pushing to GitHub, make sure `.env` and secrets are not
committed. Laravel projects normally include `.env` in `.gitignore`.

------------------------------------------------------------------------

## 16. DATABASE AND DEBUGGING COMMANDS

### MySQL commands

``` sql
SHOW DATABASES;
USE user_portal;
SHOW TABLES;
DESCRIBE users;
DESCRIBE education_qualifications;
SELECT * FROM users;
SELECT * FROM education_qualifications;
SELECT COUNT(*) FROM users;
```

Find education records for one user:

``` sql
SELECT *
FROM education_qualifications
WHERE user_id = 1;
```

Count qualifications per user:

``` sql
SELECT user_id, COUNT(*) AS total_qualifications
FROM education_qualifications
GROUP BY user_id;
```

### Laravel logs

Laravel's usual application log location is:

``` text
storage/logs/laravel.log
```

Linux/macOS:

``` bash
tail -f storage/logs/laravel.log
tail -n 100 storage/logs/laravel.log
```

PowerShell:

``` powershell
Get-Content storage/logs/laravel.log -Tail 100
Get-Content storage/logs/laravel.log -Wait
```

### Check configuration

``` bash
php artisan about
php artisan config:show database
php artisan config:show queue
php artisan config:show mail
```

Some commands and options vary by Laravel version. Use
`php artisan help command-name` to inspect the exact syntax available in
your installed version.

### Common troubleshooting

  -----------------------------------------------------------------------
  Problem                             First things to check
  ----------------------------------- -----------------------------------
  Database connection refused         MySQL service, DB_HOST, DB_PORT and
                                      credentials

  Table does not exist                Run `php artisan migrate`

  Changes in `.env` not applied       Run `php artisan config:clear`

  Class not found                     Check namespace and run
                                      `composer dump-autoload`

  Route not found                     Run `php artisan route:list`

  View not found                      Check the Blade file path and name

  Email not sending                   Check SMTP credentials, queue
                                      worker and failed jobs

  Job remains in `jobs`               Check that a queue worker is
                                      running

  Permission denied                   Check ownership and permissions of
                                      `storage` and `bootstrap/cache`

  419 Page Expired                    Check that the form includes
                                      `@csrf` and the session is working
  -----------------------------------------------------------------------

------------------------------------------------------------------------

## 17. INTERVIEW PREPARATION --- Questions to practise

Try answering these in your own words before reading documentation.

### Laravel basics

1.  What is Laravel?
2.  What is MVC architecture?
3.  What is the purpose of `routes/web.php`?
4.  What is the difference between a controller and a model?
5.  What is Artisan?
6.  What is Composer?
7.  What is the purpose of `.env`?
8.  What is the service container?
9.  What are service providers?
10. What is middleware?

### Database and Eloquent

11. What is a migration?
12. What is a seeder?
13. What is a factory?
14. What is Eloquent ORM?
15. What is the difference between `hasOne`, `hasMany`, `belongsTo` and
    `belongsToMany`?
16. What is eager loading?
17. What is the N+1 query problem?
18. What is mass assignment?
19. What is `$fillable`?
20. What is a foreign key?
21. What is a database transaction?
22. What is the difference between `DB::table()` and Eloquent?

### Authentication and security

23. What is authentication?
24. What is authorization?
25. What is the difference between `auth` and `guest` middleware?
26. Why should passwords be hashed?
27. What is CSRF protection?
28. Why should the session ID be regenerated after login?
29. Why should one user's records be scoped to that user?
30. What is SQL injection and how does Laravel help prevent it?

### Queue and email

31. What is a queue?
32. Why should emails be sent asynchronously?
33. What is a queue worker?
34. What does `ShouldQueue` mean?
35. What is the difference between `dispatch()` and `dispatchSync()`?
36. What happens when a job fails?
37. What are retries and backoff?
38. What is the difference between database and Redis queue drivers?
39. Why should queue workers be supervised in production?
40. What does `afterCommit` do?

### PHP and Composer

41. What is the difference between an interface and an abstract class?
42. What are traits in PHP?
43. What is dependency injection?
44. What are namespaces?
45. What is autoloading?
46. What is PSR-4?
47. What is the difference between `==` and `===`?
48. What is the difference between `include` and `require`?
49. What are exceptions?
50. What is the difference between `composer install` and
    `composer update`?

### Practical interview exercises

Try implementing these without looking at the solution:

-   Add a profile-photo upload.
-   Add email verification.
-   Add password reset.
-   Add pagination to the education list.
-   Search education qualifications by degree.
-   Add a new `skills` table with a many-to-many relationship.
-   Add a queued notification when a profile is updated.
-   Write a feature test that prevents one user from editing another
    user's education record.
-   Use a database transaction when a process needs multiple related
    database writes.
-   Add login rate limiting.

------------------------------------------------------------------------

## 18. TROUBLESHOOTING --- Quick command finder

  If you want to...              Run
  ------------------------------ ----------------------------------------------
  See all Artisan commands       `php artisan list`
  Know Laravel version           `php artisan --version`
  Know PHP version               `php -v`
  Find active php.ini            `php --ini`
  See all routes                 `php artisan route:list`
  Create a model                 `php artisan make:model ModelName`
  Create a model and migration   `php artisan make:model ModelName -m`
  Create a controller            `php artisan make:controller NameController`
  Create a migration             `php artisan make:migration migration_name`
  Run migrations                 `php artisan migrate`
  Check migration status         `php artisan migrate:status`
  Clear Laravel caches           `php artisan optimize:clear`
  Rebuild config cache           `php artisan config:cache`
  Start the web server           `php artisan serve`
  Start the queue worker         `php artisan queue:work`
  Open Tinker                    `php artisan tinker`
  Run tests                      `php artisan test`
  Watch Laravel logs             `tail -f storage/logs/laravel.log`

------------------------------------------------------------------------

## 19. PRODUCTION CHECKLIST

Before deploying this project:

-   [ ] Set `APP_ENV=production`.
-   [ ] Set `APP_DEBUG=false`.
-   [ ] Use a strong, private `APP_KEY`.
-   [ ] Configure production database credentials securely.
-   [ ] Configure real SMTP credentials or a mail provider.
-   [ ] Set `QUEUE_CONNECTION` to the chosen production queue driver.
-   [ ] Keep queue workers running with Supervisor or systemd.
-   [ ] Configure failed-job monitoring and retry policy.
-   [ ] Run migrations as a planned deployment step.
-   [ ] Run `composer install --no-dev --optimize-autoloader`.
-   [ ] Run `php artisan optimize`.
-   [ ] Configure the web server document root to Laravel's `public`
    directory.
-   [ ] Enable HTTPS.
-   [ ] Ensure `storage` and `bootstrap/cache` have correct permissions.
-   [ ] Add rate limiting to login and registration.
-   [ ] Add email verification if required.
-   [ ] Test authorization for every user-owned record.
-   [ ] Back up the database.
-   [ ] Never commit `.env`, passwords, API keys or SMTP credentials.

------------------------------------------------------------------------

## Final learning advice

Do not just memorise commands. For every feature, learn this sequence:

1.  **Route:** Which URL receives the request?
2.  **Middleware:** Is the user allowed to access it?
3.  **Controller:** What business logic runs?
4.  **Validation:** Is the submitted data valid?
5.  **Model:** How does Laravel interact with the database?
6.  **Migration:** What is the database structure?
7.  **View:** What does the user see?
8.  **Test:** How do we prove that it works?

If you can explain and implement that flow, you will be much more
prepared for a Laravel backend interview.

Happy learning!

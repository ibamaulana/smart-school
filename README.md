# smart-school
Smart School by ibamaulana

## Features

- Laravel 8
- Vue + VueRouter + Vuex + VueI18n + ESlint
- Pages with dynamic import and custom layouts
- Login, register, email verification and password reset
- Authentication with JWT
- Socialite integration
- Bootstrap 4 + Font Awesome 5

## Installation

- `composer install`
- Edit `.env` and set your database connection details
- `php artisan key:generate` and `php artisan jwt:secret`
- `php artisan migrate`
- `php artisan db:seed` (seeding for role)
- `npm install`

## Usage

#### Development

```bash
# Build and watch
npm run watch

# Serve with hot reloading (not working)
npm run hot
```

#### Production

```bash
npm run production
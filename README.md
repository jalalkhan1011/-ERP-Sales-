## Project Overview

-   এই ERP Module-টি একটি Sales Management System, যা Laravel ভিত্তিক।
-   এটি ব্যবহার করে আপনি:

    -   Customer & Product Management করতে পারবেন

    -   Sales Entry করতে পারবেন (Multi Product, Qty, Price, Discount সহ)

    -   Notes (Sale বা Product ভিত্তিক) Add করতে পারবেন

    -   Sales Soft Delete → Trash & Restore করতে পারবেন

    -   Sales Edit & Update করতে পারবেন

    -   Search, Filter এবং Pagination ব্যবহার করতে পারবেন

1.  System Requirements

    - PHP 8.2+
    - Laravel 12
    - MySQL 8+
    - Composer
    - Node.js & NPM (Bootstrap ব্যবহার করলে optional)

2.  Installation Steps
    # 1. Clone the repository
        - git clone https://github.com/your-repo/erp-sales-module.gi
    # 2. Enter project folder
        - cd erp-sales-module
    # 3. Install dependencies
        - composer install
    # 4. Copy environment file
        - cp .env.example .env
    # 5. Configure .env (DB credentials)
        - DB_DATABASE=erp_sales
        - DB_USERNAME=root
        - DB_PASSWORD=
    # 6. Generate app key
        - php artisan key:generate
    # 7. Run migrations (with seeders if needed)
        - php artisan migrate --seed
    # 8. Serve the application
        - php artisan serve
3.  Database Structure

    - Table Description
    - customers Stores customer information
    - products Stores product details (price, stock)
    - sales Stores sales overview (customer, total, date)
    - sale_items Stores product-wise sale details
    - notes Polymorphic table for notes (sale/product)

4.  Routes Overview

    # Sales CRUD + Soft Delete

    - Route::resource('sales', SaleController::class);

    # Trash View & Restore

    - Route::get('sales/trash', [SaleController::class,'trash'])->name('sales.trash');
    - Route::patch('sales/restore/{id}', [SaleController::class,'restore'])->name('sales.restore');

    # Customers & Products

    - Route::resource('customers', CustomerController::class);
    - Route::resource('products', ProductController::class);

5.  Features Implemented

    - Sales Management

        - Add multiple products in a single sale
        - Auto price fill when product selected
        - Qty × Price − Discount → Subtotal auto calculate
        - Total amount auto calculate
        - AJAX form submit (no page reload)

    - Notes System

        - Polymorphic Notes for Sale & Product
        - Show notes in Edit page
        - Update/Delete notes properly

    - Soft Delete & Trash

        - Sales delete → goes to Trash
        - Trash list view
        - Restore sales from Trash

    - Search & Filter
        - Filter sales by customer, product, date
        - Paginated results with total sum

6.  UI

    - Bootstrap 5 used for layout & styling
    - Alerts (Success/Error) on actions

7.  How to Use
    1️⃣ Create some Customers & Products.
    2️⃣ Go to Sales → New Sale to create a sale.
    3️⃣ Add multiple products dynamically, set qty, price, discount → total auto update.
    4️⃣ Save sale → success message shown.
    5️⃣ Edit sale → modify items & note.
    6️⃣ Delete sale → moves to Trash.
    7️⃣ Restore sale from Trash if needed.
8.  Bonus Features

    - Eloquent Relationships optimized (with with() to avoid N+1)
    - Polymorphic Notes
    - AJAX powered forms

9.  Ready to Run!
    - php artisan serve
    - Then open → http://127.0.0.1:8000
10. login credential - User-> admin@example.com - Password -> 123456789
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

-   [Simple, fast routing engine](https://laravel.com/docs/routing).
-   [Powerful dependency injection container](https://laravel.com/docs/container).
-   Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
-   Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
-   Database agnostic [schema migrations](https://laravel.com/docs/migrations).
-   [Robust background job processing](https://laravel.com/docs/queues).
-   [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

-   **[Vehikl](https://vehikl.com)**
-   **[Tighten Co.](https://tighten.co)**
-   **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
-   **[64 Robots](https://64robots.com)**
-   **[Curotec](https://www.curotec.com/services/technologies/laravel)**
-   **[DevSquad](https://devsquad.com/hire-laravel-developers)**
-   **[Redberry](https://redberry.international/laravel-development)**
-   **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

# 🛒 SmartCart - E-Commerce Website

## MarketNest | Modern Clothing Store

![Laravel](https://img.shields.io/badge/Laravel-12.x-red?style=flat-square&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.2-blue?style=flat-square&logo=php)
![MySQL](https://img.shields.io/badge/MySQL-8.0-orange?style=flat-square&logo=mysql)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-purple?style=flat-square&logo=bootstrap)
![License](https://img.shields.io/badge/License-MIT-green?style=flat-square)

## 📌 Live Demo

- https://drive.google.com/file/d/1awVbdx3SOhCcT6ECUwgPgOSJkTpRs9Xh/view?usp=sharing

## 📋 Table of Contents

- [Features](#-features)
- [Tech Stack](#-tech-stack)
- [Screenshots](#-screenshots)
- [Installation](#-installation)
- [Admin Access](#-admin-access)
- [Project Structure](#-project-structure)
- [Contributing](#-contributing)
- [License](#-license)

## ✨ Features

### 👤 Frontend (Customer)

- ✅ User Registration & Login
- ✅ Product Listing with Filters
- ✅ Product Search & Sorting
- ✅ Product Details Page
- ✅ Shopping Cart (Add/Remove/Update)
- ✅ Checkout Process
- ✅ Order Confirmation
- ✅ Order History Dashboard
- ✅ Order Cancellation
- ✅ Product Reviews & Ratings
- ✅ Contact Page

### 🔐 Admin Panel

- ✅ Admin Dashboard
- ✅ Product Management (CRUD)
- ✅ Category Management (CRUD)
- ✅ Brand Management (CRUD)
- ✅ Order Management with Status Update
- ✅ Customer Contact Messages
- ✅ Yajra DataTables Integration
- ✅ SweetAlert Confirmations

## 🛠️ Tech Stack

| Category | Technologies |
|----------|-------------|
| **Backend** | Laravel 12, PHP 8.2 |
| **Frontend** | Bootstrap 5, jQuery, Blade |
| **Database** | MySQL |
| **JavaScript** | DataTables, SweetAlert2, AJAX |
| **Image Processing** | Intervention Image |
| **Icons** | Font Awesome, Bootstrap Icons |


## 🚀 Installation

### Prerequisites

- PHP >= 8.2
- Composer
- MySQL
- XAMPP / WAMP / Laragon

### Step-by-Step Setup

```bash
# 1. Clone the repository
git clone https://github.com/MaryamFatimayaqoob/MarketNest.git
cd smartcart

# 2. Install dependencies
composer install

# 3. Copy environment file
cp .env.example .env

# 4. Generate application key
php artisan key:generate

# 5. Configure database in .env file
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=smartcartdb
DB_USERNAME=root
DB_PASSWORD=

# 6. Run migrations
php artisan migrate

# 7. (Optional) Run seeders
php artisan db:seed

# 8. Create storage link
php artisan storage:link

# 9. Start the development server
php artisan serve
👑 Admin Access
After migration, you can register as admin by setting utype to ADM in database, or use:

text
Email: admin@example.com
Password: password
📁 Project Structure
text
smartcart/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AdminController.php
│   │   │   ├── CartController.php
│   │   │   ├── HomeController.php
│   │   │   ├── ShopController.php
│   │   │   └── UserController.php
│   │   └── Middleware/
│   └── Models/
├── database/
│   ├── migrations/
│   └── seeders/
├── public/
│   └── uploads/
├── resources/
│   └── views/
│       ├── admin/
│       ├── user/
│       └── layouts/
└── routes/
    └── web.php
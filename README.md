# To-Do List Application

To-Do List Application is a task management tool that allows users to manage their tasks efficiently. Users can add, edit, view, and delete tasks, filter tasks by priority, status, or due date, and receive email notifications about upcoming deadlines.

This project is built with Laravel 11, offering a simple and intuitive interface with robust functionality.

---

## Live Demo

You can explore the application online at:  
**[https://flowdo.flowjob.pl/](https://flowdo.flowjob.pl/)**

---

## Features

1. **CRUD Operations**:
   - Create, Read, Update, and Delete tasks with the following attributes:
     - Task name (required, max 255 characters)
     - Description (optional)
     - Priority (low/medium/high)
     - Status (to-do, in progress, done)
     - Due date (required)

2. **Task Filtering**:
   - Filter tasks by:
     - Priority
     - Status
     - Due date range

3. **Email Notifications**:
   - Receive automated email reminders one day before a task is due.

4. **Validation**:
   - Front-end and back-end validation to ensure correct data input.

5. **User Authentication**:
   - Each user has their own account and can manage their tasks securely.

---

## Requirements

- PHP 8.1 or newer
- Composer
- MySQL database

---

## Installation

Follow these steps to set up the project locally:

### Step 1: Clone the Repository

Clone the repository and navigate to the project directory:
git clone https://github.com/Krystiano1999/todo

### Step 2: Install Dependencies

Install PHP dependencies:  
composer install  

Install front-end dependencies:  
npm install  

### Step 3: Configure the Environment

1. Copy the `.env.example` file to `.env`:  
   cp .env.example .env  

2. Update the `.env` file with your database and mail server configuration:  
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=todolist
   DB_USERNAME=your_db_user
   DB_PASSWORD=your_db_password

   MAIL_MAILER=smtp
   MAIL_HOST=your_smtp_server
   MAIL_PORT=465
   MAIL_USERNAME=your_email@example.com
   MAIL_PASSWORD=your_email_password
   MAIL_ENCRYPTION=tls
   MAIL_FROM_ADDRESS=your_email@example.com
   MAIL_FROM_NAME="To-Do List"
   ```

### Step 4: Migrate the Database

Run the migrations to create the required database tables:  
php artisan migrate  

### Step 5: Seed the Database (Optional)

Add test data to the database:  
php artisan db:seed  

### Step 6: Serve the Application

Start the Laravel development server:  
php artisan serve  

The application will be available at:  
http://localhost:8000  

---

## Scheduler Setup

The application uses Laravel Scheduler to send email reminders. Configure your system's `cron` to execute the scheduler every minute:

1. Open the crontab editor:  
   crontab -e  

2. Add the following line:  
   * * * * * /usr/bin/php /path/to/todolist/artisan schedule:run >> /dev/null 2>&1  

Replace `/path/to/todolist` with the full path to your Laravel project directory.

---

## Queue Worker Setup

To handle queued jobs for email notifications, start the queue worker:  
php artisan queue:work  

---


## Contributing

Feel free to fork this repository and submit pull requests.

---

## License

This project is open-source and available under the [MIT License](LICENSE).

---
---

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

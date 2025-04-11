## Workspace Management System

A modern and responsive **Workspace Management System** built for ABC Company to streamline the booking and management of private office spaces. This full-stack application supports both **user-facing bookings** and a powerful **admin dashboard** for workspace administrators.

---

## 🚀 Project Overview

This system allows users to **browse**, **book**, and **manage office space rentals**, while enabling staff to manage users, contracts, reports, and workspace availability through a secure admin portal.

## 🧩 Tech Stack

- **Backend:** Laravel 12 (PHP ^8.2)
- **Frontend:** React.js + Tailwind CSS
- **Database:** MySQL
- **Backend Testing:** Pest

## 🛠️ Prerequisites

Ensure you have the following installed:
- PHP 8.2+
- Composer
- Node.js & NPM
- MySQL
- Postman
- phpstorm (recommended) or other IDE

---

## 🔑 Key Features

### ✅ User Portal (React Frontend)
- User registration and login
- Calendar view of available booking dates (prevents double bookings)
- Filter by package types (5/10/15 seaters)
- Booking form with user full name, company name, telephone, and email
- View booking history and download contracts
- Edit user profile

### ✅ Admin Dashboard
- Confirm/cancel bookings and extend booking periods (daily to yearly)
- Manage users attached to a booking (with NIC, company, contract details)
- Upload signed contracts
- CRUD operations for package management
- View revenue and occupancy rate reports

### ✅ Backend API (Laravel)
- RESTful API using Laravel Sanctum for authentication
- Email notifications for confirmations, cancellation and contract uploads
- SQL injection protection (Eloquent) and rate limiting
- Unit testing with Pest
- API documentation with Postman

---

### 🧱 Database Schema (Highlights)

- `users`: User and admin accounts
- `packages`: Package details (5/10/15 seaters)
- `bookings`: Booking details (user, package, date)
- `booking_extensions`: Booking extension details
- `contracts`: Contract details (signed contracts)
- `booking_users`: Users attached to a booking

### 🗂️ Architecture

The system is designed with Domain-Driven Design (DDD) principles and adheres to SOLID principles for a clean, scalable, testable and maintainable codebase.

🧠 Backend (Laravel)
- **MVC architecture**: Laravel’s Model-View-Controller structure is used as the foundation.
- **Repository Pattern**: Data access is abstracted from Eloquent models, promoting flexibility.
- **Actions**: Abstracts specific pieces of logic (e.g., `CreateBooking`, `UploadContract`) to decouple business logic from controllers and services, making them reusable and testable.
- **Event-Driven Architecture:**: Key processes trigger events (e.g., `BookingConfirmed`, `ContractUploaded`) to which listeners respond (e.g., email notifications, logs).
- **Dependency Injection**: Enables loose coupling between classes.
- **Validation & Security**: Uses Laravel Form Requests and default SQL injection protections.

🎨 Frontend (React + Tailwind CSS)
- **Component-Based Architecture**: React components are reusable and maintainable.
- **State Management**: React Context API is used for global state management.
- **Routing**: React Router for client-side routing.
- **Responsive Design**: Tailwind CSS for a mobile-first approach.

---

## 🔧 Installation

1. Clone the Repository

    ```bash
    git@github.com:shashikanuwan/workora.git
    ```
    ```bash
   cd workora
    ```

### 🛠️ Setup - Backend

1. Go to the backend directory

    ```bash
   cd backend
    ```
2. Install dependencies

    ```bash
   composer install
   ```
   
3. Set Up Environment Variables

    ```bash
   cp .env.example .env
   ```
   Update the database credentials, email and other configuration values.

4. Generate the application key

    ```bash
   php artisan key:generate
    ```

5. Run migrations and seeders

    ```bash
    php artisan migrate --seed
    ```

6. Start the local development server:

    ```bash
    php artisan serve
    ```
   and
    ```bash
   php artisan queu:work
   ```

## 📝 Testing

1. Test the backend
    ```bash
   cd backend
    ```

    ```bash
    ./vendor/bin/pest
    ```
2. Test coverage (Requires XDebug 3.0+ or PCOV)
    ```bash
    ./vendor/bin/pest --coverage
    ```
3. Type coverage
    ```bash
    ./vendor/bin/pest --type-coverage
    ```

⛳️ How to Use
1. **User Portal**:
   * Login with the default user using dummy data:
     - Email: `user_1@workora.com`
     - Password: `password`

2. **Admin Portal**:
    * Login with the default admin using dummy data:
      * Email: `admin_1@workora.com`
      * Password: `password`

## 🕹 Postman Collection

- [Postman Collection](https://www.postman.com/navigation-physicist-45077490/workspace/public/collection/13953611-242c69d9-4424-4155-bc01-77adce1cafcb?action=share&creator=13953611&active-environment=13953611-98185e2a-b805-4f3b-a0b7-7bbe69b8ca3b)

## 📜 License
This project is licensed under the MIT License.

## 📩 Contact
For any questions, reach out at [contact@shashikanuwan.me](mailto:contact@shashikanuwan.me)
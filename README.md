# Krokology Todo API

This is a Laravel-based Todo API application with authentication and CRUD operations for managing todos.

## Features

- User authentication (register, login, logout) using Laravel Sanctum
- CRUD operations for todos
- Image upload for todos
- Assign todos to users
- Search functionality
- Pagination
- Email notifications for todo creation and updates (simulated)
- Unit tests

## Requirements

- PHP 8.2+
- Composer
- MySQL
- Laravel 11

## Installation

1. Clone the repository:
   ```
   git clone git@github.com:3omarbadr/Krokology.git
   ```
2. Navigate to the project directory:
   ```
   cd Krokology
   ```
3. Install dependencies:
   ```
   composer install
   ```
4. Copy the `.env.example` file to `.env` and configure your database settings:
   ```
   cp .env.example .env
   ```
5. Generate an application key:
   ```
   php artisan key:generate
   ```
6. Run migrations and seeders:
   ```
   php artisan migrate --seed
   ```
7. Start the development server:
   ```
   php artisan serve
   ```

## API Documentation

### Postman Collection

To quickly test and explore the API endpoints, you can use our Postman collection:

[Krokology Todo API Postman Collection](https://www.postman.com/krokology/workspace/krokology-todo-api)

### Authentication

- Register: `POST /api/auth/register`
- Login: `POST /api/auth/login`
- Logout: `POST /api/auth/logout` (requires authentication)

### Todos

- List todos: `GET /api/todos`
- Create todo: `POST /api/todos`
- Get todo: `GET /api/todos/{id}`
- Update todo: `PUT /api/todos/{id}`
- Delete todo: `DELETE /api/todos/{id}`

All todo endpoints require authentication.

## Application Flow

The following sequence diagram illustrates the flow of a typical todo creation process in the application:

![Sequence Diagram](https://github.com/3omarbadr/Krokology/blob/main/public/images/todo-sequence-diagram.png?raw=true)

This diagram shows the interaction between different components of the application during the authentication and todo creation process.

## Database Schema

The database schema for the Krokology Todo API is represented in the following entity-relationship diagram:

![Entity-Relationship Diagram](https://github.com/3omarbadr/Krokology/blob/main/public/images/todo-ERD.png?raw=true)

This diagram illustrates the structure and relationships between the main entities in our database: Users, Todos, and Personal Access Tokens.

## Running Tests

To run the unit tests, use the following command:
```
php artisan test
```

# Krokology Todo API - Repository Pattern Conventions

[... Rest of the repository pattern conventions remain unchanged ...]

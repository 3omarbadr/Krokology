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

[Krokology Todo API Postman Collection](https://documenter.getpostman.com/view/16204995/2sAXqqePV1)

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

## Running Tests

To run the unit tests, use the following command:
```
php artisan test
```

# Krokology Todo API - Repository Pattern Conventions

## Directory Structure

The repository pattern is implemented with the following directory structure:

```
app/
├── Repositories/
│   ├── Contracts/
│   │   └── ITodoRepository.php
│   └── SQL/
│       └── TodoRepository.php
├── Providers/
│   └── RepositoryServiceProvider.php
```

## Naming Conventions

1. **Repository Interfaces**:
   - Location: `app/Repositories/Contracts/`
   - Naming: Prefixed with "I", PascalCase, suffixed with "Repository"
   - Example: `ITodoRepository`

2. **Repository Implementations**:
   - Location: `app/Repositories/SQL/`
   - Naming: PascalCase, suffixed with "Repository"
   - Example: `TodoRepository`

3. **Service Provider**:
   - Location: `app/Providers/`
   - Naming: PascalCase, suffixed with "ServiceProvider"
   - Example: `RepositoryServiceProvider`

## Implementation Details

1. **Interfaces (Contracts)**:
   - Define methods that the repository must implement
   - Example: `ITodoRepository` would define methods like `getAll()`, `findById()`, `create()`, etc.

2. **Implementations**:
   - Implement the corresponding interface
   - Contain the actual database query logic
   - Example: `TodoRepository` implements `ITodoRepository`

3. **Service Provider**:
   - Automatically binds interfaces to their implementations
   - Uses reflection to dynamically bind all repository interfaces to their SQL implementations

## Usage in Controllers

Controllers should type-hint the repository interface in their constructor:

```php
use App\Repositories\Contracts\ITodoRepository;

class TodoController extends Controller
{
    public function __construct(private ITodoRepository $todoRepository)
    {}

    // ...
}
```

This approach allows for easy swapping of repository implementations and promotes separation of concerns.

## Advantages

1. **Abstraction**: Business logic is separated from data access logic
2. **Testability**: Easier to mock repositories for unit testing
3. **Flexibility**: Can easily switch between different data sources (e.g., SQL to NoSQL)
4. **Consistency**: Provides a standard way of accessing data across the application

# Pro PHP MVC

Pro PHP MVC is a lightweight and customizable Model-View-Controller (MVC) framework for building web applications using PHP. It follows best practices in web development, providing a structured and organized approach to building scalable and maintainable applications.

## Features

- **MVC Architecture:** Organize your code into models, views, and controllers for a clean separation of concerns.
- **Routing:** Easily define and manage your application routes for clean and user-friendly URLs.
- **Template Engine:** Use a flexible template engine for rendering views and creating dynamic content.
- **Database Abstraction:** Interact with databases using a simple and secure database abstraction layer.
- **Middleware:** Implement middleware for handling tasks such as authentication, logging, and more.
- **Error Handling:** Comprehensive error handling for better debugging and user experience.
- **Dependency Injection:** Use dependency injection to manage and organize your application dependencies.

## Getting Started

### Prerequisites

- PHP 7.2 or later
- Composer

### Installation

1. Clone the repository:

   ```bash
   git clone https://github.com/Saboor-Hamedi/pro-php-mvc.git


### Usage

1. **Define Routes:**
   - Open the `routes.php` file in the `app` directory.
   - Define your application routes using the provided syntax, linking routes to controllers and actions.

   ```php
      protected $route;
        public function routes()
        {
        $this->route = new Router();
        $this->route->get('/home', [HomeController::class, 'index']);
        $this->route->get('/home/update/{id}', [HomeController::class, 'update']);
        $this->route->get('/home/create/{id}', [HomeController::class, 'create']);
        $this->route->get('/home/delete/{id}', [HomeController::class, 'delete']);

        // group
        $this->route->group('/dashboard', function ($route) {
        $this->route->get('/admin', [DashboardController::class, 'index']);
        });
        $this->route->route();
      }


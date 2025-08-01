# PHP Login System with SOLID Principles

A modern PHP-based authentication and user management system demonstrating all five SOLID principles of object-oriented design.

## Project Overview

This project implements a complete user authentication system with a focus on clean architecture, maintainability, and extensibility. The system showcases real-world application of SOLID principles through a well-structured codebase.

## Architecture & Features

### Core Features
- **User Registration & Authentication** - Complete signup/login functionality
- **Multi-User Types** - Regular, Admin, and Guest user roles
- **Session Management** - Secure session handling with timeout and regeneration
- **Extensible Authentication** - Support for multiple authentication methods
- **Role-Based Access Control** - Different permissions for different user types

### SOLID Principles Implementation

#### 1. **Single Responsibility Principle (SRP)**
- **SessionManager** - Dedicated class for all session operations
- **AuthController** - Focuses only on authentication logic
- **RegisterController** - Handles only user registration
- Each class has one reason to change

#### 2. **Open-Closed Principle (OCP)**
- **AuthenticationInterface** - Contract for authentication methods
- **AuthenticationManager** - Context for switching authentication methods
- New authentication methods can be added without modifying existing code

#### 3. **Liskov Substitution Principle (LSP)**
- **User Hierarchy** - Base User class with RegularUser, AdminUser, GuestUser

#### 4. **Interface Segregation Principle (ISP)**
- **Focused Interfaces** - Small, specific interfaces for different concerns
- **No Fat Interfaces** - Classes implement only what they need
- **Role-Specific Contracts** - Different interfaces for different user capabilities

#### 5. **Dependency Inversion Principle (DIP)**
- **Dependency Injection** - Controllers receive dependencies via constructor
- **Abstraction Dependencies** - Depend on interfaces, not concrete classes
- **Inversion of Control** - High-level modules don't depend on low-level modules

## 📁 Project Structure

```
login/
├── controller/
│   ├── AuthController.php          # Authentication logic
│   ├── RegisterController.php      # User registration
│   └── AuthenticationManager.php   # Authentication strategy manager
├── models/
│   ├── User.php                    # Base user class (abstract)
│   ├── RegularUser.php            # Standard user implementation
│   ├── AdminUser.php              # Administrator user
│   └── GuestUser.php              # Guest user implementation
├── services/
│   ├── SessionManager.php         # Session management service
│   └── UserFactory.php           # User creation factory
├── auth/
│   ├── EmailPasswordAuth.php     # Email/password authentication
│   ├── TokenAuth.php             # Token-based authentication
│   └── OAuthAuth.php             # OAuth authentication
├── interfaces/
│   └── AuthenticationInterface.php # Authentication contract
├── demo_*.php                     # Demonstration files
└── README.md                      # This file
```

## Technical Stack

- **PHP 7.4+** - Core programming language
- **MySQLi** - Database connectivity
- **Session Management** - Native PHP sessions with security enhancements
- **Object-Oriented Design** - Full OOP implementation
- **Design Patterns** - Strategy, Factory, Dependency Injection

## 🗄️ Database Schema

```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    user_type ENUM('regular', 'admin', 'guest') DEFAULT 'regular',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    is_active BOOLEAN DEFAULT TRUE
);
```

## Getting Started

### Prerequisites
- PHP 7.4 or higher
- MySQL/MariaDB
- Web server (Apache/Nginx) or XAMPP

### Installation

1. **Clone/Download** the project to your web server directory
   ```bash
   # For XAMPP users
   cd C:\xampp\htdocs\
   ```

2. **Database Setup**
   - Create a MySQL database
   - Run the SQL schema above to create the users table

3. **Configuration**
   - Update database connection settings in your controller files
   - Ensure proper file permissions

4. **Access**
   - Navigate to `http://localhost/login/` in your browser
   - Use the registration form to create new users
   - Test different user types and authentication methods

## 🧪 Testing & Demonstrations

The project includes several demonstration files:

- **`demo_lsp.php`** - Demonstrates Liskov Substitution Principle
- **`demo_ocp.php`** - Shows Open-Closed Principle implementation
- **`demo_session_manager.php`** - SessionManager functionality demo

Run these files to see SOLID principles in action:
```bash
php demo_lsp.php
php demo_ocp.php
php demo_session_manager.php
```

## 🔐 Security Features

- **Password Hashing** - Secure password storage using PHP's password_hash()
- **Session Security** - Session ID regeneration and timeout handling
- **Input Validation** - Proper sanitization of user inputs
- **SQL Injection Prevention** - Prepared statements with MySQLi
- **Access Control** - Role-based permissions system

## 🎯 Key Benefits

### For Developers
- **Maintainable Code** - Clear separation of concerns
- **Extensible Architecture** - Easy to add new features
- **Testable Components** - Each class can be unit tested
- **Reusable Code** - Components can be used in other projects

### For Learning
- **SOLID Principles** - Real-world implementation examples
- **Design Patterns** - Strategy, Factory, Dependency Injection
- **Best Practices** - Modern PHP development standards
- **Clean Architecture** - Professional code organization

## 🔄 User Types & Permissions

### Regular User
- View and edit profile
- Change password
- Access dashboard
- Basic user functionality

### Admin User
- All regular user permissions
- User management capabilities
- System administration access
- Advanced reporting features

### Guest User
- Limited read-only access
- Public content viewing
- Basic interaction capabilities
- No sensitive data access

## Future Enhancements

- **Email Verification** - Account activation via email
- **Password Reset** - Secure password recovery system
- **Two-Factor Authentication** - Enhanced security layer
- **API Integration** - RESTful API endpoints
- **Frontend Framework** - Modern JavaScript framework integration
- **Caching Layer** - Redis/Memcached for performance
- **Logging System** - Comprehensive audit trails

## Learning Resources

This project demonstrates:
- **SOLID Principles** in real-world PHP application
- **Object-Oriented Programming** best practices
- **Design Patterns** implementation
- **Security Considerations** in web development
- **Database Design** and interaction patterns

## Contributing

Feel free to contribute to this project by:
- Adding new authentication methods
- Implementing additional user types
- Enhancing security features
- Improving documentation
- Adding unit tests

## License

This project is created for educational purposes and demonstrates SOLID principles in PHP development.

---

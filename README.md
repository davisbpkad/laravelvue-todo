# Laravel Vue Todo Application

A modern, feature-rich Todo application built with Laravel 11 and Vue 3, featuring role-based access control, responsive design, and modular component architecture.

## 🚀 Features

### Core Features
- ✅ **CRUD Operations** - Create, read, update, delete todos
- 👥 **User Management** - Multi-user support with authentication
- 🔐 **Role-Based Access** - Admin and User roles with different permissions
- 📊 **Dashboard Analytics** - Statistics and overview of todos
- 🎯 **Priority System** - Low, Medium, High priority levels
- 📅 **Due Dates** - Set and track due dates with overdue detection
- ✔️ **Status Tracking** - Complete/Incomplete status management
- 🔍 **Advanced Filtering** - Filter by status, user, priority, and dates
- 📱 **Responsive Design** - Mobile-first, works on all devices

### Admin Features
- 👑 **Admin Dashboard** - Overview of all users' todos
- 👤 **User Assignment** - Assign todos to specific users
- 📈 **System Analytics** - Complete system statistics
- 🔧 **User Management** - Manage all users and their todos

### User Features
- 🏠 **Personal Dashboard** - User-specific todo overview
- ✏️ **Personal Todo Management** - Manage own todos
- 📊 **Personal Statistics** - Individual progress tracking

## 🛠 Tech Stack

### Backend
- **Laravel 11** - PHP framework
- **PHP 8.2+** - Programming language
- **MySQL** - Database
- **Inertia.js** - Server-side routing

### Frontend
- **Vue 3** - JavaScript framework
- **TypeScript** - Type safety
- **Tailwind CSS** - Utility-first CSS framework
- **Lucide Vue** - Icon library
- **Vite** - Build tool and dev server

### Architecture
- **SPA (Single Page Application)** - Using Inertia.js
- **Modular Components** - Reusable Vue components
- **TypeScript Interfaces** - Type-safe development
- **Responsive Design** - Mobile-first approach

## 📁 Project Structure

```
laravelvue-todo/
├── app/
│   ├── Http/Controllers/
│   │   ├── DashboardController.php
│   │   ├── TodoController.php
│   │   └── Auth/
│   ├── Models/
│   │   ├── User.php
│   │   └── Todo.php
│   └── Policies/
│       └── TodoPolicy.php
├── resources/
│   ├── js/
│   │   ├── components/
│   │   │   └── Todos/
│   │   │       ├── TodoFilter.vue
│   │   │       ├── TodoItem.vue
│   │   │       ├── TodoList.vue
│   │   │       └── TodoModal.vue
│   │   ├── layouts/
│   │   │   └── AppLayout.vue
│   │   ├── pages/
│   │   │   ├── Dashboard.vue
│   │   │   └── Todos/
│   │   │       └── Index.vue
│   │   └── types/
│   │       └── index.ts
│   └── views/
│       └── app.blade.php
├── routes/
│   └── web.php
└── database/
    ├── migrations/
    └── seeders/
```

## 🔧 Installation

### Prerequisites
- PHP 8.2 or higher
- Composer
- Node.js 18+ and npm
- MySQL 8.0+
- XAMPP/WAMP/MAMP (for local development)

### Setup Steps

1. **Clone the repository**
   ```bash
   git clone <your-repo-url>
   cd laravelvue-todo
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install Node.js dependencies**
   ```bash
   npm install
   ```

4. **Environment configuration**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Configure database in `.env`**
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=laravelvue_todo
   DB_USERNAME=root
   DB_PASSWORD=
   ```

6. **Create database**
   ```sql
   CREATE DATABASE laravelvue_todo;
   ```

7. **Run migrations and seeders**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

8. **Build frontend assets**
   ```bash
   npm run build
   # or for development
   npm run dev
   ```

9. **Start the development server**
   ```bash
   php artisan serve
   ```

10. **Access the application**
    - Open http://localhost:8000 in your browser

## 👥 Default Users

After running the seeders, you can login with:

### Admin User
- **Email:** admin@example.com
- **Password:** password
- **Role:** Administrator

### Regular User
- **Email:** user@example.com
- **Password:** password
- **Role:** User

## 🎯 Usage Guide

### For Regular Users

1. **Dashboard Overview**
   - View personal todo statistics
   - Quick access to different todo categories
   - Personal progress tracking

2. **Managing Todos**
   - Click "Add New Todo" to create todos
   - Set title, description, priority, and due date
   - Mark todos as complete/incomplete
   - Edit or delete your todos

3. **Filtering**
   - Filter by status (All, Completed, Incomplete, Overdue)
   - Search and sort your todos

### For Administrators

1. **Admin Dashboard**
   - View system-wide statistics
   - Monitor all users' todos
   - Track overall system usage

2. **User Management**
   - View todos from all users
   - Assign todos to specific users
   - Filter by user and status

3. **System Overview**
   - Complete analytics of the system
   - User activity monitoring

## 🏗 Component Architecture

### Modular Design
The application uses a modular component architecture for better maintainability:

#### Todo Components
- **TodoFilter.vue** - Handles filtering functionality
- **TodoItem.vue** - Individual todo item display
- **TodoList.vue** - Container for todo items
- **TodoModal.vue** - Create/edit modal component

#### Layout Components
- **AppLayout.vue** - Main application layout
- **Navigation components** - Sidebar and header

#### Page Components
- **Dashboard.vue** - Main dashboard page
- **Todos/Index.vue** - Todo management page

### Benefits
- **Reusability** - Components can be reused across pages
- **Maintainability** - Easy to update individual features
- **Testing** - Each component can be tested independently
- **Performance** - Better code splitting and lazy loading

## 🔒 Security Features

- **Authentication** - Laravel Sanctum/Breeze authentication
- **Authorization** - Role-based access control
- **CSRF Protection** - Built-in CSRF protection
- **Input Validation** - Server-side and client-side validation
- **SQL Injection Prevention** - Eloquent ORM protection

## 🎨 UI/UX Features

- **Dark/Light Mode** - Theme switching support
- **Responsive Design** - Works on all screen sizes
- **Accessibility** - ARIA labels and keyboard navigation
- **Loading States** - User feedback during operations
- **Error Handling** - Graceful error display
- **Smooth Animations** - CSS transitions and animations

## 📊 API Endpoints

### Authentication
- `POST /login` - User login
- `POST /logout` - User logout
- `POST /register` - User registration

### Dashboard
- `GET /dashboard` - Dashboard with statistics

### Todos
- `GET /todos` - List todos with filters
- `POST /todos` - Create new todo
- `PUT /todos/{id}` - Update todo
- `DELETE /todos/{id}` - Delete todo
- `PATCH /todos/{id}/toggle-complete` - Toggle completion status

## 🧪 Testing

```bash
# Run PHP tests
php artisan test

# Run JavaScript tests (if configured)
npm run test

# Run specific test suite
php artisan test --filter TodoTest
```

## 🚀 Deployment

### Production Build
```bash
npm run build
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Environment Variables
Set the following in production:
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com
```

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## 📝 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## 🐛 Bug Reports

If you discover a bug, please create an issue on GitHub with:
- Steps to reproduce
- Expected behavior
- Actual behavior
- Screenshots (if applicable)

## 📞 Support

For support and questions:
- Create an issue on GitHub
- Check the documentation
- Review existing issues

## 🔄 Changelog

### Version 1.0.0
- Initial release
- Basic CRUD operations
- User authentication
- Role-based access control
- Responsive design
- Modular component architecture

## 🚧 Roadmap

- [ ] Email notifications
- [ ] Real-time updates (WebSockets)
- [ ] File attachments
- [ ] Todo categories/tags
- [ ] Team collaboration features
- [ ] Mobile app (React Native/Flutter)
- [ ] API documentation (Swagger)
- [ ] Unit and integration tests
- [ ] Performance optimization
- [ ] Docker containerization

---

**Made with ❤️ using Laravel 11 & Vue 3**

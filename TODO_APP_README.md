# Laravel Vue Todo Application

A comprehensive Todo application built with Laravel 11, Vue 3, TypeScript, and Inertia.js featuring role-based access control and advanced filtering capabilities.

## Features

### User Roles
- **User**: Can create, update, and delete only their own todos
- **Admin**: Can view, create, update, and delete all todos (including those created by users and other admins)

### Todo Management
- Create todos with title, description, priority (low/medium/high), and due date
- Mark todos as complete/incomplete
- Edit existing todos
- Delete todos
- Real-time status updates

### Filtering System
- **Status Filter**: 
  - All Status
  - Completed Todos
  - Incomplete Todos  
  - Overdue Todos
- **User Filter** (Admin only): Filter todos by specific user

### Dashboard Analytics
- Total todos count
- Completed todos count
- Incomplete todos count
- Overdue todos count
- Quick action links
- Role-based information display

## Database Structure

### Users Table
- `id`: Primary key
- `name`: User's full name
- `email`: User's email address
- `role`: User role (user/admin) - defaults to 'user'
- `password`: Hashed password
- `email_verified_at`: Email verification timestamp
- `remember_token`: Remember me token
- `created_at` & `updated_at`: Timestamps

### Todos Table
- `id`: Primary key
- `title`: Todo title (required)
- `description`: Todo description (optional)
- `completed`: Boolean completion status (defaults to false)
- `priority`: Priority level (low/medium/high) - defaults to 'medium'
- `due_date`: Due date (optional)
- `user_id`: Foreign key to users table
- `created_at` & `updated_at`: Timestamps

## Setup Instructions

### Prerequisites
- PHP >= 8.2
- Composer
- Node.js & npm
- SQLite (or your preferred database)

### Installation

1. **Clone and install dependencies**:
   ```bash
   git clone <repository-url>
   cd laravelvue-todo
   composer install
   npm install
   ```

2. **Environment Setup**:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

3. **Database Setup**:
   ```bash
   php artisan migrate:fresh --seed
   ```

4. **Build Assets**:
   ```bash
   npm run dev
   ```

5. **Start Development Server**:
   ```bash
   php artisan serve
   ```

### Default Users (Created by Seeder)

**Admin User**:
- Email: `admin@example.com`
- Password: `password`
- Role: Admin

**Regular Users**:
- Email: `john@example.com` / Password: `password`
- Email: `jane@example.com` / Password: `password`
- Role: User

## API Endpoints

### Todo Routes (Protected by Auth)
- `GET /todos` - List todos with filtering
- `POST /todos` - Create new todo
- `GET /todos/{todo}` - Show specific todo
- `PUT /todos/{todo}` - Update todo
- `DELETE /todos/{todo}` - Delete todo
- `PATCH /todos/{todo}/toggle-complete` - Toggle completion status

### Filter Parameters
- `status`: 'completed', 'incomplete', 'overdue'
- `user_id`: Filter by specific user (admin only)

## Frontend Structure

### Pages
- `Dashboard.vue` - Analytics dashboard with todo statistics
- `Todos/Index.vue` - Main todos listing with filters and CRUD operations

### Components
- Modal-based create/edit forms
- Dynamic filtering interface
- Responsive design with dark mode support
- Role-based UI elements

## Access Control

### User Permissions
- Can only see and manage their own todos
- Cannot assign todos to other users
- Cannot see other users' todos

### Admin Permissions  
- Can see and manage all todos from all users
- Can assign todos to any user
- Can filter todos by user
- Has access to user management features

## Technical Features

### Backend
- Laravel 11 with Inertia.js
- Eloquent ORM with relationships
- Form Request validation
- Policy-based authorization
- Database seeders and factories

### Frontend
- Vue 3 with Composition API
- TypeScript for type safety
- Tailwind CSS for styling
- Responsive design
- Real-time filtering
- Modal-based forms

### Security
- CSRF protection
- Authentication required
- Role-based access control
- Input validation and sanitization

## Usage Examples

### Creating a Todo
1. Navigate to `/todos`
2. Click "Add New Todo"
3. Fill in the form (title required, others optional)
4. Admins can assign to specific users
5. Click "Create"

### Filtering Todos
1. Use the status dropdown to filter by completion status
2. Admins can use the user dropdown to filter by specific user
3. Filters update the display in real-time

### Managing Todos
- Click "Mark Complete/Incomplete" to toggle status
- Click "Edit" to modify todo details
- Click "Delete" to remove (with confirmation)

## Development Notes

- Uses SQLite by default for easy setup
- Includes comprehensive seeders for testing
- TypeScript interfaces for type safety
- Responsive design works on all devices
- Dark mode support included

## Future Enhancements

- Todo categories/tags
- File attachments
- Todo comments/notes
- Email notifications for overdue todos
- Team/project-based todo organization
- Advanced reporting and analytics

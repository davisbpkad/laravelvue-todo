# Laravel Vue Todo Application

Aplikasi Todo modern yang dibangun dengan Laravel 11 dan Vue.js 3, dilengkapi dengan sistem role-based access control dan fitur filtering yang canggih.

## 📋 Fitur Utama

### 🔐 Role-Based Access Control
- **User Role**: Dapat membuat, mengubah, dan menghapus todo milik sendiri
- **Admin Role**: Dapat melihat, membuat, mengubah, dan menghapus semua todo (termasuk milik user lain)

### ✅ Manajemen Todo
- Membuat todo dengan judul, deskripsi, prioritas, dan tanggal jatuh tempo
- Mengubah status todo (completed/incomplete)
- Mengedit informasi todo
- Menghapus todo dengan konfirmasi
- Toggle status completion dengan satu klik

### 🔍 Sistem Filtering Canggih
- **Filter berdasarkan Status**:
  - All Status (semua todo)
  - Completed (todo yang sudah selesai)
  - Incomplete (todo yang belum selesai)
  - Overdue (todo yang sudah lewat deadline)
- **Filter berdasarkan User** (khusus Admin):
  - Dropdown list semua user
  - Melihat todo berdasarkan user tertentu

### 📊 Dashboard Analytics
- Statistik real-time jumlah todo
- Breakdown berdasarkan status
- Quick action links untuk filter populer
- Informasi khusus berdasarkan role user

### 🎨 Modern UI/UX
- **Dark Mode Support** dengan tema light gray yang nyaman
- Responsive design untuk semua device
- Modal-based forms untuk create/edit
- Visual indicators untuk prioritas dan status
- Clean, modern interface menggunakan Tailwind CSS

## 🚀 Tech Stack

- **Backend**: Laravel 11
- **Frontend**: Vue.js 3 + TypeScript
- **Database**: MySQL/SQLite
- **Styling**: Tailwind CSS
- **UI Components**: Custom components with shadcn/ui
- **Build Tool**: Vite
- **Authentication**: Laravel Breeze

## 📦 Instalasi

### Prerequisites
- PHP >= 8.2
- Composer
- Node.js >= 18
- MySQL/SQLite
- Git

### Langkah Instalasi

1. **Clone Repository**
   ```bash
   git clone <repository-url>
   cd laravelvue-todo
   ```

2. **Install Dependencies Backend**
   ```bash
   composer install
   ```

3. **Install Dependencies Frontend**
   ```bash
   npm install
   ```

4. **Setup Environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Konfigurasi Database**
   Edit file `.env` dan sesuaikan konfigurasi database:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=laravelvue_todo
   DB_USERNAME=root
   DB_PASSWORD=
   ```

6. **Migrasi Database dan Seeder**
   ```bash
   php artisan migrate:fresh --seed
   ```

7. **Build Assets**
   ```bash
   npm run build
   # atau untuk development
   npm run dev
   ```

8. **Jalankan Server**
   ```bash
   php artisan serve
   ```

   Aplikasi akan tersedia di: `http://localhost:8000`

## 👥 User Testing

Setelah menjalankan seeder, Anda dapat login dengan akun berikut:

### Admin Account
- **Email**: `admin@example.com`
- **Password**: `password`
- **Akses**: Semua todo dari semua user

### User Accounts
- **Email**: `john@example.com` / **Password**: `password`
- **Email**: `jane@example.com` / **Password**: `password`
- **Akses**: Hanya todo milik sendiri

## 📁 Struktur Proyek

```
laravelvue-todo/
├── app/
│   ├── Http/Controllers/
│   │   └── TodoController.php          # Controller untuk manajemen todo
│   ├── Http/Requests/
│   │   ├── StoreTodoRequest.php        # Validasi create todo
│   │   └── UpdateTodoRequest.php       # Validasi update todo
│   ├── Models/
│   │   ├── Todo.php                    # Model Todo dengan scopes
│   │   └── User.php                    # Model User dengan role
│   └── Http/Middleware/
│       └── AdminMiddleware.php         # Middleware untuk admin access
├── database/
│   ├── migrations/
│   │   ├── *_create_todos_table.php    # Migration untuk table todos
│   │   └── *_add_role_to_users_table.php # Migration untuk role user
│   ├── factories/
│   │   ├── TodoFactory.php             # Factory untuk generate test data
│   │   └── UserFactory.php             # Factory untuk user dengan role
│   └── seeders/
│       └── TodoSeeder.php              # Seeder untuk data testing
├── resources/
│   ├── js/
│   │   ├── components/                 # Vue components
│   │   ├── pages/
│   │   │   ├── Dashboard.vue           # Dashboard dengan analytics
│   │   │   └── Todos/
│   │   │       └── Index.vue           # Main todo management page
│   │   └── types/                      # TypeScript type definitions
│   └── css/
│       └── app.css                     # Custom dark theme styling
└── routes/
    └── web.php                         # Route definitions
```

## 🎯 Cara Penggunaan

### 1. **Login ke Aplikasi**
   - Akses `http://localhost:8000`
   - Login dengan salah satu akun testing
   - Navigate ke Dashboard untuk melihat statistik

### 2. **Manajemen Todo**
   - Klik "Todos" di sidebar untuk masuk ke halaman todo
   - Klik "Add Todo" untuk membuat todo baru
   - Klik todo yang ada untuk edit atau hapus
   - Toggle checkbox untuk mark as completed

### 3. **Menggunakan Filter**
   - **Filter Status**: Pilih dari dropdown untuk filter berdasarkan status
   - **Filter User** (Admin only): Pilih user tertentu untuk melihat todo mereka
   - Filter akan update secara real-time

### 4. **Role Testing**
   - Login sebagai User: Hanya bisa melihat todo sendiri
   - Login sebagai Admin: Bisa melihat dan manage semua todo
   - Test create, edit, delete dengan role yang berbeda

## 🔧 Development

### Menjalankan Development Server
```bash
# Terminal 1 - Laravel server
php artisan serve

# Terminal 2 - Vite dev server
npm run dev
```

### Database Commands
```bash
# Reset database dengan data fresh
php artisan migrate:fresh --seed

# Membuat migration baru
php artisan make:migration create_example_table

# Membuat seeder baru
php artisan make:seeder ExampleSeeder
```

### Testing
```bash
# Menjalankan feature tests
php artisan test

# Test specific file
php artisan test tests/Feature/TodoTest.php
```

## 🎨 Customization

### Mengubah Theme Dark Mode
Edit file `resources/css/app.css` di bagian `.dark` untuk menyesuaikan warna:

```css
.dark {
    --background: hsl(0 0% 18%);    /* Background utama */
    --card: hsl(0 0% 24%);          /* Background card */
    --border: hsl(0 0% 35%);        /* Border color */
    /* ... */
}
```

### Menambah Role Baru
1. Update enum di migration `add_role_to_users_table.php`
2. Update method `isAdmin()` di model `User.php`
3. Update authorization logic di `TodoController.php`

### Menambah Filter Baru
1. Tambah scope baru di model `Todo.php`
2. Update filter options di component `Todos/Index.vue`
3. Update computed property `filteredTodos`

## 📝 API Endpoints

| Method | Endpoint | Description | Access |
|--------|----------|-------------|---------|
| GET | `/todos` | List todos | User: own todos, Admin: all todos |
| POST | `/todos` | Create todo | All authenticated users |
| GET | `/todos/{id}` | Show todo | Owner or Admin |
| PUT | `/todos/{id}` | Update todo | Owner or Admin |
| DELETE | `/todos/{id}` | Delete todo | Owner or Admin |
| PATCH | `/todos/{id}/toggle-complete` | Toggle completion | Owner or Admin |

## 🛡️ Security Features

- **CSRF Protection**: Semua form menggunakan CSRF token
- **Role-based Authorization**: Middleware dan policy untuk akses control
- **Input Validation**: Request classes untuk validasi data
- **SQL Injection Prevention**: Eloquent ORM dan prepared statements
- **XSS Protection**: Blade templating dengan auto-escaping

## 🐛 Troubleshooting

### Error: "Target class [TodoController] does not exist"
```bash
composer dump-autoload
php artisan config:clear
```

### Error: Database connection
- Pastikan MySQL/database server berjalan
- Check konfigurasi `.env` file
- Pastikan database sudah dibuat

### Error: Assets tidak load
```bash
npm run build
php artisan config:clear
```

### Error: Permission denied
```bash
# Linux/Mac
sudo chown -R $USER:$USER storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

# Windows (run as administrator)
icacls storage /grant Users:F /T
icacls bootstrap/cache /grant Users:F /T
```

## 🤝 Contributing

1. Fork repository
2. Buat feature branch (`git checkout -b feature/amazing-feature`)
3. Commit changes (`git commit -m 'Add amazing feature'`)
4. Push ke branch (`git push origin feature/amazing-feature`)
5. Buat Pull Request

## 📄 License

Project ini menggunakan [MIT License](LICENSE).

## 👨‍💻 Author

Dikembangkan dengan ❤️ menggunakan Laravel dan Vue.js

---

**Happy Coding! 🚀**

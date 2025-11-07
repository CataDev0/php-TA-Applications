<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# TAAMS
#### Teaching Assistants<br>Application Management System
A streamlined web application for creating and managing Teaching Assistant applications.
Built with Laravel and a modern front-end stack to support efficient workflows for teachers and assistants.

---

### Features
- **Application Management:** Create, edit, and delete TA applications.
- **Authentication:** Secure registration, login, and logout.
- **Filtering & Sorting:** Dynamic filtering and column-based sorting of applications.
- **TA Actions:** Accept or reject applications directly within the interface.
- **Scalable Foundation:** Built for extensibility and easy feature integration.

---

## Requirements

Ensure your environment meets the following

| Dependency   | Version |
|--------------|---------|
| **PHP**      | ≥ 8.2   | 
| **Laravel**  | ^12.0   |
| **Composer** | ≥ 2.5   |
| **Node.js**  | ≥ 18.x  |
| **NPM**      | ≥ 9.x   |

For PHP, sqlite3 extension is required to be enabled.

---

### Installation

Clone the repository and install dependencies:

```bash
composer install
npm install && npm run build
php artisan migrate
# (Optional) Seed database with sample data
php artisan db:seed

```

---

### Development Server
Run the local development environment:

    composer run dev

---

### Technologies

| Category            | Technologies                   |
|---------------------|--------------------------------|
| **Backend**         | Laravel                        |
| **Frontend**        | Bootstrap, Tailwind CSS, Axios |
| **Build Tools**     | Vite, NPM                      |
| **Database**        | SQLite                         |
| **Package Manager** | Composer                       |


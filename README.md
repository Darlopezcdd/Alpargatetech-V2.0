# 🍽️ AlpargateTech — Full-Stack Restaurant POS, Table Management & Order Processing Platform

[![Laravel](https://img.shields.io/badge/Laravel-11.x-FF2D20?style=for-the-badge&logo=laravel)](https://laravel.com/)
[![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php)](https://www.php.net/)
[![PostgreSQL](https://img.shields.io/badge/PostgreSQL-16+-336791?style=for-the-badge&logo=postgresql)](https://www.postgresql.org/)
[![Blade](https://img.shields.io/badge/Blade-UI_Engine-orange?style=for-the-badge)](https://laravel.com/docs/blade)
[![Tailwind](https://img.shields.io/badge/Tailwind-CSS-38B2AC?style=for-the-badge&logo=tailwind-css)](https://tailwindcss.com/)

A comprehensive, enterprise-ready Restaurant Point of Sale (POS) and operations management system designed for fast-paced hospitality environments. Features real-time table state tracking, multi-tier order processing, inventory synchronization, and cryptographic audit trails.

---

## ⚡ Core Architecture & Business Logic

- **🪑 Table & Floor Management:** Interactive floor plan tracking table statuses (Available, Occupied, Billing, Reserved) with real-time state synchronization (`app/Models/Mesa.php`).
- **🧾 Dynamic Order Processing:** Real-time order creation, item customization, kitchen ticket routing, and split-billing support (`Order.php`, `OrderItem.php`).
- **💳 Multi-Method Payment Gateway:** Integrated payment processing tracking cash, card, and digital payment methods with validation reconciliations (`Payment.php`).
- **🛡️ Security & Tamper-Evident Auditing:** Comprehensive session and transactional audit logging (`AuditLog.php`, `SessionLog.php`) recording sensitive operations, price overrides, and cancellations.
- **📦 Inventory & Menu Management:** Hierarchical category and product catalog with stock depletion tracking and pricing controls.

---

## 🛠️ Tech Stack

| Layer | Tools |
|---|---|
| **Framework** | Laravel 11.x (MVC Architecture) |
| **Language** | PHP 8.2+ |
| **Database** | PostgreSQL / MySQL with Eloquent ORM & Relational Foreign Keys |
| **Frontend** | Laravel Blade Templates, Vite, Tailwind CSS, Alpine.js |
| **Deployment** | Docker / Render / Linux Server ready (`render.yaml`) |

---

## 📂 Architecture Overview

```bash
app/
├── Http/Controllers/       # POS, Orders, Kitchen, and Table Controllers
├── Models/
│   ├── AuditLog.php        # Immutable system activity tracking
│   ├── Mesa.php            # Table floor-map state management
│   ├── Order.php           # Order status & financial totals
│   ├── OrderItem.php       # Itemized dish details & modifications
│   ├── Payment.php         # Payment transactions & invoice matching
│   └── Product.php         # Menu catalog & stock levels
├── database/migrations/    # Structured relational schema with foreign key constraints
└── resources/views/        # Responsive Blade templates for POS terminals
```

---

## 👨‍💻 Author
**Dario López** — *Backend Developer & Full-Stack Engineer*
- GitHub: [@Darlopezcdd](https://github.com/Darlopezcdd)
- Upwork: [Dario L. Profile](https://www.upwork.com)

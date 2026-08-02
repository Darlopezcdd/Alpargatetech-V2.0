# AlpargateTech v2.0

A Point of Sale (POS) system for restaurants featuring a real-time kitchen dashboard, inventory management, and sales reporting.

## 🌟 Key Features

*   **Real-time Kitchen Dashboard:** Orders are instantly sent to the kitchen using WebSockets.
*   **Comprehensive Order Management:** Waiters can select tables, pick items from the menu, and manage orders seamlessly.
*   **Inventory Control:** Track ingredients and fixed assets efficiently.
*   **Detailed Reporting:** Generate sales and performance reports.
*   **Role-based Access Control:** Dedicated panels and permissions for Admins, Waiters, and Kitchen staff.
*   **Secure Authentication:** Includes 2FA (Two-Factor Authentication) via email.

## 📸 Screenshots

![Dashboard Placeholder](https://via.placeholder.com/800x400?text=Dashboard+Overview)
*(Placeholder: Dashboard overview showing sales and active tables)*

![Kitchen Panel Placeholder](https://via.placeholder.com/800x400?text=Real-time+Kitchen+View)
*(Placeholder: Real-time kitchen view displaying pending orders)*

## 🛠️ Technology Stack

*   **Backend:** Laravel 12 + PHP 8.2
*   **Database:** PostgreSQL
*   **Frontend:** Blade + Alpine.js + Tailwind CSS
*   **Real-time / WebSockets:** Laravel Reverb
*   **PDF Generation:** DomPDF
*   **Job Queues:** Laravel Queue (Database driver)

## 📋 Prerequisites

*   PHP 8.2+
*   Composer
*   Node.js 18+
*   PostgreSQL 14+

## 🚀 Installation & Setup

1.  **Clone the repository:**
    ```bash
    git clone https://github.com/Darlopezcdd/Alpargatetech-V2.0.git
    cd Alpargatetech-V2.0
    ```
2.  **Install Dependencies:**
    ```bash
    composer install
    npm install
    ```
3.  **Environment Setup:**
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```
4.  **Database Configuration:**
    Create a database in PostgreSQL and run migrations.
    ```bash
    php artisan migrate --seed
    ```
5.  **Compile Assets & Run Server:**
    ```bash
    npm run build
    composer run dev
    ```

## 🔒 License
Private project — All rights reserved.

# 🏠 Mama Anis Kos — Premium Boarding House Showcase & Management Platform

[![Laravel](https://img.shields.io/badge/Laravel-11.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2%2B-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![TailwindCSS](https://img.shields.io/badge/Tailwind_CSS-3.x-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white)](https://tailwindcss.com)
[![SQLite](https://img.shields.io/badge/SQLite-Database-003B57?style=for-the-badge&logo=sqlite&logoColor=white)](https://sqlite.org)

**Mama Anis Kos** is a modern, high-performance web platform designed to showcase room listings, facilities, integrated local services, and provide an interactive real-time analytics dashboard for boarding house management. Built with Laravel and modern web design principles, it offers an intuitive browsing experience for prospective tenants and robust analytics for property managers.

---

## ✨ Key Features

### 🌟 Public Showcase & Tenant Experience
- **Hero & Fluid Navigation**: Responsive navbar featuring dynamic scroll morphing (transparent dark-glass in hero section, crisp white with brand emerald below hero).
- **Interactive Room Catalog**: Filterable listings with price per month, availability badges, and room types.
- **3-in-1 Room Gallery**: Multi-image slider featuring floating arrow controls, mobile touch-swipe gesture support, and thumbnail lightbox previews.
- **Mandatory Room Facilities**: Dedicated icon highlights for *Kamar Mandi Dalam*, *AC Sejuk*, *WiFi Cepat*, *Kasur Springbed & Bantal*, *Lemari Pakaian*, *Meja & Kursi*, *Listrik Token*, and *Air Bersih*.
- **Integrated Local Business Cards**: Connected service showcases for *Warung Mama Anis* (dining) and *Sari Prima Laundry* with direct inquiry links.

### 🛡️ Anti-Fraud & Security System
- **Sequential Welcome Advisory**:
  1. *Desktop Experience Modal*: Recommends viewing on larger screens for optimal visual exploration.
  2. *Security Center Advisory*: Warns prospective tenants against scams by verifying official communication channels.
- **Official Credentials Verification**: Explicitly displays official WhatsApp (`0877-8204-9784`) and bank account details (**Bank Mandiri a.n. MARLIYAH**).

### 📊 Real-Time Admin Analytics & Dashboard
- **Live Database Metrics**: Accurate view counters for total room visits, average views per unit, and growth metrics (no dummy data).
- **Interactive Chart.js View Trends**: Responsive view frequency graph with filter presets (7 Days, 30 Days, 6 Months, 1 Year) and individual room selectors.
- **Mobile-Optimized Horizontal Scroll**: Independent swipeable card containers for analytics charts and popular room rankings on mobile devices.
- **Room Activity Management**: Detailed table with view logs, last visited timestamps, and management tools.

---

## 🛠️ Technology Stack

- **Framework**: [Laravel 11.x](https://laravel.com)
- **Language**: PHP 8.2+
- **Styling**: Tailwind CSS & Vanilla CSS (Fluid Responsive Layouts)
- **Database**: SQLite (Default) / MySQL Compatible
- **Charts & Visualization**: Chart.js
- **Icons & Typography**: SVG Icons, Google Fonts (Plus Jakarta Sans, Montserrat, JetBrains Mono)

---

## 🚀 Getting Started

### Prerequisites
- PHP `>= 8.2`
- Composer
- Node.js & npm (optional, for asset bundling)

### Installation Steps

1. **Clone the Repository**
   ```bash
   git clone https://github.com/your-username/mamaanis_kos.git
   cd mamaanis_kos
   ```

2. **Install PHP Dependencies**
   ```bash
   composer install
   ```

3. **Environment Setup**
   Copy the example environment configuration file:
   ```bash
   cp .env.example .env
   ```
   Generate the application key:
   ```bash
   php artisan key:generate
   ```

4. **Database Configuration & Seeding**
   Initialize the SQLite database (or configure MySQL in `.env`):
   ```bash
   touch database/database.sqlite
   php artisan migrate --seed
   ```

5. **Run the Development Server**
   ```bash
   php artisan serve
   ```
   Open your browser and navigate to `http://127.0.0.1:8000`.

---

## 🔐 Security & Anti-Fraud Notice

> **IMPORTANT**: Official transactions and inquiries are strictly conducted through the following channels:
> - **Official WhatsApp**: `+62 877-8204-9784`
> - **Official Bank Account**: **Bank Mandiri** `a.n. MARLIYAH`
> 
> *Mama Anis Kos is not responsible for transactions conducted outside of these official credentials.*

---

## 📝 License

This project is open-source software licensed under the [MIT License](LICENSE).

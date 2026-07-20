<div align="center">

![Logo](public/assets/static/logo.svg)

# DashUninet

### Portal Utama Uninet Untuk Layanan Pelanggan

**PT. Uninet Media Sakti**

[![Laravel](https://img.shields.io/badge/Laravel-8.x-FF2D20?style=flat-square&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-%5E7.3%7C8.0-777BB4?style=flat-square&logo=php&logoColor=white)](https://www.php.net)
[![MySQL](https://img.shields.io/badge/MySQL-5.7+-4479A1?style=flat-square&logo=mysql&logoColor=white)](https://www.mysql.com)
[![Tabler](https://img.shields.io/badge/UI-Tabler-4263EB?style=flat-square&logo=tabler&logoColor=white)](https://tabler.io)

</div>

---

## Deskripsi

**DashUninet** adalah portal back-office CRM/ERP terintegrasi untuk pengelolaan layanan internet **PT. Uninet Media Sakti**. Aplikasi ini mengelola siklus hidup pelanggan lengkap mulai dari leads penjualan, order, aktivasi langganan (otomatis via Mikrotik RouterOS), penagihan invoice, hingga support ticket.

---

## Arsitektur Sistem

```mermaid
graph TB
    subgraph "Frontend"
        UI[Tabler Dashboard UI]
        JS[jQuery + ApexCharts]
    end

    subgraph "Backend - Laravel 8"
        CTRL[Controllers]
        MID[Middleware]
        JOB[Queue Jobs]
        HELP[Helpers]
    end

    subgraph "Database"
        DB[(MySQL - portaluninet)]
    end

    subgraph "Integrasi Eksternal"
        MIK[Mikrotik RouterOS<br/>Port 8728]
        API[Backend API<br/>api-staging.uninet.net.id]
        MOB[Mobile App<br/>com.uninet.umscustomerapp]
    end

    UI --> CTRL
    JS --> CTRL
    CTRL --> DB
    CTRL --> JOB
    JOB --> MIK
    CTRL --> API
    API --> MOB
    MID --> CTRL
    HELP --> CTRL
```

---

## Alur Kerja Pelanggan

```mermaid
flowchart LR
    A[Pipeline<br/>Leads] -->|Create Order| B[Sales Order<br/>SO]
    B -->|Approve| C[Order<br/>Approved]
    C -->|Buat SPK| D[SPK<br/>Work Order]
    D -->|Installasi| E[Subscription<br/>Active]
    E -->|Auto Generate| F[Invoice<br/>Published]
    F -->|Bayar| G[Payment<br/>Paid]
    G -->|Auto Activate| E
    F -->|Jatuh Tempo| H[Overdue]
    H -->|Auto Suspend| I[Suspended]
    I -->|Bayar| G
    E -->|Expired| J[Deactive]

    style A fill:#4263eb,color:#fff
    style E fill:#2b9348,color:#fff
    style F fill:#fb8500,color:#fff
    style J fill:#e63946,color:#fff
```

---

## Fitur Utama

### Dashboard

| Dashboard | Fungsi |
|-----------|--------|
| **Dashboard Utama** | Ringkasan performa bisnis secara real-time |
| **Revenue** | Analisis pendapatan per periode |
| **Subscription** | Statistik langganan aktif/nonaktif |
| **Sales Order** | Performa penjualan & progress order |

### Modul Penjualan

| Modul | Fungsi |
|-------|--------|
| **Pipeline** | Manajemen leads & prospek penjualan |
| **Sales Order** | Pembuatan, approve, progress tracking order |
| **SPK / BA** | Surat Perintah Kerja & Berita Acara digital |
| **Komisi** | Tracking komisi sales per order |

### Modul Layanan

| Modul | Fungsi |
|-------|--------|
| **Subscription** | Aktivasi, update, suspensi, deaktivasi langganan |
| **Mikrotik Router** | Manajemen perangkat jaringan & PPPoE secrets |
| **Auto Job** | Auto activate/suspend/deactivate via queue jobs |

### Modul Keuangan

| Modul | Fungsi |
|-------|--------|
| **Invoice** | Draft, publish, batch publish, reminder |
| **Pembayaran** | Upload bukti bayar, approval, payment tracking |
| **Deposit** | Topup deposit, approval, auto-deduct balance |
| **Promo** | Kode promosi & diskon |

### Modul Pelanggan

| Modul | Fungsi |
|-------|--------|
| **Customer** | Data pelanggan aktif, korporat, membership |
| **Downline** | Sistem referral & jaringan pelanggan |
| **Credit Point** | Poin loyalitas & reward redemption |
| **Loyalty** | Katalog reward & pengelolaan hadiah |

### Modul Support

| Modul | Fungsi |
|-------|--------|
| **Ticket** | Layanan pelanggan (open/close/overdue) |
| **Documentation** | CMS dokumentasi & panduan pengguna |

### Modul Lainnya

| Modul | Fungsi |
|-------|--------|
| **Product** | Katalog produk, harga, billing cycle |
| **Reseller** | Manajemen mitra/reseller |
| **Project** | Site project & area cakupan |
| **Banner** | Manajemen banner aplikasi |
| **Report** | Export laporan ke Excel (Customer, Subscription, Invoice) |

---

## Role & Akses

```mermaid
graph LR
    subgraph "Role Akses"
        R1[Sales Executive]
        R2[NOC]
        R3[Admin / Super Admin]
        R4[Finance]
        R5[Sales Leader]
        R6[Manager]
        R7[Billing]
    end

    R1 -->|Pipeline, SO| S1[Penjualan]
    R2 -->|Subscription, Router| S2[Jaringan]
    R3 -->|Semua Modul| S3[Full Access]
    R4 -->|Invoice, Payment| S4[Keuangan]
    R5 -->|Pipeline, Komisi| S5[Supervisi Sales]
    R6 -->|Report, Approval| S6[Manajemen]
    R7 -->|Invoice, Deposit| S7[Penagihan]
```

| Role | Akses Utama |
|------|-------------|
| **Sales Executive** | Pipeline, Sales Order, Komisi |
| **NOC** | Subscription, Router, Auto Jobs |
| **Admin** | Seluruh modul (full access) |
| **Finance** | Invoice, Payment, Deposit, Report |
| **Sales Leader** | Pipeline, Komisi, Supervisi |
| **Manager** | Report, Approval, Manajemen |
| **Billing** | Invoice, Deposit, Penagihan |

---

## Integrasi Eksternal

```mermaid
sequenceDiagram
    participant Dash as DashUninet
    participant Mik as Mikrotik RouterOS
    participant BE as Backend API
    participant App as Mobile App

    Dash->>Mik: PPPoE Secret (activate/deactivate)
    Mik-->>Dash: Status response

    Dash->>BE: Upload file / image
    BE-->>Dash: File URL

    Dash->>BE: Push notification
    BE->>App: Notify pelanggan

    Dash->>BE: Email notification
    BE-->>App: Transactional email
```

| Layanan | Protocol | Fungsi |
|---------|----------|--------|
| **Mikrotik RouterOS** | TCP :8728 | PPPoE secret management, disconnect sessions |
| **Backend API** | HTTPS | File upload, push notification, email |
| **Mobile App** | Deep Link | `com.uninet.umscustomerapp` (Android) |

---

## Tech Stack

| Layer | Teknologi |
|-------|-----------|
| **Backend** | Laravel 8.75, PHP ^7.3\|^8.0 |
| **Database** | MySQL (portaluninet) |
| **Frontend** | Tabler Dashboard, jQuery 3.6, ApexCharts |
| **Auth** | Laravel Session + Role-Based Access Control |
| **API Auth** | Laravel Sanctum |
| **Export** | Maatwebsite Excel |
| **ID Generator** | haruncpi/laravel-id-generator |
| **Network** | Mikrotik RouterOS API (PHP Socket Client) |
| **CI/CD** | GitLab CI → SSH Deploy |

---

## Setup & Installation

### Prerequisites

- PHP ^7.3 atau ^8.0
- MySQL 5.7+
- Composer
- Node.js & NPM
- Mikrotik Router (untuk integrasi jaringan)

### Instalasi

```bash
# Clone repository
git clone <repository-url>
cd dashuninet

# Install dependency PHP
composer install

# Install dependency JS
npm install

# Copy environment
cp .env.example .env

# Generate app key
php artisan key:generate

# Konfigurasi database di .env
# DB_DATABASE=portaluninet
# DB_USERNAME=root
# DB_PASSWORD=

# Build assets
npm run dev

# Jalankan server
php artisan serve
```

### Konfigurasi Environment

Variabel penting di `.env`:

```env
APP_NAME=DashUninet
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=portaluninet
DB_USERNAME=root
DB_PASSWORD=

# Backend API (file upload, notification)
BACKEND_URL=https://api-staging.uninet.net.id
```

---

## Struktur Aplikasi

```
dashuninet/
├── app/
│   ├── Console/            # Task scheduler
│   ├── Exports/            # Excel export classes
│   ├── Helpers/            # DepositHelper, SubscriptionHelper
│   ├── Http/
│   │   ├── Controllers/    # 17 controllers
│   │   └── Middleware/     # Auth, FraudOrder, Cors
│   ├── Jobs/              # AutoactiveJob, AutodeactiveJob, dll
│   ├── Library/           # RouterosAPI client
│   └── Models/            # 48 Eloquent models
├── resources/views/
│   ├── layouts/           # Main layout (console.blade.php)
│   ├── component/
│   │   ├── navbar.blade.php
│   │   ├── canvas/        # 19 filter panels
│   │   └── modal/         # 43 modal dialogs
│   └── page/              # 63+ page views
├── routes/
│   ├── web.php            # 338 routes
│   └── api.php            # API endpoints
└── public/assets/         # Tabler UI, static files
```

---

<div align="center">

**PT. Uninet Media Sakti** — DashUninet Portal

</div>

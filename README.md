<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

---

# **Dokumentasi Setup Project Skill Assestment Web Company Profile Haventwined**  

## **1. Clone Repository**  
```bash
git clone https://github.com/abyalax/Skill-Assesment-Test-Havenwined.git
cd Skill-Assesment-Test-Havenwined
```

## **2. Install Dependencies**  

### **Backend (Laravel)**
```bash
composer install
cp .env.example .env
```

### **Frontend (Vue)**
```bash
npm install
```

## **3. Konfigurasi Environment (`.env`)**  
Edit file `.env` dan masukkan credential berikut:  

```env
# URL Cloudinary untuk upload banner
CLOUDINARY_URL="cloudinary://api_key:secret_key"

# Credential EmailJS
VITE_SERVICE_ID=service_exampleID
VITE_TEMPLATE_ID=template_exampleID
VITE_USER_ID=4_nJ_7TTYexample_USerID

# Konfigurasi Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_haventwined
DB_USERNAME=root
DB_PASSWORD=
```

## **4. Generate Key & Migrasi Database**
```bash
php artisan key:generate
php artisan migrate --seed
```

## **5. Menjalankan Server Backend & Frontend**  

### **Terminal 1 - Laravel (Backend)**
```bash
php artisan serve
```

### **Terminal 2 - Vue (Frontend)**
```bash
npm run dev
```

## **6. Login ke Dashboard**  
Akses aplikasi di `http://localhost:8000`.  
Gunakan kredensial login berikut:  

- **Email:** `admin@haventwined.com`  
- **Password:** `password1234`  

## **7. Mengelola Company Profile**  
Setelah login, navigasikan ke **"Manage Company Profile"** di navbar atas untuk mengelola informasi perusahaan.  

## **8. Struktur Penyimpanan Aset**  
- **Event dan aset lainnya:** disimpan di `public/images/`  
- **Banner:** diunggah secara **dinamis** menggunakan **Cloudinary**  

## **9. Next Development**  
- Implementasi **CRUD untuk Event Company**  
- Integrasi dengan fitur tambahan jika diperlukan  

---

### **Tech Stack**  

#### **Frontend (Vue 3 + Vite + Tailwind CSS)**  
- **Framework:** Vue 3 (SSR)  
- **Router & State Management:** Inertia.js  
- **Styling:** Tailwind CSS  
- **SSR & Rendering:** Vue Server Renderer, @vueuse/head  
- **Markdown & Editor:** Marked, SimpleMDE, Vditor, Vue Markdown Render  ( untuk fitur events company di next development )
- **Image Management:** Cloudinary Vue  

#### **Backend (Laravel 10 + Breeze + Sanctum)**  
- **Framework:** Laravel 10  
- **Auth & Security:** Laravel Breeze, Sanctum  
- **Database & ORM:** MySQL, Eloquent  
- **Image Upload:** Cloudinary Laravel  
- **API & HTTP Client:** Guzzle  
- **Routing Helper:** Tightenco Ziggy  

#### **Build & Dev Tools**  
- **Frontend Bundler:** Vite  
- **Code Formatting & Testing:** Laravel Pint, PHP CS Fixer, PHPUnit  
- **Local Dev:** Laravel Sail, Mockery  

🚀 **Stack ini digunakan untuk membangun aplikasi SSR Vue dengan Laravel sebagai backend serta integrasi Cloudinary untuk manajemen gambar.**

### 🚀 **Proyek siap dijalankan!**  
Jika ada kendala, pastikan semua service sudah berjalan dan environment sudah dikonfigurasi dengan benar.
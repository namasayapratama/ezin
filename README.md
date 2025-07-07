# 🚀 Panduan Setup Proyek Laravel

<div class="alert alert-info">
<strong>📌 Prerequisite:</strong> Pastikan sudah terinstall:
- PHP ≥ 8.1
- Composer
- Node.js & npm
- Git
</div>

## 📥 1. Clone Repository
```bash
git clone https://github.com/username/repo-project.git
cd repo-project
```

## 🔑 2. Setup Environment
```bash
cp .env.example .env
php artisan key:generate
```

<div class="alert alert-warning">
<strong>⚠️ Penting:</strong> Edit file <code>.env</code> dengan konfigurasi:
- Database credentials
- Mail server settings
- Konfigurasi lainnya
</div>

## 📦 3. Install Dependencies
```bash
composer install --no-dev
npm install
npm run build
```

## 🗃️ 4. Setup Database
```bash
php artisan migrate --seed
```

## 🔗 5. Storage Link (Jika perlu)
```bash
php artisan storage:link
```

## ⚡ 6. Optimasi Aplikasi
```bash
php artisan optimize
```

## 🚦 7. Jalankan Development Server
```bash
php artisan serve
```

## 🔧 Perintah Tambahan
```bash
# Clear cache
php artisan cache:clear

# Generate IDE helper
php artisan ide-helper:generate

# Jalankan test
php artisan test
```

## 🛠️ Troubleshooting
### Error Permission
```bash
chmod -R 775 storage/
chmod -R 775 bootstrap/cache/
```

### Error Class Not Found
```bash
composer dump-autoload
```

---

**Catatan**:  
- Untuk production, gunakan `--no-dev` pada composer install
- Pastikan file `.env` tidak di-commit ke repository
- Notifikasi WA membutuhkan langganan API WA
- key pada setting WA adalah token.secret (gabungan token dan secret) penyedia API lain mungkin hanya membutuhkan token saja.
  

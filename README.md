# HRIS Web App (Studi Kasus)

Aplikasi ini dibuat sebagai bahan studi kasus untuk belajar pengembangan web menggunakan **Laravel 12**. Aplikasi ini memiliki fitur yang menyerupai **HRIS (Human Resource Information System)** dengan fungsi dasar seperti autentikasi, presensi, manajemen tugas, cuti, dan payroll.

---

## Fitur Utama

- **Autentikasi**
    - Login dan Logout
- **Dashboard HR & Developer**
    - Statistik presensi (Chart.js)
    - Daftar tugas terbaru
- **Dashboard Sales (Personal)**
    - Ringkasan kehadiran, payroll, dan sisa jatah cuti
    - Halaman presensi pribadi
    - Halaman payroll pribadi
    - Pengajuan dan riwayat cuti dengan info sisa jatah cuti
- **Presensi**
    - Check-in dan Check-out karyawan
- **Manajemen Tugas (Task)**
    - Buat, ubah, update status (Done, Pending)
- **Cuti**
    - Pengajuan cuti oleh karyawan
    - Persetujuan dan penolakan oleh HR
- **Payroll**
    - Mengelola data gaji karyawan
- **Manajemen Karyawan**
    - Tambah, edit, hapus data karyawan
- **Manajemen Departemen & Role**
    - Tambah, edit, hapus departemen dan role

---

## Teknologi yang Digunakan

- **Framework**: Laravel 12
- **Template**: [Mazer](https://github.com/zuramai/mazer)
- **Database**: MySQL
- **Frontend Tools**:
    - Blade Template
    - Chart.js
    - Flatpickr
    - Select2
    - SweetAlert2

---

## Persyaratan Sistem

- PHP >= 8.2
- Composer
- MySQL
- Node.js & NPM

---

## Proses Instalasi

1. **Clone repository**
   ```bash
   git clone https://github.com/ihsanzakyf/humanresourcesapp.git
   cd humanresourcesapp
   ```

2. **Install dependency Laravel**
   ```bash
   composer install
   ```

3. **Install dependency frontend**
   ```bash
   npm install && npm run build
   ```

4. **Salin file .env**
   ```bash
   cp .env.example .env
   ```

5. **Konfigurasi database di `.env`**
   ```env
   DB_DATABASE=hris_db
   DB_USERNAME=root
   DB_PASSWORD=
   ```

6. **Generate key aplikasi**
   ```bash
   php artisan key:generate
   ```

7. **Migrasi database dan seeder**
   ```bash
   php artisan migrate:fresh --seed
   ```

8. **Jalankan server**
   ```bash
   php artisan serve
   ```

---

## Akun Default

| Role      | Email                  | Password |
|-----------|------------------------|----------|
| HR        | test@example.com       | password |
| Developer | developer@mail.com     | password |
| Sales     | emp@example.com        | password |

---

## Hak Akses Per Role

| Fitur              | HR  | Developer | Sales |
|--------------------|-----|-----------|-------|
| Dashboard utama    | Ya  | Ya        | -     |
| Employees          | Ya  | -         | -     |
| Departments        | Ya  | -         | -     |
| Roles              | Ya  | -         | -     |
| Tasks              | Ya  | Ya        | -     |
| Presences (semua)  | Ya  | Ya        | -     |
| Payrolls (semua)   | Ya  | Ya        | -     |
| Leave Requests     | Ya  | Ya        | -     |
| Sales Dashboard    | -   | -         | Ya    |
| Presences (sendiri)| -   | -         | Ya    |
| Payrolls (sendiri) | -   | -         | Ya    |
| Cuti (sendiri)     | -   | -         | Ya    |

---

## Developer

**Abdul Falaq**
abdulfalaq5@gmail.com

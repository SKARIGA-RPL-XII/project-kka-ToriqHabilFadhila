## Deskripsi
LMS atau Learning Management System adalah aplikasi berbasis web yang digunakan sekolah untuk mengelola kegiatan belajar mengajar secara digital. Melalui LMS, pembelajaran tidak hanya berlangsung di kelas, tetapi juga dapat dilakukan secara online dalam satu sistem yang rapi dan terpusat. Guru dapat membuat kelas, mengunggah materi, memberikan tugas dan kuis, serta melakukan penilaian, sementara siswa dapat mengakses materi kapan saja, mengumpulkan tugas secara online, melihat nilai, dan memantau perkembangan belajarnya sendiri.

## Teknologi
- Laravel 11
- PostgreSQL
- Tailwind CSS

## Cara Instalasi
1. Clone repository
git clone https://github.com/username/nama-repo.git

2. Masuk ke folder project
cd nama-repo

3. Install dependency
composer install
composer require laravel/socialite
npm install


4. Copy file environment
cp .env.example .env

5. Generate key
php artisan key:generate

6. Setting database di .env

7. Migrasi database
php artisan migrate

## Menjalankan Aplikasi (Development)
1. Jalankan server Laravel
php artisan serve

2. Jalankan Tailwind & asset bundler
npm run dev
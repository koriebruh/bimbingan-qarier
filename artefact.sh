#composer require laravel/breeze --dev
php artisan db:seed
php artisan make:migration create_obats_tabel --create=obats
php artisan make:migration create_jadwal_periksas_tabel --create=jadwal_periksas
php artisan make:migration create_janji_periksas_tabel --create=janji_periksas
php artisan make:migration create_periksas_tabel --create=periksas
php artisan make:migration create_detail_periksas_tabel --create=detail_periksas
php artisan make:migration create_poli_tabel --create=poli
php artisan make:migration create_chat_tabel --create=chat
#
php artisan make:seeder UsersTableSeeder
php artisan make:seeder ObatsTableSeeder
php artisan make:seeder JadwalPeriksasTableSeeder
php artisan make:seeder JanjiPeriksasTableSeeder
php artisan make:seeder PeriksasTableSeeder
php artisan make:seeder DetailPeriksasTableSeeder
php artisan make:seeder PoliTableSeeder
php artisan make:seeder ChatTableSeeder

php artisan make:model Poli
php artisan make:model User
php artisan make:model Obat
php artisan make:model JadwalPeriksa
php artisan make:model JanjiPeriksa
php artisan make:model Periksa
php artisan make:model DetailPeriksa
php artisan make:model Chat

php artisan tinker
App\Models\User::all();
App\Models\Obat::all();
App\Models\JadwalPeriksa::all();
App\Models\JanjiPeriksa::all();
App\Models\Periksa::all();
App\Models\DetailPeriksa::all();

php artisan make:controller DokterController
php artisan make:controller Dokter/DokterController
php artisan make:controller Dokter/ObatController
php artisan make:controller Dokter/PeriksaController
php artisan make:controller Dokter/JadwalPeriksaController
php artisan make:controller Dokter/ChatDokterController

php artisan make:controller Dokter/MemeriksaController

php artisan make:controller Pasien/PeriksaController
php artisan make:controller Pasien/ChatPasienController

php artisan make:controller Pasien/JanjiPeriksaController

php artisan make:controller Admin/AdminController

php artisan make:controller admin/UserManagementController
php artisan make:controller admin/PasienManagementController

php artisan make:controller admin/PoliController
php artisan make:controller admin/ObatController

php artisan migrate:refresh --seed

{{ route('dashboard') }}


php artisan route:list | grep jadwal_periksa

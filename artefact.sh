#composer require laravel/breeze --dev
php artisan db:seed
php artisan make:migration create_obats_tabel --create=obats
php artisan make:migration create_jadwal_periksas_tabel --create=jadwal_periksas
php artisan make:migration create_janji_periksas_tabel --create=janji_periksas
php artisan make:migration create_periksas_tabel --create=periksas
php artisan make:migration create_detail_periksas_tabel --create=detail_periksas
#
php artisan make:seeder UsersTableSeeder
php artisan make:seeder ObatsTableSeeder
php artisan make:seeder JadwalPeriksasTableSeeder
php artisan make:seeder JanjiPeriksasTableSeeder
php artisan make:seeder PeriksasTableSeeder
php artisan make:seeder DetailPeriksasTableSeeder

php artisan make:model User
php artisan make:model Obat
php artisan make:model JadwalPeriksa
php artisan make:model JanjiPeriksa
php artisan make:model Periksa
php artisan make:model DetailPeriksa

php artisan tinker
App\Models\User::all();
App\Models\Obat::all();
App\Models\JadwalPeriksa::all();
App\Models\JanjiPeriksa::all();
App\Models\Periksa::all();
App\Models\DetailPeriksa::all();

php artisan make:controller DokterController
php artisan make:controller PasienController

php artisan migrate:refresh --seed

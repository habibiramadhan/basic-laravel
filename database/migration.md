composer require laravel/sanctum

# Generate Migration Commands
php artisan make:migration modify_users_table --table=users
php artisan make:migration create_website_settings_table
php artisan make:migration create_kategori_alat_table
php artisan make:migration create_alat_berat_table
php artisan make:migration create_pemesanan_table
php artisan make:migration create_pembayaran_table


# Generate Seeders
php artisan make:seeder UserSeeder
php artisan make:seeder WebsiteSettingSeeder
php artisan make:seeder KategoriAlatSeeder
php artisan make:seeder AlatBeratSeeder


# Generate Models
php artisan make:model WebsiteSetting
php artisan make:model KategoriAlat
php artisan make:model AlatBerat
php artisan make:model Pemesanan
php artisan make:model Pembayaran

# Generate Middlewares
php artisan make:middleware AdminMiddleware
php artisan make:middleware CustomerMiddleware
php artisan make:middleware ShareWebsiteSettings


php artisan migrate --seed 
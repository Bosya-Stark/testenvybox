#backend
composer install
php artisan key:generate
php artisan migrate
php artisan serve

#frontend
npm install
npm run serve
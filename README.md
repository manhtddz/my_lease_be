<!-- install -->
composer install 
cp .env.example .env
php artisan key:generate
php artisan optimize:clear
php artisan storage:link
php artisan migrate
php artisan db:seed

npm install
<!-- run -->
php artisan serve
npm run dev
<!-- truy cập route  -->
http://127.0.0.1:8000/admin

php -r "copy('.env.example', '.env');"
call composer install
call php artisan key:generate
call php artisan migrate:refresh --seed
call npm install
start cmd /k "npm run dev"
start cmd /k "php artisan serve"
timeout 5
start http://127.0.0.1:8000

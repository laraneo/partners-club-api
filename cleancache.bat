echo Cleaning caches..
php artisan cache:clear 
php artisan configuracion:clear
composer dump-autoload
echo Clean finished.
pause
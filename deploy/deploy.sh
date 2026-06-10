set -e

php artisan migrate --force
php artisan optimize
php artisan queue:restart
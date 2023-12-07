<p align="center">Documentación de la prueba técnica</p>

<p>Configura el archivo .env y el archivo .env.testing con las variables enviadas por email</p>

git clone git@github.com:GaitanGonzalo/prueba_tecnica.git
php artisan migrate --seeder
php artisan config:clear
php artisan test

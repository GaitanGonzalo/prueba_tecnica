<p align="center">Documentación de la prueba técnica</p>

<p>Configura el archivo .env y el archivo .env.testing con las variables enviadas por email</p>

git clone git@github.com:GaitanGonzalo/prueba_tecnica.git
php artisan migrate --seeder
php artisan config:clear
php artisan test

Una vez corrieron los test hay que agregar apikey al array de middlewares en la primera posición, esto es en el archivo de rutas/api.

#[INFO] Api
usuario de prueba
email:test@test1.com
password:password
LOGIN
#dominio es en caso de pruebas localhost:puerto

[POST] #dominio#/api/login
una vez logueado utilizar el token y api key que fue enviada por email.
[GET] #dominio#/api/customers
[POST] #dominio#/api/customers
[DELETE]#dominio#/api/customers/customer
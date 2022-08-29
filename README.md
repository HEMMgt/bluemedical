# Blue Medical
Creado: Hugo Morán
## Prueba técnica Full Stack
Se desea administrar el acceso de vehículos a un estacionamiento de pago. El
estacionamiento no se encuentra automatizado, por lo que existe un empleado
encargado de registrar las entradas y salidas de vehículos.
Los vehículos se identifican por su número de placa. Cuando un vehículo entra en el
estacionamiento el empleado registra su entrada y al salir registra su salida y, en
algunos casos, cobra el importe correspondiente por el tiempo de estacionamiento..

## Caracteristicas

- Los vehículos oficiales no pagan, pero se registran sus estancias para llevar
el control. (Una estancia consiste en una hora de entrada y una de salida)
- Los residentes pagan a final de mes a razón de $0.05 el minuto. La aplicación
irá acumulando el tiempo (en minutos) que han permanecido estacionados.
- Los no residentes pagan a la salida del estacionamiento a razón de $0.5 por
minuto. Se prevé que en el futuro puedan incluirse nuevos tipos de vehículos,
por lo que la aplicación desarrollada deberá ser fácilmente extensible en ese
aspecto.

## Funconamiento API

Pequeño video muestra el funcionamiento de la API duración 6 minutos
[Ver Video](https://drive.google.com/file/d/1A9hUACneqI45OQOCzGRKlx8ykw_7jxj1/view?usp=sharing) 

## Instalación

El proyecto debe ser descargado o clonado en el presente respositorio [Github](https://github.com/HEMMgt/bluemedical.git).

Agregando dentro de su git local remotamente.

```sh
git remote add origin https://github.com/HEMMgt/bluemedical.git
git branch -M main
git pull -u origin main
```

Debe tener instalado composer y nodejs y ejecutar los siguientes comandos.

```sh
composer install
npm install
```
Correr las migraciones (ya debe tener configurado su entorno en el arhivo .env)

```sh
php artisan migrate
```

Crear los registros iniciales usando seed
-  Regista los 3 tipos de vehiculos existente
-  Registra 4 vehiculos 
-  Crea empleado admin@bluemedical.com pass: Blue123

```sh
php artisan db:seed
```


Inicializar los servicios.

```sh
php artisan serve
```
Abrir su navegador
```sh
127.0.0.1:8000
```
## Plugins

Adicional a las dependencias ya definidas.

| Plugin | README |
| ------ | ------ |
| jwt-auth | [https://jwt-auth.readthedocs.io/en/develop/][PlDb] |
| laravel/spanish | [https://github.com/Laraveles/spanish][PlGh] |


## Documentación
Muy pronto


## License

MIT
# dssd-unlp-2021-grupo11-paises-estados-service

# Comenzando 馃殌

_Sigue las siguientes instrucciones para clonar este repositorio en tu m谩quina local_

### Pre-requisitos 馃搵

- docker-compose
https://docs.docker.com/compose/install/

- Haber clonado e instalado el docker-compose provisto por el grupo, siguiendo la gu铆a de instalaci贸n provista https://github.com/juliancasaburi/dssd-unlp-2021-grupo11-laradock

### Instalaci贸n 馃敡

_Sigue las siguientes instrucciones para clonar el repositorio_

_1. Posicionese sobre el directorio dssd-unlp-2021-grupo11-laradock_
```
cd ./dssd-unlp-2021-grupo11-laradock
```

_2. Posicionese sobre el directorio_

```
cd dssd-unlp-2021-grupo11-paises-estados-service
```

_3. Configure el repositorio_

```
sudo chmod -R 777 storage bootstrap/cache
```

_4. Configure las variables de entorno_

Configure las variables en el archivo ` .env`

### En el primer inicio del servicio, deber谩 instalar las dependencias y realizar algunas actividades de configuraci贸n

Luego de iniciar el docker-compose provisto, deber谩 ejecutar los siguientes comandos

```
cd ./dssd-unlp-2021-grupo11-laradock/laradock
sudo docker-compose exec workspace /bin/bash
cd dssd-unlp-2021-grupo11-paises-estados-service
composer install
php artisan key:generate
php artisan jwt:secret
php artisan migrate
```

# Accediendo a la api
La api puede accederse en http://localhost:81

# Endpoints - Documentaci贸n
La documentaci贸n generada por OpenAPI/Swagger, puede ser accedida en http://localhost:81/api/docs

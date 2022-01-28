# Ru
## Установить
### без sail
```
* Версия Php должна быть 7.4 | 8.*
> cd /new-task/
> composer install
> php artisan migrate
> php artisan passport:install
> php artisan npm install
> php artisan npm run dev
> php artisan serve
```
* вы открываете http://localhost:8000

### С sail
* сначала проверьте, установлены ли docker и docker-compose:
```
> cd /new-task/
> ./vendore/bin/sail up
> # Ждать ...
```
* Откройте вторую вкладку терминала::
```
> ./vendore/bin/sail artisan migrate
> ./vendore/bin/sail artisan passport:install
> ./vendore/bin/sail artisan npm install
> ./vendore/bin/sail artisan npm run dev
```
* вы открываете http://localhost

# En
## Setup
### without sail
```
* Php verion must be 7.4 | 8.*
> cd /new-task/
> composer install
> php artisan migrate
> php artisan passport:install
> php artisan npm install
> php artisan npm run dev
> php artisan serve
```
* then you open http://localhost:8000

### With sail
```
* check first if docker and docker-compose are installed, then:
> cd /new-task/
> ./vendore/bin/sail up
```
* Open a second terminal tab and you run:

```
> ./vendore/bin/sail artisan migrate
> ./vendore/bin/sail artisan passport:install
> ./vendore/bin/sail artisan npm install
> ./vendore/bin/sail artisan npm run dev
```
* then you open http://localhost

## Примечание

* Я push с директора `vendor`, чтобы использовать `sail`


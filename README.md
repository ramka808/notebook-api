## Задание


Разработать REST API для записной книжки . Примерная структура методов: 


    1.1. GET /api/v1/notebook/
    1.2. POST /api/v1/notebook/
    1.3. GET /api/v1/notebook/<id>/
    1.4. POST /api/v1/notebook/<id>/
    1.5. DELETE /api/v1/notebook/<id>/
    
    
Поля для POST запискной книжки: 
   
   
    1. ФИО (обязательное)
    2. Компания
    3. Телефон (обязательное)
    4. Email (обязательное)
    5. Дата рождения 
    6. Фото


Нужна возможность выводить информацию в списке постранично 

## Запуск
```
docker-compose up -d
```
Подождать минуту(идет composer install)

### Сервер http://localhost:8876

### PhpMyAdmin http://localhost:8080

### Маршруты https://app.swaggerhub.com/apis-docs/RAMIL1234717_1/Notebook-api/1.0.2#/Notebook

## Тестирование
```
docker exec -it project_app php artisan test
```

# Instalacja

1. Pobieramy gita: 
    
    `git clone https://github.com/avatec/codiway.git`

2. Wchodzimy w katalog codiway `cd codiway`
3. Wykonujemy polecenie `composer install`
4. Wykonujemy polecenie `cp .env.example .env`
5. Wykonujemy polecenie `php artisan key:generate`
6. Edytujemy .env i wprowadzamy następujące dane:
    ```
    APP_PORT=8080
    DB_HOST=mysql
    DB_DATABASE=github_app
    DB_USERNAME=sail
    DB_PASSWORD=password
    ```
7. Wykonujemy polecenie `npm install && npm run build`
8. Wykonujemy polecenie `./sail up` (docker powinien być uruchomiony)
9. Wchodzimy na zakładkę: http://127.0.0.1:8080/register podajemy dane do logowania
10. Gotowe - wszystko śmiga :-)

### Lista przykładowych repozytoriów:
    - https://github.com/TicketSwap/omnipay-przelewy24
    - https://github.com/smarty-php/smarty
    - https://github.com/laravel/sail
    - https://github.com/twigphp/Twig
    - https://github.com/WordPress/WordPress

### Api

Dostępne jest pod adresem: http://127.0.0.1:8080/api/github/ (nie tworzyłem systemu authentyfikacji użytkownika)

### Dodatkowe informacje

Tworzenie dokumentacji wykonujemy poleceniem 

```php artisan vendor:publish --tag=request-docs-config --force```

Dostęp do dokumentacji: http://127.0.0.1:8080/request-docs/



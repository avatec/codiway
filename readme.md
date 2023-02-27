# Instalacja

1. Pobierz repozytorium
2. Wejdź do katalogu github-app: ``` cd github-app ```
3. Wykonaj polecenie: ``` composer update ```
4. Upewnij się, że plik sail ma uprawnienie wykonania ``` chmod +x ./sail ```
5. Uruchom aplikację: ``` ./sail up ``` a następnie wykonaj migrację ```./sail artisan migrate:install```
6. Otwórz przeglądarkę pod adresem ```https://127.0.0.1:8080```
7. Kliknij na register ```http://127.0.0.1:8080/register``` i utwórz swoje konto.
8. Przejdź do zakładki ```repozytoria```
9. Dodaj repozytoria (lista przykładowych):
    - https://github.com/TicketSwap/omnipay-przelewy24
    - https://github.com/smarty-php/smarty
    - https://github.com/laravel/sail
    - https://github.com/twigphp/Twig
    - https://github.com/WordPress/WordPress
10. Api dostępne jest pod adresem: http://127.0.0.1:8080/api/github/ (nie tworzyłem systemu authentyfikacji użytkownika)

## Dodatkowe informacje

Tworzenie dokumentacji wykonujemy poleceniem ```php artisan vendor:publish --tag=request-docs-config --force```.

Dostęp do dokumentacji: ```http://127.0.0.1:8080/request-docs/```



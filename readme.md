# Instalacja

1. Pobierz repozytorium
2. Wejdź do katalogu github-app: ``` cd github-app ```
3. Wykonaj polecenie: ``` composer update ```
4. Upewnij się, że plik sail ma uprawnienie wykonania ``` chmod +x ./sail ```
5. Uruchom aplikację: ``` ./sail up ```
6. Otwórz przeglądarkę pod adresem ```https://127.0.0.1```
7. Kliknij na register ```http://127.0.0.1/register``` i utwórz swoje konto.
8. Zaloguj się ```http://127.0.0.1/login``` podając swoje dane.
9. Przejdź do zakładki ```repozytoria```
10. Dodaj repozytoria (lista przykładowych):
    - https://github.com/TicketSwap/omnipay-przelewy24
    - https://github.com/smarty-php/smarty
    - https://github.com/laravel/sail
    - https://github.com/twigphp/Twig
    - https://github.com/WordPress/WordPress
11. Api dostępne jest pod adresem: http://127.0.0.1/api/github/ (nie tworzyłem systemu authentyfikacji użytkownika)

## Dodatkowe informacje

Tworzenie dokumentacji wykonujemy poleceniem ```php artisan vendor:publish --tag=request-docs-config --force```.

Dostęp do dokumentacji: ```http://127.0.0.1/request-docs/```



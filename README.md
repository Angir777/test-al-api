# test-al-api

Testowa aplikacja angulara + laravela (API)

## Uruchomienie API

<ol>
    <li><code>composer install</code></li>
    <li><code>cp .env.example .env</code></li>
    <li><code>php artisan key:generate</code></li>
    <li>W pliku .env należy ustawić dane do DB</li>
    <li><code>composer fresh-db</code> - skrypt utworzy czystą bazę oraz klucze do passport</li>
    <li>(OPCJONALNE)<code>composer fake-db</code> - skrypt uruchomi podstawowe dane</li>
    <li>Serwer uruchamiany jest poleceniem <code>php artisan serve</code></li>
</ol>

## Przygotowanie pod prod
https://laravel.com/docs/8.x/deployment
<ol>
    <li><code>composer install --optimize-autoloader --no-dev</code></li>
    <li><code>php artisan config:cache</code></li>
    <li><code>php artisan route:cache</code></li>
    <li><code>php artisan view:cache</code></li>
</ol>
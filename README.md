# test-al-api

Testowa aplikacja angulara + laravela (API)

# Uruchomienie projektu

<ol>
    <li><code>composer install</code></li>
    <li><code>cp .env.example .env</code></li>
    <li>W pliku <code>.env</code> należy ustawić dane do DB</li>
    <li><code>composer fresh-db</code> - skrypt utworzy czystą bazę oraz klucze do passport</li>
    <li>(OPCJONALNE)<code>composer fake-db</code> - skrypt uruchomi podstawowe dane</li>
    <li>Serwer uruchamiany jest poleceniem <code>php artisan serve</code></li>
</ol>
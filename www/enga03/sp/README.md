# Semestrálka – quick README

## 1 · Instalace

```bash
git clone <repo-url>
cd <repo>
composer install
npm install && npm run dev

cp .env.example .env      # doplňte připojení k DB
php artisan key:generate
php artisan migrate --seed
php artisan serve          # → http://localhost:8000
```
## 2. přihlášení kouče

| Role  | E-mail                  | Heslo    |
|-------|--------------------------|----------|
| Coach | petr.novak@example.com | password |


aplikace je spuštěna na: https://crm-platforma-production.up.railway.app/

# Voxie

## Installation steps
1. Clone repository
2. cd to project folder and copy .env.example to .env
3. Run: 
```
docker-compose build --no-cache && docker-compose up -d
```
4. Access php cli:
```
docker exec -it --user root webapp-app bash
``` 
5. Run:
```
composer install
php artisan key:generate
php artisan migrate:fresh --seed
```
6. Optional: Create test CSV file (file will be created in a new csvFiles folder in project's root):
```
php artisan create:csv
```
7. Access app in http://localhost:8000

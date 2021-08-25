# MEDICERAM project
These are the steps I use for this project

## Installation Steps

1. Clone repo [https://github.com/adibismail/mediceram] and place in xampp/htdocs folder
2. Run composer install and npm install 
```

```
2. Run commands
```
1. Open cmd as **administrator** 
2. php artisan config:clear
3. php artisan route:clear
4. php artisan cache:clear
5. php artisan key:generate
6. php artisan config:cache
7. php artisan route:cache
8. php artisan ziggy:generate
9. php artisan db:seed (will only create 1 user for sign-in)
```
3. Open in browser
```
Go to [http://localhost/mediceram/public/login]
```
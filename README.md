# Chat APP Gemini AI

# Setup

## Backend Setup

Run this command to install dependencies
```
composer install
php artisan install:api
php artisan gemini:install
```

Setup your database connection in your .env file
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=chatapp_gpt
DB_USERNAME=root
DB_PASSWORD=
```

Get gemini api key and add into your .env file.
```
GEMINI_API_KEY=
```

Run Migration
```
php artisan migrate:fresh
php artisan db:seed
```

Run Server
```
php artisan serve
```

## Frontend Setup

you can access the frontend code here: [chatapp](https://github.com/dimss113/gemini-chatapp)

Install all dependency:
```
npm install
```

Run the server
```
npm run dev
```

## Demo Video

[YouTube](https://youtu.be/RHNHJLZOKaU)

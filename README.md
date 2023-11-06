Project Setup:

1. composer install / composer update

2. cp .env.example .env
  
4. php artisan key:generate

5. Add in .env:

   API_BACKEND = 'http://localhost:8002'

6. Import collection to postman (Collections -> Button Import -> Drop file collection)
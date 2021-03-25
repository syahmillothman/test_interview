## Laravel interview question.

### Deployment step

##### 1. Clone repository
``` git clone https://github.com/syahmillothman/test_inteview.git ```
##### 2. Composer install
``` composer install ```
##### 3. Create and setup .env file
1) copy `.env.example` to `.env`
2) Create and setup database.
3) `php artisan migrate --seed && php artisan passport:install`
4) `npm install && npm run dev`
5) `php artisan key:generate && php artisan serve`

##### App is hosted at http://localhost:8000

##### Login detail

###### login for administrator.
`email: admin@test.com / password: password`
###### login for role user
`email: user@test.com, password: password`

`Admin API endpoint`

**Login endpoint**
```bash
curl -X POST http://localhost:8000/api/v1/login  -H "Content-type: application/json" \
-d '{"email":"admin@test.com","password":"password"}'
```

**Get users endpoint**
Request for role __users__ only
```bash 
curl -X GET http://localhost:8000/api/v1/admin/users?roles=2 -H "Authorization: Bearer {Authorization token here}"
```

### Unit testing
Command to run unit testing .
`./vendor/bin/phpunit --testdox`"# test_interview" 
"# test_interview" 
"# test_interview" 

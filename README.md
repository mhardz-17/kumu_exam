##KUMU EXAM Setups

Before doing the steps for setup, make sure you already have install all necessary software to run Laravel framework.
This include Git,Composer, any software that run apache php(ex. WAMP, Laragon or XAMPP)

1. Clone the repository then go inside the clone directory.
  - git clone https://github.com/mhardz-17/kumu_exam.git

2. Run compose install
  - composer install

3. Setup your .env file,set entry for database and cache driver
```
   DB_DATABASE=kumu_exam
   DB_USERNAME=<mysqlusername>
   DB_PASSWORD=<mysqlpassword>
   
   ...
   CACHE_DRIVER=redis   
```
4. Create database kumu_exam.p

5. Run migrations
  - php artisan migrate

6. Run the system, you can access the url given after running below command to access the system. 
  - php artisan serve


##How to use the API Endpoint

You can access the endpoint with the given URL

``` http://<hostname>/api/github/users/<comma seperated usernames> ```

Example

```http://localhost:8000/api/github/users/mhardz-17,test1,test2,test3,test5```

Or just use the UI tester

``` http://localhost:8000/github-user-tester ```

if you want to test it for like mobile app API, take this step.

1. Login on api, if it was successful a token will be returned to you.
   ``` 
    - http://localhost:8000/api/sanctum-login
     params:
       email: your registered email
       password:
       device_name: any name just for testing
   
   ```
2. Using postman, make a request with the below url but be sure to put the token given above as Authorization header
   
  ```http://localhost:8000/api/github/users/mhardz-17,test1,test2,test3,test5```

   | Key           | Value         |
   | ------------- | ------------- |
   | Authorization | Bearer ```<the token given on login>```  |

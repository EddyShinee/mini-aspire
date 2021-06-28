# Welcom to Mini Aspire
### Vu Duc Thuan
## Setup Project * Please following all step bellow

``This is a simple project with API Resgister, Login, CRUD Loans Package, CRD Loans and Repayment``

### 1. Clone project from github link bellow
Please check link bellow and checkout branch ``master``

``https://github.com/EddyShinee/mini-aspire.git``

### 2. Config .ENV file
After clone git please create database and change config in ``.env``
if you don't have ``.env`` file when clone source code from git.
Please duplicate file ``.env.example`` and rename file to ``.env``

2.1 Create Database\
Create database in mysql with whatever you want. Example: (mini-aspire).

2.2 Get your database config from MYSQL and change information in  ``.env``. Find the config bellow and replace information:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=8889
DB_DATABASE=mini_aspire
DB_USERNAME=root
DB_PASSWORD=root
```
### 3. Run bellow command:

#### 3.1 Composer update
Install package using in project:
``composer update``

#### 3.2 Run Migration and Seed
Run command to create table and data seed to database:
``php artisan migrate --seed``

### 4. Run servive:
Run the service:
``php artisan serve``
Example: http://locahost:8000 or http://127.0.0.1:8000
### 5. Get file API JSON and Import to Postman

Please go to the project folder ``Root`` and get this file: \
``New Collection.mini-aspire_postman_collection.json``
Import file in to Postman and you can see the Request file.
--------------------------------------------------------
## How to use API
##### Flow [User register] --- [Login] --- get [Loans Package] --- create [Loans] --- Repayment
### 1. Run API Register

### 2. Run API Login (Get the token and copy token to the Authentication Bearer Token)

### 3. Run API Create Loans

### 4. Run API Repayment



# Welcom to Mini Aspire
### Vu Duc Thuan
## Setup Project * Please following all step bellow

``This is a simple project with API Resgister, Login, CRUD Loans Package, CRD Loans and Repayment``

###1. Clone project from github link bellow
Please check link bellow and checkout branch ``master``

``https://github.com/EddyShinee/mini-aspire.git``

###2. Config .ENV file
After clone git please create database and change config in ``.env``

2.1 Create Database\
Create database in mysql with whatever you want. Example: (mini-aspire).

2.2 Get your database config from MYSQL and change information in  ``.env``\
DB_CONNECTION=mysql\
DB_HOST=127.0.0.1\
DB_PORT=8889\
DB_DATABASE=mini_aspire\
DB_USERNAME=root\
DB_PASSWORD=root

###3. Run bellow command:
####3.1 Composer update
``composer update``
####3.2 Run Migration and Seed
``php artisan migrate --seed``
###4. Run servive:
``php artisan serve``


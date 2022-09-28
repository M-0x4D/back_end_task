# Supervisor & Employee System

## Description

Supervisors have a big problem to handle projects and tasks with them employees and this system helps them to do that and give supervisors permissons or some privillages more than employees .

## prerequisites :

    1- php -> Laravel
    2 - rest Api
    3 - multi Auth
    4- spati for authorization
    5- mail
    6- eloquent orm
___________________________________________

## setup

    1- create database and name it whatever you need 
    2- download the code from github
    3- reset << DB_DATABASE >> in env file to your database name and check the database port number
    4- composer require laravel/ui
    5- php artisan make:mail ResetPassword
    6- php artisan migrate
    7- then start to use services apis from postman using this collection from link : 
        
        https://www.getpostman.com/collections/c9f942ead24d3b91fb76
    
## additional notes

### database design without auth
![database_design2](https://user-images.githubusercontent.com/56012558/192781601-e893f1a9-3134-46a4-854d-76c1a7b38db9.PNG)

    

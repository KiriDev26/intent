<p align="center"><img src="https://res.cloudinary.com/dtfbvvkyp/image/upload/v1566331377/laravel-logolockup-cmyk-red.svg" width="400"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

This test project

Guide for deploy: 

clone with: https://github.com/punks88/intent.git

1. Run docker-compose up -d 
2. Added in your file hosts new row with <ip-docker-container> blog.loc
2. Create database in docker container and config db name in env file
3. Run composer install
4. Run php artisan migrate
4. Run php artisan storage:link 
5. Import blog api.postman_collection.json in your postman app


Successful!

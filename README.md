## Laravel-Vue-SPA-CRUD
Laravel과 vue를 사용한 SPA CRUD 입니다.

## Setting
- os: Ubuntu 18.04
- language: PHP, Vue.js
- Database: Mysql, Redis
- FrameWork: Laravel, PHPUnit
- VSCODE

## Laravel & Vue Setting
- composer create-project --prefer-dist laravel/laravel 이름
- composer require laravel/ui
- composer require predis/predis
- php artisan ui vue
- npm install
- npm install vue-router vue-axios --save
- npm run dev
- npm run watch

## 기타 오류
####composer create-project 속도가 느릴 시
- composer clear-cache

####npm install 후 warn deprecated 
- npm install webpack --save
- npm audit fix --force
- npm install

<p align="center"><img src="https://res.cloudinary.com/dtfbvvkyp/image/upload/v1566331377/laravel-logolockup-cmyk-red.svg" width="400"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## 
##how to install
`cp .env.example .env`  
`make build`  
wait for composer to install all packages (just check the folder)  
`make php_bash`  
`supervisorctl status`  --check if horizon is running then the installation (build) is over  
`php artisan migrate`  
#####it's set to 10 000 users and 1 000 messages you can change this parameters in seeders or modify them on your purpose.
`php artisan db:seed`  
`php artisan ide-helper:generate`  

uncomment `$schedule->command('scheduled-messages:send')->everyMinute();` in App\Console\Kernel



/todo/
- handle message not sent (write to db and schedule resend)

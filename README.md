# Symfony Weather Forecast

A simple Symfony 5 site where a user will be able to provide his city and country via form and after submission system 
will display current weather forecast.

![preview](https://raw.githubusercontent.com/mikoweb/symfony-weather-forecast/master/markdown/view.png)

## env options (.env.local)

    APP_ENV
    DATABASE_URL
    APP_OPEN_WEATHER_API_KEY
    APP_GOOGLE_MAPS_API_KEY
    APP_WEATHER_FORECAST_CACHE_TIME

Sample config for PostgreSQL:

    DATABASE_URL="postgresql://symfony:ChangeMe@127.0.0.1:5432/symfony_weather_forecast?serverVersion=14&charset=utf8"

## Installation

    php8.1 composer.phar install
    php8.1 bin/console doctrine:database:create
    php8.1 bin/console doctrine:schema:update --force

### Create Apache Virtual Host

Create file `/etc/apache2/sites-available/001-symfony-weather-forecast`:

```apacheconf
<VirtualHost symfony-weather-forecast.home:80>
	DocumentRoot /home/[username]/Projects/SymfonyWeatherForecast/public
	ServerName symfony-weather-forecast.home

	Include /etc/apache2/conf-available/php8.1-fpm.conf

	<Directory /home/[username]/Projects/SymfonyWeatherForecast/public/>
		Options Indexes FollowSymLinks MultiViews
		AllowOverride all
		Require all granted
		Order deny,allow
		deny from all
		allow from 127.0.0.1
	</Directory>
</VirtualHost>
```

Add this to `/etc/hosts`:

```
127.0.0.1 symfony-weather-forecast.home
```

Enable virtual host:

    sudo a2ensite 001-symfony-weather-forecast

Restart apache:

    sudo systemctl restart apache2

## Commands

### Show Weather

    php8.1 bin/console app:show-weather --country="Polska" --city="Olsztyn"

![preview](https://raw.githubusercontent.com/mikoweb/symfony-weather-forecast/master/markdown/command.png)

## Routes

```
 -------------------------- -------- -------- ------ ----------------------------------- 
  Name                       Method   Scheme   Host   Path                               
 -------------------------- -------- -------- ------ -----------------------------------       
  app_weather_index          GET      ANY      ANY    /                                  
 -------------------------- -------- -------- ------ ----------------------------------- 

 ```

## Copyrights

Copyright (c) Rafał Mikołajun 2022.

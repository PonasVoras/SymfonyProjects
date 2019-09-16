# SymfonyProjects
Projects made with symfony framework


``` sh
# Static shipping registration service, using fake 3rd party API's
How it works :
- Getts triggered when user is in "/" route, "Registering shipping" should be rendered
- Uses Entity data to get Shipping data
- Picks the right shipping handler object, using Strategy pattern
- Handler handles shipping processess
- Passes Json to mutual OrderRegistrationApi class
- Receives the status from so called API Utility
- Loggs status as a sign of a successful registration

It is :
- Tested
- Easily reusable
- Easily readable due to explicit naming
- Using all the latest versions 
- Populated with strict types
 
Disclaimer :
Registration API class is commented due to the fact, that API endpoints are 'fake'. This was done in order to pass the tests and to not make room for error.

How to get it working :
- Composer install
- Composer update
- start a server in public dir (in my case i used php -S localhost:8000 index.php)
- a command for testing - php bin/phpunit tests --bootstrap vendor/autoload.php

Possible improvements 
- Real API endpoints
- Registration class refactoring into 2 different classes

```

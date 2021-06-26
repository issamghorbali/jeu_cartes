Installation
------------

**Installer les differents composents via composer**

composer install

**creer la base de données**

 php bin/console doctrine:database:create

 php bin/console doctrine:shema:update --force
 
 **alimenter la base de données**
 php bin/console doctrine:fixtures:load


**Lancer l'application**

 php -S localhost:8000 -t public -d display_errors=
 
 http://localhost:8000/
 
 
 ![Screenshot](screenshot.jpg)
 

 
 

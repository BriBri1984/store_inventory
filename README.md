Inventory Manager
===============

#### How to reset database
```$xslt
./bin/console doctrine:database:drop --force
./bin/console doctrine:database:create
./bin/console doctrine:migrations:migrate --no-interaction
```

# vehicle-fleet-parking-management-console-app

## install

`git clone https://github.com/pat-och/vehicle-fleet-parking-management-console-app.git vehicle-fleet-parking-management-console-app`

`composer install`

`php bin/console doctrine:database:create`

`php bin/console doctrine:migration:migrate`

## run tests

`php bin/phpunit tests` to run acceptance tests "grosses mailles"

## run console commands

`php bin/console fleet:create 007`
(do it twice for success and error)

`php bin/console fleet:register-vehicle 007 abc`
(do it twice for success and error)

`php bin/console fleet:localize-vehicle 007 abc` (get an error message)

then `php bin/console fleet:geolocate-for-inextenso-demo-only` to add (123, 456) geopoint to all vehicles in DB

then rerun `php bin/console fleet:localize-vehicle 007 abc` to get success message





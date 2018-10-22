Symfony IP store application
===

A Symfony project created on October 15, 2018, 10:37 am.

## Install

``` bash
$ git clone https://github.com/BodakYura/symfony-ip-store-application.git
$ cd symfony-ip-store-application
$ composer install
$ php bin/console server:run
$ Open link http://127.0.0.1:8000 in browser
```

## Default Config

``` bash
ip_storage:
    driver: 'doctrine'
    validator: 'default'
    table_name: 'ip_storage'
```

## Documentation

#### Create custom StorageDriver

Create custom storage driver which implements **StorageDriverInterface**:

``` php
<?php

use bodakyuriy\IPStorageBundle\Driver\Contract\StorageDriverInterface;

class CustomStorageDriver implements StorageDriverInterface 
{
     public function save(string $ip) : bool {...};
     
     public function getCount(string $ip) : int {...};
}

```

Register as service with tag **ip_storage.driver**: 

``` bash
YourBundle\Driver\CustomDriver:
        tags:
            -  { name: 'ip_storage.driver', alias: 'customDriver' }
```

Change driver in config:

``` bash
ip_storage:
      driver: 'customDriver'
      validator: 'default'
      table_name: 'ip_storage'
```
#### Create custom Validator

Create custom validator driver which implements **ValidatorInterface**:

``` php
<?php

use bodakyuriy\IPStorageBundle\Validator\Contract\ValidatorInterface;

class CustomValidator implements ValidatorInterface 
{
     public function validate(string $ip) : array {...};
}

```

Register as service with tag **ip_storage.validator**: 

``` bash
YourBundle\Driver\CustomDriver:
        tags:
            -  { name: 'ip_storage.driver', alias: 'customValidator' }
```

Change validator in config:

``` bash
ip_storage:
      driver: 'doctrine'
      validator: 'customValidator'
      table_name: 'ip_storage'
```
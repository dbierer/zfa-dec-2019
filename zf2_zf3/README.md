# ZF3 App that Calls ZF2 Services

## Install ZF2
* Get latest version of ZF2 as a ZIP file from [this location](https://framework.zend.com/downloads/archives)
* Unzip into a folder `ZF2_Project/ZF2`
* You should have a directory structure that looks something like this:
```
ZF2_Project/
├── autoload_classmap.php
├── composer.json
├── composer.phar
├── config
│   ├── application.config.php
│   └── autoload
│       ├── global.php
│       ├── local.php
│       ├── local.php.dist
│       └── README.md
├── data
│   ├── cache
│   ├── test.db
│   └── test_users_insert.sql
├── init_autoloader.php
├── module
│   ├── Application
│   │   ├── config
│   │   │   └── module.config.php
│   │   ├── language
│   │   │   ├── ar_JO.mo
|   |   | etc.
│   │       └── layout
│   │           └── layout.phtml
│   └── Lookup
│       ├── config
│       │   └── module.config.php
│       ├── Module.php
│       ├── src
│       │   ├── Controller
│       │   │   ├── IndexControllerFactory.php
│       │   │   └── IndexController.php
│       │   └── Model
│       │       ├── UserModelFactory.php
│       │       └── UserModel.php
│       └── view
│           └── lookup
│               └── index
│                   └── index.phtml
├── public
│   ├── css
│   ├── fonts
│   ├── img
│   ├── index.php
│   └── js
├── README.md
├── Vagrantfile
└── ZF2
    ├── bin
    │   ├── autoload_example.php
    │   ├── autoload_examples.php
    │   ├── classmap_generator.php
    │   ├── createAutoloadTestClasses.php
    │   ├── pluginmap_generator.php
    │   ├── templatemap_generator.php
    │   └── update_hostname_validator.php
    ├── CHANGELOG.md
    ├── composer.json
    ├── composer.lock
    ├── CONTRIBUTING.md
    ├── INSTALL.md
    ├── library
    │   ├── Zend
    |   | etc.
```
* This is how the `autoload_classmap.php` file was generated:
```
cd ZF2_Project
ZF2/bin/classmap_generator.php
```
* Run the PHP webserver
```
php -S localhost:8822 -t public
```
* Test the ZF2 project from a browser: `http://localhost:8822/`

## Install ZF3
* Change to the ZF3 project folder
```
cd ../ZF3_Project
```
* Run composer install
```
php composer.phar install
```
* Run the PHP webserver
```
php -S localhost:8833 -t public
```
* Test the ZF2 project from a browser: `http://localhost:8833/`

# CF CRUD App

![image](https://github.com/rachow/cf-crud-app/assets/12745192/798e1669-39fb-447f-84d4-1a1384359017)


## What is this App

The CF CRUD App is a simple and skeleton app for CRUD (Create, Read, Update, Delete) operations.
This App has been built with insights from [CF Partners](https://www.cf-partners.com)

The App has been built on the PHP CodeIgniter 4 (MVC) framework.

## Installation 

Clone the repository `git clone https://github.com/rachow/cf-crud-app.git`

Once your configurations are set and database is up and running, you are ready
to launch the local PHP development server.

Use the following command whilst within the root project directory.

`$ php -S localhost:9090 -t public/`

## Setup

Copy `env` to `.env` and tailor for your app, specifically the baseURL
and any database settings.

## Server Requirements

PHP version 7.4 or higher is required, with the following extensions installed:

- [intl](http://php.net/manual/en/intl.requirements.php)
- [mbstring](http://php.net/manual/en/mbstring.installation.php)

Additionally, make sure that the following extensions are enabled in your PHP:

- json (enabled by default - don't turn it off)
- [mysqlnd](http://php.net/manual/en/mysqlnd.install.php) if you plan to use MySQL
- [libcurl](http://php.net/manual/en/curl.requirements.php) if you plan to use the HTTP\CURLRequest library

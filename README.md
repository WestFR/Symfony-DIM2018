# Symfony-DIM2018 - ShowRoom Project

Symfony project created during the license pro DIM 2017 - 2018.
This is a web application of TV shows based on the amazing Symfony PHP Framework.

Follow this instructions to install the application & develop your features !


## Requirements

- Install Composer (Globally is better) : https://getcomposer.org/
- A local server environment such as MAMP / XAMPP / LAMP configured with PHP 5.5.9 or higher (7+ is better).


## Installation

1. Clone this project in your project folder : <br>
   `git clone https://github.com/WestFR/Symfony-DIM2018`

2. After have installed Composer, do this command line in your project's folder : <br>
`composer install`

3. Launch your server environment and your create your database with this command line : <br>
`bin/console doctrine:database:create`

4. After, make migrations for create tables in your database: <br>
`bin/console doctrine:migrations:migrate`

5. For correct use of the OMDB API, please follow these instructions (optional) :
- Connect to this site for obtain your API KEY : http://www.omdbapi.com/
- Add your API KEY in "config/parameter.yml" with the same name of "config/parameter.yml.dist" : `OMDB_api_key: your_key`
- Now, you can search a show and retrieve results with local database and online API !


## Usage

1. Create a user through the API or directly through your database with "ROLE_ADMIN" role for login to this application.

2. Launch your server environment and execute this command in your project's folder : <br>
`bin/console s:r`

3. Connect to this application thanks your user.


## API

A simple API is available on this application.

- A documentation is available : `yourProject/api/doc`
- You can use this API directly with this documentation or thanks an external application.


## What's else ?

ENJOY (and put a star if you like this app) !

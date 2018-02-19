# Symfony-DIM2018 - ShowRoom Project

Symfony project created during the license pro DIM 2017 - 2018.
This is a web application of TV shows based on the amazing Symfony PHP Framework.

Follow this instructions to install the application & develop your features !


## Requirements

- Install Composer (Globally is better) : https://getcomposer.org/
- A local server environment such as MAMP / XAMPP / LAMP configured with PHP 5.5.9 or higher (7+ is better).


## Installation

1. Clone this project in your project folder :
`git clone https://github.com/WestFR/Symfony-DIM2018`

2. After have installed Composer, do this command line in your project's folder :
`composer install`

3. Launch your server environment and your create your database with this command line :
`bin/console doctrine:database:create`

4. For correct use of the OMDB API, please follow these instructions (optional) :
- Connect to this site for obtain your API KEY : http://www.omdbapi.com/
- Add your API KEY in "config/parameter.yml" with the same name of "config/parameter.yml.dist" : "OMDB_api_key: your_key"
- Now, you can search a show and retrieve results with local database and online API !


## Usage

- Option 2 (whitout debug bar / profile - not conseilled) :

Place your project in "htdocs" path of your server environment.
Launch your server environment and access to the site with your main path
`localhost:port/yourproject/)`


- Option 2 (with debug bar - conseilled) :

Launch your server environment and execute this command in your project's folder : 
`bin/console s:r`


## What's else ?

ENJOY (and put a star if you like this app) !
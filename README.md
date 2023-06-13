# fonky-challenge
## To get this project up and running on Ubuntu:
- Install docker https://docs.docker.com/engine/install/ubuntu/
- navigate to the project directory.
- execute the command:
 
```docker run --rm -v C:\Users\ahmad\PhpstormProjects\test\fonky-challenge:/var/www/html -w /var/www/html laravelsail/php81-composer:latest composer install --ignore-platform-reqs```
- then execute the command

```./vendor/bin/sail up```

## To get this project up and running on Windows:
- make sure you have the WSL2 active
- install one of the ubuntu distributions from the app store.
- install docker desktop
- make sure your distribution is enabled in settings -> resources -> WSL integration inside docker desktop
- navigate using the terminal or powershell to the project directory. 
- execute the command ```wsl -d {dist_name}```
- withing the bash command line execute the commands from step 3 onwards as in ubuntu guid.

## What was done for this project
- made a laravel project from scratch with no prior knowledge of laravel.
- made sure the project works with docker
- made a utility class csvParser
- made 2 views, one would import the csv file into the database and the other will give a count of the given column name.

To import the csv file into the database go to localhost/readOrderFromCsv
To look at the count of each value for a certain column visit 


ToDoList
========

# Codacy Badge

[![Codacy Badge](https://app.codacy.com/project/badge/Grade/fb2af3f00de9418894d67482b95db87e)](https://www.codacy.com/gh/bernikw/Projet-8/dashboard?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=bernikw/Projet-8&amp;utm_campaign=Badge_Grade)


## Getting start
=========

### Prerequisites

Installation of To Do List requires:

- Symfony 6.1
- PHP version 8.1.6
- Version du serveur 10.4.24
- Composer 2.3.10
- Doctrine/ORM 
- Bootstrap 5.2

## Installation

1. On your local machine, create a local repository and make a
git remote add to your GitHub repository

2. Copy the link on GitHub and clone it on your local repository
https://github.com/bernikw/Projet-8.git

3. Open file .env and configure username and password for database connection. Example:
DATABASE_URL="mysql://root@127.0.0.1:3306/db_user?serverVersion=10.4.24-MariaDB&charset=utf8mb4"

4. Create database:
symfony console doctrine:database:create
symfony console make:migration
symfony console doctrine:migration:migrate

5. Fill the database with fixtures:
symfony console doctrine:fixtures:load

## Features

If the user is the author of the task is authenticate:

- Get list of tasks to do of author
- Get list of tasks done of author
- Get the details of a task
- Edit a task
- Mark a task as done
- Delete a task 

The admin can also:

- Delete user
- Delete unassigned tasks

Run the tests: In your terminal, run vendor/bin/phpunit


## Contributions

If you want to contribute to this project and make it better, your help is very welcome. Look [the documentation](https://github.com/bernikw/Projet-8#contributing) to see how contribute.





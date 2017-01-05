# PHP Repositories
This application displays the most starred public PHP projects on GitHub. It gets the data from the GitHub API and stores it to a database table. The front-end uses JQuery and Bootstrap. The back-end uses PHP and MySQL. The design pattern uses models to interact with the database and controllers to get the data from the model and build views using templates. 

There is a installation script that creates the database and populates the data from the GitHub API. To refresh the data there is a button on the UI that makes and ajax call. The ajax request get the most recent data from the API, compares the new dataset to the existing dataset and saves any changes. It also returns the updated dataset and highlights the changed rows in the UI.

##Requirements
* Web Server (apache, nginx, etc.)
* PHP 5.5 or higher
* MySQL 5.6 or higher
* git

_All of these need to be on the same server._

##Installation

###Create Virtual Host
Create a virtual host using a web server of your choice.

###Clone Repo
Clone this repo to the document root of the virtual host from the previous step.
```
git clone git@github.com:tharpfer/phprepos.git
```

###Run setup.php
```
php setup.php
```

This does the following: 

1. Prompts you to enter MySQL root user and password
2. Creates database, table and user
3. Gets data from GitHub API and saves it to the table

##You're Done!
Go to the virtual host's url in a browser.
 

> ## Admin mycourses
manage the administration interface of the website mycourses. manageaccess,
create courses, lesson, and create a different categories

>#### Installation
-   Open your terminal
-   Go to the folder where you want to install the apps
-   Run the command ``git clone https://github.com/rostand2017/adminmycourses.git``
-   Move to the root directory of the downloaded project
-   Download ``composer.phar`` and execute ``php composer.phar install`` (set php as environment variable first)
-   Run ```php bin/console make:migration``` and ``php bin/console doctrine:migrations:migrate``
-   Run finally ``symfony server:start`` to run the application (install first symfony)
> #### Enjoy now ;)
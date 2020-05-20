CoreBundle
=============

[Api documentation](../master/Resources/doc/api.md)

Coding standards
----------------
PHP Code Sniffer is available via composer, the standard used is defined in phpcs.xml.diff:
````bash
composer phpcs
````

If your code is not compliant, you could try fixing it automatically:
````bash
composer phpcbf
````

PHPStan is configured at level 3, you can check for errors locally using:
`````bash
composer phpstan
`````

Controller/ApplController.php is excluded 
Please take some time to refactor the deprecated functions to use dependency injection instead of getting services from the container

Documentation
-------------
* [Installation](../master/Resources/doc/install.md)
* [API](../master/Resources/doc/api.md)
* [Todo](../master/Resources/doc/todo.md)

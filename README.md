Moufla: a new generation MVC framework for Joomla
=================================================

![Moufla_logo](logo.jpg "Moufla!")


Why should I care?
------------------

Moufla is a **MVC framework for Joomla**. Actually, it is a bridge between [Joomla](http://joomla.org/) and
the [Splash MVC framework](http://mouf-php.com/packages/mouf/mvc.splash/index.md) 
used by [Mouf-PHP](http://mouf-php.com) (a dependency injection based framework).

Moufla offers the following features:

- **compatible controllers**, declared through a nice graphical DI container
- **PSR-7 compatibility**: your controllers can take into parameter `Request` objects and respond `Response` objects
  that are compatible with the [PSR-7 HTTP Message interfaces](http://www.php-fig.org/psr/psr-7/).
- use of **annotations** in your controllers (for instance: `@URL` to declare a new route, `@Logged` to restrict access to logged users, etc...)
- support for any kind of **views** supported in Splash MVC (this includes plain PHP files, [Twig templates](http://twig.sensiolabs.org/), etc...)
- a [nice web-based UI to scafold your controllers and views](http://mouf-php.com/packages/mouf/mvc.splash/doc/writing_controllers.md)
- integration of your views inside the Joomla theme
- (very) easy Ajax support

Another interesting feature is that your code is **100% compatible** with Splash MVC. This means that:

- You can write a controller in Splash MVC and deploy it later in Joomla (or the opposite)
- Since there is also a Drupal module for Splash ([Druplash](http://mouf-php.com/packages/mouf/integration.drupal.druplash/README.md)),
  and a Wordpress module for Splash ([Moufpress](http://mouf-php.com/packages/mouf/integration.wordpress.moufpress/README.md)),
  you can actually **write a controller in Joomla and deploy it in Drupal or Wordpress** (or the other way around).
  Yes, you read it correctly, you can develop an application that will run on Wordpress, Drupal and Joomla (!)
  Haha! I see you're interested. Let's get started!

Supported Joomla version
------------------------

Moufla 2.x is compatible with Joomla 3.x.

Installation
------------

You will first need to install Joomla and Mouf side by side.

1. Start by installing [Joomla](http://joomla.org/) as you would normally do.
2. [Install the Mouf PHP framework](http://mouf-php.com/packages/mouf/mouf/doc/installing_mouf.md) _in the same directory_ as Joomla
   This means you should have the **composer.json** file of Composer in the same directory as the **wp-config.php** of Joomla.
3. Modify **composer.json** and add the **moufla** module. Your **composer.json** should contain at least these lines: 

		{
			"autoload" : {
				"psr-4" : {
					"MyApp\\" : "src/MyApp"
				}
			},
			"require" : {
				"mouf/mouf" : "~2.0",
				"mouf/integration.joomla.moufla" : "~2.0"
			},
			"minimum-stability" : "dev",
			"prefer-stable": true
		}

   Do not forget to customize your vendor name (the `MyApp` part of the autoloader section).
4. Create the empty `src/` directory at the root of your project.
5. Run the install process in Mouf: connect to Mouf UI (go to localhost/your_folder/vendor/mouf/mouf) 
   and run the install process for all the packages  (including the Moufla install process of course)


Getting started
---------------

[In the next section, we will learn **how to create a controller and a view**.](doc/mvc.md)

Or if you already know Splash, you can directly jump to another part of this documentation:

- [widgets integration](doc/widgets.md)
- [authentication and authorization](doc/authentication_and_right_management.md)
- [web library (JS/CSS)](doc/scripts-and-styles.md)

Building a controller and a view for Joomla
===========================================

We will not describe the whole process of creating a controller and a view in the Moufla documentation.
Indeed, Moufla is just a compatibility layer on top of the Splash MVC framework. Therefore, you can
simply refer to the [Splash MVC video tutorial to get started](http://mouf-php.com/packages/mouf/mvc.splash/doc/writing_controllers.md).

Integrating with Joomla theme
-----------------------------

When you run Moufla's installer, a `joomlaTemplate` instance will be created. This instance represents the current
Joomla theme.
Therefore, calling `$joomlaTemplate->toHtml()` will trigger the display of the Joomla theme.
If you do not call this method, the Joomla theme will not be displayed and anything outputed will be directly 
sent to the browser. This is a fairly easy way to do some Ajax since you won't be polluted by the Joomla theme at all.

What next?
----------

Learn more about:

<a href="scripts-and-styles.md" class="btn btn-primary">Web library (JS/CSS) &gt;</a>

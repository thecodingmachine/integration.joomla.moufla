Scripts and styles integration
==============================

By default, Joomla uses the `$document->addScript` and `$document->addStyleSheet` methods to handle
CSS and JS files.

In Mouf, on the other hand, scripts and styles are handled using 
[WebLibraries](http://mouf-php.com/packages/mouf/html.utils.weblibrarymanager/README.md).

When you use Moufla, you can use both techniques to add JS and CSS files to your pages.

**One important thing:** Web libraries are used on pages managed by Moufla only.
On pages managed by Joomla (a Joomla post, the home page, etc...) web libraries will be ignored. Therefore:

- If you want to add JS/CSS on *all pages* of your Joomla site, including the pages not managed by
  Moufla, you should do this *the Joomla way*.
- If on the other hand, you want some JS and CSS specifically on the *dynamic pages* handled by Moufla' controllers,
  you should declare a *web library*.

Using *Web libraries* in Moufla
----------------------------------

We will not cover the use of web libraries in this documentation. If you want to learn how to use
we libraries, please refer to the [web libraries documentation](http://mouf-php.com/packages/mouf/html.utils.weblibrarymanager/README.md).

<?php

namespace Mouf\Integration\Joomla\Moufla;

use Mouf\Utils\Value\ValueInterface;
use Mouf\Utils\Value\ValueUtils;
use Psr\Log\LoggerInterface;
use Mouf\Mvc\Splash\Services\SplashUtils;
use Zend\Stratigility\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;


/**
 * This router always returns a 404 page, based on the configured page not found controller.
 * 
 * @author Guillaume Van Der Putte
 */
class MouflaNotFoundRouter implements MiddlewareInterface
{

	/**
	 * Process an incoming request and/or response.
	 *
	 * Accepts a server-side request and a response instance, and does
	 * something with them.
	 *
	 * If the response is not complete and/or further processing would not
	 * interfere with the work done in the middleware, or if the middleware
	 * wants to delegate to another process, it can use the `$out` callable
	 * if present.
	 *
	 * If the middleware does not return a value, execution of the current
	 * request is considered complete, and the response instance provided will
	 * be considered the response to return.
	 *
	 * Alternately, the middleware may return a response instance.
	 *
	 * Often, middleware will `return $out();`, with the assumption that a
	 * later middleware will return a response.
	 *
	 * @param Request $request
	 * @param Response $response
	 * @param null|callable $out
	 *
	 * @return null|Response
	 */
	public function __invoke(Request $request, Response $response, callable $out = null)
	{
		return $response->withHeader("Vary", "mouflaNotFound")->withStatus(404, "Mouf component not found");
	}
}

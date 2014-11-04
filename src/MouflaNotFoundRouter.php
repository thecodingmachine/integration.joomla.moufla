<?php

namespace Mouf\Integration\Joomla\Moufla;

use Symfony\Component\HttpKernel\HttpKernelInterface;
use Mouf\Mvc\Splash\Controllers\Http404HandlerInterface;
use Mouf\Utils\Value\ValueInterface;
use Mouf\Utils\Value\ValueUtils;
use Symfony\Component\HttpFoundation\Response;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Mouf\Mvc\Splash\Services\SplashUtils;


/**
 * This router always returns a 404 page, based on the configured page not found controller.
 * 
 * @author Guillaume Van Der Putte
 */
class MouflaNotFoundRouter implements HttpKernelInterface {
	/**
	 * Handles a Request to convert it to a Response.
	 *
	 * When $catch is true, the implementation must catch all exceptions
	 * and do its best to convert them to a Response instance.
	 *
	 * @param Request $request A Request instance
	 * @param int     $type    The type of the request
	 *                          (one of HttpKernelInterface::MASTER_REQUEST or HttpKernelInterface::SUB_REQUEST)
	 * @param bool    $catch Whether to catch exceptions or not
	 *
	 * @return Response A Response instance
	 *
	 * @throws \Exception When an Exception occurs during processing
	 */
	public function handle(Request $request, $type = self::MASTER_REQUEST, $catch = true) {
        $response = new Response();
        $response->setVary("mouflaNotFound");
        $response->setStatusCode(404, "Mouf component not found");
		return $response;
	}
}
<?php

namespace Omnibill\Common\Exception;

/**
 * Invalid Request Exception
 *
 * Thrown when a request is invalid or missing required fields.
 */
class AuthException extends \Exception implements OmnipayException
{
}

<?php


namespace app\core\exceptions;


class ForbiddenException extends \Exception
{
    protected $message = "You don't have access to this page";
    protected $code = 403;
}
<?php


namespace app\core\middlewares;


use app\core\Application;
use app\core\exceptions\ForbiddenException;

class AuthMiddleware extends Middleware
{
    public array $actions;

    /**
     * AuthMiddleware constructor.
     * @param string[] $actions
     */
    public function __construct(array $actions)
    {
        $this->actions = $actions;
    }


    public function execute()
    {
        if (!Application::$app->user && in_array(Application::$app->controller->action, $this->actions)) {
            throw new ForbiddenException();
        }
    }
}
<?php


namespace app\core\form;


use app\core\Model;

class Form
{
    public string $action;
    public string $method;
    private Model $model;

    /**
     * Form constructor.
     * @param string $action
     * @param string $method
     */
    public function __construct(string $action, string $method, Model $model)
    {
        $this->action = $action;
        $this->method = $method;
        $this->model = $model;
    }


    public function begin()
    {
        echo sprintf('<form action="%s" method="%s">', $this->action, $this->method);
    }

    public function end()
    {
        echo '</form>';
    }

    public function field($attribute)
    {
        return new Field($this->model, $attribute);
    }
}
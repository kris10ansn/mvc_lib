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
     * @param Model $model
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

    public function inputField($attribute): InputField
    {
        return new InputField($this->model, $attribute);
    }

    public function textAreaField($attribute): TextAreaField
    {
        return new TextAreaField($this->model, $attribute);
    }
}
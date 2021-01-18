<?php


namespace app\core\form;


use app\core\Model;

abstract class Field
{
    protected Model $model;
    public string $attribute;

    /**
     * Field constructor.
     * @param Model $model
     * @param string $attribute
     */
    public function __construct(Model $model, string $attribute)
    {
        $this->model = $model;
        $this->attribute = $attribute;
    }

    abstract public function render(): string;

    public function __toString(): string
    {
        return sprintf('
            <label>
                %s
                %s
                <p class="error">%s</p>
            </label>
        ',
            $this->model->getLabel($this->attribute),
            $this->render(),
            $this->model->hasError($this->attribute) ? "*{$this->model->getFirstError($this->attribute)}" : ""
        );
    }
}
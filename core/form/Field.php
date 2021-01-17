<?php


namespace app\core\form;


use app\core\Model;

class Field
{
    public const TYPE_TEXT = "text";
    public const TYPE_PASSWORD = "password";

    private Model $model;
    public string $attribute;
    public string $type;

    /**
     * Field constructor.
     * @param Model $model
     * @param string $attribute
     */
    public function __construct(Model $model, string $attribute)
    {
        $this->model = $model;
        $this->attribute = $attribute;
        $this->type = self::TYPE_TEXT;
    }

    public function password(): Field
    {
        $this->type = self::TYPE_PASSWORD;
        return $this;
    }

    public function __toString(): string
    {
        return sprintf('
            <label>
                %s
                <input type="%s" name="%s" value="%s" class="%s" autocomplete="off">
                <p class="error">%s</p>
            </label>
        ',
            $this->attribute,
            $this->type,
            $this->attribute,
            $this->model->{$this->attribute},
            $this->model->hasError($this->attribute) ? "invalid" : "",
            $this->model->hasError($this->attribute) ? "*{$this->model->getFirstError($this->attribute)}" : ""
        );
    }
}
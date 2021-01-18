<?php


namespace app\core\form;


use app\core\Model;

class InputField extends Field
{
    public const TYPE_TEXT = "text";
    public const TYPE_PASSWORD = "password";

    public string $type;

    /**
     * InputField constructor.
     * @param Model $model
     * @param string $attribute
     */
    public function __construct(Model $model, string $attribute)
    {
        $this->type = self::TYPE_TEXT;
        parent::__construct($model, $attribute);
    }


    public function password(): InputField
    {
        $this->type = self::TYPE_PASSWORD;
        return $this;
    }

    public function render(): string
    {
        return sprintf('
            <input type="%s" name="%s" value="%s" class="%s" autocomplete="off">
            ',
            $this->type,
            $this->attribute,
            $this->model->{$this->attribute},
            $this->model->hasError($this->attribute) ? "invalid" : "",
        );
    }
}
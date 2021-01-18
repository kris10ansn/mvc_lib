<?php


namespace app\core\form;


class TextAreaField extends Field
{

    public function render(): string
    {
        return sprintf('
            <textarea name="%s" class="%s">%s</textarea>
            ',
            $this->attribute,
            $this->model->hasError($this->attribute) ? "invalid" : "",
            $this->model->{$this->attribute}
        );
    }
}
<?php

namespace Fast\Software\Forms\Fields;

use Kris\LaravelFormBuilder\Fields\FormField;

class CategoryMultiField extends FormField
{

    /**
     * @return string
     */
    protected function getTemplate()
    {
        return 'plugins/software::categories.categories-multi';
    }
}

<?php

namespace Fast\Software\Forms\Fields;

use Kris\LaravelFormBuilder\Fields\FormField;

class LanguageMultiField extends FormField
{

    /**
     * @return string
     */
    protected function getTemplate()
    {
        return 'plugins/software::languages.language-multi';
    }
}

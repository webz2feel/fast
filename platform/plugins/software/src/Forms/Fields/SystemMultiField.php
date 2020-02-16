<?php

namespace Fast\Software\Forms\Fields;

use Kris\LaravelFormBuilder\Fields\FormField;

class SystemMultiField extends FormField
{

    /**
     * @return string
     */
    protected function getTemplate()
    {
        return 'plugins/software::systems.system-multi';
    }
}

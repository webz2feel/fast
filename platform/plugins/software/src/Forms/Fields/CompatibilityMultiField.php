<?php

namespace Fast\Software\Forms\Fields;

use Kris\LaravelFormBuilder\Fields\FormField;

class CompatibilityMultiField extends FormField
{

    /**
     * @return string
     */
    protected function getTemplate()
    {
        return 'plugins/software::compatibilities.compatibility-multi';
    }
}

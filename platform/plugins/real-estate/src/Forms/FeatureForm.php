<?php

namespace Fast\RealEstate\Forms;

use Fast\Base\Forms\FormAbstract;
use Fast\RealEstate\Http\Requests\FeatureRequest;
use Fast\RealEstate\Models\Feature;
use Throwable;

class FeatureForm extends FormAbstract
{

    /**
     * @return mixed|void
     * @throws Throwable
     */
    public function buildForm()
    {
        $this
            ->setupModel(new Feature)
            ->setValidatorClass(FeatureRequest::class)
            ->withCustomFields()
            ->add('name', 'text', [
                'label'      => trans('plugins/real-estate::feature.form.name'),
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'placeholder'  => trans('plugins/real-estate::feature.form.name'),
                    'data-counter' => 120,
                ],
            ]);
    }
}
